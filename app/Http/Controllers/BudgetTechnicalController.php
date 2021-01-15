<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budget;
use Session;

class BudgetTechnicalController extends Controller
{
    public function index(Request $request)
    {
        $budgets = Budget::where('technical_id', auth()->user()->id)
        		->orWhereHas('usersAccess', function($q){
		        	return $q->where('user_id', auth()->user()->id);
		        })->get();
    	return view('budgets.technical.index', ['budgets' => $budgets]);
    }

    public function show(Request $request)
    {
    	$budget = Budget::where('id', $request->id)->first();
    	if ( ($budget->hasAccess(auth()->user()->id)) ||
    			(auth()->user()->id == $budget->technical_id) ) {
    		return view('budgets.technical.show', ['budget' => $budget]);
    	}

    	Session::flash('flash_message', __('- Acceso denegado.'));
        Session::flash('flash_type', 'alert-danger');
        return back();
    }

    public function status(Request $request)
    {
    	$budget = Budget::where('id', $request->id)->first();
    	if ( ($budget->hasAccess(auth()->user()->id)) ||
    			(auth()->user()->id == $budget->technical_id) ) {
	        Budget::where('id', $request->id)->update(['status' => $request->status]);
	        return redirect()->route('budget.technical.show', ['id' => $request->id]);
	    }

	    Session::flash('flash_message', __('- Acceso denegado.'));
        Session::flash('flash_type', 'alert-danger');
        return back();
    }

    public function embedview(Request $request)
    {
    	$budget = Budget::where('id', $request->budgetid)->first();

    	if ( ($budget->hasAccess(auth()->user()->id)) ||
    			(auth()->user()->id == $budget->technical_id) ) {
	        $budget = Budget::where('id',$request->budgetid)->first();
	        return view('mails.budget_mail_pdf', ['budget'=>$budget]);
	    }
    }
}
