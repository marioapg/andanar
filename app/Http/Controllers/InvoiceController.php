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

    public function create(Request $request)
    {
        $newNumDoc = 1;
        $lastInvoice = Invoice::withTrashed()->orderBy('id','desc')->first();
        if ($lastInvoice) {
            $newNumDoc += $lastInvoice->id;
        }

    	return view('invoices.create', ['newNumDoc' => $newNumDoc, 'type' => $request->type]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => ['required', 'string', 'min:4', 'exists:clients,name'],
            'doc_number' => ['unique:invoices,doc_number'],
            'date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:pending,payed'],
            'type' => ['required', 'string', 'in:sell,buy'],
            'comment' => ['nullable', 'string', 'min:1'],
            'pay_way' => ['required', 'string'],
            'itemname' => ['required', 'array', 'min:1'],
            'itemname.*' => ['required'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Por favor, revise los datos e intente nuevamente 1.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $total = floatval(0);
        $iva = floatval(0);
        $grand_total = floatval(0);

        // Calcular total de la factura
        foreach ($request->itemname as $key => $value) {
            $amount = floatval($request->itemprice[$key]) * intval($request->itemqty[$key]);
            $tax_rate = floatval($request->taxrate[$key] / 100);
            $iva += floatval($amount * $tax_rate);
            $total +=  $amount;
        }

        $grand_total =  $total + $iva;

        $invoice_args = $request->only(['client', 'date', 'doc_number', 'due_date','status', 'type', 'comment', 'pay_way']);
        $invoice_args['client_id'] = Client::where('name', $request->client)->first()->id;
        $invoice_args['total'] = round($total, 2);
        $invoice_args['iva'] = round($iva, 2);
        $invoice_args['grand_total'] = round($grand_total, 2);

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
                $tax_rate = floatval($request->taxrate[$key] / 100);
                $iva = floatval($amount * $tax_rate);


                Item::create(
                        array(
                                'invoice_id' => $invoice->id,
                                'name' => $value,
                                'description' => $request->itemdescription[$key],
                                'quantity' => $request->itemqty[$key],
                                'price' => $request->itemprice[$key],
                                'tax_rate' => round($tax_rate, 2),
                                'total' => round($amount, 2),
                                'tax' => round($iva, 2),
                                'grand_total' => round(($amount + $iva), 2),
                            )
                        );
            }
        } catch (Exception $e) {
            Session::flash('flash_message', __('+ Por favor, revise los datos e intente nuevamente 2.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors(['error' => 'Try later']);
        }

        Session::flash('flash_message', __('+ Factura registrada.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('invoices.index', ['type' => $invoice->type]);
    }

    public function status(Request $request)
    {
        Invoice::where('id', $request->id)->update(['status' => $request->status]);

        return redirect()->route('invoice.show', ['id' => $request->id]);
    }

    public function delete(Request $request)
    {
        $invoice = Invoice::find($request->id);        
        $type = $invoice->type;
        if ( $invoice->items()->delete() && $invoice->delete() ) {
            return redirect()->route('invoices.index', ['type' => $type]);
        }

        return back()->withErrors(['error' => __('Por favor intente más tarde')]);
    }

    public function edit(Request $request)
    {
        return view('invoices.edit', [ 'invoice' => Invoice::where('id', $request->id)->first() ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => ['required', 'string', 'min:4', 'exists:clients,name'],
            'date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:pending,payed'],
            'type' => ['required', 'string', 'in:sell,buy'],
            'comment' => ['nullable', 'string', 'min:1'],
            'pay_way' => ['required', 'string'],
            'itemname' => ['required', 'array', 'min:1'],
            'itemname.*' => ['required'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Por favor, revise los datos e intente nuevamente 1.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $total = floatval(0);
        $iva = floatval(0);
        $grand_total = floatval(0);

        // Calcular total de la factura
        foreach ($request->itemname as $key => $value) {
            $amount = floatval($request->itemprice[$key]) * intval($request->itemqty[$key]);
            $tax_rate = floatval($request->taxrate[$key] / 100);
            $iva += floatval($amount * $tax_rate);
            $total +=  $amount;
        }

        $grand_total =  $total + $iva;

        $invoice_args = $request->only(['client', 'date', 'due_date','status', 'type', 'comment', 'pay_way']);
        $invoice_args['client_id'] = Client::where('name', $request->client)->first()->id;
        $invoice_args['total'] = round($total, 2);
        $invoice_args['iva'] = round($iva, 2);
        $invoice_args['grand_total'] = round($grand_total, 2);

        $invoice = Invoice::find($request->id);
        try {
            $invoice->update($invoice_args);

            // Agregar items de la factura
            foreach ($request->itemname as $key => $value) {
                if ($request->itemqty[$key] == null || $request->itemprice[$key] == null) {
                    $invoice->items()->delete();
                    $invoice->delete();
                    Session::flash('flash_message', __('- Por favor, complete todos los datos e intente nuevamente.'));
                    Session::flash('flash_type', 'alert-danger');
                    return back()->withErrors($validator)->withInput();
                } elseif ($key == 0) {
                    $invoice->items()->delete();
                }

                $amount = floatval($request->itemprice[$key]) * intval($request->itemqty[$key]);
                $tax_rate = floatval($request->taxrate[$key] / 100);
                $iva = floatval($amount * $tax_rate);


                Item::create(
                        array(
                                'invoice_id' => $invoice->id,
                                'name' => $value,
                                'description' => $request->itemdescription[$key],
                                'quantity' => $request->itemqty[$key],
                                'price' => round($request->itemprice[$key], 2),
                                'tax_rate' => round($tax_rate, 2),
                                'total' => round($amount, 2),
                                'tax' => round($iva, 2),
                                'grand_total' => round(($amount + $iva), 2),
                            )
                        );
            }
        } catch (Exception $e) {
            Session::flash('flash_message', __('+ Por favor, revise los datos e intente nuevamente 2.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors(['error' => 'Try later']);
        }

        Session::flash('flash_message', __('+ Factura registrada.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('invoices.index', ['type' => $invoice->type]);
    }
}