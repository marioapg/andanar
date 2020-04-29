<?php

namespace App\Http\Controllers;

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
}
