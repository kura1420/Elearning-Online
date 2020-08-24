<?php

namespace App\Http\Controllers\Sekolah;

use App\UjianHarian;
use App\UjianHarianSiswa;
use App\UjianHarianHasil;
use App\RumusPenilaianUjian;
use App\Rules\SekolahFieldUnique;
use App\DataTables\UjianHariansDataTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UjianHarianController extends Controller
{

    const FOLDER = 'sekolah.ujian_harian.';
    const URL = '/sch/ujian-harian';

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

        $jenisUjians = \App\JenisUjian::where('sekolah_id', session('sch_id'))
                            ->orderBy('nama', 'asc')
                            ->get();

        return view(self::FOLDER . 'index')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
                    'jenisUjians' => $jenisUjians,
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

        $jenisUjians = \App\JenisUjian::where('sekolah_id', session('sch_id'))
                            ->orderBy('nama', 'asc')
                            ->get();

        $rumusPenilaianUjians = \App\RumusPenilaianUjian::where('sekolah_id', session('sch_id'))
                                    ->orderBy('nama', 'asc')
                                    ->get();

        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
                    'jenisUjians' => $jenisUjians,
                    'rumusPenilaianUjians' => $rumusPenilaianUjians,
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
        $waktu_mulai = isset($request->waktu_mulai) ? $request->waktu_mulai : Carbon::now()->format('H:i');
        $tampilkan_nilai = $request->tampilkan_nilai == 1 ? 'nullable|numeric' : 'nullable';

        $request->validate([
            'tanggal' => 'required|date|after:' . Carbon::yesterday()->format('m/d/Y'),
            'waktu_mulai' => 'required|string|after:' . Carbon::now()->format('Hi'),
            'waktu_habis' => 'required|string|after:' . $waktu_mulai,
            'tampilkan_nilai' => 'nullable|string',
            'alert_simpan_jawaban' => 'required|string',
            'batas_kelulusan' => $tampilkan_nilai,
            'pertanyaan_acak' => 'nullable|string',
            'soal' => 'required|string',
            'pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
            'kelas' => 'required|string',
            'jenis_ujian' => 'required|string',
            // 'rumus_penilaian_ujian' => 'required|string',
            'tahun_ajaran' => 'required|string',
            // 'judul' => [
            //     'required',
            //     'string',
            //     'max:255',
            //     function ($attr, $val, $fail) use ($request) {
            //         $check = UjianHarian::where('sekolah_id', session('sch_id'))
            //                     ->where('pelajaran_id', $request->pelajaran)
            //                     ->where('pelajaran_tipe_id', $request->pelajaran_tipe)
            //                     ->where('kelas_id', $request->kelas)
            //                     ->where('jenis_ujian_id', $request->jenis_ujian)
            //                     ->where('tahun_ajaran_id', $request->tahun_ajaran)
            //                     ->where('judul', $val)
            //                     ->where('tanggal', date('Y-m-d', strtotime($request->tanggal)))
            //                     ->count();

            //         if ($check !== 0) {
            //             $fail("Data ujian sudah tersedia.");
            //         }
            //     }
            // ],

            'list_siswa_ujian' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $soal = \App\Soal::findOrFail($request->soal);

            $total_waktu_pengerjaan = Carbon::parse($request->waktu_mulai)->diffInMinutes($request->waktu_habis);

            $ujianHarian = UjianHarian::create([
                // 'judul' => $request->judul,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_habis' => $request->waktu_habis,
                'total_waktu_pengerjaan' => $total_waktu_pengerjaan,
                'tampilkan_nilai' => isset($request->tampilkan_nilai) ? $request->tampilkan_nilai : NULL,
                'alert_simpan_jawaban' => $request->alert_simpan_jawaban,
                'batas_kelulusan' => isset($request->batas_kelulusan) ? $request->batas_kelulusan : NULL,
                'pertanyaan_acak' => $request->pertanyaan_acak,
                'soal_id' => $request->soal,
                'pelajaran_id' => $request->pelajaran,
                'pelajaran_tipe_id' => $request->pelajaran_tipe,
                'kelas_id' => $request->kelas,
                'jenis_ujian_id' => $request->jenis_ujian,
                'rumus_penilaian_ujian_id' => $soal->rumus_penilaian_ujian_id,
                'tahun_ajaran_id' => $request->tahun_ajaran,
            ]);

            $insertUjianHarianSiswa = [];
            foreach ($request->list_siswa_ujian as $lsu) {
                $insertUjianHarianSiswa[] = [
                    'status' => 'BR',
                    'tahun_ajaran_id' => $request->tahun_ajaran,
                    'pelajaran_id' => $request->pelajaran,
                    'pelajaran_tipe_id' => $request->pelajaran_tipe,
                    'kelas_id' => $request->kelas,
                    'soal_id' => $request->soal,
                    'siswa_id' => $lsu['siswa'],
                    'ujian_harian_id' => $ujianHarian->id,
                ];
            }
            $ujianHarian->ujian_harian_siswas()->createMany($insertUjianHarianSiswa);

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
        $row = UjianHarian::findOrFail($id);

        $ujianHarian = UjianHarian::join('soals', 'ujian_harians.soal_id', '=', 'soals.id')
                        ->join('pelajarans', 'ujian_harians.pelajaran_id', '=', 'pelajarans.id')
                        ->join('pelajaran_tipes', 'ujian_harians.pelajaran_tipe_id', '=', 'pelajaran_tipes.id')
                        ->join('kelas', 'ujian_harians.kelas_id', '=', 'kelas.id')
                        ->join('jenis_ujians', 'ujian_harians.jenis_ujian_id', '=', 'jenis_ujians.id')
                        ->join('rumus_penilaian_ujians', 'soals.rumus_penilaian_ujian_id', '=', 'rumus_penilaian_ujians.id')
                        ->join('tahun_ajarans', 'ujian_harians.tahun_ajaran_id', '=', 'tahun_ajarans.id')
                        ->where('ujian_harians.id', $id)
                        ->select([
                            'ujian_harians.id',
                            'ujian_harians.judul',
                            DB::raw('DATE_FORMAT(ujian_harians.tanggal, "%d-%m-%Y") as tanggal'),
                            'ujian_harians.waktu_mulai',
                            'ujian_harians.waktu_habis',
                            'ujian_harians.total_waktu_pengerjaan',
                            DB::raw('(CASE WHEN ujian_harians.tampilkan_nilai = 1 THEN "Ya" ELSE "Tidak" END) as tampilkan_nilai'),
                            'ujian_harians.alert_simpan_jawaban',
                            'ujian_harians.batas_kelulusan',
                            DB::raw('(CASE WHEN ujian_harians.pertanyaan_acak = 1 THEN "Ya" ELSE "Tidak" END) as pertanyaan_acak'),

                                DB::raw('CONCAT(tahun_ajarans.merge_periode, "/", tahun_ajarans.semester) as tahun_ajaran_id'),
                                    'soals.judul as soal_text',
                                    'soals.tipe',
                                    'soals.tipe_pilihan_ganda',
                                        'pelajarans.nama as pelajaran_text',
                                            'pelajaran_tipes.nama as pelajaran_tipe_text',
                                                'kelas.nama as kelas_text',
                                                    'jenis_ujians.nama as jenis_ujian_text',
                                                        'rumus_penilaian_ujians.nama as rumus_penilaian_ujian_text',
                        ])
                        ->first();

        $ujianHarianSiswas = $row->ujian_harian_siswas()
                                ->join('siswas', 'ujian_harian_siswas.siswa_id', 'siswas.id')
                                ->leftJoin('ujian_harian_hasils', 'ujian_harian_siswas.id', '=', 'ujian_harian_hasils.ujian_harian_siswa_id')
                                ->select([
                                    'ujian_harian_siswas.id',
                                    'ujian_harian_siswas.status',
                                    'siswas.nomor_induk',
                                    'siswas.nama',
                                    'ujian_harian_hasils.nilai',
                                    'ujian_harian_hasils.id as ujian_harian_hasil_id',
                                ])
                                ->get();

        return view(self::FOLDER . 'show')
                ->with([
                    'url' => self::URL,
                    'row' => $ujianHarian,
                    'ujianHarianSiswas' => $ujianHarianSiswas,
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
        $row = UjianHarian::findOrFail($id);

        $ujianHarian = UjianHarian::join('soals', 'ujian_harians.soal_id', '=', 'soals.id')
                        ->join('pelajarans', 'ujian_harians.pelajaran_id', '=', 'pelajarans.id')
                        ->join('pelajaran_tipes', 'ujian_harians.pelajaran_tipe_id', '=', 'pelajaran_tipes.id')
                        ->join('kelas', 'ujian_harians.kelas_id', '=', 'kelas.id')
                        ->where('ujian_harians.id', $id)
                        ->select([
                            'ujian_harians.id',
                            'ujian_harians.judul',
                            DB::raw('DATE_FORMAT(tanggal, "%d-%m-%Y") as tanggal'),
                            'ujian_harians.waktu_mulai',
                            'ujian_harians.waktu_habis',
                            'ujian_harians.total_waktu_pengerjaan',
                            'ujian_harians.tampilkan_nilai',
                            'ujian_harians.alert_simpan_jawaban',
                            'ujian_harians.batas_kelulusan',
                            'ujian_harians.pertanyaan_acak',
                            'ujian_harians.soal_id',
                            'ujian_harians.pelajaran_id',
                            'ujian_harians.pelajaran_tipe_id',
                            'ujian_harians.kelas_id',
                            'ujian_harians.jenis_ujian_id',
                            // 'ujian_harians.rumus_penilaian_ujian_id',
                            'ujian_harians.tahun_ajaran_id',

                            'soals.judul as soal_text',
                            'pelajarans.nama as pelajaran_text',
                            'pelajaran_tipes.nama as pelajaran_tipe_text',
                            'kelas.nama as kelas_text',
                        ])
                        ->first();

        $ujianHarianSiswas = $row->ujian_harian_siswas()
                                ->join('siswas', 'ujian_harian_siswas.siswa_id', 'siswas.id')
                                ->select([
                                    'ujian_harian_siswas.id',
                                    'siswas.nomor_induk',
                                    'siswas.nama',
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

        $jenisUjians = \App\JenisUjian::where('sekolah_id', session('sch_id'))
                            ->orderBy('nama', 'asc')
                            ->get();

        $rumusPenilaianUjians = \App\RumusPenilaianUjian::where('sekolah_id', session('sch_id'))
                                    ->orderBy('nama', 'asc')
                                    ->get();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
                    'jenisUjians' => $jenisUjians,
                    'rumusPenilaianUjians' => $rumusPenilaianUjians,
                    'row' => $ujianHarian,
                    'ujianHarianSiswas' => $ujianHarianSiswas,
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
        $row = UjianHarian::findOrFail($id);

        $waktu_mulai = isset($request->waktu_mulai) ? $request->waktu_mulai : Carbon::now()->format('H:i');
        $tampilkan_nilai = $request->tampilkan_nilai == 1 ? 'nullable|numeric' : 'nullable';

        $request->validate([
            'tanggal' => 'required|date|after:' . Carbon::yesterday()->format('m/d/Y'),
            'waktu_mulai' => 'required|string',
            'waktu_habis' => 'required|string|after:' . $waktu_mulai,
            'tampilkan_nilai' => 'nullable|string',
            'alert_simpan_jawaban' => 'required|string',
            'batas_kelulusan' => $tampilkan_nilai,
            'pertanyaan_acak' => 'nullable|string',
            'soal' => 'required|string',
            'pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
            'kelas' => 'required|string',
            'jenis_ujian' => 'required|string',
            // 'rumus_penilaian_ujian' => 'required|string',
            'tahun_ajaran' => 'required|string',
            // 'judul' => [
            //     'required',
            //     'string',
            //     'max:255',
            //     function ($attr, $val, $fail) use ($request, $row) {
            //         if ($row->judul !== $val) {
            //             $check = UjianHarian::where('sekolah_id', session('sch_id'))
            //                     ->where('pelajaran_id', $request->pelajaran)
            //                     ->where('pelajaran_tipe_id', $request->pelajaran_tipe)
            //                     ->where('kelas_id', $request->kelas)
            //                     ->where('jenis_ujian_id', $request->jenis_ujian)
            //                     ->where('tahun_ajaran_id', $request->tahun_ajaran)
            //                     ->where('judul', $val)
            //                     ->where('tanggal', date('Y-m-d', strtotime($request->tanggal)))
            //                     ->count();

            //             if ($check !== 0) {
            //                 $fail("Data ujian sudah tersedia.");
            //             }
            //         }
            //     }
            // ],

            'list_siswa_ujian' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $total_waktu_pengerjaan = Carbon::parse($request->waktu_mulai)->diffInMinutes($request->waktu_habis);

            $row->update([
                // 'judul' => $request->judul,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_habis' => $request->waktu_habis,
                'total_waktu_pengerjaan' => $total_waktu_pengerjaan,
                'tampilkan_nilai' => isset($request->tampilkan_nilai) ? $request->tampilkan_nilai : NULL,
                'alert_simpan_jawaban' => $request->alert_simpan_jawaban,
                'batas_kelulusan' => isset($request->batas_kelulusan) ? $request->batas_kelulusan : NULL,
                'pertanyaan_acak' => $request->pertanyaan_acak,
                'soal_id' => $request->soal,
                'pelajaran_id' => $request->pelajaran,
                'pelajaran_tipe_id' => $request->pelajaran_tipe,
                'kelas_id' => $request->kelas,
                'jenis_ujian_id' => $request->jenis_ujian,
                // 'rumus_penilaian_ujian_id' => $request->rumus_penilaian_ujian,
                'tahun_ajaran_id' => $request->tahun_ajaran,
            ]);

            $insertUjianHarianSiswa = [];
            foreach ($request->list_siswa_ujian as $lsu) {
                $check = UjianHarianSiswa::where([
                    ['id', $row->id],
                    ['status', 'BR'],
                ])->count();

                if ($check == 0) {
                    $insertUjianHarianSiswa[] = [
                        'status' => 'BR',
                        'tahun_ajaran_id' => $request->tahun_ajaran,
                        'pelajaran_id' => $request->pelajaran,
                        'pelajaran_tipe_id' => $request->pelajaran_tipe,
                        'kelas_id' => $request->kelas,
                        'soal_id' => $request->soal,
                        'siswa_id' => $lsu['siswa'],
                        'ujian_harian_id' => $row->id,
                    ];
                }
            }

            if (count($insertUjianHarianSiswa) !== 0) {
                $row->ujian_harian_siswas()->createMany($insertUjianHarianSiswa);
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
        $row = UjianHarian::findOrFail($id);
        
        $row->ujian_harian_siswas()->delete();
        $row->ujian_harian_jawaban_siswas()->delete();
        $row->ujian_harian_hasils()->delete();
        $row->delete();

        return response()->json();
    }

    public function hasilUjian($ujian_harian_hasil_id)
    {
        $ujianHarian = UjianHarian::join('soals', 'ujian_harians.soal_id', '=', 'soals.id')
                        ->join('pelajarans', 'ujian_harians.pelajaran_id', '=', 'pelajarans.id')
                        ->join('pelajaran_tipes', 'ujian_harians.pelajaran_tipe_id', '=', 'pelajaran_tipes.id')
                        ->join('kelas', 'ujian_harians.kelas_id', '=', 'kelas.id')
                        ->join('jenis_ujians', 'ujian_harians.jenis_ujian_id', '=', 'jenis_ujians.id')
                        ->join('rumus_penilaian_ujians', 'soals.rumus_penilaian_ujian_id', '=', 'rumus_penilaian_ujians.id')
                        ->join('tahun_ajarans', 'ujian_harians.tahun_ajaran_id', '=', 'tahun_ajarans.id')
                        ->join('ujian_harian_hasils', 'ujian_harians.id', '=', 'ujian_harian_hasils.ujian_harian_id')
                        ->join('siswas', 'ujian_harian_hasils.siswa_id', '=', 'siswas.id')
                        ->where('ujian_harian_hasils.id', $ujian_harian_hasil_id)
                        ->select([
                            'ujian_harians.id',
                            'ujian_harians.judul',
                            DB::raw('DATE_FORMAT(ujian_harians.tanggal, "%d-%m-%Y") as tanggal_ujian'),
                            'ujian_harians.waktu_mulai',
                            'ujian_harians.waktu_habis',
                            'ujian_harians.total_waktu_pengerjaan',
                            DB::raw('(CASE WHEN ujian_harians.tampilkan_nilai = 1 THEN "Ya" ELSE "Tidak" END) as tampilkan_nilai'),
                            'ujian_harians.alert_simpan_jawaban',
                            'ujian_harians.batas_kelulusan',
                            DB::raw('(CASE WHEN ujian_harians.pertanyaan_acak = 1 THEN "Ya" ELSE "Tidak" END) as pertanyaan_acak'),
                                DB::raw('CONCAT(tahun_ajarans.merge_periode, "/", tahun_ajarans.semester) as tahun_ajaran_id'),
                                    'soals.id as soal_id',
                                    'soals.judul as soal_text',
                                    'soals.tipe',
                                    'soals.tipe_pilihan_ganda',
                                        'pelajarans.nama as pelajaran_text',
                                            'pelajaran_tipes.nama as pelajaran_tipe_text',
                                                'kelas.nama as kelas_text',
                                                    'jenis_ujians.nama as jenis_ujian_text',
                                                        'rumus_penilaian_ujians.nama as rumus_penilaian_ujian_text',
                                                            'ujian_harian_hasils.tanggal as tanggal_selesai',
                                                            'ujian_harian_hasils.status',
                                                            'ujian_harian_hasils.nilai',
                                                            'ujian_harian_hasils.total_pertanyaan',
                                                            'ujian_harian_hasils.total_benar',
                                                            'ujian_harian_hasils.total_salah',
                                                            'ujian_harian_hasils.pertanyaan_dijawab',
                                                            'ujian_harian_hasils.pertanyaan_tidak_dijawab',
                                                            'ujian_harian_hasils.pertanyaan_dijawab_ragu',
                                                            'ujian_harian_hasils.ujian_harian_siswa_id',
                                                                'siswas.nomor_induk',
                                                                'siswas.nama',
                        ])
                        ->first();

        switch ($ujianHarian->tipe) {
            case 'pg':
                $soalPertanyaans = \App\Soal::findOrFail($ujianHarian->soal_id)
                                        ->soal_pertanyaans()
                                        ->leftJoin('ujian_harian_jawaban_siswas', function ($q) use ($ujianHarian) {
                                            $q->on('soal_pertanyaans.id', '=', 'ujian_harian_jawaban_siswas.soal_pertanyaan_id')
                                                ->where('ujian_harian_jawaban_siswas.ujian_harian_siswa_id', $ujianHarian->ujian_harian_siswa_id);
                                        })
                                        ->leftJoin('soal_pertanyaan_jawabans', 'ujian_harian_jawaban_siswas.soal_pertanyaan_jawaban_id', '=', 'soal_pertanyaan_jawabans.id')
                                        ->orderBy('soal_pertanyaans.nomor', 'asc')
                                        ->select([
                                            'soal_pertanyaans.id',
                                            'soal_pertanyaans.nomor',
                                            'soal_pertanyaans.pertanyaan',
                                                'ujian_harian_jawaban_siswas.tipe',
                                                    'soal_pertanyaan_jawabans.benar',
                                        ])
                                        ->get();

                $ujianHarianJawabanSiswa = UjianHarianSiswa::findOrFail($ujianHarian->ujian_harian_siswa_id)
                                            ->ujian_harian_jawaban_siswas()
                                            ->select([
                                                'soal_pertanyaan_jawaban_id',
                                                'tipe'
                                            ])
                                            ->get()
                                            ->toArray();

                return view(self::FOLDER . 'hasil_ujian_pg')
                        ->with([
                            'url' => self::URL,
                            'ujianHarian' => $ujianHarian,
                            'soalPertanyaans' => $soalPertanyaans,
                            'ujianHarianJawabanSiswa' => $ujianHarianJawabanSiswa
                        ]);
                break;

            case 'es':
                $soalPertanyaans = \App\Soal::findOrFail($ujianHarian->soal_id)
                                    ->soal_pertanyaans()
                                    ->leftJoin('ujian_harian_jawaban_siswas', function ($q) use ($ujianHarian) {
                                        $q->on('soal_pertanyaans.id', '=', 'ujian_harian_jawaban_siswas.soal_pertanyaan_id')
                                            ->where('ujian_harian_jawaban_siswas.ujian_harian_siswa_id', $ujianHarian->ujian_harian_siswa_id);
                                    })
                                    ->orderBy('soal_pertanyaans.nomor', 'asc')
                                    ->select([
                                        'soal_pertanyaans.id',
                                        'soal_pertanyaans.nomor',
                                        'soal_pertanyaans.pertanyaan',
                                            'ujian_harian_jawaban_siswas.essay',
                                            'ujian_harian_jawaban_siswas.tipe',
                                    ])
                                    ->get();
                                            
                return view(self::FOLDER . 'hasil_ujian_essay')
                        ->with([
                            'url' => self::URL,
                            'ujianHarian' => $ujianHarian,
                            'soalPertanyaans' => $soalPertanyaans,
                            'ujian_harian_hasil_id' => $ujian_harian_hasil_id
                        ]);
                break;

            case 'cu':
                return view(self::FOLDER . 'hasil_ujian_cu')
                        ->with([
                            'url' => self::URL,
                            'ujianHarian' => $ujianHarian,
                        ]);
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    public function storeScoreEssay(Request $request, $id)
    {
        $ujianHarianHasil = UjianHarianHasil::findOrFail($id);
        $ujianHarian = UjianHarian::findOrFail($ujianHarianHasil->ujian_harian_id);
        $rumusPenilaianUjian = RumusPenilaianUjian::findOrFail($ujianHarian->rumus_penilaian_ujian_id);

        $benarSalah = $request->benar + $request->salah;

        $request->validate([
            // 'nilai' => 'required|numeric|max:100|min:0',
            'total_pertanyaan' => 'required|numeric',
            'benar' => [
                'required',
                'numeric',
                'max:' . $request->total_pertanyaan,
                function ($attr, $val, $fail) use ($benarSalah, $request) {
                    if ($benarSalah > $request->total_pertanyaan) {
                        $fail("Jawaban benar dan salah tidak boleh melebihi total pertanyaan.");
                    }
                }
            ],
            'salah' => [
                'required',
                'numeric',
                'max:' . $request->total_pertanyaan,
                function ($attr, $val, $fail) use ($benarSalah, $request) {
                    if ($benarSalah > $request->total_pertanyaan) {
                        $fail("Jawaban benar dan salah tidak boleh melebihi total pertanyaan.");
                    }
                }
            ],
        ]);

        # $hitungHasilUjian = $request->benar / $request->total_pertanyaan * 100;
        $hitungHasilUjian = ($request->benar * $rumusPenilaianUjian->benar) / $request->total_pertanyaan * 100;
        $salah = $request->total_pertanyaan - $request->benar;
        $nilaiHasilUjian = ceil($hitungHasilUjian);

        $ujianHarianHasil->update([
            'nilai' => $nilaiHasilUjian,
            'total_benar' => $request->benar,
            'total_salah' => $request->salah,
        ]);

        return response()->json([
            'nilai' => $ujianHarianHasil->nilai
        ]);
    }
}
