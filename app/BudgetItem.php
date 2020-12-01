<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    protected $fillable = [
    	'budget_id',
        'part',
        'material',
        'small',
        'medium',
        'big',
        'paint',
        'small_vds',
        'medium_vds',
        'big_vds',
        'paint_vds',
        'total_vds',
        'total_money',
    ];

    public function Budget()
    {
    	return $this->belongsTo('App\Budget');
    }
}