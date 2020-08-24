<?php

namespace App\Http\Controllers\Magenta;

use App\Sekolah;
use App\PicSekolah;
use App\DataTables\SekolahsDataTable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SekolahController extends Controller
{

    const FOLDER = 'magenta.sekolah.';
    const URL = '/mgt/sekolah';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SekolahsDataTable $dataTable)
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
        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL
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
        $request->validate([
            'npsn' => 'nullable|string|unique:sekolahs',
            'nama' => 'required|string|min:2|max:255|unique:sekolahs',
            'status' => 'required|string',
            'pendidikan' => 'required|string',
            'logo' => 'nullable|string',
            'alamat' => 'required|string|min:2',
            'telp' => 'nullable|min:13|max:14',
            'email' => 'nullable|string|email|min:2|max:50|unique:sekolahs',
            'fax' => 'nullable|string|min:2|max:20|unique:sekolahs',
            // 'singkatan' => 'required|string|alpha_num|max:50|min:2|unique:sekolahs',

            'pic_sekolah' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $sekolah = Sekolah::create([
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
                'singkatan' => Str::random(5),
            ]);

            $sekolah->jenis_ujians()->createMany([
                [
                    'nama' => 'PR',
                    'jenis' => 'harian',
                    'sekolah_id' => $sekolah->id,
                ],
                [
                    'nama' => 'Ulangan',
                    'jenis' => 'harian',
                    'sekolah_id' => $sekolah->id,
                ],
                [
                    'nama' => 'Semester',
                    'jenis' => 'mingguan',
                    'sekolah_id' => $sekolah->id,
                ],
                [
                    'nama' => 'Try Out',
                    'jenis' => 'mingguan',
                    'sekolah_id' => $sekolah->id,
                ]
            ]);

            $sekolah->rumus_penilaian_ujians()->createMany([
                [
                    'nama' => 'Mudah',
                    'benar' => 1,
                    'salah' => 0,
                    'sekolah_id' => $sekolah->id,
                ],
                [
                    'nama' => 'Sedang',
                    'benar' => 2,
                    'salah' => 0,
                    'sekolah_id' => $sekolah->id,
                ],
                [
                    'nama' => 'Sulit',
                    'benar' => 3,
                    'salah' => 1,
                    'sekolah_id' => $sekolah->id,
                ],
            ]);
    
            $insertPicSekolah = [];
            $pic_sekolahs = $request->pic_sekolah;
            if (isset($pic_sekolahs)) {
                foreach ($pic_sekolahs as $pic_sekolah) {
                    $insertPicSekolah[] = [
                        'nama' => $pic_sekolah['nama'],
                        'email' => strtolower($pic_sekolah['email']),
                        'handphone' => $pic_sekolah['handphone'],
                        'telp' => $pic_sekolah['telp'],
                        'alamat' => $pic_sekolah['alamat'],
                        'jabatan' => $pic_sekolah['jabatan'],
                        'sekolah_id' => $sekolah->id,
                    ];
                }

                $sekolah->pic_sekolahs()->createMany($insertPicSekolah);
            }

            DB::commit();

            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
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
        $row = Sekolah::findOrFail($id);
        $pic_sekolahs = $row->pic_sekolahs()->get();

        return view(self::FOLDER . 'show')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'pic_sekolahs' => $pic_sekolahs
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
        $row = Sekolah::findOrFail($id);
        $pic_sekolahs = $row->pic_sekolahs()->orderBy('nama', 'asc')->get();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'pic_sekolahs' => $pic_sekolahs
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
        $row = Sekolah::findOrFail($id);

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

            'pic_sekolah' => 'nullable|array',
        ];

        $request->validate($rules);

        DB::beginTransaction();
        try {
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

            $insertPicSekolah = [];
            $pic_sekolahs = $request->pic_sekolah;
            if (isset($pic_sekolahs)) {
                foreach ($pic_sekolahs as $pic_sekolah) {
                    if ($pic_sekolah['status'] == 'new') {
                        $insertPicSekolah[] = [
                            'nama' => $pic_sekolah['nama'],
                            'email' => strtolower($pic_sekolah['email']),
                            'handphone' => $pic_sekolah['handphone'],
                            'telp' => $pic_sekolah['telp'],
                            'alamat' => $pic_sekolah['alamat'],
                            'jabatan' => $pic_sekolah['jabatan'],
                            'sekolah_id' => $row->id,
                        ];
                    }
                }

                if (count($insertPicSekolah) !== 0) {
                    $row->pic_sekolahs()->saveMany($insertPicSekolah);
                }
            }

            DB::commit();

            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
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
        $sekolah = Sekolah::findOrFail($id);

        $pic_sekolahs = $sekolah->pic_sekolahs();

        $users = $pic_sekolahs->whereNotNull('user_id');
        if ($users->count() !== 0) {
            \App\User::whereIn('id', $users->get('user_id')->toArray())
                ->update([
                    'active' => 0
                ]);
        }
        
        $pic_sekolahs->delete();
        $sekolah->delete();

        return response()->json();
    }
}
