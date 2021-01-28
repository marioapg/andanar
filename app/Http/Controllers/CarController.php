<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBCar;
use Session;

class CarController extends Controller
{
    public function index(Request $request)
    {
    	return view('cars.index', ['cars' => DBCar::all()]);
    }

    public function create(Request $request)
    {
    	return view('cars.create');
    }
    
    public function show(Request $request)
    {
    	return view('cars.show', ['car' => DBCar::where('id', $request->id)->first()]);
    }
    
    public function store(Request $request)
    {
    	$car = DBCar::create(['brand' => $request->brand, 'model' => $request->model]);
    	Session::flash('flash_message', __('- Coche actualizado.'));
        Session::flash('flash_type', 'alert-success');
    	return redirect()->route('cars.index');
    }
    
    public function update(Request $request)
    {
        $car = DBCar::where('id', $request->id)->first();
        $car->timestamps = false;
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->save();
        Session::flash('flash_message', __('- Coche actualizado.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('cars.index');
    }
    
    public function delete(Request $request)
    {
    	$car = DBCar::where('id', $request->id)->first()->delete();
    	Session::flash('flash_message', __('- Coche eliminado.'));
        Session::flash('flash_type', 'alert-success');
    	return redirect()->route('cars.index');
    }
}