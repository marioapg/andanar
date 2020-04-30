<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Invoice;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
    	return view('invoices.index', ['invoices' => Invoice::all()]);
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
            'client' => ['required', 'string', 'min:4'],
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
            return back()->withErrors($validator)->withInput();
        }

        $invoice_args = $request->only(['client', 'date', 'due_date', 'iva_rate','status', 'type', 'comment', 'pay_way']);
        $invoice_args['doc_number'] = '123';
        $invoice = Invoice::create($invoice_args);

        return $invoice;
    }
}
