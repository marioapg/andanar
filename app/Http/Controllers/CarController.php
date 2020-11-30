<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;

class CarController extends Controller
{
    public function index(Request $request)
    {
    	return view('cars.index', ['cars' => Car::all()]);
    }

    public function create(Request $request)
    {
    	return view('cars.create');
    }
}
