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
    	return view('clients.create');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:clients'],
			"nif" => ['required', 'string', 'max:15'],
			"type" => ['required', 'string','in:person,business'],
			"address" => ['required', 'string', 'max:100'],
			"population" => ['required', 'string', 'max:100'],
			"postal_code" => ['required', 'integer', 'digits_between:1,10'],
			"province" => ['required', 'string', 'max:100'],
			"country" => ['required', 'string', 'max:100', 'in:españa'],
			"commercial_name" => ['nullable', 'string', 'max:100'],
			"phone" => ['nullable', 'string', 'max:100'],
			"celphone" => ['nullable', 'string', 'max:100'],
			"website" => ['nullable', 'string', 'max:100'],
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
    	$validator = Validator::make($request->except(['email', 'country']), [
            'name' => ['required', 'string', 'max:80'],
			"nif" => ['required', 'string', 'max:15'],
			"type" => ['required', 'string','in:person,business'],
			"address" => ['required', 'string', 'max:100'],
			"population" => ['required', 'string', 'max:100'],
			"postal_code" => ['required', 'integer', 'digits_between:1,10'],
			"province" => ['required', 'string', 'max:100'],
			"commercial_name" => ['nullable', 'string', 'max:100'],
			"phone" => ['nullable', 'string', 'max:100'],
			"celphone" => ['nullable', 'string', 'max:100'],
			"website" => ['nullable', 'string', 'max:100'],
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Error en los datos, por favor verifique e intente de nuevo.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        Client::where('email', $request->email)->update($request->except(['email', 'country', '_token', '_method']));

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
}
