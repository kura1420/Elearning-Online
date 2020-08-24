<?php

namespace App\Http\Controllers\Magenta;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index()
    {
        if (! Auth::check()) {
            return view('magenta.auth.login');
        } else {
            $user = Auth::user();

            if ($user->type == 'mgt') {
                return redirect('/mgt');
            } elseif ($user->type == 'sch') {
                return redirect('/sch');
            } else {
                return redirect('/');
            }
        }
    }

    public function process(Request $request)
    {
        Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ])->validate();

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'active' => 1,
            'type' => 'mgt',
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/mgt');
        } else {
            return redirect('/mgt/login')->with('wrong_username_password', 'Salah username dan password.');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect('/mgt/login');
    }
}
