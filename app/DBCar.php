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

    public function __get($key)
	{
	    if (is_string($this->getAttribute($key))) {
	        return strtoupper( $this->getAttribute($key) );
	    } else {
	        return $this->getAttribute($key);
	    }
	}
}