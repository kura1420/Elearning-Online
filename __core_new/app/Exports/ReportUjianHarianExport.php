<?php

namespace App\Exports;

use App\UjianHarianHasil;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportUjianHarianExport implements FromView
{

    const FOLDER = 'sekolah.report.ujian_harian.export_excel.';

    private $param, $type;

    public function __construct(String $param, $type)
    {
        $this->param = $param;
        $this->type = $type;
    }
    
    public function view(): View
    {
        switch ($this->type) {
            case 'summary':
                return $this->summary($this->param);
                break;

            case 'perSiswa':
                return $this->perSiswa($this->param);
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    protected function summary($param)
    {
        $row = DB::table('ujian_harian_hasils')
                ->where('ujian_harian_id', $param)
                ->select([
                    DB::raw('COUNT(siswa_id) AS total_siswa'),
                    DB::raw('SUM(total_benar) AS total_benar'),
                    DB::raw('SUM(total_salah) AS total_salah'),
                    DB::raw('SUM(pertanyaan_tidak_dijawab) AS total_tidak_dijawab'),
                ])
                ->first();

        return view(self::FOLDER . 'summary')
                ->with([
                    'row' => $row,
                ]);
    }

    protected function perSiswa($param)
    {
        $ujianHarian = json_decode($param);

        switch ($ujianHarian->tipe) {
            case 'pg':
                $soalPertanyaanJawabanSiswas = DB::select("SELECT 
                    a.nomor, a.pertanyaan,
                    b.urutan AS kunci,
                    (SELECT urutan FROM soal_pertanyaan_jawabans WHERE id = c.soal_pertanyaan_jawaban_id) AS dijawab,
                    (CASE WHEN b.id = c.soal_pertanyaan_jawaban_id THEN 'Benar' ELSE 'Salah' END) AS status
                FROM soal_pertanyaans AS a
                INNER JOIN soal_pertanyaan_jawabans AS b ON a.id = b.soal_pertanyaan_id AND b.benar = 1
                INNER JOIN ujian_harian_jawaban_siswas AS c ON a.id = c.soal_pertanyaan_id
                WHERE a.soal_id = '{$ujianHarian->soal_id}' AND c.ujian_harian_siswa_id = '{$ujianHarian->ujian_harian_siswa_id}'
                ORDER BY a.nomor ASC");

                return view(self::FOLDER . 'hasil_pg')
                        ->with([
                            'ujianHarian' => $ujianHarian,
                            'soalPertanyaanJawabanSiswas' => $soalPertanyaanJawabanSiswas,
                        ]);
                break;

            case 'es':
                $soalPertanyaanJawabanSiswas = \App\Soal::findOrFail($ujianHarian->soal_id)
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


                return view(self::FOLDER . 'hasil_essay')
                        ->with([
                            'ujianHarian' => $ujianHarian,
                            'soalPertanyaanJawabanSiswas' => $soalPertanyaanJawabanSiswas,
                        ]);
                break;

            case 'cu':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }
}
