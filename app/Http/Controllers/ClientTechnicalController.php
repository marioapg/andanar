<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientTechnicalController extends Controller
{
    public function index(Request $request)
    {
    	return view('clients.index', ['clients' => Client::where('created_by', auth()->user()->id)->get()]);
    }
}