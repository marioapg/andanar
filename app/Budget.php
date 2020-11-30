<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'client_id',
        'technical_id',
        'responsable_id',
        'perito_id',
        'car_id',
        'date',
        'public_comment',
        'private_comment',
        'status',
        'cia_sure',
        'iva_rate',
        'total',
        'iva',
        'grand_total',
        'tarifa_pdr',
	];

    public function client()
    {
    	return $this->hasOne('App\Client', 'id', 'client_id');
    }
  
    public function responsable()
    {
        return $this->hasOne('App\User', 'id', 'responsable_id');
    }
  
    public function technical()
    {
        return $this->hasOne('App\User', 'id', 'technical_id');
    }

    public function perito()
    {
        return $this->hasOne('App\User', 'id', 'perito_id');
    }
}