<?php

namespace App\Http\Controllers\Sekolah;

use App\Sekolah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    //
    const FOLDER = 'sekolah.sekolah.';
    const URL = '/sch/profil-sekolah';

    public function index($sekolah_id)
    {
        $row = Sekolah::findOrFail($sekolah_id);

        return view(self::FOLDER . 'index')
                ->with([
                    'url' => self::URL,
                    'row' => $row
                ]);
    }

    public function update(Request $request, $sekolah_id)
    {
        $row = Sekolah::findOrFail($sekolah_id);

        $rulesTableUnique = '|unique:sekolahs';

        $unique_npsn = $request->npsn !== $row->npsn ? $rulesTableUnique : '';
        $unique_nama = $request->nama !== $row->nama ? $rulesTableUnique : '';
        $unique_email = $request->email !== $row->email ? $rulesTableUnique : '';
        $unique_fax = $request->fax !== $row->fax ? $rulesTableUnique : '';
        // $unique_singkatan = $request->singkatan !== $row->singkatan ? $rulesTableUnique : '';

        $rules = [
            'npsn' => 'nullable|string' . $unique_npsn,
            'nama' => 'required|string|min:2|max:255' . $unique_nama,
            'status' => 'required|string',
            'pendidikan' => 'required|string',
            'logo' => 'nullable|string',
            'alamat' => 'required|string|min:2',
            'telp' => 'nullable|min:13|max:14',
            'email' => 'nullable|string|email|min:2|max:50' . $unique_email,
            'fax' => 'nullable|string|min:2|max:20' . $unique_fax,
            // 'singkatan' => 'required|string|alpha_num|max:50|min:2' . $unique_singkatan,
        ];

        $request->validate($rules);

        $row->update([
            'npsn' => $request->npsn,
            'nama' => $request->nama,
            'status' => $request->status,
            'pendidikan' => $request->pendidikan,
            'logo' => $request->logo,
            'alamat' => $request->alamat,
            'email' => strtolower($request->email),
            'telp' => $request->telp,
            'fax' => $request->fax,
            // 'singkatan' => strtoupper($request->singkatan),
        ]);

        return response()->json();
    }
}
