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
}
