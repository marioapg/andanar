<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	use SoftDeletes;

	protected $fillable = [
	    'doc_number',
        'client_id',
        'date',
        'due_date',
        'type',
        'comment',
        'pay_way',
        'status',
        'iva_rate',
        'total',
        'iva',
        'grand_total',
        'client_id',
	];

    public function client()
    {
    	return $this->hasOne('App\Client', 'id', 'client_id');
    }

    public function items()
    {
    	return $this->hasMany('App\Item', 'invoice_id', 'id');
    }
}
