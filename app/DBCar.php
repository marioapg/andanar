<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DBCar extends Model
{
	public $timestamps = false;
	
    protected $table = 'db_cars';

    protected $fillable = [
    	'brand',
    	'model'
    ];
}