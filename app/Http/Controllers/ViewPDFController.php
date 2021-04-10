<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budget;
use PDF;

class ViewPDFController extends Controller
{
    public function view(Request $request)
    {
        $budget = Budget::where('id', $request->budgetid)->first();
        if ($budget) {
	        $pdf = PDF::loadView('mails.budget_mail_pdf', ['budget'=>$budget]);

            if ($request->download) {
                return $pdf->download($budget->car->plate);
            }

            return view('budgets.budget_pdf_view', ['budget'=>$budget]);
	        // return $pdf->stream();
        }

        return back();
    }

    public function viewTechnical(Request $request)
    {
        $budget = Budget::where('id', $request->budgetid)->first();
        if ($budget) {

            return view('budgets.budget_pdf_view', ['budget'=>$budget]);
	        // $pdf = PDF::loadView('mails.budget_mail_pdf', ['budget'=>$budget]);
	        // return $pdf->stream();
        }

        return back();
    }
}
