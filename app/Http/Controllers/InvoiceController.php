<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Invoice;
use App\Client;
use App\Item;
use Session;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if (!isset($request->type)) {
            $invoices = Invoice::all();
        }elseif ($request->type == 'all') {
            $invoices = Invoice::all();
        } else {
            $invoices = Invoice::where('type', $request->type)->get();
        }

    	return view('invoices.index', ['invoices' => $invoices, 'type' => $request->type]);
    }

    public function show(Request $request)
    {
    	return view('invoices.show', ['invoice' => Invoice::find($request->id)]);
    }

    public function create()
    {
    	return view('invoices.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => ['required', 'string', 'min:4', 'exists:clients,name'],
            'date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:pending,payed'],
            'type' => ['required', 'string', 'in:sell,buy'],
            'iva_rate' => ['required'],
            'comment' => ['nullable', 'string', 'min:1'],
            'pay_way' => ['required', 'string'],
            'itemname' => ['required', 'array', 'min:1'],
            'itemname.*' => ['required'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Por favor, revise los datos e intente nuevamente.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $total = floatval(0);
        $iva = floatval(0);
        $grand_total = floatval(0);

        // Calcular total de la factura
        foreach ($request->itemname as $key => $value) {
            $amount = floatval($request->itemprice[$key]) * intval($request->itemqty[$key]);
            $tax_rate = floatval($request->iva_rate / 100);
            $iva += floatval($amount * $tax_rate);
            $total +=  $amount;
        }

        $grand_total =  $total + $iva;

        $invoice_args = $request->only(['client', 'date', 'due_date', 'iva_rate','status', 'type', 'comment', 'pay_way']);
        $invoice_args['doc_number'] = '123';
        $invoice_args['client_id'] = Client::where('name', $request->client)->first()->id;
        $invoice_args['total'] = $total;
        $invoice_args['iva'] = $iva;
        $invoice_args['grand_total'] = $grand_total;

        try {
            $invoice = Invoice::create($invoice_args);

            // Agregar items de la factura
            foreach ($request->itemname as $key => $value) {
                if ($request->itemqty[$key] == null || $request->itemprice[$key] == null) {
                    Item::where('invoice_id', $invoice->id)->delete();
                    $invoice->delete();
                    Session::flash('flash_message', __('- Por favor, complete todos los datos e intente nuevamente.'));
                    Session::flash('flash_type', 'alert-danger');
                    return back()->withErrors($validator)->withInput();
                }

                $amount = floatval($request->itemprice[$key]) * intval($request->itemqty[$key]);
                $tax_rate = floatval($request->iva_rate / 100);
                $iva = floatval($amount * $tax_rate);


                Item::create(
                        array(
                                'invoice_id' => $invoice->id,
                                'name' => $value,
                                'description' => $request->itemdescription[$key],
                                'quantity' => $request->itemqty[$key],
                                'price' => $request->itemprice[$key],
                                'tax_rate' => $request->iva_rate,
                                'total' => $amount,
                                'tax' => $iva,
                                'grand_total' => ($amount + $iva),
                            )
                        );
            }
        } catch (Exception $e) {
            Session::flash('flash_message', __('+ Por favor, revise los datos e intente nuevamente.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors(['error' => 'Try later']);
        }

        Session::flash('flash_message', __('+ Factura registrada.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('invoices.index');
    }

    public function status(Request $request)
    {
        Invoice::where('id', $request->id)->update(['status' => $request->status]);

        return redirect()->route('invoice.show', ['id' => $request->id]);
    }
}
