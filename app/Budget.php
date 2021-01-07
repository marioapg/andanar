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
        'currency',
        'iva',
        'grand_total',
        'tarifa_pdr',
        'attached',
	];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'attached' => 'array',
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

    public function items()
    {
        return $this->hasMany('App\BudgetItem');
    }

    public function car()
    {
        return $this->hasOne('App\Car', 'id', 'car_id');
    }

    public function isClient($client_id)
    {
        if (is_null($this->client)) {
            return false;
        }

        if ($this->client->id == $client_id) {
            return true;
        }

        return false;
    }

    public function isPerito($perito_id)
    {
        if (is_null($this->perito)) {
            return false;
        }

        if ($this->perito->id == $perito_id) {
            return true;
        }

        return false;
    }

    public function isTechnical($technical_id)
    {
        if (is_null($this->technical)) {
            return false;
        }

        if ($this->technical->id == $technical_id) {
            return true;
        }

        return false;
    }

    public function isBoss($boss_id)
    {
        if (is_null($this->responsable)) {
            return false;
        }

        if ($this->responsable->id == $boss_id) {
            return true;
        }

        return false;
    }
}