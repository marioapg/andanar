<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BudgetsExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Budget;

class ExportReportController extends Controller
{
    public function export(Request $request)
    {
    	if ($request->from && $request->to) {
    		$from = Carbon::create($request->from);
    		$to = Carbon::create($request->to);
    		$budgets = Budget::whereBetween('created_at', [$from, $to])->get();
    	}
    	if ($request->from && !$request->to) {
    		$from = Carbon::create($request->from);
    		$to = Carbon::now();
    		$budgets = Budget::whereBetween('created_at', [$from, $to])->get();
    	}
    	if (!$request->from && $request->to) {
    		$from = Carbon::create('01-01-1990');
    		$to = Carbon::create($request->to);
    		$budgets = Budget::whereBetween('created_at', [$from, $to])->get();
    	}
    	if (!$request->from && !$request->to) {
    		$budgets = Budget::all();
    	}
		return Excel::download(new BudgetsExport($budgets), 'test.xlsx');
    }
}
