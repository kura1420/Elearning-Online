<?php

namespace App\Http\Controllers\Sekolah;

use App\UjianHarian;
use App\UjianHarianSiswa;
use App\UjianHarianJawabanSiswa;
use App\UjianHarianHasil;
use App\RumusPenilaianUjian;
use App\Soal;
use App\SoalPertanyaan;
use App\SoalPertanyaanJawaban;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UjianHarianSiswaController extends Controller
{

    const FOLDER = 'sekolah.ujian_harian_siswa.';
    const URL = '/sch/ujian-harian-siswa';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rows = DB::table('ujian_harians as a')
                    ->join('ujian_harian_siswas as b', 'a.id', '=', 'b.ujian_harian_id')
                    ->join('pelajarans as c', 'a.pelajaran_id', '=', 'c.id')
                    ->join('soals as e', 'a.soal_id', '=', 'e.id')
                    ->join('jenis_ujians as f', 'a.jenis_ujian_id', '=', 'f.id')
                    ->where('b.siswa_id', session('sch_pic'))
                    ->where('a.sekolah_id', session('sch_id'))
                    ->where('b.status', 'BR')
                    ->orWhere('b.status', 'OP')
                    ->whereNull('b.deleted_at')
                    ->whereRaw('NOW() >= CAST(CONCAT(a.tanggal, " ", a.waktu_mulai) AS DATETIME) + INTERVAL -5 MINUTE AND NOW() <= CAST(CONCAT(a.tanggal, " ", a.waktu_habis) AS DATETIME)')
                    ->select([
                        'a.id as ujian_harian_id',
                        'e.judul',
                        DB::raw('DATE_FORMAT(a.tanggal, "%d-%m-%Y") as tanggal'),
                        'a.waktu_mulai',
                        'a.waktu_habis',
                            'b.id as ujian_harian_siswa_id',
                            'b.status',
                                'c.nama as pelajaran',
                                    'e.judul as soal',
                                        'f.nama as jenis_ujian'
                    ])
                    ->get();

        return view(self::FOLDER . 'index')
                ->with([
                    'url' => self::URL,
                    'rows' => $rows,
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $ujianHarian = $request->h;
        $ujianHarianSiswa = $request->s;

        if (isset($ujianHarian) && isset($ujianHarianSiswa)) {
            $row = DB::table('ujian_harian_siswas as a')
                    ->join('pelajarans as b', 'a.pelajaran_id', '=', 'b.id')
                    ->join('pelajaran_tipes as c', 'a.pelajaran_tipe_id', '=', 'c.id')
                    ->join('ujian_harians as d', 'a.ujian_harian_id', '=', 'd.id')
                    ->join('soals as e', 'a.soal_id', '=', 'e.id')
                    ->where('a.sekolah_id', session('sch_id'))
                    ->where('a.siswa_id', session('sch_pic'))
                    ->where('a.ujian_harian_id', $ujianHarian)
                    ->where('a.id', $ujianHarianSiswa)
                    ->whereRaw('NOW() >= CAST(CONCAT(d.tanggal, " ", d.waktu_mulai) AS DATETIME) + INTERVAL -5 MINUTE AND NOW() <= CAST(CONCAT(d.tanggal, " ", d.waktu_habis) AS DATETIME)')
                    ->whereNull('a.deleted_at')
                    ->select([
                        'a.id',
                        'a.status',
                        'a.soal_id',
                        'a.ujian_harian_id',
                            'b.nama as pelajaran',
                                'c.nama as pelajaran_tipe',
                                    'd.tanggal',
                                    'd.waktu_mulai',
                                    'd.waktu_habis',
                                    'd.total_waktu_pengerjaan',
                                    'd.tampilkan_nilai',
                                    'd.alert_simpan_jawaban',
                                    'd.batas_kelulusan',
                                    'd.pertanyaan_acak',
                                        'e.judul',
                    ])
                    ->first();    

            if ($row->status == 'BR' || $row->status == 'OP') {
                $soal = \App\Soal::findOrFail($row->soal_id);
                
                switch ($soal->tipe) {
                    case 'pg':
                        if ($row->status == 'BR') {
                            UjianHarianSiswa::findOrFail($ujianHarianSiswa)
                                ->update([
                                    'status' => 'OP'
                                ]);
                        }

                        $soalPertanyaan = $soal->soal_pertanyaans();
                        $pertanyaans = $row->pertanyaan_acak == 1 ? $soalPertanyaan->inRandomOrder() : $soalPertanyaan->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'asc');

                        $ujianHarianJawabanSiswa = UjianHarianJawabanSiswa::where('sekolah_id', session('sch_id'))
                                                    ->where('ujian_harian_id', $ujianHarian)
                                                    ->where('ujian_harian_siswa_id', $ujianHarianSiswa)
                                                    ->where('siswa_id', session('sch_pic'))
                                                    ->get()
                                                    ->toArray();

                        $jawabanRagu = UjianHarianJawabanSiswa::where('sekolah_id', session('sch_id'))
                                        ->where('ujian_harian_id', $ujianHarian)
                                        ->where('ujian_harian_siswa_id', $ujianHarianSiswa)
                                        ->where('siswa_id', session('sch_pic'))
                                        ->where('tipe', 'ragu')
                                        ->select([
                                            'soal_pertanyaan_id',
                                        ])
                                        ->get();

                        $pertanyaanRagu = [];
                        foreach ($jawabanRagu as $ragu) {
                            $pertanyaanRagu[] = '#' . $ragu['soal_pertanyaan_id'];
                        }

                        return view(self::FOLDER . 'create_pg')
                                ->with([
                                    'url' => self::URL,
                                    'row' => $row,
                                    'soal' => $soal,
                                    'pertanyaans' => $pertanyaans->get(),
                                    'ujianHarianJawabanSiswa' => $ujianHarianJawabanSiswa,
                                    'pertanyaanRagu' => $pertanyaanRagu,
                                ]);
                        break;

                    case 'es':
                        $soalPertanyaan = $soal->soal_pertanyaans()
                                            ->leftJoin('ujian_harian_jawaban_siswas', function ($q) use ($ujianHarianSiswa) {
                                                $q->on('soal_pertanyaans.id', '=', 'ujian_harian_jawaban_siswas.soal_pertanyaan_id')
                                                    ->where('ujian_harian_jawaban_siswas.ujian_harian_siswa_id', $ujianHarianSiswa);
                                            });

                        $pertanyaans = $row->pertanyaan_acak == 1 ? $soalPertanyaan->inRandomOrder() : $soalPertanyaan->orderBy('soal_pertanyaans.nomor', 'asc');                        
                        
                        return view(self::FOLDER . 'create_es')
                                ->with([
                                    'url' => self::URL,
                                    'row' => $row,
                                    'soal' => $soal,
                                    'pertanyaans' => $pertanyaans->select([
                                        'soal_pertanyaans.id',
                                        'soal_pertanyaans.nomor',
                                        'soal_pertanyaans.pertanyaan',
                                        'ujian_harian_jawaban_siswas.essay',
                                        'ujian_harian_jawaban_siswas.tipe',
                                    ])->get(),
                                ]);
                        break;

                    case 'cu':
                        return view(self::FOLDER . 'create_cu')
                                ->with([
                                    'url' => self::URL,
                                    'row' => $row,
                                    'soal' => $soal,
                                    'pertanyaans' => $pertanyaans->get(),
                                ]);
                        break;
                    
                    default:
                        return abort(404);
                        break;
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }        
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
            'ujian_harian' => 'required|string',
            'ujian_harian_siswa' => 'required|string',
            'soal' => 'required|string',
            'tipe' => 'required|string',

            'list_jawaban' => 'nullable|array',
            'list_ragu' => 'nullable|array',
        ]);

        switch ($request->tipe) {
            case 'pg':
                return $this->storePG($request);
                break;

            case 'essay':
                return $this->storeEssay($request);
                break;

            case 'custom':
                return $this->storeCustom($request);
                break;
            
            default:
                return abort(404);
                break;
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
        $row = DB::table('ujian_harian_siswas as a')
                    ->join('pelajarans as b', 'a.pelajaran_id', '=', 'b.id')
                    ->join('pelajaran_tipes as c', 'a.pelajaran_tipe_id', '=', 'c.id')
                    ->join('ujian_harians as d', 'a.ujian_harian_id', '=', 'd.id')
                    ->join('soals as e', 'a.soal_id', '=', 'e.id')
                    ->join('jenis_ujians as f', 'd.jenis_ujian_id', '=', 'f.id')
                    ->where('a.sekolah_id', session('sch_id'))
                    ->where('a.siswa_id', session('sch_pic'))
                    ->whereNull('a.deleted_at')
                    ->where('a.id', $id)
                    ->whereRaw('NOW() >= CAST(CONCAT(d.tanggal, " ", d.waktu_mulai) AS DATETIME) + INTERVAL -5 MINUTE AND NOW() <= CAST(CONCAT(d.tanggal, " ", d.waktu_habis) AS DATETIME)')
                    ->select([
                        'a.id',
                        'a.status',
                        'a.soal_id',
                        'a.ujian_harian_id',
                            'b.nama as pelajaran',
                                'c.nama as pelajaran_tipe',
                                    'd.judul',
                                    'd.tanggal',
                                    'd.waktu_mulai',
                                    'd.waktu_habis',
                                    'd.total_waktu_pengerjaan',
                                    'd.tampilkan_nilai',
                                    'd.alert_simpan_jawaban',
                                    'd.batas_kelulusan',
                                    'd.pertanyaan_acak',
                                        'e.judul as soal',
                                            'f.nama as jenis_ujian',
                    ])
                    ->first();      
                    
        if (isset($row) && $row->status == 'BR') {
            return view(self::FOLDER . 'instruksi')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                ]);
        } else {
            return view(self::FOLDER . 'lewat_waktu');
        }
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
        $row = UjianHarianSiswa::where('id', $id);

        if ($row->count() !== 0) {
            $row->update([
                'status' => 'CL'
            ]);
            $row->delete();
        }

        return response()->json();
    }

    public function hasil($ujianHarianHasil)
    {
        $row = UjianHarianHasil::findOrFail($ujianHarianHasil);
        $ujianHarian = UjianHarian::findOrFail($row->ujian_harian_id);

        return view(self::FOLDER . 'hasil')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                    'ujianHarian' => $ujianHarian,
                ]);
    }

    protected function storePG($request)
    {
        DB::beginTransaction();
        try {            
            $ujianHarian = UjianHarian::findOrFail($request->ujian_harian);
            $rumusPenilaianUjian = RumusPenilaianUjian::findOrFail($ujianHarian->rumus_penilaian_ujian_id);
            $ujianHarianSiswa = UjianHarianSiswa::findOrFail($request->ujian_harian_siswa);
            $listJawaban = $request->list_jawaban ?? [];
            $listRagu = $request->list_ragu ?? [];
            $pertanyaanDijawabs = [];
            $soal = Soal::findOrFail($request->soal);
            $soalPertanyaans = $soal->soal_pertanyaans();
            $totalPertanyaan = $soalPertanyaans->count();            
            $benar = 0;
            $salah = $totalPertanyaan;

            if (isset($listJawaban)) {
                foreach ($listJawaban as $jawaban) {
                    $soalPertanyaanJawaban = SoalPertanyaanJawaban::findOrFail($jawaban);
    
                    $tipe = strlen(array_search($soalPertanyaanJawaban->soal_pertanyaan_id, array_column($listRagu, 'soal_pertanyaan_id'))) > 0 ? 'ragu' : 'ok';

                    UjianHarianJawabanSiswa::updateOrInsert(
                        [
                            'soal_pertanyaan_id' => $soalPertanyaanJawaban->soal_pertanyaan_id,
                            'soal_pertanyaan_jawaban_id' => $soalPertanyaanJawaban->id,
                            'ujian_harian_id' => $request->ujian_harian,
                            'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                        ],
                        [
                            'id' => \Str::uuid(),

                            'tanggal' => Carbon::now(),
                            'tipe' => $tipe,
                            'essay' => NULL,

                            'soal_id' => $soalPertanyaanJawaban->soal_id,
                            // 'soal_pertanyaan_id' => $soalPertanyaanJawaban->soal_pertanyaan_id,
                            // 'soal_pertanyaan_jawaban_id' => $soalPertanyaanJawaban->id,
                            'pelajaran_id' => $soal->pelajaran_id,
                            'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                            'kelas_id' => $soal->kelas_id,
                            'siswa_id' => session('sch_pic'),
                            // 'ujian_harian_id' => $request->ujian_harian,
                            // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                            'sekolah_id' => session('sch_id'),

                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );
                    
                    if ($soalPertanyaanJawaban->benar == 1) {
                        $benar = $benar + $soalPertanyaanJawaban->benar;
                    }

                    $pertanyaanDijawabs[] = $soalPertanyaanJawaban->soal_pertanyaan_id;
                }

                if ($totalPertanyaan !== count($pertanyaanDijawabs)) {
                    $soalPertanyaanTidakDijawabs = $soalPertanyaans->whereNotIn('id', $pertanyaanDijawabs);

                    if ($soalPertanyaanTidakDijawabs->count() !== 0) {
                        foreach ($soalPertanyaanTidakDijawabs->get() as $soalPertanyaanTidakDijawab) {
                            UjianHarianJawabanSiswa::updateOrInsert(
                                [
                                    'soal_pertanyaan_id' => $soalPertanyaanTidakDijawab->id,
                                    'soal_pertanyaan_jawaban_id' => NULL,
                                    'ujian_harian_id' => $request->ujian_harian,
                                    'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                                ],
                                [
                                    'id' => \Str::uuid(),

                                    'tanggal' => Carbon::now(),
                                    'tipe' => 'tdk',
                                    'essay' => NULL,
            
                                    'soal_id' => $soalPertanyaanTidakDijawab->soal_id,
                                    // 'soal_pertanyaan_id' => $soalPertanyaanTidakDijawab->id,
                                    // 'soal_pertanyaan_jawaban_id' => NULL,
                                    'pelajaran_id' => $soal->pelajaran_id,
                                    'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                                    'kelas_id' => $soal->kelas_id,
                                    'siswa_id' => session('sch_pic'),
                                    // 'ujian_harian_id' => $request->ujian_harian,
                                    // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                                    'sekolah_id' => session('sch_id'),

                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]
                            );
                        }
                    }
                }
            } else {
                foreach ($soalPertanyaans->get() as $soalPertanyaan) {
                    UjianHarianJawabanSiswa::updateOrInsert(
                        [
                            'soal_pertanyaan_id' => $soalPertanyaan->id,
                            'soal_pertanyaan_jawaban_id' => NULL,
                            'ujian_harian_id' => $request->ujian_harian,
                            'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                        ],
                        [
                            'id' => \Str::uuid(),

                            'tanggal' => Carbon::now(),
                            'tipe' => 'tdk',
                            'essay' => NULL,

                            'soal_id' => $soalPertanyaan->soal_id,
                            // 'soal_pertanyaan_id' => $soalPertanyaan->id,
                            // 'soal_pertanyaan_jawaban_id' => NULL,
                            'pelajaran_id' => $soal->pelajaran_id,
                            'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                            'kelas_id' => $soal->kelas_id,
                            'siswa_id' => session('sch_pic'),
                            // 'ujian_harian_id' => $request->ujian_harian,
                            // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                            'sekolah_id' => session('sch_id'),

                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );
                }
            }

            # $hitungHasilUjian = $benar / $totalPertanyaan * 100;
            $hitungHasilUjian = ($benar * $rumusPenilaianUjian->benar) / $totalPertanyaan * 100;
            $salah = $totalPertanyaan - $benar;
            $nilaiHasilUjian = ceil($hitungHasilUjian);
            
            $statusHasilUjian = NULL;
            if (! empty($ujianHarian->batas_kelulusan)) {
                $statusHasilUjian = $nilaiHasilUjian >= $ujianHarian->batas_kelulusan ? 1 : 0;
            }

            $getTotalJawabanPertanyaan = UjianHarianJawabanSiswa::where('ujian_harian_id', $request->ujian_harian)
                                            ->where('ujian_harian_siswa_id', $request->ujian_harian_siswa)
                                            ->select([
                                                DB::raw("SUM(CASE WHEN tipe = 'ok' THEN 1 ELSE 0 END) AS ok"),
                                                DB::raw("SUM(CASE WHEN tipe = 'ragu' THEN 1 ELSE 0 END) AS ragu"),
                                                DB::raw("SUM(CASE WHEN tipe = 'tdk' THEN 1 ELSE 0 END) AS tdk"),
                                            ])
                                            ->first();

            $ujianHarianHasil = UjianHarianHasil::updateOrInsert(
                [
                    'ujian_harian_id' => $request->ujian_harian,
                    'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                ],
                [
                    'id' => \Str::uuid(),

                    'tanggal' => Carbon::now(),
                    'status' => $statusHasilUjian,
                    'nilai' => $nilaiHasilUjian,
                    'total_pertanyaan' => $totalPertanyaan,
                    'total_benar' => $benar,
                    'total_salah' => $salah,
                    'pertanyaan_dijawab' => $getTotalJawabanPertanyaan->ok,
                    'pertanyaan_tidak_dijawab' => $getTotalJawabanPertanyaan->tdk,
                    'pertanyaan_dijawab_ragu' => $getTotalJawabanPertanyaan->ragu,
                    'soal_id' => $soal->id,
                    'pelajaran_id' => $soal->pelajaran_id,
                    'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                    'kelas_id' => $soal->kelas_id,
                    'siswa_id' => session('sch_pic'),
                    // 'ujian_harian_id' => $request->ujian_harian,
                    // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                    'sekolah_id' => session('sch_id'),
                    
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            )->first();

            $ujianHarianSiswa->update([
                'status' => 'FN',
            ]);
            
            DB::commit();

            return response()->json(['token' => $ujianHarianHasil->id]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    protected function storeEssay($request)
    {
        DB::beginTransaction();
        try {            
            $ujianHarian = UjianHarian::findOrFail($request->ujian_harian);
            $ujianHarianSiswa = UjianHarianSiswa::findOrFail($request->ujian_harian_siswa);
            $listJawaban = $request->list_jawaban ?? [];
            $listRagu = $request->list_ragu ?? [];
            $pertanyaanDijawabs = [];
            $soal = Soal::findOrFail($request->soal);
            $soalPertanyaans = $soal->soal_pertanyaans();
            $totalPertanyaan = $soalPertanyaans->count();            
            $benar = 0;
            $salah = $totalPertanyaan;

            if (isset($listJawaban)) {
                foreach ($listJawaban as $jawaban) {
                    $tipe = strlen(array_search($jawaban['pertanyaan'], array_column($listRagu, 'soal_pertanyaan_id'))) > 0 ? 'ragu' : 'ok';

                    UjianHarianJawabanSiswa::updateOrInsert(
                        [
                            'soal_pertanyaan_id' => $jawaban['pertanyaan'],
                            'ujian_harian_id' => $request->ujian_harian,
                            'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                        ],
                        [
                            'id' => \Str::uuid(),

                            'tanggal' => Carbon::now(),
                            'tipe' => $tipe,
                            'essay' => $jawaban['jawaban_isi'],
    
                            'soal_id' => $request->soal,
                            // 'soal_pertanyaan_id' => $jawaban['pertanyaan'],
                            'soal_pertanyaan_jawaban_id' => NULL,
                            'pelajaran_id' => $soal->pelajaran_id,
                            'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                            'kelas_id' => $soal->kelas_id,
                            'siswa_id' => session('sch_pic'),
                            // 'ujian_harian_id' => $request->ujian_harian,
                            // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                            'sekolah_id' => session('sch_id'),
                            
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );

                    $pertanyaanDijawabs[] = $jawaban['pertanyaan'];
                }

                if ($totalPertanyaan !== count($pertanyaanDijawabs)) {
                    $soalPertanyaanTidakDijawabs = $soalPertanyaans->whereNotIn('id', $pertanyaanDijawabs);

                    if ($soalPertanyaanTidakDijawabs->count() !== 0) {
                        foreach ($soalPertanyaanTidakDijawabs->get() as $soalPertanyaanTidakDijawab) {
                            UjianHarianJawabanSiswa::updateOrInsert(
                                [
                                    'soal_pertanyaan_id' => $soalPertanyaanTidakDijawab->id,
                                    'ujian_harian_id' => $request->ujian_harian,
                                    'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                                ],
                                [
                                    'id' => \Str::uuid(),

                                    'tanggal' => Carbon::now(),
                                    'tipe' => 'tdk',
                                    'essay' => NULL,

                                    'soal_id' => $soalPertanyaanTidakDijawab->soal_id,
                                    // 'soal_pertanyaan_id' => $soalPertanyaanTidakDijawab->id,
                                    'soal_pertanyaan_jawaban_id' => NULL,
                                    'pelajaran_id' => $soal->pelajaran_id,
                                    'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                                    'kelas_id' => $soal->kelas_id,
                                    'siswa_id' => session('sch_pic'),
                                    // 'ujian_harian_id' => $request->ujian_harian,
                                    // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                                    'sekolah_id' => session('sch_id'),
                                    
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]
                            );
                        }
                    }
                }
            } else {
                foreach ($soalPertanyaans->get() as $soalPertanyaan) {
                    UjianHarianJawabanSiswa::updateOrInsert(
                        [
                            'soal_pertanyaan_id' => $soalPertanyaan->id,
                            'ujian_harian_id' => $request->ujian_harian,
                            'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                        ],
                        [
                            'id' => \Str::uuid(),

                            'tanggal' => Carbon::now(),
                            'tipe' => 'tdk',
                            'essay' => NULL,

                            'soal_id' => $soalPertanyaan->soal_id,
                            // 'soal_pertanyaan_id' => $soalPertanyaanTidakDijawab->id,
                            'soal_pertanyaan_jawaban_id' => NULL,
                            'pelajaran_id' => $soal->pelajaran_id,
                            'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                            'kelas_id' => $soal->kelas_id,
                            'siswa_id' => session('sch_pic'),
                            // 'ujian_harian_id' => $request->ujian_harian,
                            // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                            'sekolah_id' => session('sch_id'),
                            
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );
                }
            }
            
            $nilaiHasilUjian = NULL;
            $statusHasilUjian = NULL;

            $getTotalJawabanPertanyaan = UjianHarianJawabanSiswa::where('soal_id', $soal->id)
                                            ->where('pelajaran_id', $soal->pelajaran_id)
                                            ->where('pelajaran_tipe_id', $soal->pelajaran_tipe_id)
                                            ->where('kelas_id', $soal->kelas_id)
                                            ->where('siswa_id', session('sch_pic'))
                                            ->where('ujian_harian_id', $request->ujian_harian)
                                            ->where('ujian_harian_siswa_id', $request->ujian_harian_siswa)
                                            ->where('sekolah_id', session('sch_id'))
                                            ->select([
                                                DB::raw("SUM(CASE WHEN tipe = 'ok' THEN 1 ELSE 0 END) AS ok"),
                                                DB::raw("SUM(CASE WHEN tipe = 'ragu' THEN 1 ELSE 0 END) AS ragu"),
                                                DB::raw("SUM(CASE WHEN tipe = 'tdk' THEN 1 ELSE 0 END) AS tdk"),
                                            ])
                                            ->first();

            $ujianHarianHasil = UjianHarianHasil::updateOrInsert(
                [
                    'ujian_harian_id' => $request->ujian_harian,
                    'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                ],
                [
                    'id' => \Str::uuid(),

                    'tanggal' => Carbon::now(),
                    'status' => $statusHasilUjian,
                    'nilai' => $nilaiHasilUjian,
                    'total_pertanyaan' => $totalPertanyaan,
                    'total_benar' => NULL,
                    'total_salah' => NULL,
                    'pertanyaan_dijawab' => $getTotalJawabanPertanyaan->ok,
                    'pertanyaan_tidak_dijawab' => $getTotalJawabanPertanyaan->tdk,
                    'pertanyaan_dijawab_ragu' => $getTotalJawabanPertanyaan->ragu,
                    'soal_id' => $soal->id,
                    'pelajaran_id' => $soal->pelajaran_id,
                    'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                    'kelas_id' => $soal->kelas_id,
                    'siswa_id' => session('sch_pic'),
                    // 'ujian_harian_id' => $request->ujian_harian,
                    // 'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                    'sekolah_id' => session('sch_id'),
                ]
            )->first();

            $ujianHarianSiswa->update([
                'status' => 'FN',
            ]);
            
            DB::commit();

            $request->session()->regenerateToken();

            return response()->json(['token' => $ujianHarianHasil->id]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    protected function storeCustom($request)
    {
        DB::beginTransaction();
        try {            
            $ujianHarian = UjianHarian::findOrFail($request->ujian_harian);
            $ujianHarianSiswa = UjianHarianSiswa::findOrFail($request->ujian_harian_siswa);
            $listJawaban = $request->list_jawaban ?? [];
            $listRagu = $request->list_ragu ?? [];
            $pertanyaanDijawabs = [];
            $soal = Soal::findOrFail($request->soal);
            $soalPertanyaans = $soal->soal_pertanyaans();
            $totalPertanyaan = $soalPertanyaans->count();            
            $benar = 0;
            $salah = $totalPertanyaan;

            if (isset($listJawaban)) {
                foreach ($listJawaban as $jawaban) {
                    
                }

                if ($totalPertanyaan !== count($pertanyaanDijawabs)) {
                    
                }
            } else {
                foreach ($soalPertanyaans->get() as $soalPertanyaan) {

                }
            }
            
            DB::commit();

            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }
}
