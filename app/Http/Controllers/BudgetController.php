<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Utils\Currencies;
use App\BudgetItem;
use App\Budget;
use App\Client;
use App\Car;
use Session;

class BudgetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $budgets = Budget::all();
    	return view('budgets.index', ['budgets' => $budgets]);
    }

    public function show(Request $request)
    {
    	return view('budgets.show', ['budget' => Budget::find($request->id)]);
    }

    public function createStepOne(Request $request)
    {
        $car = $request->session()->get('car');
    	return view('budgets.create-step-one', compact('car'));
    }

    public function storeStepOne(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate' => ['required']
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Por favor, ingrese una matricula.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $searchCar = Car::where('plate',$request->plate)->get();

        if ( $searchCar->count() ) {
            $car = $searchCar->first();
            $request->session()->put('car', $car);
            return redirect()->route('budget.create.step.three');
        }

        $car = new Car();
        $car->plate = strtoupper($request->plate);
        $car->client_id = null;
        $car->brand = null;
        $car->model = null;
        $car->year = null;
        $car->color = null;

        $request->session()->put('car', $car);

        return redirect()->route('budget.create.step.two');
    }

    public function createStepTwo(Request $request)
    {
        $car = $request->session()->get('car');
        if (empty($car)) {
            return redirect()->route('budget.create.step.one');
        }
        return view('budgets.create-step-two', compact('car'));
    }

    public function storeStepTwo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => ['required'],
            'model' => ['required'],
            'color' => ['required'],
            'year' => ['required'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Todos los campos son requeridos.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $car = $request->session()->get('car');
        if (!empty($car)) {
            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->color = $request->color;
            $car->year = $request->year;
            $request->session()->put('car', $car);
            return redirect()->route('budget.create.step.three');
        }
        return redirect()->route('budget.create.step.one');
    }

    public function createStepThree(Request $request)
    {
        $car = $request->session()->get('car');
        if (empty($car)) {
            return redirect()->route('budget.create.step.one');
        }
        return view('budgets.create-step-three', compact('car'));
    }

    public function storeStepThree(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => ['required'],
            'proficient_id' => ['nullable', 'exists:users,id'],
            'technical_id' => ['nullable','exists:users,id'],
            'boss_id' => ['nullable','exists:users,id'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Todos los campos son requeridos.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $car = $request->session()->get('car');
        if (empty($car)) {
            return redirect()->route('budget.create.step.one');
        }
        $params = new \stdClass();
        $params->client_id = $request->client_id;
        $params->perito_id = is_null($request->proficient_id) ? '' : $request->proficient_id;
        $params->technical_id = is_null($request->technical_id) ? '' : $request->technical_id;
        $params->boss_id = is_null($request->boss_id) ? '' : $request->boss_id;

        $request->session()->put('params', $params);

        return redirect()->route('budget.create.step.four');
    }

    public function createStepFour(Request $request)
    {
        $car = $request->session()->get('car');
        if (empty($car)) {
            return redirect()->route('budget.create.step.one');
        }
        $params = $request->session()->get('params');
        if (empty($params)) {
            return redirect()->route('budget.create.step.three');
        }
        return view('budgets.create-step-four', compact(['car','params']));
    }

    public function storeStepFour(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'client_id' => ['required'],
            'proficient_id' => ['nullable', 'exists:users,id'],
            'technical_id' => ['nullable','exists:users,id'],
            "plate" => ['required'],
            "brand" => ['required'],
            "model" => ['required'],
            "color" => ['required'],
            "currency" => ['required', 'in:USD,EUR,ARS'],
            "year" => ['required'],
            "client_id" => ['required', 'exists:users,id'],
            "perito_id" => ['nullable', 'exists:users,id'],
            "technical_id" => ['nullable', 'exists:users,id'],
            "tarifa" => ['numeric']
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Todos los campos son requeridos.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $validator = Validator::make($request->all(), [
            'part' => ['required', 'array', 'min:1'],
            'part.*' => ['required'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Debe agregar al menos 1 bollo.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $car = Car::where('plate', $request->plate)->first();

        if (!$car) {
            $car = Car::create([
                'client_id' => $request->client_id,
                'plate' => $request->plate,
                'brand' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
            ]);
        }

        $manual = isset($request->manual_check) ? 1 : 0;

        $budget = Budget::create([
                    'client_id' => $request->client_id,
                    'technical_id' => $request->technical_id,
                    'responsable_id' => $request->boss_id,
                    'perito_id' => $request->perito_id,
                    'date' => now(),
                    'car_id' => $car->id,
                    'public_comment' => $request->public_comment,
                    'currency' => $request->currency,
                    'private_comment' => $request->private_comment,
                    'cia_sure' => $request->cia,
                    'iva_rate' => $request->iva,
                    'total' => ($request->grand_total - $request->iva_total),
                    'iva' => $request->iva_total,
                    'grand_total' => $request->grand_total,
                    'tarifa_pdr' => $request->tarifa,
                    'desmontaje' => $request->desmontaje,
                    'manual' => $manual,
                ]);
        foreach ($request->part as $key => $value) {
            $mat = $request->material[$key] ? 'Aluminio' : 'Hierro';
            BudgetItem::create([
                                'budget_id' => $budget->id,
                                'part' => $request->part[$key],
                                'material' =>  $mat,
                                'small' => $request->small_damage[$key],
                                'medium' => $request->medium_damage[$key],
                                'big' => $request->big_damage[$key],
                                'paint' => $request->topaint_damage[$key],
                                'small_vds' => $request->small_vd[$key],
                                'medium_vds' => $request->medium_vd[$key],
                                'big_vds' => $request->big_vd[$key],
                                'paint_vds' => $request->topaint_vd[$key],
                                'total_vds' => $request->totalrow[$key],
                                'total_money' => $request->totalMoneyRow[$key],
                            ]);
        }

        if($request->hasFile('file')) {
            $images = array();
            // Upload path
            $destinationPath = public_path().'/images/budgets/';

            // Create directory if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('file') as $key => $value) {
                // Get file extension
                $extension = $value->getClientOriginalExtension();

                // Valid extensions
                $validextensions = array("jpeg","jpg","png","pdf");

                // Check extension
                if(in_array(strtolower($extension), $validextensions)){
                    // Rename file 
                    $fileName = $value->getClientOriginalName().time() .'.' . $extension;
                    // Uploading file to given path
                    $value->move($destinationPath, $fileName);
                    array_push($images, $fileName);
                }
            }
            $images = $images;
            $budget->attached = $images;
            $budget->save();
        }

        $request->session()->forget('car');
        $request->session()->forget('params');
        Session::flash('flash_message', __('- Presupuesto creado con éxito.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('budgets.index');
    }

    public function status(Request $request)
    {
        Budget::where('id', $request->id)->update(['status' => $request->status]);

        return redirect()->route('budget.show', ['id' => $request->id]);
    }

    public function delete(Request $request)
    {
        $budget = Budget::find($request->id);
        $num = $budget->id;
        if ( $budget->items()->delete() && $budget->delete() ) {
            Session::flash('flash_message', __('- Presupuesto #'.$num.' eliminado.'));
            Session::flash('flash_type', 'alert-success');
            return redirect()->route('budgets.index');
        }

        return back()->withErrors(['error' => __('Por favor intente más tarde')]);
    }

    public function edit(Request $request)
    {
        return view('budgets.edit', [ 'budget' => Budget::where('id', $request->id)->first() ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => ['required'],
            'proficient_id' => ['nullable', 'exists:users,id'],
            'technical_id' => ['nullable','exists:users,id'],
            "plate" => ['required'],
            "brand" => ['required'],
            "model" => ['required'],
            "color" => ['required'],
            "year" => ['required'],
            "client_id" => ['required', 'exists:users,id'],
            "perito_id" => ['nullable', 'exists:users,id'],
            "technical_id" => ['nullable', 'exists:users,id'],
            "tarifa" => ['numeric']
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Todos los campos son requeridos.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $validator = Validator::make($request->all(), [
            'part' => ['required', 'array', 'min:1'],
            'part.*' => ['required'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Debe agregar al menos 1 bollo.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $budget = Budget::where('id', $request->budget_id)->first();
        if ( !$budget ) {
            Session::flash('flash_message', __('- No existe el presupuesto.'));
            Session::flash('flash_type', 'alert-danger');
            return back();
        }

        $car = Car::where('plate', $request->plate)->first();

        if (!$car) {
            $car = Car::create([
                'client_id' => $request->client_id,
                'plate' => $request->plate,
                'brand' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
            ]);
        }

        $manual = isset($request->manual_check) ? 1 : 0;

        $flag = $budget->update([
                    'client_id' => $request->client_id,
                    'technical_id' => $request->technical_id,
                    'perito_id' => $request->perito_id,
                    'date' => now(),
                    'car_id' => $car->id,
                    'public_comment' => $request->public_comment,
                    'private_comment' => $request->private_comment,
                    'currency' => $request->currency,
                    'cia_sure' => $request->cia,
                    'iva_rate' => $request->iva,
                    'total' => ($request->grand_total - $request->iva_total),
                    'iva' => $request->iva_total,
                    'grand_total' => $request->grand_total,
                    'tarifa_pdr' => $request->tarifa,
                    'manual' => $manual,
                    'desmontaje' => $request->desmontaje,
                ]);
        
        $budget->items()->delete();
        foreach ($request->part as $key => $value) {
            BudgetItem::create([
                                'budget_id' => $budget->id,
                                'part' => $request->part[$key],
                                'material' => $request->material[$key],
                                'small' => $request->small_damage[$key],
                                'medium' => $request->medium_damage[$key],
                                'big' => $request->big_damage[$key],
                                'paint' => $request->topaint_damage[$key],
                                'small_vds' => $request->small_vd[$key],
                                'medium_vds' => $request->medium_vd[$key],
                                'big_vds' => $request->big_vd[$key],
                                'paint_vds' => $request->topaint_vd[$key],
                                'total_vds' => $request->totalrow[$key],
                                'total_money' => $request->totalMoneyRow[$key],
                            ]);
        }

        if($request->hasFile('file')) {
            $images = array();
            // Upload path
            $destinationPath = public_path().'/images/budgets/';

            // Create directory if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('file') as $key => $value) {
                // Get file extension
                $extension = $value->getClientOriginalExtension();

                // Valid extensions
                $validextensions = array("jpeg","jpg","png","pdf");

                // Check extension
                if(in_array(strtolower($extension), $validextensions)){
                    // Rename file 
                    $fileName = $value->getClientOriginalName().time() .'.' . $extension;
                    // Uploading file to given path
                    $value->move($destinationPath, $fileName);
                    array_push($images, $fileName);
                }
            }
            $images = $images;
            $budget->attached = $images;
            $budget->save();
        }

        Session::flash('flash_message', __('- Presupuesto actualizado con éxito.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('budget.show', ['id' => $budget->id]);
    }

    public function alloweds(Request $request)
    {
        return view('budgets.autorizes', ['budget' => Budget::find($request->id)]);
    }

    public function autorize(Request $request)
    {
        dd($request->all());
    }
}