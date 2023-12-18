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
    public function user_home()
    {
        return view('users.user');
    }

    public function managerHome()
    {
        return view('managerHome');
    }

    public function index() {
        return view('welcome');
    }
}
