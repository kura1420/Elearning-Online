<?php

namespace App\Http\Controllers\Sekolah;

use App\User;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginPertamaKaliController extends Controller
{
    //
    const FOLDER = 'sekolah.auth.';

    public function gantiPassword($sch_pic)
    {
        $userLevel = auth()->user()->level;

        switch ($userLevel) {
            case 'ss':
                $row = \App\Siswa::findOrFail($sch_pic);

                if (isset($row->perbarui_password)) {
                    return redirect('/sch/ujian-harian-siswa');
                } else {
                    return view(self::FOLDER . 'ganti_password')
                        ->with([
                            'row' => $row,
                        ]);
                }
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    public function gantiPasswordUpdate(Request $request, $sch_pic)
    {
        $userLevel = auth()->user()->level;

        switch ($userLevel) {
            case 'ss':
                $row = \App\Siswa::findOrFail($sch_pic);

                Validator::make($request->all(), [
                    'password' => 'required|string|min:6',
                ])->validate();

                $row->update([
                    'perbarui_password' => Carbon::now(),
                ]);

                User::findOrFail($row->user_id)
                    ->update([
                        'password' => bcrypt($request->password),
                    ]);

                return redirect('/sch/ujian-harian-siswa');
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    public function tidakGantiPassword($sch_pic)
    {
        $userLevel = auth()->user()->level;

        switch ($userLevel) {
            case 'ss':
                $row = \App\Siswa::findOrFail($sch_pic);

                $row->update([
                    'perbarui_password' => Carbon::now(),
                ]);

                return redirect('/sch/ujian-harian-siswa');
                break;
            
            default:
                return abort(404);
                break;
        }
    }
}
