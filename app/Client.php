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
		"nif",
		"type",
		"address",
		"population",
		"postal_code",
		"province",
		"country",
		"commercial_name",
		"phone",
		"celphone",
		"website",
    ];
}
