<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Budget;

class BudgetsExport implements FromView
{

    protected $budgets;
 
    public function __construct($budgets = null)
    {
        $this->budgets = $budgets;
    }
 
    public function view(): View
    {
        return view('exports.budgets', [
            'budgets' => $this->budgets
        ]);
    }
}