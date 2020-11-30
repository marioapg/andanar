<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DBCar;

class DBModelController extends Controller
{
    public function index(Request $request)
    {
    	$models = DB::table('db_cars')
    				->select('model')
    				->where('brand','like','%'.$request->brand.'%')
    				->get();
    	$output = '';
    	foreach ($models as $key => $value) {
    		$output .= '<option value="'.$value->model.'">'.$value->model.'</option>';
    	}
    	return $output;
    }
}
