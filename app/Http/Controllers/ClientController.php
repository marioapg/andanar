<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Client;
use Session;

class ClientController extends Controller
{
    public function index(Request $request)
    {
    	return view('clients.index', ['clients' => Client::all()]);
    }

    public function show(Request $request)
    {
    	return view('clients.edit', ['client' => Client::find($request->id)]);
    
    }

    public function create(Request $request)
    {
        $countries = require '../vendor/umpirsky/country-list/data/es_VE/country.php';
    	return view('clients.create',['countries' => $countries]);
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:clients'],
			"document" => ['required', 'string', 'max:30'],
			"address" => ['required', 'string', 'max:100'],
			"city" => ['required', 'string', 'max:100'],
			"postal_code" => ['required', 'numeric', 'digits_between:1,10'],
			"state" => ['required', 'string', 'max:100'],
			"country" => ['required', 'string', 'max:100'],
			"phone" => ['nullable', 'string', 'max:100'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Error en los datos, por favor verifique e intente de nuevo.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        Client::create($request->all());

        Session::flash('flash_message', __('+ Datos actualizados'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('clients.index');
    }

    public function update(Request $request)
    {
    	$validator = Validator::make($request->except(['email']), [
            'name' => ['required', 'string', 'max:80'],
			"document" => ['required', 'string', 'max:100'],
			"address" => ['required', 'string', 'max:100'],
			"city" => ['required', 'string', 'max:100'],
			"postal_code" => ['required', 'numeric', 'digits_between:1,10'],
			"state" => ['required', 'string', 'max:100'],
            "country" => ['required', 'string', 'max:100'],
			"phone" => ['nullable', 'string', 'max:100']
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Error en los datos, por favor verifique e intente de nuevo.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        Client::where('email', $request->email)->update($request->except(['email', '_token', '_method']));

        Session::flash('flash_message', __('+ Datos actualizados'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('clients.index');
    }
/*
    public function search(Request $request)
    {
        $data = Client::select("name")
        ->where("name","LIKE","%{$request->input('query')}%")
        ->get();

        return response()->json($data);
    }
    */
    public function search(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = Client::select("name")
                    ->where("name","LIKE","%{$request->input('query')}%")
                    ->get();
            $output = '<ul class="" style="display:block; position:relative">';
            foreach($data as $row) {
                $output .= '<li><a href="#">'.$row->name.'</a></li>';
            }
            $output .= '</ul>';
            
            echo $output;
        }
    }

    public function delete(Request $request)
    {
        $client = Client::where('id', $request->id)->first()->delete();
        Session::flash('flash_message', __('- Usuario eliminado.'));
        Session::flash('flash_type', 'alert-success');
        return redirect('/user');
    }
}