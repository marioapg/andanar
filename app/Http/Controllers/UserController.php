<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->where('type', '!=', 'admin')->paginate(15)]);
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);
        return view('users.show', ['user' => $user]);
    }

    public function update(Request $request)
    {
        User::find($request->id)->update($request->only(['name', 'phone', 'type', 'status']));

        Session::flash('flash_message', __('+ Actualización exitosa.'));
        Session::flash('flash_type', 'alert-success');
        return back()->withStatus(__('Actualización exitosa.'));
    }

    public function updatePass(PasswordRequest $request)
    {
        User::find($request->id)->update(['password' => Hash::make($request->get('password'))]);

        Session::flash('flash_message', __('+ Password cambiada con éxito.'));
        Session::flash('flash_type', 'alert-success');
        return back()->withStatusPassword(__('Password cambiada con éxito.'));
    }

    public function create(Request $request)
    {
        return view('users.create');
    }

    protected function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'type' => ['required'],
            'phone' => ['nullable']
        ]);

        if ( $validator->fails() ) {
            Session::flash('flash_message', __('- Error en los datos, por favor verifique e intente de nuevo.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors($validator)->withInput();
        }

        if ($request->type =! 'technical') {
            $pass = 'secret1234';
        } else {
            $pass = $request->password;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($pass),
            'type' => $request->type,
            'phone' => $request->phone,
            'created_by' => auth()->user()->id
        ]);


        if (is_null($user)) {
            Session::flash('flash_message', __('- Error en los datos, por favor verifique e intente de nuevo.'));
            Session::flash('flash_type', 'alert-danger');
            return back()->withErrors(['create' => 'No se pudo guardar, intenta más tarde']);
        }

        $user->roles()->attach(Role::where('name', 'user')->first());

        Session::flash('flash_message', __('+ Usuario creado con éxito.'));
        Session::flash('flash_type', 'alert-success');
        return redirect()->route('user.index');
    }

    public function delete(Request $request)
    {
        $user = User::where('id', $request->id)->first()->delete();
        Session::flash('flash_message', __('- Usuario eliminado.'));
        Session::flash('flash_type', 'alert-success');
        return redirect('/user');
    }
}