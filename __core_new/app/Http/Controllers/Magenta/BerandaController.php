<?php

namespace App\Http\Controllers\Magenta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    //
    const FOLDER = 'magenta.beranda.';

    public function index()
    {
        return view(self::FOLDER . 'index');
    }
}
