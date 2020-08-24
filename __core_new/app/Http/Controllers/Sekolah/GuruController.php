<?php

namespace App\Http\Controllers\Sekolah;

use App\User;
use App\Guru;
use App\DataTables\GurusDataTable;
use App\Imports\GurusImport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Carbon\Carbon;
use App\Rules\SekolahFieldUnique;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuruController extends Controller
{

    const FOLDER = 'sekolah.guru.';
    const URL = '/sch/guru';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GurusDataTable $dataTable)
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
        $pelajarans = \App\Pelajaran::where('sekolah_id', session('sch_id'))->orderBy('nama', 'asc')->get();

        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                    'pelajarans' => $pelajarans,
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
        Validator::make($request->all(), [
            'nomor_induk' => [
                'nullable',
                'string',
                'max:100',
                new SekolahFieldUnique('gurus'),
            ],
            'nama' => 'required|string|min:2|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|min:2|max:255',
            'tanggal_lahir' => 'nullable|date|before:' . Carbon::now()->format('Y'),
            'alamat' => 'nullable|string|min:2',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:100',
                new SekolahFieldUnique('gurus'),
            ],
            'handphone' => 'required|numeric',
            'telp' => 'nullable|numeric',
            'tanggal_masuk' => 'nullable|date',
            'jabatan' => 'nullable|string|min:2|max:191',

            'pelajaran' => 'required|array',
            
            'username' => [
                'required',
                'string',
                'alpha_num',
                'min:4',
                'max:100',
                function ($attr, $val, $fail) {
                    $username = session('sch_shortname') . '_' . strtolower($val);
                    $check = User::where('username', $username)->count();

                    if ($check !== 0) {
                        $fail("Username sudah tersedia.");
                    }
                }
            ],
            'password' => 'required|string|min:6|max:191',
        ])->validate();

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama,
                'email' => strtolower($request->email),
                'username' => session('sch_shortname') . '_' . strtolower($request->username),
                'username_sch' => strtolower($request->username),
                'password' => bcrypt($request->password),
                'level' => 'gr',
                'active' => 1,
                'type' => 'sch',
            ]);

            $guru = Guru::create([
                'nomor_induk' => $request->nomor_induk,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => isset($request->tanggal_lahir) ? date('Y-m-d', strtotime($request->tanggal_lahir)) : NULL,
                'alamat' => $request->alamat,
                'email' => strtolower($request->email),
                'handphone' => $request->handphone,
                'telp' => $request->telp,
                'tanggal_masuk' => isset($request->tanggal_masuk) ? date('Y-m-d', strtotime($request->tanggal_masuk)) : NULL,
                'tanggal_keluar' => NULL,
                'jabatan' => $request->jabatan,

                'user_id' => $user->id,
            ]);

            $insertGuruPelajaran = [];
            foreach ($request->pelajaran as $p) {
                $insertGuruPelajaran[] = [
                    'aktif' => 1,
                    'guru_id' => $guru->id,
                    'pelajaran_id' => $p,
                ];
            }
            $guru->guru_pelajarans()->createMany($insertGuruPelajaran);
        });

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
        $row = Guru::findOrFail($id);

        return view(self::FOLDER . 'show')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                ]);
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
        $row = Guru::findOrFail($id);
        $user = User::findOrFail($row->user_id);
        $guruPelajarans = $row->guru_pelajarans()->pluck('pelajaran_id')->toArray();

        $pelajarans = \App\Pelajaran::where('sekolah_id', session('sch_id'))->orderBy('nama', 'asc')->get();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'user' => $user,
                    'guruPelajarans' => $guruPelajarans,
                    'pelajarans' => $pelajarans,
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
        $row = Guru::findOrFail($id);

        $unique_nomorInduk = $row->nomor_induk !== $request->nomor_induk ? new SekolahFieldUnique('gurus') : NULL;
        $unique_email = $row->email !== $request->email ? new SekolahFieldUnique('gurus') : NULL;

        $rules = [
            'nomor_induk' => [
                'nullable',
                'string',
                'max:100',
                $unique_nomorInduk,
            ],
            'nama' => 'required|string|min:2|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|min:2|max:255',
            'tanggal_lahir' => 'nullable|date|before:' . Carbon::now()->format('Y'),
            'alamat' => 'nullable|string|min:2',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:100',
                $unique_email,
            ],
            'handphone' => 'required|numeric',
            'telp' => 'nullable|numeric',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date',
            'jabatan' => 'nullable|string|min:2|max:191',

            'pelajaran' => 'required|array',
        ];

        $user_guru = [
            'nomor_induk' => $request->nomor_induk,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => isset($request->tanggal_lahir) ? date('Y-m-d', strtotime($request->tanggal_lahir)) : NULL,
            'alamat' => $request->alamat,
            'email' => strtolower($request->email),
            'handphone' => $request->handphone,
            'telp' => $request->telp,
            'tanggal_masuk' => isset($request->tanggal_masuk) ? date('Y-m-d', strtotime($request->tanggal_masuk)) : NULL,
            'tanggal_keluar' => isset($request->tanggal_keluar) ? date('Y-m-d', strtotime($request->tanggal_keluar)) : NULL,
            'jabatan' => $request->jabatan,
        ];

        $user = [
            'name' => $request->nama,
            'email' => strtolower($request->email),
            'active' => isset($request->tanggal_keluar) ? 0 : 1,
        ];

        if ($request->password) {
            $rules['password'] = 'required|string|min:6|max:191';

            $user['password'] = bcrypt($request->password);
        }

        Validator::make($request->all(), $rules)->validate();

        DB::transaction(function () use ($request, $row, $user_guru, $user) {
            User::findOrFail($row->user_id)->update($user);
            
            $row->update($user_guru);       

            $guruPelajarans = $row->guru_pelajarans();            
            
            $guruPelajarans->delete();

            $insertGuruPelajaran = [];
            foreach ($request->pelajaran as $p) {
                $insertGuruPelajaran[] = [
                    'aktif' => 1,
                    'guru_id' => $row->id,
                    'pelajaran_id' => $p,
                ];
            }
            $guruPelajarans->createMany($insertGuruPelajaran);
        });

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
        $row = Guru::findOrFail($id);

        User::findOrFail($row->user_id)
            ->update([
                'active' => 0,
            ]);
            
        $row->delete();

        return response()->json();
    }

    public function import()
    {
        return view(self::FOLDER . 'import')
                ->with([
                    'url' => self::URL,
                ]);
    }
    
    public function importStore(Request $request)
    {
        Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ])->validate();

        Excel::import(new GurusImport, request()->file('file'));

        return redirect(self::URL)->with('success', 'Import Data Berhasil.');
    }
}
