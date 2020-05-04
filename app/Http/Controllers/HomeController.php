<?php

namespace App\Http\Controllers;
use App\Invoice;
use App\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $invoices = Invoice::all();
        $sell_invoices_count = $invoices->where('type', 'sell')->count();
        $buy_invoices_count = $invoices->where('type', 'buy')->count();
        $clients_count = Client::all()->count();
        return view('dashboard', [
            'sell_invoices_count' => $sell_invoices_count,
            'buy_invoices_count' => $buy_invoices_count,
            'clients_count' => $clients_count
        ]);
    }
}
