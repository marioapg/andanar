<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
    	'client_id',
        'plate',
        'brand',
        'model',
        'year',
        'color',
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
