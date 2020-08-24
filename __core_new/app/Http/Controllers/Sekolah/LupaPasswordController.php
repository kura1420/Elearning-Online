<?php

namespace App\Http\Controllers\Sekolah;

use Validator;
use App\Sekolah;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LupaPasswordController extends Controller
{
    //
    const FOLDER = 'sekolah.auth.';

    public function index($sekolah_id)
    {
        $row = Sekolah::findOrFail($sekolah_id);

        return view(self::FOLDER . 'lupa_password')
                ->with([
                    'row' => $row,
                ]);
    }

    public function check(Request $request)
    {
        Validator::make($request->all(), [
            'nomor_induk' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'tipe' => 'required|string',
            'sekolah' => 'required|string',
        ])->validate();

        $table = NULL;
        switch ($request->tipe) {
            case 'gr':
                $table = 'gurus';
                break;

            case 'ss':
                $table = 'siswas';
                break;
            
            default:
                return abort(404);
                break;
        }

        $check = DB::table($table)->where([
            ['nomor_induk', $request->nomor_induk],
            ['tanggal_lahir', date('Y-m-d', strtotime($request->tanggal_lahir))],
            ['sekolah_id', $request->sekolah]
        ]);

        if ($check->count() !== 0) {
            $row = $check->first();

            return redirect("/sch/{$row->sekolah_id}/lupa-password/{$row->user_id}/reset");
        } else {
            return redirect("/sch/{$request->sekolah}/lupa-password")->with('error', 'Data tidak ditemukan.');
        }        
    }

    public function reset($sekolah_id, $user_id)
    {
        $row = \App\User::with('siswas')->findOrFail($user_id);

        return view(self::FOLDER . 'reset_password')
                ->with([
                    'row' => $row,
                ]);
    }

    public function resetProcess(Request $request, $sekolah_id, $user_id)
    {
        $row = \App\User::findOrFail($user_id);

        Validator::make($request->all(), [
            'password' => 'required|min:6',
        ])->validate();

        $row->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect("/sch/{$sekolah_id}/login")->with('info', 'User anda sudah berhasil di reset passwordnya.');
    }
}
