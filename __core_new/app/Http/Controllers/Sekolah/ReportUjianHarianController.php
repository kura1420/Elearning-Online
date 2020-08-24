<?php

namespace App\Http\Controllers\Sekolah;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Exports\ReportUjianHarianExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportUjianHarianController extends Controller
{
    //
    const FOLDER = 'sekolah.report.ujian_harian.';
    const URL = '/sch/report/ujian-harian';

    public function index()
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

    public function filter(Request $request)
    {
        $request->validate([
            'soal' => 'required|string',
            'pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
            'kelas' => 'required|string',
            'tanggal_ujian' => 'required|string',
        ]);

        $rows = DB::table('ujian_harian_hasils as a')
                    ->join('siswas as b', 'a.siswa_id', '=', 'b.id')
                    ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                    ->where('a.soal_id', $request->soal)
                    ->where('a.pelajaran_id', $request->pelajaran)
                    ->where('a.pelajaran_tipe_id', $request->pelajaran_tipe)
                    ->where('a.kelas_id', $request->kelas)
                    ->where('a.ujian_harian_id', $request->tanggal_ujian)
                    ->where('a.sekolah_id', session('sch_id'))
                    ->orderBy('b.nama', 'asc')
                    ->select([
                        'a.id',
                        'a.total_pertanyaan',
                        'a.nilai',
                        'b.nomor_induk',
                        'b.nama',
                        'c.nama as kelas',
                    ])
                    ->get();

        return response()->json($rows);
    }
    
    public function hasil($ujian_harian_hasil_id)
    {
        $ujianHarian = \App\UjianHarian::join('soals', 'ujian_harians.soal_id', '=', 'soals.id')
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

                $ujianHarianJawabanSiswa = \App\UjianHarianSiswa::findOrFail($ujianHarian->ujian_harian_siswa_id)
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

    public function exportSummaryToExcel($ujian_harian_id)
    {
        return Excel::download(new ReportUjianHarianExport($ujian_harian_id, 'summary'), 'Summary_' . Carbon::now()->format('YmdHis') . '.xlsx');
    }

    public function exportSoalJawabanPersiswa($ujian_harian_hasil_id, $typeFile)
    {
        if (isset($ujian_harian_hasil_id) && isset($typeFile)) {
            switch ($typeFile) {
                case 'pdf':
                    return $this->generateFilePdf($ujian_harian_hasil_id);
                    break;

                case 'excel':
                    return $this->generateFileExcel($ujian_harian_hasil_id);
                    break;

                case 'word':
                    return $this->generateFileWord($ujian_harian_hasil_id);
                    break;
                
                default:
                    return abort(404);
                    break;
            }
        } else {
            return abort(404);
        }        
    }

    protected function _loadDataUjianHarianHasilSiswa($ujian_harian_hasil_id)
    {
        $row = \App\UjianHarian::join('soals', 'ujian_harians.soal_id', '=', 'soals.id')
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

        return $row;
    }

    protected function generateFilePdf($ujian_harian_hasil_id)
    {
        $ujianHarian = $this->_loadDataUjianHarianHasilSiswa($ujian_harian_hasil_id);

        switch ($ujianHarian->tipe) {
            case 'pg':
                $soalPertanyaanJawabanSiswas = DB::select("SELECT 
                    a.id,
                    a.nomor, a.pertanyaan,
                    b.urutan AS kunci,
                    (SELECT urutan FROM soal_pertanyaan_jawabans WHERE id = c.soal_pertanyaan_jawaban_id) AS dijawab,
                    (CASE WHEN b.id = c.soal_pertanyaan_jawaban_id THEN 'Benar' ELSE 'Salah' END) AS status
                FROM soal_pertanyaans AS a
                INNER JOIN soal_pertanyaan_jawabans AS b ON a.id = b.soal_pertanyaan_id AND b.benar = 1
                INNER JOIN ujian_harian_jawaban_siswas AS c ON a.id = c.soal_pertanyaan_id
                WHERE a.soal_id = '{$ujianHarian->soal_id}' AND c.ujian_harian_siswa_id = '{$ujianHarian->ujian_harian_siswa_id}'
                ORDER BY a.nomor ASC");

                $pdf = \PDF::loadView(self::FOLDER . 'export_pdf.hasil_pg', compact('ujianHarian', 'soalPertanyaanJawabanSiswas'));
        
                return $pdf->stream($ujianHarian->nomor_induk . '_' . Str::slug($ujianHarian->nama, '_') . '.pdf');
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

                $pdf = \PDF::loadView(self::FOLDER . 'export_pdf.hasil_essay', compact('ujianHarian', 'soalPertanyaans'));
        
                return $pdf->stream($ujianHarian->nomor_induk . '_' . Str::slug($ujianHarian->nama, '_') . '.pdf');
                break;

            case 'cu':
                # code...
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    protected function generateFileExcel($ujian_harian_hasil_id)
    {
        $ujianHarian = $this->_loadDataUjianHarianHasilSiswa($ujian_harian_hasil_id);

        return Excel::download(new ReportUjianHarianExport($ujianHarian, 'perSiswa'), $ujianHarian->nomor_induk . '_' . Str::slug($ujianHarian->nama, '_') . '.xlsx');
    }

    public function generateFileWord($ujian_harian_hasil_id)
    {
        $ujianHarian = $this->_loadDataUjianHarianHasilSiswa($ujian_harian_hasil_id);

        switch ($ujianHarian->tipe) {
            case 'pg':
                $soalPertanyaanJawabanSiswas = DB::select("SELECT 
                    a.id,
                    a.nomor, a.pertanyaan,
                    b.urutan AS kunci,
                    (SELECT urutan FROM soal_pertanyaan_jawabans WHERE id = c.soal_pertanyaan_jawaban_id) AS dijawab,
                    (CASE WHEN b.id = c.soal_pertanyaan_jawaban_id THEN 'Benar' ELSE 'Salah' END) AS status
                FROM soal_pertanyaans AS a
                INNER JOIN soal_pertanyaan_jawabans AS b ON a.id = b.soal_pertanyaan_id AND b.benar = 1
                INNER JOIN ujian_harian_jawaban_siswas AS c ON a.id = c.soal_pertanyaan_id
                WHERE a.soal_id = '{$ujianHarian->soal_id}' AND c.ujian_harian_siswa_id = '{$ujianHarian->ujian_harian_siswa_id}'
                ORDER BY a.nomor ASC");


                $htmlPertanyaan = NULL;
                $htmlJawaban = NULL;

                if (isset($soalPertanyaanJawabanSiswas)) {
                    foreach ($soalPertanyaanJawabanSiswas as $soalPertanyaanJawabanSiswa) {
                        $jawabans = \App\SoalPertanyaanJawaban::where('soal_pertanyaan_id', $soalPertanyaanJawabanSiswa->id)->orderBy('urutan', 'asc')->get();
                        foreach ($jawabans as $jawaban) {
                            if ($jawaban->urutan == 'a') {
                                $htmlJawaban = '<tr>
                                    <td style="vertical-align:top;" width="5px"> ' . $jawaban->urutan . '. </td>
                                    <td> ' . $jawaban->jawaban . ' </td>
                                </tr>';					
                            } else {
                                $htmlJawaban .= '<tr>
                                    <td style="vertical-align:top;" width="5px"> ' . $jawaban->urutan . '. </td>
                                    <td> ' . $jawaban->jawaban . ' </td>
                                </tr>';	
                            }
                        }
                        
                        $htmlPertanyaan .= '<tr>
                            <td width="20px" style="vertical-align:top;"> ' . $soalPertanyaanJawabanSiswa->nomor . '. </td>
                            <td colspan="3"> ' . $soalPertanyaanJawabanSiswa->pertanyaan . ' </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3">
                                <table border="0" cellpadding="4" cellspacing="0" width="650px">
                                    ' . $htmlJawaban .  '
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="10px"><b>Kunci: </b> ' . $soalPertanyaanJawabanSiswa->kunci . ' </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="10px"><b>Jawab: </b> ' . $soalPertanyaanJawabanSiswa->dijawab . '</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                        </tr>';
                    }
                }

                $HTML = '<table border="0" cellpadding="4" cellspacing="0" width="100%">
                    <tr>
                        <td width="10%"><b>Judul</b></td>
                        <td width="2%"><b>:</b></td>
                        <td> ' . $ujianHarian->soal_text . ' </td>

                        <td rowspan="2" width="30%"><img src="' . asset('assets/img/logo.png') . '" width="100" height="60"></td>
                    </tr>

                    <tr>
                        <td width="10%"><b>Pelajaran</b></td>
                        <td width="2%"><b>:</b></td>
                        <td> ' . $ujianHarian->pelajaran_text . ' </td>
                    </tr>

                    <tr>
                        <td width="20%"><b>Pelajaran Tipe</b></td>
                        <td width="2%"><b>:</b></td>
                        <td> ' . $ujianHarian->pelajaran_tipe_text . ' </td>
                    </tr>
                </table>

                <hr>

                <table border="0" cellpadding="4" cellspacing="0">
                    <tr>
                        <td width="20px"><b>No. Induk</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->nomor_induk . ' </td>

                        <td width="20px"><b>Siswa</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->nama . ' </td>

                        <td width="20px"><b>Nilai</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->nilai . ' </td>
                    </tr>

                    <tr>
                        <td width="20px"><b>Kelas</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->kelas_text . ' </td>

                        <td width="150px"><b>Tlg. Pengerjaan</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . date('d/M/Y, H:i', strtotime($ujianHarian->tanggal_selesai)) . ' WIB </td>
                    </tr>
                </table>

                <hr>

                <table border="0" cellpadding="4" cellspacing="0" width="700px">
                    <tr>
                        <td colspan="4"><b>Soal Pilihan Ganda</b></td>
                    </tr>' . $htmlPertanyaan . '
                </table>';

                header("Content-type:application/vnd.ms-word");
                header("Content-disposition:attachment;Filename=" . $ujianHarian->nomor_induk . ' - ' . Str::slug($ujianHarian->nama, '_') . ".doc");
                header("Pragma:no-cache");
                header("Expires:0");

                $output = preg_replace("/<img src=\"([^\"]+)\" style=\"width: (\d+)px;\"/", "<img src=\"$1\" width=\"$2\" height=\"$2\"", $HTML);
                return $output;
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

                $htmlPertanyaan = NULL;
                if (isset($soalPertanyaanJawabanSiswas)) {
                    foreach ($soalPertanyaanJawabanSiswas as $soalPertanyaanJawabanSiswa) {   
                        $jawaban = $soalPertanyaanJawabanSiswa->essay ?? '<i>Siswa tidak mengisi jawaban</i>';
                        
                        $htmlPertanyaan .= '<tr>
                            <td width="20px" style="vertical-align:top;"> ' . $soalPertanyaanJawabanSiswa->nomor . '. </td>
                            <td colspan="3"> ' . $soalPertanyaanJawabanSiswa->pertanyaan . ' </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> <b>Jawab:</b> <br>'. $jawaban .'</td>
                        </tr>';
                    }
                }


                $HTML = '<table border="0" cellpadding="4" cellspacing="0" width="100%">
                    <tr>
                        <td width="10%"><b>Judul</b></td>
                        <td width="2%"><b>:</b></td>
                        <td> ' . $ujianHarian->soal_text . ' </td>

                        <td rowspan="2" width="30%"><img src="' . asset('assets/img/logo.png') . '" width="100" height="60"></td>
                    </tr>

                    <tr>
                        <td width="10%"><b>Pelajaran</b></td>
                        <td width="2%"><b>:</b></td>
                        <td> ' . $ujianHarian->pelajaran_text . ' </td>
                    </tr>

                    <tr>
                        <td width="20%"><b>Pelajaran Tipe</b></td>
                        <td width="2%"><b>:</b></td>
                        <td> ' . $ujianHarian->pelajaran_tipe_text . ' </td>
                    </tr>
                </table>

                <hr>

                <table border="0" cellpadding="4" cellspacing="0">
                    <tr>
                        <td width="20px"><b>No. Induk</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->nomor_induk . ' </td>

                        <td width="20px"><b>Siswa</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->nama . ' </td>

                        <td width="20px"><b>Nilai</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->nilai . ' </td>
                    </tr>

                    <tr>
                        <td width="20px"><b>Kelas</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . $ujianHarian->kelas_text . ' </td>

                        <td width="150px"><b>Tlg. Pengerjaan</b></td>
                        <td width="2px"><b>:</b></td>
                        <td> ' . date('d/M/Y, H:i', strtotime($ujianHarian->tanggal_selesai)) . ' WIB </td>
                    </tr>
                </table>

                <hr>

                <table border="0" cellpadding="4" cellspacing="0" width="700px">
                    <tr>
                        <td colspan="4"><b>Soal Pilihan Ganda</b></td>
                    </tr>' . $htmlPertanyaan . '
                </table>';

                header("Content-type:application/vnd.ms-word");
                header("Content-disposition:attachment;Filename=" . $ujianHarian->nomor_induk . ' - ' . Str::slug($ujianHarian->nama, '_') . ".doc");
                header("Pragma:no-cache");
                header("Expires:0");

                $output = preg_replace("/<img src=\"([^\"]+)\" style=\"width: (\d+)px;\"/", "<img src=\"$1\" width=\"$2\" height=\"$2\"", $HTML);
                return $output;
                break;

            case 'cu':
                # code...
                break;
            
            default:
                return abort(404);
                break;
        }
    }
}
