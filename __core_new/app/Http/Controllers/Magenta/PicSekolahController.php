<?php

namespace App\Http\Controllers\Magenta;

use App\User;
use App\Sekolah;
use App\PicSekolah;
use App\DataTables\PicSekolahsDataTable;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PicSekolahController extends Controller
{

    const FOLDER = 'magenta.pic_sekolah.';
    const URL = '/mgt/pic-sekolah';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PicSekolahsDataTable $dataTable)
    {
        //
        return $dataTable->render(self::FOLDER . 'index', ['url' => self::URL]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sekolahs = Sekolah::orderBy('nama', 'asc')->get();

        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                    'sekolahs' => $sekolahs,
                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'nama' => 'required|string|max:100',
            'email' => 'nullable|string|email|max:100',
            'handphone' => 'required|numeric',
            'telp' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'sekolah' => 'required|string',
        ];

        if (! empty($request->username) || ! empty($request->password)) {
            $rules['password'] = 'required|string|min:6';
            $rules['username'] = [
                'required',
                'string',
                'max:100',
                'alpha_num',
                function ($attr, $val, $fail) use ($request) {
                    $sekolah = Sekolah::where('id', $request->sekolah)->first();
                    
                    if (isset($sekolah)) {
                        $username = strtolower($sekolah->singkatan) . '_' . $val;

                        $check = User::where('username', $username)->count();

                        if ($check !== 0) {
                            $fail("Username sudah tersedia");
                        }
                    }
                }
            ];
        }

        Validator::make($request->all(), $rules)->validate();

        $user_id = NULL;
        if (isset($request->username) && isset($request->password)) {
            $sekolah = Sekolah::findOrFail($request->sekolah);
            $username = strtolower($sekolah->singkatan) . '_' . $request->username;

            $user = User::create([
                'name' => $request->nama,
                'email' => strtolower($request->email),
                'username' => $username,
                'username_sch' => $request->username,
                'password' => bcrypt($request->password),
                'level' => 'asc',
                'active' => 1,
                'type' => 'sch',
            ]);

            $user_id = $user->id;
        }

        PicSekolah::create([
            'nama' => $request->nama,
            'email' => strtolower($request->email),
            'handphone' => $request->handphone,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jabatan' => strtoupper($request->jabatan),
            'sekolah_id' => $request->sekolah,
            'user_id' => $user_id
        ]);

        return redirect(self::URL);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $sekolahs = Sekolah::orderBy('nama', 'asc')->get();

        $row = PicSekolah::findOrFail($id);
        $user = User::where('id', $row->user_id)->first();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'sekolahs' => $sekolahs,
                    'user' => $user,
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $row = PicSekolah::findOrFail($id);

        $rules = [
            'nama' => 'nullable|string|max:100',
            'email' => 'nullable|string|email|max:100',
            'handphone' => 'required|numeric',
            'telp' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'sekolah' => 'required|string',
        ];

        if (isset($row->user_id)) {
            if (! empty($request->password)) {
                $rules['password'] = 'required|string|min:6';
            }
        } else {
            if (! empty($request->username) || ! empty($request->password)) {
                $rules['password'] = 'required|string|min:6';
                $rules['username'] = [
                    'required',
                    'string',
                    'max:100',
                    'alpha_num',
                    function ($attr, $val, $fail) use ($request) {
                        $sekolah = Sekolah::where('id', $request->sekolah)->first();
                        
                        if (isset($sekolah)) {
                            $username = strtolower($sekolah->singkatan) . '_' . $val;
    
                            $check = User::where('username', $username)->count();
    
                            if ($check !== 0) {
                                $fail("Username sudah tersedia");
                            }
                        }
                    }
                ];
            }
        }

        Validator::make($request->all(), $rules)->validate();

        $user_id = NULL;
        if (isset($row->user_id)) {
            $userField = [
                'name' => $request->nama,
                'email' => strtolower($request->email),
            ];

            if (isset($request->password)) {
                $userField['password'] = bcrypt($request->password);
            }

            User::findOrFail($row->user_id)->update($userField);

            $user_id = $row->user_id;
        } else {
            if (isset($request->username) && isset($request->password)) {
                $sekolah = Sekolah::findOrFail($request->sekolah);
                $username = strtolower($sekolah->singkatan) . '_' . $request->username;
    
                $user = User::create([
                    'name' => $request->nama,
                    'email' => strtolower($request->email),
                    'username' => $username,
                    'username_sch' => $request->username,
                    'password' => bcrypt($request->password),
                    'level' => 'asc',
                    'active' => 1,
                    'type' => 'sch',
                ]);
    
                $user_id = $user->id;
            }
        }

        $row->update([
            'nama' => $request->nama,
            'email' => strtolower($request->email),
            'handphone' => $request->handphone,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jabatan' => strtoupper($request->jabatan),
            'sekolah_id' => $request->sekolah,
            'user_id' => $user_id,
        ]);

        return redirect(self::URL);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $row = PicSekolah::where('id', $id);

        if ($row->count() !== 0) {
            $r = $row->first();

            $user = User::where('id', $r->user_id);

            if ($user->count() !== 0) {
                $user->update([
                    'active' => 0,
                ]);
            }

            $row->delete();
        }

        return response()->json();
    }
}
