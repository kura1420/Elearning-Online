<?php

namespace App\Http\Controllers\Sekolah;

use App\Soal;
use App\SoalPertanyaanJawaban;
use App\UjianHarianJawabanSiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UjianHarianJawabanSiswaController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'ujian_harian' => 'required|string',
            'ujian_harian_siswa' => 'required|string',
            'soal' => 'required|string',
            'tipe' => 'required|string',

            'list_jawaban' => 'required|array',
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

    protected function storePG($request)
    {
        DB::beginTransaction();
        try {
            $listJawaban = $request->list_jawaban;
            $listRagu = $request->list_ragu ?? [];

            $soal = Soal::findOrFail($request->soal);

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
            }

            DB::commit();

            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    protected function storeEssay($request)
    {
        DB::beginTransaction();
        try {
            $listJawaban = $request->list_jawaban;
            $listRagu = $request->list_ragu ?? [];
            $soal = Soal::findOrFail($request->soal);

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
            }

            DB::commit();

            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    protected function storeCustom($request)
    {
        DB::beginTransaction();
        try {
            $listJawaban = $request->list_jawaban;
            $listRagu = $request->list_ragu ?? [];

            foreach ($listJawaban as $jawaban) {
                $soalPertanyaanJawaban = SoalPertanyaanJawaban::findOrFail($jawaban);
                $soal = Soal::findOrFail($soalPertanyaanJawaban->soal_id);

                $ujianHarianJawabanSiswa = UjianHarianJawabanSiswa::where('soal_id', $soalPertanyaanJawaban->soal_id)
                                            ->where('soal_pertanyaan_id', $soalPertanyaanJawaban->soal_pertanyaan_id)
                                            ->where('soal_pertanyaan_jawaban_id', $soalPertanyaanJawaban->id)
                                            ->where('pelajaran_id', $soal->pelajaran_id)
                                            ->where('pelajaran_tipe_id', $soal->pelajaran_tipe_id)
                                            ->where('kelas_id', $soal->kelas_id)
                                            ->where('siswa_id', session('sch_pic'))
                                            ->where('ujian_harian_id', $request->ujian_harian)
                                            ->where('ujian_harian_siswa_id', $request->ujian_harian_siswa)
                                            ->where('sekolah_id', session('sch_id'));

                $tipe = strlen(array_search($soalPertanyaanJawaban->soal_pertanyaan_id, array_column($listRagu, 'soal_pertanyaan_id'))) > 0 ? 'ragu' : 'ok';

                if ($ujianHarianJawabanSiswa->count() == 0) {
                    UjianHarianJawabanSiswa::create([
                        'tanggal' => Carbon::now(),
                        'tipe' => $tipe,

                        'soal_id' => $soalPertanyaanJawaban->soal_id,
                        'soal_pertanyaan_id' => $soalPertanyaanJawaban->soal_pertanyaan_id,
                        'soal_pertanyaan_jawaban_id' => $soalPertanyaanJawaban->id,
                        'pelajaran_id' => $soal->pelajaran_id,
                        'pelajaran_tipe_id' => $soal->pelajaran_tipe_id,
                        'kelas_id' => $soal->kelas_id,
                        'siswa_id' => session('sch_pic'),
                        'ujian_harian_id' => $request->ujian_harian,
                        'ujian_harian_siswa_id' => $request->ujian_harian_siswa,
                        'sekolah_id' => session('sch_id'),
                    ]);
                } else {
                    $ujianHarianJawabanSiswa->update([
                        'tanggal' => Carbon::now(),
                        'tipe' => $tipe,
                    ]);
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
