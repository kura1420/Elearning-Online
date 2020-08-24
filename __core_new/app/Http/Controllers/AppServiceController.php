<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppServiceController extends Controller
{
    // CRUD file
    public function uploadImage(Request $request)
    {
        $val = Validator::make($request->all(), [
            'folder' => 'required|string',
            'file' => 'required|image',
        ]);

        if ($val->fails()) {
            return response()->json($val->errors()->all()[0], 422);
        } else {
            $filename = Str::random(10) . '.' . $request->file->extension();
            
            #$path = public_path($request->folder);

            $path = NULL;
            if ($request->folder == 'uploads') {
                $sch_id = session('sch_id');                
                $path = "uploads/files/{$sch_id}/image/tinymce";
            } else {
                $path = $request->folder;
            }           

            $request->file->move($path, $filename);

            return response()->json([
                'filename' => $filename,
                'location' => $path . '/' . $filename,
            ]);
        }
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'folder' => 'required|string',
            'file' => 'required|string',
        ]);

        $path = $request->folder . '/' . $request->file;

        if (file_exists($path)) {
            unlink($path);

            return response()->json();
        } else {
            return response()->json('File tidak ditemukan', 422);
        }       
    }
    // end CRUD file
    

    // service data
    public function guruPelajaran(Request $request)
    {
        $request->validate([
            'mt' => 'required|string',
        ]);

        $rows = DB::table('guru_pelajarans as a')
                    ->join('gurus as b', 'a.guru_id', '=', 'b.id')
                    ->where('a.pelajaran_id', $request->mt)
                    ->where('a.aktif', 1)
                    ->select([
                        'b.id',
                        'b.nama'
                    ])
                    ->get();

        return response()->json($rows);
    }

    public function tahunAjaranJadwalDestroy(Request $request)
    {
        $this->validate($request, [
            'pelajaran_id' => 'required|string',
            'kelas_id' => 'required|string',
            'user_guru_id' => 'required|string',
            'tahun_ajaran_id' => 'required|string',
        ]);

        $row = \App\TahunAjaranJadwal::where('pelajaran_id', $request->pelajaran_id)
                            ->where('kelas_id', $request->kelas_id)
                            ->where('guru_id', $request->user_guru_id)
                            ->where('tahun_ajaran_id', $request->tahun_ajaran_id);

        if ($row->count() > 0) {
            $row->delete();

            return response()->json();
        } else {
            return response()->json(['message' => 'Not Found!'], 500);
        }
    }

    public function listKelas(Request $request)
    {
        $request->validate([
            'ta' => 'required|string',
        ]);

        $rows = [];
        if (auth()->user()->level == 'gr') {
            $rows = DB::table('tahun_ajaran_jadwals as a')
                    ->join('kelas as b', 'a.kelas_id', '=', 'b.id')
                    ->where('a.tahun_ajaran_id', $request->ta)
                    ->where('a.guru_id', session()->get('sch_pic'))
                    ->whereNull('a.deleted_at')
                    ->orderBy(DB::raw('b.nama'), 'asc')
                    ->select([
                        'a.kelas_id',
                        'b.nama'
                    ])
                    ->distinct()
                    ->get();
        } else {
            $rows = DB::table('tahun_ajaran_jadwals as a')
                    ->join('kelas as b', 'a.kelas_id', '=', 'b.id')
                    ->where('a.tahun_ajaran_id', $request->ta)
                    ->whereNull('a.deleted_at')
                    ->orderBy(DB::raw('b.nama'), 'asc')
                    ->select([
                        'a.kelas_id',
                        'b.nama'
                    ])
                    ->distinct()
                    ->get();
        }

        return response()->json($rows);
    }

    public function listSiswa(Request $request)
    {
        $this->validate($request, [
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
        ]);

        $rows = [];
        if ($request->kelas == '*') {
            if (auth()->user()->level == 'gr') {
                $rows = DB::table('siswas as a')
                    ->join('siswa_kelas as b', 'a.id', '=', 'b.siswa_id')
                    ->join('tahun_ajarans as c', 'b.tahun_ajaran_id', '=', 'c.id')
                    ->join('kelas as d', 'b.kelas_id', '=', 'd.id')
                    ->where('b.tahun_ajaran_id', $request->tahun_ajaran)
                    ->whereIn('b.kelas_id', \App\TahunAjaranJadwal::whereGuruId(session()->get('sch_pic'))->select('kelas_id')->get()->toArray())
                    ->whereNull('a.deleted_at')
                    ->orderBy('a.nama', 'asc')
                    ->select([
                        'a.id',
                        'a.nomor_induk',
                        'a.nama',
                        'b.keterangan',
                        DB::raw('CONCAT(c.merge_periode, "/", c.semester) as tahun_ajaran'),
                        'd.nama as kelas',
                    ])
                    ->get();
            } else {
                $rows = DB::table('siswas as a')
                    ->join('siswa_kelas as b', 'a.id', '=', 'b.siswa_id')
                    ->join('tahun_ajarans as c', 'b.tahun_ajaran_id', '=', 'c.id')
                    ->join('kelas as d', 'b.kelas_id', '=', 'd.id')
                    ->where('b.tahun_ajaran_id', $request->tahun_ajaran)
                    ->whereNull('a.deleted_at')
                    ->orderBy('a.nama', 'asc')
                    ->select([
                        'a.id',
                        'a.nomor_induk',
                        'a.nama',
                        'b.keterangan',
                        DB::raw('CONCAT(c.merge_periode, "/", c.semester) as tahun_ajaran'),
                        'd.nama as kelas',
                    ])
                    ->get();
            }
        } else {
            $rows = DB::table('siswas as a')
                    ->join('siswa_kelas as b', 'a.id', '=', 'b.siswa_id')
                    ->join('tahun_ajarans as c', 'b.tahun_ajaran_id', '=', 'c.id')
                    ->join('kelas as d', 'b.kelas_id', '=', 'd.id')
                    ->where('b.tahun_ajaran_id', $request->tahun_ajaran)
                    ->where('b.kelas_id', $request->kelas)
                    ->whereNull('a.deleted_at')
                    ->orderBy('a.nama', 'asc')
                    ->select([
                        'a.id',
                        'a.nomor_induk',
                        'a.nama',
                        'b.keterangan',
                        DB::raw('CONCAT(c.merge_periode, "/", c.semester) as tahun_ajaran'),
                        'd.nama as kelas',
                    ])
                    ->get();
        }

        return response()->json($rows);
    }

    public function siswaKelasEdit($siswa_kelas_id)
    {
        $row = \App\SiswaKelas::findOrFail($siswa_kelas_id);

        return response()->json($row);
    }

    public function siswaKelasPut(Request $request, $siswa_kelas_id)
    {
        $row = \App\SiswaKelas::findOrFail($siswa_kelas_id);

        $this->validate($request, [
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $row->update([
            'tahun_ajaran_id' => $request->tahun_ajaran,
            'kelas_id' => $request->kelas,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json();
    }

    public function siswaKelasDestroy($siswa_kelas_id)
    {
        $row = \App\SiswaKelas::findOrFail($siswa_kelas_id);

        $row->update(['aktif' => 0]);
        $row->delete();

        return response()->json();
    }

    public function listPelajaran(Request $request)
    {
        $this->validate($request, [
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
        ]);

        if (auth()->user()->level == 'gr') {
            $pelajaranId = \App\GuruPelajaran::whereGuruId(session()->get('sch_pic'))
                                ->whereAktif(1)
                                ->select('pelajaran_id')
                                ->get()
                                ->toArray();

            $rows = DB::table('tahun_ajaran_jadwals as a')
                    ->join('pelajarans as b', 'a.pelajaran_id', '=', 'b.id')
                    ->where('a.tahun_ajaran_id', $request->tahun_ajaran)
                    ->where('a.kelas_id', $request->kelas)
                    ->where('a.pelajaran_id', $pelajaranId)
                    ->whereNull('a.deleted_at')
                    ->orderBy('b.nama', 'asc')
                    ->select([
                        'a.pelajaran_id',
                        'b.nama',
                    ])
                    ->get();
        } else {
            $rows = DB::table('tahun_ajaran_jadwals as a')
                    ->join('pelajarans as b', 'a.pelajaran_id', '=', 'b.id')
                    ->where('a.tahun_ajaran_id', $request->tahun_ajaran)
                    ->where('a.kelas_id', $request->kelas)
                    ->whereNull('a.deleted_at')
                    ->orderBy('b.nama', 'asc')
                    ->select([
                        'a.pelajaran_id',
                        'b.nama',
                    ])
                    ->get();
        }

        return response()->json($rows);
    }

    public function listPelajaranTipe(Request $request)
    {
        $this->validate($request, [
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'pelajaran' => 'required|string',
        ]);

        $rows = DB::table('tahun_ajaran_jadwals as a')
                    ->join('pelajarans as b', 'a.pelajaran_id', '=', 'b.id')
                    ->join('pelajaran_tipes as c', 'b.id', '=', 'c.pelajaran_id')
                    ->where('a.tahun_ajaran_id', $request->tahun_ajaran)
                    ->where('a.kelas_id', $request->kelas)
                    ->where('a.pelajaran_id', $request->pelajaran)
                    ->whereNull('a.deleted_at')
                    ->orderBy('b.nama', 'asc')
                    ->select([
                        'c.id',
                        'c.nama',
                    ])
                    ->get();

        return response()->json($rows);
    }

    public function listSoal(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
        ]);

        $rows = \App\Soal::where('sekolah_id', session('sch_id'))
                    // ->where('publish', 1)
                    ->where('pelajaran_id', $request->pelajaran)
                    ->where('pelajaran_tipe_id', $request->pelajaran_tipe)
                    ->where('kelas_id', $request->kelas)
                    ->where('tahun_ajaran_id', $request->tahun_ajaran)
                    ->get();

        return response()->json($rows);
    }

    public function nomorPertanyaan(Request $request)
    {
        $request->validate([
            'soal' => 'required|string',
        ]);

        $row = \App\SoalPertanyaan::where('sekolah_id', session('sch_id'))
                    ->where('soal_id', $request->soal)
                    ->orderBy('nomor', 'desc')
                    ->limit(1)
                    ->first();

        $nomor = isset($row) ? $row->nomor + 1 : 1;

        return response()->json($nomor);
    }

    public function listUjianHarian(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'jenis_ujian' => 'required|string',
        ]);

        if (auth()->user()->level == 'gr') {
            $pelajaranId = \App\GuruPelajaran::whereGuruId(session()->get('sch_pic'))
                                ->whereAktif(1)
                                ->select('pelajaran_id')
                                ->get()
                                ->toArray();

            $rows = DB::table('ujian_harians as a')
                    ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', '=', 'b.id')
                    ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                    ->join('soals as d', 'a.soal_id', '=', 'd.id')
                    ->join('pelajarans as e', 'a.pelajaran_id', '=', 'e.id')
                    ->join('pelajaran_tipes as f', 'a.pelajaran_tipe_id', '=', 'f.id')
                    ->where('a.sekolah_id', session('sch_id'))
                    ->where('a.tahun_ajaran_id', $request->tahun_ajaran)
                    ->where('a.kelas_id', $request->kelas)
                    ->where('a.jenis_ujian_id', $request->jenis_ujian)
                    ->whereIn('a.pelajaran_id', $pelajaranId)
                    ->whereNull('a.deleted_at')
                    ->select([
                        'a.id',
                        'a.judul',
                        'a.tanggal',

                        DB::raw('CONCAT(b.merge_periode, "/", b.semester) AS tahun_ajaran_id'),
                        'c.nama as kelas_id',
                        'd.judul as soal_id',
                        'e.nama as pelajaran_id',
                        'f.nama as pelajaran_tipe_id',
                    ])
                    ->get();
        } else {
            $rows = DB::table('ujian_harians as a')
                    ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', '=', 'b.id')
                    ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                    ->join('soals as d', 'a.soal_id', '=', 'd.id')
                    ->join('pelajarans as e', 'a.pelajaran_id', '=', 'e.id')
                    ->join('pelajaran_tipes as f', 'a.pelajaran_tipe_id', '=', 'f.id')
                    ->where('a.sekolah_id', session('sch_id'))
                    ->where('a.tahun_ajaran_id', $request->tahun_ajaran)
                    ->where('a.kelas_id', $request->kelas)
                    ->where('a.jenis_ujian_id', $request->jenis_ujian)
                    ->whereNull('a.deleted_at')
                    ->select([
                        'a.id',
                        'a.judul',
                        'a.tanggal',

                        DB::raw('CONCAT(b.merge_periode, "/", b.semester) AS tahun_ajaran_id'),
                        'c.nama as kelas_id',
                        'd.judul as soal_id',
                        'e.nama as pelajaran_id',
                        'f.nama as pelajaran_tipe_id',
                    ])
                    ->get();
        }

        return response()->json($rows);
    }

    public function tglUjianHarian(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
            'soal' => 'required|string',
            'jenis_ujian' => 'required|string',
        ]);

        $rows = DB::table('ujian_harians')
                ->where('tahun_ajaran_id', $request->tahun_ajaran)
                ->where('kelas_id', $request->kelas)
                ->where('pelajaran_id', $request->pelajaran)
                ->where('pelajaran_tipe_id', $request->pelajaran_tipe)
                ->where('soal_id', $request->soal)
                ->where('jenis_ujian_id', $request->jenis_ujian)
                ->where('sekolah_id', session('sch_id'))
                ->select([
                    'id',
                    DB::raw('CONCAT(tanggal, ", ", waktu_mulai, " s/d ", waktu_habis) as tanggal_waktu_ujian'),
                ])
                ->get();

        return response()->json($rows);
    }

    public function listSoalPertanyaan(Request $request)
    {
        $request->validate([
            'soal' => 'required|string',
        ]);

        $rows = \App\SoalPertanyaan::whereSoalId($request->soal)->get();

        return DataTables::of($rows)->make(true);
    }
    // service data
}
