<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    //
    const FOLDER = 'sekolah.beranda.';

    public function index()
    {
        return view(self::FOLDER . 'index');
    }
}
