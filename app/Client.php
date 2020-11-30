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
		"document",
		"address",
		"city",
		"postal_code",
		"state",
		"country",
		"phone"
    ];

    public function budgets()
    {
    	return $this->hasMany('App\Budget', 'client_id', 'id');
    }
}
