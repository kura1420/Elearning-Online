<?php

namespace App\Http\Controllers\Sekolah;

use App\Soal;
use App\DataTables\SoalsDataTable;
use App\Rules\SekolahFieldUnique;
use App\Imports\SoalPertanyaansImport;
use App\imports\SoalPertanyaanJawabansImport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SoalController extends Controller
{

    const FOLDER = 'sekolah.soal.';
    const URL = '/sch/soal';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SoalsDataTable $dataTabel)
    {
        //
        return $dataTabel->render(self::FOLDER . 'index', ['url' => self::URL]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tahunAjarans = \App\TahunAjaran::where('sekolah_id', session('sch_id'))
                            ->orderBy('created_at', 'asc')
                            ->get();

        $rumusPenilaianUjians = \App\RumusPenilaianUjian::where('sekolah_id', session('sch_id'))
                                    ->orderBy('nama', 'asc')
                                    ->get();

        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
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
        $rule_tipe_pilihan_ganda = $request->tipe == 'pg' ? 'required|string' : 'nullable';
        
        $request->validate([
            'instruksi' => 'required|string',
            'tipe' => 'required|string',
            'tipe_pilihan_ganda' => $rule_tipe_pilihan_ganda,
            'publish' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
            'kelas' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'rumus_penilaian_ujian' => 'required|string',
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request) {
                    $check = Soal::where('sekolah_id', session('sch_id'))
                                ->where('pelajaran_id', $request->mata_pelajaran)
                                ->where('pelajaran_tipe_id', $request->pelajaran_tipe)
                                ->where('kelas_id', $request->kelas)
                                ->where('tahun_ajaran_id', $request->tahun_ajaran)
                                ->where('judul', $val)
                                ->count();

                    if ($check !== 0) {
                        $fail("Data judul soal di tahun pelajaran, kelas, pelajaran dan tipe pelajaran tersedia.");
                    }
                }
            ],
        ]);

        $soal = Soal::create([
            'judul' => $request->judul,
            'instruksi' => $request->instruksi,
            'tipe' => $request->tipe,
            'tipe_pilihan_ganda' => $request->tipe_pilihan_ganda,
            'publish' => $request->publish,
            'pelajaran_id' => $request->mata_pelajaran,
            'pelajaran_tipe_id' => $request->pelajaran_tipe,
            'rumus_penilaian_ujian_id' => $request->rumus_penilaian_ujian,
            'kelas_id' => $request->kelas,
            'user_id' => session('sch_pic'),
            'tahun_ajaran_id' => $request->tahun_ajaran,
        ]);

        return response()->json(['url' => $soal->id]);
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
        $row = Soal::findOrFail($id);
        $soalPertanyaans = $row->soal_pertanyaans()->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'asc')->get();

        $soal = DB::table('soals as a')
                ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', '=', 'b.id')
                ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                ->join('pelajarans as d', 'a.pelajaran_id', '=', 'd.id')
                ->join('pelajaran_tipes as e', 'a.pelajaran_tipe_id', '=', 'e.id')
                ->join('rumus_penilaian_ujians as f', 'a.rumus_penilaian_ujian_id', '=', 'f.id')
                ->where('a.id', $id)
                ->select([
                    'a.id',
                    'a.judul',
                    'a.instruksi',
                    DB::raw('(CASE WHEN a.tipe = "pg"
                            THEN "Pilihan Ganda"
                        WHEN a.tipe = "es"
                            THEN "Essay"
                        WHEN a.tipe = "cu"
                            THEN "Custom"
                        ELSE NULL 
                    END) AS tipe'),
                    'a.tipe_pilihan_ganda',
                    'a.publish',

                    DB::raw('CONCAT(b.merge_periode, "/", b.semester) AS tahun_ajaran_id'),
                    'c.nama as kelas_id',
                    'd.nama as pelajaran_id',
                    'e.nama as pelajaran_tipe_id',
                    'f.nama as rumus_penilaian_ujian',
                ])
                ->first();

        $tahunAjarans = \App\TahunAjaran::where('sekolah_id', session('sch_id'))
                            ->orderBy('created_at', 'asc')
                            ->get();

        switch ($row->tipe) {
            case 'pg':
                return view(self::FOLDER . 'show_pg')
                        ->with([
                            'url' => self::URL,
                            'soal' => $soal,
                            'soalPertanyaans' => $soalPertanyaans,
                            'tahunAjarans' => $tahunAjarans,
                        ]);
                break;

            case 'es':
                return view(self::FOLDER . 'show_es')
                        ->with([
                            'url' => self::URL,
                            'soal' => $soal,
                            'soalPertanyaans' => $soalPertanyaans,
                            'tahunAjarans' => $tahunAjarans,
                        ]);
                break;

            case 'cu':
                return view(self::FOLDER . 'show_cu')
                        ->with([
                            'url' => self::URL,
                            'soal' => $soal,
                            'tahunAjarans' => $tahunAjarans,
                        ]);
                break;
            
            default:
                return abort(404);
                break;
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
        $row = DB::table('soals as a')
                ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', '=', 'b.id')
                ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                ->join('pelajarans as d', 'a.pelajaran_id', '=', 'd.id')
                ->join('pelajaran_tipes as e', 'a.pelajaran_tipe_id', '=', 'e.id')
                ->where('a.id', $id)
                ->select([
                    'a.id',
                    'a.judul',
                    'a.instruksi',
                    'a.tipe',
                    'a.tipe_pilihan_ganda',
                    'a.publish',
                    'a.pelajaran_id',
                    'a.pelajaran_tipe_id',
                    'a.kelas_id',
                    'a.tahun_ajaran_id',
                    'a.rumus_penilaian_ujian_id',

                    'c.nama as kelas_nama',
                    'd.nama as pelajaran_nama',
                    'e.nama as pelajaran_tipe_nama',
                ])
                ->first();
        
        $tahunAjarans = \App\TahunAjaran::where('sekolah_id', session('sch_id'))
                            ->orderBy('created_at', 'asc')
                            ->get();

        $rumusPenilaianUjians = \App\RumusPenilaianUjian::where('sekolah_id', session('sch_id'))
                                    ->orderBy('nama', 'asc')
                                    ->get();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'tahunAjarans' => $tahunAjarans,
                    'row' => $row,
                    'rumusPenilaianUjians' => $rumusPenilaianUjians,
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
        $row = Soal::findOrFail($id);
        
        $rule_tipe_pilihan_ganda = $request->tipe == 'pg' ? 'required|string' : 'nullable';

        $request->validate([
            'instruksi' => 'required|string',
            'tipe' => 'required|string',
            'tipe_pilihan_ganda' => $rule_tipe_pilihan_ganda,
            'publish' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
            'rumus_penilaian_ujian' => 'required|string',
            'kelas' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request, $row) {
                    if ($row->judul !== $val) {
                        $check = Soal::where('sekolah_id', session('sch_id'))
                                ->where('pelajaran_id', $request->mata_pelajaran)
                                ->where('pelajaran_tipe_id', $request->pelajaran_tipe)
                                ->where('kelas_id', $request->kelas)
                                ->where('tahun_ajaran_id', $request->tahun_ajaran)
                                ->where('judul', $val)
                                ->count();

                        if ($check !== 0) {
                            $fail("Data judul soal di tahun pelajaran, kelas, pelajaran dan tipe pelajaran tersedia.");
                        }
                    }
                }
            ],
        ]);

        $row->update([
            'judul' => $request->judul,
            'instruksi' => $request->instruksi,
            'tipe' => $request->tipe,
            'tipe_pilihan_ganda' => $request->tipe_pilihan_ganda,
            'publish' => $request->publish,
            'pelajaran_id' => $request->mata_pelajaran,
            'pelajaran_tipe_id' => $request->pelajaran_tipe,
            'rumus_penilaian_ujian_id' => $request->rumus_penilaian_ujian,
            'kelas_id' => $request->kelas,
            'user_id' => session('sch_pic'),
            'tahun_ajaran_id' => $request->tahun_ajaran,
        ]);

        return response()->json();
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
        $row = Soal::findOrFail($id);
        $row->soal_pertanyaans()->delete();
        $row->soal_pertanyaan_jawabans()->delete();
        $row->delete();

        return response()->json();
    }

    public function pilihManualImport($id)
    {
        $row = Soal::findOrFail($id);

        return view(self::FOLDER . 'pilih_manual_import')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                ]);
    }

    public function importPertanyaan($id)
    {
        $row = Soal::findOrFail($id);

        return view(self::FOLDER . 'import_pertanyaan')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                ]);
    }
    
    public function importPertanyaanStore(Request $request, $id)
    {
        $row = Soal::findOrFail($id);

        Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ])->validate();

        Excel::import(new SoalPertanyaansImport($row->id, $row->tipe), request()->file('file'));

        return redirect(self::URL . '/' . $row->id)->with('success', 'Import Data Berhasil.');
    }

    public function importPertanyaanJawaban($id)
    {
        $row = Soal::findOrFail($id);
        
        return view(self::FOLDER . 'import_pertanyaan_jawaban')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
                ]);
    }
    
    public function importPertanyaanJawabanStore(Request $request, $id)
    {
        $row = Soal::findOrFail($id);

        Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ])->validate();

        Excel::import(new SoalPertanyaanJawabansImport($row->id), request()->file('file'));

        return redirect(self::URL . '/' . $row->id)->with('success', 'Import Data Berhasil.');
    }

    public function copy($id)
    {
        $row = Soal::findOrFail($id);
        $soalPertanyaans = $row->soal_pertanyaans()->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'asc')->get();

        $soal = DB::table('soals as a')
                ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', '=', 'b.id')
                ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                ->join('pelajarans as d', 'a.pelajaran_id', '=', 'd.id')
                ->join('pelajaran_tipes as e', 'a.pelajaran_tipe_id', '=', 'e.id')
                ->where('a.id', $id)
                ->select([
                    'a.id',
                    'a.judul',
                    'a.instruksi',
                    'a.tipe',
                    'a.tipe_pilihan_ganda',
                    'a.publish',
                    'a.pelajaran_id',
                    'a.pelajaran_tipe_id',
                    'a.kelas_id',
                    'a.tahun_ajaran_id',
                    'a.rumus_penilaian_ujian_id',

                    'c.nama as kelas_nama',
                    'd.nama as pelajaran_nama',
                    'e.nama as pelajaran_tipe_nama',
                ])
                ->first();

        $tahunAjarans = \App\TahunAjaran::where('sekolah_id', session('sch_id'))
                            ->orderBy('created_at', 'asc')
                            ->get();

        $rumusPenilaianUjians = \App\RumusPenilaianUjian::where('sekolah_id', session('sch_id'))
                                    ->orderBy('nama', 'asc')
                                    ->get();

        switch ($row->tipe) {
            case 'pg':
                return view(self::FOLDER . 'copy_pg')
                        ->with([
                            'url' => self::URL,
                            'row' => $soal,
                            'soalPertanyaans' => $soalPertanyaans,
                            'tahunAjarans' => $tahunAjarans,
                            'rumusPenilaianUjians' => $rumusPenilaianUjians,
                        ]);
                break;

            case 'es':
                return view(self::FOLDER . 'copy_es')
                        ->with([
                            'url' => self::URL,
                            'row' => $soal,
                            'soalPertanyaans' => $soalPertanyaans,
                            'tahunAjarans' => $tahunAjarans,
                            'rumusPenilaianUjians' => $rumusPenilaianUjians,
                        ]);
                break;

            case 'cu':
                return view(self::FOLDER . 'copy_cu')
                        ->with([
                            'url' => self::URL,
                            'soal' => $soal,
                        ]);
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    public function copyStore(Request $request, $id)
    {        
        $rule_tipe_pilihan_ganda = $request->tipe == 'pg' ? 'required|string' : 'nullable';

        $request->validate([
            'instruksi' => 'required|string',
            'tipe' => 'required|string',
            'tipe_pilihan_ganda' => $rule_tipe_pilihan_ganda,
            'publish' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'pelajaran_tipe' => 'required|string',
            'rumus_penilaian_ujian' => 'required|string',
            'kelas' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request) {
                    $check = Soal::where('sekolah_id', session('sch_id'))
                                ->where('pelajaran_id', $request->mata_pelajaran)
                                ->where('pelajaran_tipe_id', $request->pelajaran_tipe)
                                ->where('kelas_id', $request->kelas)
                                ->where('tahun_ajaran_id', $request->tahun_ajaran)
                                ->where('judul', $val)
                                ->count();

                    if ($check !== 0) {
                        $fail("Data judul soal di tahun pelajaran, kelas, pelajaran dan tipe pelajaran tersedia.");
                    }
                }
            ],

            'list_pertanyaan' => 'required|array',
        ]);

        switch ($request->tipe) {
            case 'pg':
                return $this->copySoalPg($request);
                break;

            case 'es':
                return $this->copySoalEs($request);
                break;

            case 'cu':
                return $this->copySoalCu($request);
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    protected function copySoalPg($request)
    {
        DB::beginTransaction();
        try {
            $soal = Soal::create([
                'judul' => $request->judul,
                'instruksi' => $request->instruksi,
                'tipe' => $request->tipe,
                'tipe_pilihan_ganda' => $request->tipe_pilihan_ganda,
                'publish' => $request->publish,
                'pelajaran_id' => $request->mata_pelajaran,
                'pelajaran_tipe_id' => $request->pelajaran_tipe,
                'rumus_penilaian_ujian_id' => $request->rumus_penilaian_ujian,
                'kelas_id' => $request->kelas,
                'user_id' => session('sch_pic'),
                'tahun_ajaran_id' => $request->tahun_ajaran,
            ]);

            $idPertanyaan = NULL;    
            $insertSoalPertanyaan = [];
            $insertSoalPertanyaanJawaban = [];

            $soalPertanyaans = \App\SoalPertanyaan::whereIn('id', $request->list_pertanyaan)->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'asc');
            if ($soalPertanyaans->count() !== 0) {
                foreach ($soalPertanyaans->get() as $key => $value) {
                    $idPertanyaan = Str::uuid();
                    $insertSoalPertanyaan[] = [
                        'id' => $idPertanyaan,
                        'nomor' => $key + 1,
                        'pertanyaan' => $value->pertanyaan,
                        'tipe' => $value->tipe,
                        'tipe_jawaban' => $value->tipe_jawaban,
                        'soal_id' => $soal->id,
                        'sekolah_id' => session('sch_id'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    $soalPertanyaanJawabans = \App\SoalPertanyaanJawaban::where('soal_pertanyaan_id', $value->id)->orderBy('urutan', 'asc')->get();
                    foreach ($soalPertanyaanJawabans as $jawaban) {
                        $insertSoalPertanyaanJawaban[] = [
                            'urutan' => $jawaban->urutan,
                            'jawaban' => $jawaban->jawaban,
                            'benar' => $jawaban->benar,
                            'soal_id' => $soal->id,
                            'soal_pertanyaan_id' => $idPertanyaan,
                        ];
                    }
                }

                DB::table('soal_pertanyaans')->insert($insertSoalPertanyaan);
                $soal->soal_pertanyaan_jawabans()->createMany($insertSoalPertanyaanJawaban);
            }

            DB::commit();
    
            return response()->json(['url' => $soal->id]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    protected function copySoalEs($request)
    {
        DB::beginTransaction();
        try {
            $soal = Soal::create([
                'judul' => $request->judul,
                'instruksi' => $request->instruksi,
                'tipe' => $request->tipe,
                'tipe_pilihan_ganda' => $request->tipe_pilihan_ganda,
                'publish' => $request->publish,
                'pelajaran_id' => $request->mata_pelajaran,
                'pelajaran_tipe_id' => $request->pelajaran_tipe,
                'rumus_penilaian_ujian_id' => $request->rumus_penilaian_ujian,
                'kelas_id' => $request->kelas,
                'user_id' => session('sch_pic'),
                'tahun_ajaran_id' => $request->tahun_ajaran,
            ]);

            $insertSoalPertanyaan = [];
            $soalPertanyaans = \App\SoalPertanyaan::whereIn('id', $request->list_pertanyaan)->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'asc');
            if ($soalPertanyaans->count() !== 0) {
                foreach ($soalPertanyaans->get() as $key => $value) {
                    $insertSoalPertanyaan[] = [
                        'nomor' => $key + 1,
                        'pertanyaan' => $value->pertanyaan,
                        'tipe' => $value->tipe,
                        'tipe_jawaban' => $value->tipe_jawaban,
                        'soal_id' => $soal->id,
                    ];
                }
                $soal->soal_pertanyaans()->createMany($insertSoalPertanyaan);
            }

            DB::commit();
    
            return response()->json(['url' => $soal->id]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    protected function copySoalCu($request)
    {
        # code...
    }

    public function copyPertanyaanCheck(Request $request, $id)
    {   
        $row = Soal::findOrFail($id);

        $request->validate([
            'soal' => 'required|string',
            'list_pertanyaan' => 'required|array',
        ]);

        $soalCopy = Soal::findOrFail($request->soal);

        $message = [];
        if ($row->tipe !== $soalCopy->tipe) {
            $message = ['msg' => 'Tipe Soal yang ingin di copy pertanyaannya tidak sesuai dengan soal yang ingin di paste.'];
        } else {
            $message = ['msg' => 'Pertanyaan Soal siap di copy'];
        }
        
        return response()->json($message, 200);
    }

    public function copyPertanyaanProcess(Request $request, $id)
    {
        $row = Soal::findOrFail($id);

        $request->validate([
            'soal' => 'required|string',
            'list_pertanyaan' => 'required|array',
        ]);

        $soalCopy = Soal::findOrFail($request->soal);

        $return = null;
        if ($row->tipe !== $soalCopy->tipe) {
            if ($row->tipe == 'pg' && $soalCopy->tipe == 'es' || $row->tipe == 'pg' && $soalCopy->tipe == 'cu') {
                $return = $this->copyPertanyaanPg($row, $request, $soalCopy->tipe);
            } elseif ($row->tipe == 'es' && $soalCopy->tipe == 'pg' || $row->tipe == 'es' && $soalCopy->tipe == 'cu') {
                $return = $this->copyPertanyaanEs($row, $request, $soalCopy->tipe);
            } elseif ($row->tipe == 'cu' && $soalCopy->tipe == 'pg' || $row->tipe == 'cu' && $soalCopy->tipe == 'es') {
                $return = $this->copyPertanyaanCu($row, $request, $soalCopy->tipe);
            } else {
                $return = abort(404);
            }            
        } else {
            switch ($row->tipe) {
                case 'pg':
                    $return = $this->copyPertanyaanPg($row, $request, $soalCopy->tipe);
                    break;

                case 'es':
                    $return = $this->copyPertanyaanEs($row, $request, $soalCopy->tipe);
                    break;

                case 'cu':
                    # code...
                    break;
                
                default:
                    $return = abort(404);
                    break;
            }
        }

        return $return;    
    }

    protected function copyPertanyaanPg($row, $request, $tipe)
    {
        if ($tipe !== 'cu') {
            $idPertanyaan = NULL;    
            $insertSoalPertanyaan = [];
            $insertSoalPertanyaanJawaban = [];

            $soalPertanyaans = \App\SoalPertanyaan::whereIn('id', $request->list_pertanyaan)->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'asc');
            if ($soalPertanyaans->count() !== 0) {
                $getLastNumber = \App\SoalPertanyaan::whereSoalId($row->id)
                                        ->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'desc')
                                        ->limit(1)
                                        ->first();

                $nomor = empty($getLastNumber) ? 1 : $getLastNumber->nomor + 1; 

                foreach ($soalPertanyaans->get() as $key => $value) {
                    $idPertanyaan = Str::uuid();
                    $insertSoalPertanyaan[] = [
                        'id' => $idPertanyaan,
                        'nomor' => $nomor++,
                        'pertanyaan' => $value->pertanyaan,
                        'tipe' => $row->tipe,
                        'tipe_jawaban' => $row->tipe_jawaban,
                        'soal_id' => $row->id,
                        'sekolah_id' => session('sch_id'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    $soalPertanyaanJawabans = \App\SoalPertanyaanJawaban::where('soal_pertanyaan_id', $value->id)->orderBy('urutan', 'asc');
                    if ($soalPertanyaanJawabans->count() !== 0) {
                        foreach ($soalPertanyaanJawabans->get() as $jawaban) {
                            $insertSoalPertanyaanJawaban[] = [
                                'urutan' => $jawaban->urutan,
                                'jawaban' => $jawaban->jawaban,
                                'benar' => $jawaban->benar,
                                'soal_id' => $row->id,
                                'soal_pertanyaan_id' => $idPertanyaan,
                            ];
                        }
                    } else {
                        $explodeTipePilihanGanda = explode('-', $row->tipe_pilihan_ganda);

                        for ($i=$explodeTipePilihanGanda[0]; $i<=$explodeTipePilihanGanda[1]; $i++) { 
                            $insertSoalPertanyaanJawaban[] = [
                                'urutan' => $i,
                                'jawaban' => '-',
                                'benar' => 0,
                                'soal_id' => $row->id,
                                'soal_pertanyaan_id' => $idPertanyaan,
                            ];
                        }
                    }
                }

                DB::beginTransaction();
                try {
                    DB::table('soal_pertanyaans')->insert($insertSoalPertanyaan);
                    $row->soal_pertanyaan_jawabans()->createMany($insertSoalPertanyaanJawaban);

                    DB::commit();

                    return response()->json();
                } catch (\Exception $e) {
                    DB::rollBack();
            
                    return response()->json($e->getMessage(), 500);
                }
            }
        } else {
            # code...
        }
    }

    protected function copyPertanyaanEs($row, $request, $tipe)
    {
        if ($tipe !== 'cu') {
            $insertSoalPertanyaan = [];
            $copySoalPertanyaans = \App\SoalPertanyaan::whereIn('id', $request->list_pertanyaan)->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'asc');
            if ($copySoalPertanyaans->count() !== 0) {
                $getLastNumber = \App\SoalPertanyaan::whereSoalId($row->id)
                                        ->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'desc')
                                        ->limit(1)
                                        ->first();

                $nomor = empty($getLastNumber) ? 1 : $getLastNumber->nomor + 1; 
                foreach ($copySoalPertanyaans->get() as $key => $value) {
                    $insertSoalPertanyaan[] = [
                        'nomor' => $nomor++,
                        'pertanyaan' => $value->pertanyaan,
                        'tipe' => $row->tipe,
                        'tipe_jawaban' => $row->tipe_jawaban,
                        'soal_id' => $row->id,
                    ];
                }
                $row->soal_pertanyaans()->createMany($insertSoalPertanyaan);
            }
        } else {
            # code...
        }    

        return response()->json();
    }

    protected function copyPertanyaanCu($row, $request, $tipe)
    {
        # code...
    }
}
