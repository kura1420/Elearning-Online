<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        $rows = \App\Sekolah::all();

        return view('welcome', compact('rows'));
    }
}
