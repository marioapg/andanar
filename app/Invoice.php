<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	use SoftDeletes;

    public function client()
    {
    	return $this->hasOne('App\Client', 'id', 'client_id');
    }
}
