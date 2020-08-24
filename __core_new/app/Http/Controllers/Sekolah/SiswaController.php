<?php

namespace App\Http\Controllers\Sekolah;

use App\User;
use App\Siswa;
use App\SiswaKelas;
use App\DataTables\SiswaDataTable;
use App\Imports\SiswasImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\SekolahFieldUnique;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaController extends Controller
{

    const FOLDER = 'sekolah.siswa.';
    const URL = '/sch/siswa';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tahunAjarans = [];
        if (auth()->user()->level == 'gr') {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->whereIn('id', \App\TahunAjaranJadwal::whereGuruId(session()->get('sch_pic'))->select('tahun_ajaran_id')->get()->toArray())
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        } else {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        }

        return view(self::FOLDER . 'index')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tahunAjarans = [];
        if (auth()->user()->level == 'gr') {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->whereIn('id', \App\TahunAjaranJadwal::whereGuruId(session()->get('sch_pic'))->select('tahun_ajaran_id')->get()->toArray())
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        } else {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        }

        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
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
                'required',
                'string',
                'max:255',
                new SekolahFieldUnique('siswas'),
            ],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date|before:' . Carbon::now()->format('Y'),
            'alamat' => 'nullable|string',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:100',
            ],
            'handphone' => 'nullable|numeric',
            'telp' => 'nullable|numeric',

            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'keterangan' => 'nullable|string',
        ])->validate();

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama,
                'email' => strtolower($request->email),
                'username' => session('sch_shortname') . '_' . strtolower($request->nomor_induk),
                'username_sch' => strtolower($request->nomor_induk),
                'password' => bcrypt(date('dmY', strtotime($request->tanggal_lahir))), # 19062019
                'level' => 'ss',
                'active' => 1,
                'type' => 'sch',
            ]);

            $siswa = Siswa::create([                
                'nomor_induk' => $request->nomor_induk,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => isset($request->tanggal_lahir) ? date('Y-m-d', strtotime($request->tanggal_lahir)) : NULL,
                'alamat' => $request->alamat,
                'email' => strtolower($request->email),
                'handphone' => $request->handphone,
                'telp' => $request->telp,
                'perbarui_password' => NULL,
                'user_id' => $user->id,
            ]);

            $siswa->siswa_kelas()->create([
                'aktif' => 1,
                'keterangan' => $request->keterangan,
                'tahun_ajaran_id' => $request->tahun_ajaran,
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas,
            ]);
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
        $row = Siswa::findOrFail($id);

        $siswa_kelas = $row->siswa_kelas()
                            ->join('kelas', 'siswa_kelas.kelas_id', '=', 'kelas.id')
                            ->join('tahun_ajarans', 'siswa_kelas.tahun_ajaran_id', '=', 'tahun_ajarans.id')
                            ->orderBy('siswa_kelas.created_at', 'asc')
                            ->select([
                                'siswa_kelas.id',
                                'siswa_kelas.keterangan',
                                DB::raw('CONCAT(tahun_ajarans.merge_periode, "/", tahun_ajarans.semester) AS tahun_ajaran_id'),
                                'kelas.nama as kelas_id',
                            ])
                            ->get();

        $tahunAjarans = \App\TahunAjaran::where('sekolah_id', session('sch_id'))
                            ->orderBy('periode_awal', 'asc')
                            ->get();

        $kelas = \App\Kelas::where('sekolah_id', session('sch_id'))
                    ->orderBy('nama', 'asc')
                    ->get();

        return view(self::FOLDER . 'show')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'tahunAjarans' => $tahunAjarans,
                    'siswa_kelas' => $siswa_kelas,
                    'kelas' => $kelas,
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
        $row = Siswa::findOrFail($id);

        $siswa_kelas = $row->siswa_kelas()
                            ->join('kelas', 'siswa_kelas.kelas_id', '=', 'kelas.id')
                            ->join('tahun_ajarans', 'siswa_kelas.tahun_ajaran_id', '=', 'tahun_ajarans.id')
                            ->orderBy('siswa_kelas.created_at', 'asc')
                            ->select([
                                'siswa_kelas.id',
                                'siswa_kelas.keterangan',
                                DB::raw('CONCAT(tahun_ajarans.merge_periode, "/", tahun_ajarans.semester) AS tahun_ajaran_id'),
                                'kelas.nama as kelas_id',
                            ])
                            ->get();

        $tahunAjarans = [];
        if (auth()->user()->level == 'gr') {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->whereIn('id', \App\TahunAjaranJadwal::whereGuruId(session()->get('sch_pic'))->select('tahun_ajaran_id')->get()->toArray())
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        } else {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        }

        $kelas = \App\Kelas::where('sekolah_id', session('sch_id'))
                    ->orderBy('nama', 'asc')
                    ->get();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'tahunAjarans' => $tahunAjarans,
                    'siswa_kelas' => $siswa_kelas,
                    'kelas' => $kelas,
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
        $row = Siswa::findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date|before:' . Carbon::now()->format('Y'),
            'alamat' => 'nullable|string',
            'email' => 'nullable|string|email|min:2|max:100',
            'handphone' => 'nullable|numeric',
            'telp' => 'nullable|numeric',
        ];

        $siswa = [
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => isset($request->tanggal_lahir) ? date('Y-m-d', strtotime($request->tanggal_lahir)) : NULL,
            'alamat' => $request->alamat,
            'email' => strtolower($request->email),
            'handphone' => $request->handphone,
            'telp' => $request->telp,
        ];

        $siswa_kelas = [];

        $user = [
            'name' => $request->nama,
            'email' => strtolower($request->email),
        ];

        if ($request->tahun_ajaran) {
            $rules['tahun_ajaran'] = 'required|string';
            $rules['kelas'] = [
                'required',
                'string',
                function ($attr, $val, $fail) use ($request, $row) {
                    $check = SiswaKelas::where('tahun_ajaran_id', $request->tahun_ajaran)
                                ->where('kelas_id', $request->kelas)
                                ->where('siswa_id', $row->id)
                                ->where('sekolah_id', session('sch_id'))
                                ->count();
    
                    if ($check !== 0) {
                        $fail("Data tahun ajaran dan kelas siswa sudah tersedia.");
                    }
                }
            ];
            $rules['keterangan'] = 'nullable|string';

            $siswa_kelas['aktif'] = 1;
            $siswa_kelas['keterangan'] = $request->keterangan;
            $siswa_kelas['tahun_ajaran_id'] = $request->tahun_ajaran;
            $siswa_kelas['siswa_id'] = $row->id;
            $siswa_kelas['kelas_id'] = $request->kelas;
        }

        if ($request->password) {
            $rules['password'] = 'required|string|min:6|max:255';

            $siswa['perbarui_password'] = Carbon::now();

            $user['password'] = bcrypt($request->password);
        }

        Validator::make($request->all(), $rules)->validate();

        DB::transaction(function () use ($request, $row, $siswa, $siswa_kelas, $user) {
            User::findOrFail($row->user_id)->update($user);
            
            $row->update($siswa);

            if (count($siswa_kelas)) {
                $row->siswa_kelas()->create($siswa_kelas);
            }
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
        $row = Siswa::findOrFail($id);

        User::findOrFail($row->user_id)
            ->update([
                'active' => 0,
            ]);

        $row->ujian_harian_hasils()->delete();
        $row->ujian_harian_jawaban_siswas()->delete();
        $row->ujian_harian_siswas()->delete();

        $row->siswa_kelas()->update(['aktif' => 0]);
        $row->delete();

        return response()->json();
    }

    public function import()
    {
        $tahunAjarans = [];
        if (auth()->user()->level == 'gr') {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->whereIn('id', \App\TahunAjaranJadwal::whereGuruId(session()->get('sch_pic'))->select('tahun_ajaran_id')->get()->toArray())
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        } else {
            $tahunAjarans = \App\TahunAjaran::select('id', 'merge_periode', 'semester')
                            ->where('sekolah_id', session('sch_id'))
                            ->orderBy('periode_awal', 'asc')
                            ->get();
        }

        return view(self::FOLDER . 'import')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
                ]);
    }
    
    public function importStore(Request $request)
    {
        Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xls,xlsx',
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
        ])->validate();

        Excel::import(new SiswasImport($request->tahun_ajaran, $request->kelas), request()->file('file'));

        return redirect(self::URL)->with('success', 'Import Data Berhasil.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'siswa' => 'required|string',
        ]);

        $row = Siswa::findOrFail($request->siswa);

        User::findOrFail($row->user_id)->update([
            'password' => bcrypt(date('dmY', strtotime($row->tanggal_lahir))),
        ]);

        $row->update([
            'perbarui_password' => NULL
        ]);

        return response()->json();
    }
}
