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

        $si = $invoices->where('type', 'sell');
        $ingresos = floatval(0);
        $cobros_pendientes = floatval(0);
        foreach ($si as $key => $value) {
            if ($value->status == 'pending') {
                $cobros_pendientes += $value->grand_total;
            }
            if ($value->status == 'payed') {
                $ingresos += $value->grand_total;
            }
        }

        $bi = $invoices->where('type', 'buy');
        $gastos = floatval(0);
        $pagos_pendientes = floatval(0);
        foreach ($bi as $key => $value) {
            if ($value->status == 'pending') {
                $pagos_pendientes += $value->grand_total;
            }
            if ($value->status == 'payed') {
                $gastos += $value->grand_total;
            }
        }

        return view('dashboard', [
            'sell_invoices_count' => $sell_invoices_count,
            'buy_invoices_count' => $buy_invoices_count,
            'clients_count' => $clients_count,
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'cobros_pendientes' => $cobros_pendientes,
            'pagos_pendientes' => $pagos_pendientes,
        ]);
    }
}
