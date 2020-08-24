<?php

namespace App\Http\Controllers\Sekolah;

use App\TahunAjaran;
use App\TahunAjaranJadwal;
use App\DataTables\TahunAjaransDataTable;
use Carbon\Carbon;
use App\Rules\SekolahFieldUnique;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{

    const FOLDER = 'sekolah.tahun_ajaran.';
    const URL = '/sch/tahun-ajaran';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TahunAjaransDataTable $dataTable)
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
        $kelas = \App\Kelas::where('sekolah_id', session('sch_id'))
                    ->orderBy(DB::raw('nama'), 'asc')
                    ->get();

        $pelajarans = \App\Pelajaran::where('sekolah_id', session('sch_id'))
                        ->orderBy('nama', 'asc')
                        ->get();

        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                    'kelas' => $kelas,
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
        $this->validate($request, [
            'periode_awal' => 'required|string|min:3|max:4',
            'periode_akhir' => 'required|string|min:3|max:4|after:' . $request->periode_awal,
            'semester' => [
                'required',
                'string',
                function ($attr, $val, $fail) use ($request) {
                    $check = TahunAjaran::where('periode_awal', $request->periode_awal)
                                ->where('periode_akhir', $request->periode_akhir)
                                ->where('semester', $request->semester)
                                ->where('sekolah_id', session('sch_id'))
                                ->count();

                    if ($check > 0) {
                        $fail("Data tahun ajaran sudah tersedia.");
                    }
                }
            ],
            'list_mata_pelajaran_kelas' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            $tahunAjaran = TahunAjaran::create([
                'periode_awal' => $request->periode_awal,
                'periode_akhir' => $request->periode_akhir,
                'merge_periode' => $request->periode_awal . '-' . $request->periode_akhir,
                'semester' => $request->semester,
            ]);

            $insertTahunAjaranJadwal = [];
            foreach ($request->list_mata_pelajaran_kelas as $jadwal) {
                $insertTahunAjaranJadwal[] = [
                    'pelajaran_id' => $jadwal['pelajaran_id'],
                    'kelas_id' => $jadwal['kelas_id'],
                    'guru_id' => $jadwal['user_guru_id'],
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ];
            }
            $tahunAjaran->tahun_ajaran_jadwals()->createMany($insertTahunAjaranJadwal);

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
        $row = TahunAjaran::findOrFail($id);
        $tahunAjaranJadwals = $row->tahun_ajaran_jadwals()
                                    ->join('pelajarans', 'tahun_ajaran_jadwals.pelajaran_id', '=', 'pelajarans.id')
                                    ->join('kelas', 'tahun_ajaran_jadwals.kelas_id', '=', 'kelas.id')
                                    ->join('gurus', 'tahun_ajaran_jadwals.guru_id', '=', 'gurus.id')
                                    ->select([
                                        'tahun_ajaran_jadwals.pelajaran_id',
                                        'tahun_ajaran_jadwals.kelas_id',
                                        'tahun_ajaran_jadwals.guru_id as user_guru_id',
                                        'pelajarans.nama as pelajaran_nama',
                                        'gurus.nama as user_guru_nama',
                                    ])
                                    ->get()
                                    ->toArray();
                                    
        $kelas = \App\Kelas::where('sekolah_id', session('sch_id'))
                    ->orderBy(DB::raw('nama'), 'asc')
                    ->get();

        $pelajarans = \App\Pelajaran::where('sekolah_id', session('sch_id'))
                        ->orderBy('nama', 'asc')
                        ->get();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'tahunAjaranJadwals' => $tahunAjaranJadwals,
                    'kelas' => $kelas,
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
        $row = TahunAjaran::findOrFail($id);

        $this->validate($request, [
            'periode_awal' => 'required|string|min:3|max:4',
            'periode_akhir' => 'required|string|min:3|max:4|after:' . $request->periode_awal,
            'semester' => [
                'required',
                'string',
                function ($attr, $val, $fail) use ($request, $row) {
                    if ($row->periode_awal !== $request->periode_awal && $row->periode_akhir !== $request->periode_akhir || $row->semester !== $request->semester) {
                        $check = TahunAjaran::where('periode_awal', $request->periode_awal)
                                ->where('periode_akhir', $request->periode_akhir)
                                ->where('semester', $request->semester)
                                ->where('sekolah_id', session('id'))
                                ->count();

                        if ($check > 0) {
                            $fail("Data tahun ajaran sudah tersedia.");
                        }
                    }
                }
            ],
            'list_mata_pelajaran_kelas' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            $row->update([
                'periode_awal' => $request->periode_awal,
                'periode_akhir' => $request->periode_akhir,
                'merge_periode' => $request->periode_awal . '-' . $request->periode_akhir,
                'semester' => $request->semester,
            ]);

            $insertTahunAjaranJadwal = [];
            foreach ($request->list_mata_pelajaran_kelas as $jadwal) {                
                $check = \App\TahunAjaranJadwal::where('pelajaran_id', $jadwal['pelajaran_id'])
                            ->where('kelas_id', $jadwal['kelas_id'])
                            ->where('guru_id', $jadwal['user_guru_id'])
                            ->where('tahun_ajaran_id', $row->id)
                            ->where('sekolah_id', session('sch_id'))
                            ->count();

                if ($check == 0) {
                    $insertTahunAjaranJadwal[] = [
                        'pelajaran_id' => $jadwal['pelajaran_id'],
                        'kelas_id' => $jadwal['kelas_id'],
                        'guru_id' => $jadwal['user_guru_id'],
                        'tahun_ajaran_id' => $row->id,
                    ];
                }
            }

            if (count($insertTahunAjaranJadwal)) {
                $row->tahun_ajaran_jadwals()->createMany($insertTahunAjaranJadwal);
            }

            DB::commit();

            return response()->json();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json($th, 500);
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
        $row = TahunAjaran::findOrFail($id);

        $row->tahun_ajaran_jadwals()->delete();
        $row->delete();

        return response()->json();
    }
}
