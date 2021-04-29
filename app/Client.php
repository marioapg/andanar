<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name',
        'email',
		'document',
		'address',
		'city',
		'postal_code',
		'state',
		'country',
		'phone',
        'responsable',
        'contact_responsable'

    ];

    public function budgets()
    {
    	return $this->hasMany('App\Budget', 'client_id', 'id');
    }

    public function __get($key)
    {
        if (is_string($this->getAttribute($key))) {
            return strtoupper( $this->getAttribute($key) );
        } else {
            return $this->getAttribute($key);
        }
    }
}
