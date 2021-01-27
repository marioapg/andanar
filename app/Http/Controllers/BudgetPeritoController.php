<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budget;

class BudgetPeritoController extends Controller
{
    public function index(Request $request)
    {
    	return view('budgets.index', ['budgets' => Budget::where('perito_id', auth()->user()->id)->get()]);
    }
}
