<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
            dd($validator);
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
            dump('se crea carro porque no existe');
            $car = Car::create([
                'client_id' => $request->client_id,
                'plate' => $request->plate,
                'brand' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
            ]);
        }

        $budget = Budget::create([
                    'client_id' => $request->client_id,
                    'technical_id' => $request->technical_id,
                    'perito_id' => $request->perito_id,
                    'date' => now(),
                    'car_id' => $car->id,
                    'public_comment' => $request->public_comment,
                    'private_comment' => $request->private_comment,
                    'cia_sure' => $request->cia,
                    'iva_rate' => $request->iva,
                    'total' => ($request->grand_total - $request->iva_total),
                    'iva' => $request->iva_total,
                    'grand_total' => $request->grand_total,
                    'tarifa_pdr' => $request->tarifa,
                ]);
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
        return view('budgets.edit', [ 'invoice' => Budget::where('id', $request->id)->first() ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => ['required', 'string', 'min:4', 'exists:clients,name'],
            'date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:pending,payed'],
            'type' => ['required', 'string', 'in:sell,buy'],
            'comment' => ['nullable', 'string', 'min:1'],
            'pay_way' => ['required', 'string'],
            'itemname' => ['required', 'array', 'min:1'],
            'itemname.*' => ['required'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Por favor, revise los datos e intente nuevamente 1.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        $total = floatval(0);
        $iva = floatval(0);
        $grand_total = floatval(0);

        // Calcular total de la factura
        foreach ($request->itemname as $key => $value) {
            $amount = floatval($request->itemprice[$key]) * intval($request->itemqty[$key]);
            $tax_rate = floatval($request->taxrate[$key] / 100);
            $iva += floatval($amount * $tax_rate);
            $total +=  $amount;
        }

        $grand_total =  $total + $iva;

        $invoice_args = $request->only(['client', 'date', 'due_date','status', 'type', 'comment', 'pay_way']);
        $invoice_args['client_id'] = Client::where('name', $request->client)->first()->id;
        $invoice_args['total'] = round($total, 2);
        $invoice_args['iva'] = round($iva, 2);
        $invoice_args['grand_total'] = round($grand_total, 2);

        $invoice = Budget::find($request->id);
        try {
            $invoice->update($invoice_args);

            // Agregar items de la factura
            foreach ($request->itemname as $key => $value) {
                if ($request->itemqty[$key] == null || $request->itemprice[$key] == null) {
                    $invoice->items()->delete();
                    $invoice->delete();
                    Session::flash('flash_message', __('- Por favor, complete todos los datos e intente nuevamente.'));
                    Session::flash('flash_type', 'alert-danger');
                    return back()->withErrors($validator)->withInput();
                } elseif ($key == 0) {
                    $invoice->items()->delete();
                }

                $amount = floatval($request->itemprice[$key]) * intval($request->itemqty[$key]);
                $tax_rate = floatval($request->taxrate[$key] / 100);
                $iva = floatval($amount * $tax_rate);


                Item::create(
                        array(
                                'invoice_id' => $invoice->id,
                                'name' => $value,
                                'description' => $request->itemdescription[$key],
                                'quantity' => $request->itemqty[$key],
                                'price' => round($request->itemprice[$key], 2),
                                'tax_rate' => round($tax_rate, 2),
                                'total' => round($amount, 2),
                                'tax' => round($iva, 2),
                                'grand_total' => round(($amount + $iva), 2),
                            )
                        );
            }
        } catch (Exception $e) {
            Session::flash('flash_message', __('+ Por favor, revise los datos e intente nuevamente 2.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors(['error' => 'Try later']);
        }

        Session::flash('flash_message', __('+ Factura registrada.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('budgets.index', ['type' => $invoice->type]);
    }
}