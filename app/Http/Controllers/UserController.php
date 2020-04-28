<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;

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
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);
        return view('users.show', ['user' => $user]);
    }

    public function update(Request $request)
    {
        User::find($request->id)->update($request->only('name'));

        return back()->withStatus(__('Actualización exitosa.'));
    }

    public function updatePass(PasswordRequest $request)
    {
        User::find($request->id)->update(['password' => Hash::make($request->get('password'))]);

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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ( $validator->fails() ) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (is_null($user)) {
            return back()->withErrors(['create' => 'No se pudo guardar, intenta más tarde']);
        }

        return redirect()->route('user.index');
    }
}
