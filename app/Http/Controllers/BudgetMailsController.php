<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\BudgetCreated;
use Session;
use Mail;

class BudgetMailsController extends Controller
{
    public function send(Request $request)
    {
    	$emails = array();
    	if ( isset($request->peritocheck) && !is_null($request->peritomail) ) {
			if (filter_var($request->peritomail, FILTER_VALIDATE_EMAIL)) {
    			array_push($emails, $request->peritomail);
			}
    	}
    	if ( isset($request->tecnicocheck) && !is_null($request->tecnicomail) ) {
    		if (filter_var($request->tecnicomail, FILTER_VALIDATE_EMAIL)) {
    			array_push($emails, $request->tecnicomail);
			}
    	}
    	if ( isset($request->clientecheck) && !is_null($request->clientemail) ) {
    		if (filter_var($request->clientemail, FILTER_VALIDATE_EMAIL)) {
    			array_push($emails, $request->clientemail);
			}
    	}
    	if ( isset($request->otroscheck) && !is_null($request->otrosmails) ) {
    		$varios = explode(',', $request->otrosmails);
    		foreach ($varios as $key => $value) {
    			if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
    				array_push($emails, $value);
				}
    		}
    	}
    	if(count($emails)) {
    		foreach ($emails as $recipient) {
    			Mail::to($recipient)->send(new BudgetCreated());
			}
    		Session::flash('flash_message', __('- Emails enviados'));
	        Session::flash('flash_type', 'alert-success');
	    	return redirect()->route('budget.show',$request->budgetid);
    	}

    	Session::flash('flash_message', __('- Ningun email enviado/Listado de destinatarios vacía'));
        Session::flash('flash_type', 'alert-danger');
    	return redirect()->route('budget.show',$request->budgetid);
    }
}
