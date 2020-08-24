<?php

namespace App\Http\Controllers\Sekolah;

use Validator;
use App\Sekolah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index($sekolah_id)
    {
        if (! Auth::check()) {
            $row = Sekolah::findOrFail($sekolah_id);

            return view('sekolah.auth.login', compact('row'));
        } else {
            $user = Auth::user();

            if ($user->type == 'sch') {
                return redirect('/sch');
            } elseif ($user->type == 'mgt') {
                return redirect('/mgt');
            } else {
                return redirect('/');
            }
        }        
    }

    public function process(Request $request, $sekolah_id)
    {
        $sekolah = Sekolah::findOrFail($sekolah_id);

        Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'sekolah' => 'required|string',
        ])->validate();

        $credentials = [
            'username' => strtolower($sekolah->singkatan) . '_'  . $request->username,
            'password' => $request->password,
            'active' => 1,
            'type' => 'sch'
        ];

        if (Auth::attempt($credentials)) {
            $userLevel = auth()->user()->level;
            $userSekolah = NULL;
            switch ($userLevel) {
                case 'ss': 
                    $userSekolah = \App\Siswa::where('user_id', Auth::id())->first();

                    session([
                        'sch_id' => $userSekolah->sekolah_id,
                        'sch_pic' => $userSekolah->id,
                        'sch_shortname' => strtolower($sekolah->singkatan),
                    ]);
                    break;

                case 'gr':
                    $userSekolah = \App\Guru::where('user_id', Auth::id())->first();

                    session([
                        'sch_id' => $userSekolah->sekolah_id,
                        'sch_pic' => $userSekolah->id,
                        'sch_shortname' => strtolower($sekolah->singkatan),
                    ]);
                    break;

                case 'asc':
                    $userSekolah = \App\PicSekolah::where('user_id', Auth::id())->first();

                    session([
                        'sch_id' => $userSekolah->sekolah_id,
                        'sch_pic' => $userSekolah->id,
                        'sch_shortname' => strtolower($sekolah->singkatan),
                    ]);
                    break;
                
                default:
                    $userSekolah = NULL;
                    break;
            }

            if (isset($userSekolah)) {
                if ($userLevel == 'ss') {
                    return redirect('/sch/ganti-password/' . session('sch_pic'));
                } else {
                    if ($userLevel == 'ss') {
                        return redirect('/sch/ujian-harian-siswa');
                    } else {
                        return redirect('/sch');
                    }
                }               
            } else {
                return redirect('/sch/' . $sekolah->id . '/login')->with('wrong_username_password', 'Salah username dan password.');
            }
        } else {
            return redirect('/sch/' . $sekolah->id . '/login')->with('wrong_username_password', 'Salah username dan password.');
        }        
    }

    public function logout(Request $request, $sekolah_id)
    {
        $sekolah = Sekolah::findOrFail($sekolah_id);

        if (Auth::check()) {
            Auth::logout();

            return redirect('/');
        } else {
            return redirect('/sch/' . $sekolah->id . '/login');
        }
    }
}
