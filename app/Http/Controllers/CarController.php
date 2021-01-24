<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
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
    
    public function show(Request $request)
    {
    	return view('cars.show', ['car' => Car::where('id', $request->id)->first()]);
    }
    
    public function update(Request $request)
    {
    	$car = Car::where('id', $request->id)->first();
    	$car->update([
    		'brand' => $request->brand,
    		'model' => $request->model,
    		'color' => $request->color,
    		'plate' => $request->plate,
    	]);
    	Session::flash('flash_message', __('- Coche actualizado.'));
        Session::flash('flash_type', 'alert-success');
    	return redirect()->route('cars.index');
    }
    
    public function delete(Request $request)
    {
    	$car = Car::where('id', $request->id)->first()->delete();
    	Session::flash('flash_message', __('- Coche eliminado.'));
        Session::flash('flash_type', 'alert-success');
    	return redirect()->route('cars.index');
    }
}