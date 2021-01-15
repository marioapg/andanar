<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Budget;
use App\User;

class BudgetUser extends Model
{
    protected $table = 'budget_user';

    protected $fillable = [
    	'budget_id',
    	'user_id'
    ];
}