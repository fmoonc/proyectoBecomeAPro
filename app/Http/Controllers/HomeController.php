<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    public function admin(Request $req)
    {
        return view('admin'); //aqui irá la vista para el admin
    }

    public function user(Request $req)
    {
        return view('user'); //aqui irá la vista para el admin
    }
}