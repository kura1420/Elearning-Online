<?php

namespace App\Http\Controllers\Sekolah;

use App\Soal;
use App\SoalPertanyaan;
use App\SoalPertanyaanJawaban;
use App\Rules\SekolahFieldUnique;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SoalPertanyaanController extends Controller
{

    const FOLDER = 'sekolah.soal_pertanyaan.';
    const URL = '/sch/pertanyaan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if ($request->soal) {
            $row = Soal::findOrFail($request->soal);

            $soal = DB::table('soals as a')
                ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', '=', 'b.id')
                ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                ->join('pelajarans as d', 'a.pelajaran_id', '=', 'd.id')
                ->join('pelajaran_tipes as e', 'a.pelajaran_tipe_id', '=', 'e.id')
                ->where('a.id', $row->id)
                ->select([
                    'a.id',
                    'a.judul',
                    'a.instruksi',
                    'a.tipe',
                    DB::raw('(CASE WHEN a.tipe = "pg"
                            THEN "Pilihan Ganda"
                        WHEN a.tipe = "es"
                            THEN "Essay"
                        WHEN a.tipe = "cu"
                            THEN "Custom"
                        ELSE NULL 
                    END) AS tipe_convert'),
                    'a.tipe_pilihan_ganda',
                    'a.publish',

                    DB::raw('CONCAT(b.merge_periode, "/", b.semester) AS tahun_ajaran_id'),
                    'c.nama as kelas_id',
                    'd.nama as pelajaran_id',
                    'e.nama as pelajaran_tipe_id',
                ])
                ->first();

            $return = NULL;
            switch ($row->tipe) {
                case 'pg':
                    $return = view(self::FOLDER . 'create_pg')
                                ->with([
                                    'url' => self::URL,
                                    'soal' => $soal,
                                ]);
                    break;

                case 'es':
                    $return = view(self::FOLDER . 'create_es')
                                ->with([
                                    'url' => self::URL,
                                    'soal' => $soal,
                                ]);
                    break;

                case 'cu':
                    $return = view(self::FOLDER . 'create_cu')
                                ->with([
                                    'url' => self::URL,
                                    'soal' => $soal,
                                ]);
                    break;
                
                default:
                    $return = abort(404);
                    break;
            }

            return $return;
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
        $return = NULL;
        switch ($request->tipe) {
            case 'pg':
                $return = $this->validationStorePG($request);
                break;

            case 'es':
                $return = $this->validationStoreES($request);
                break;

            case 'cu':
                $return = $this->validationStoreCU($request);
                break;
            
            default:
                $return = abort(404);
                break;
        }

        return $return;
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
        $soalPertanyaan = SoalPertanyaan::findOrFail($id);
        
        $return = NULL;
        switch ($soalPertanyaan->tipe) {
            case 'pg':
                $return = view(self::FOLDER . 'show_pg')
                            ->with([
                                'url' => self::URL,
                                'soal' => Soal::findOrFail($soalPertanyaan->soal_id),
                                'soalPertanyaan' => $soalPertanyaan,
                                'soalPertanyaanJawaban' => $soalPertanyaan->soal_pertanyaan_jawabans()->orderBy('urutan', 'asc')->get(),
                                'benar' => $soalPertanyaan->soal_pertanyaan_jawabans()->where('benar', 1)->first()->urutan ?? '',
                            ]);
                break;

            case 'es':
                $return = view(self::FOLDER . 'show_es')
                            ->with([
                                'url' => self::URL,
                                'soal' => $soal,
                                'soalPertanyaan' => $soalPertanyaan,
                            ]);
                break;

            case 'cu':
                $return = view(self::FOLDER . 'show_cu')
                            ->with([
                                'url' => self::URL,
                                'soalPertanyaan' => $soalPertanyaan,
                                'soalPertanyaanJawaban' => $soalPertanyaan->soal_pertanyaan_jawabans()->orderBy('urutan', 'asc')->get(),
                            ]);
                break;
            
            default:
                $return = abort(404);
                break;
        }

        return $return;
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
        $soalPertanyaan = SoalPertanyaan::findOrFail($id);

        $soal = DB::table('soals as a')
                ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', '=', 'b.id')
                ->join('kelas as c', 'a.kelas_id', '=', 'c.id')
                ->join('pelajarans as d', 'a.pelajaran_id', '=', 'd.id')
                ->join('pelajaran_tipes as e', 'a.pelajaran_tipe_id', '=', 'e.id')
                ->where('a.id', $soalPertanyaan->soal_id)
                ->select([
                    'a.id',
                    'a.judul',
                    'a.instruksi',
                    'a.tipe',
                    DB::raw('(CASE WHEN a.tipe = "pg"
                            THEN "Pilihan Ganda"
                        WHEN a.tipe = "es"
                            THEN "Essay"
                        WHEN a.tipe = "cu"
                            THEN "Custom"
                        ELSE NULL 
                    END) AS tipe_convert'),
                    'a.tipe_pilihan_ganda',
                    'a.publish',

                    DB::raw('CONCAT(b.merge_periode, "/", b.semester) AS tahun_ajaran_id'),
                    'c.nama as kelas_id',
                    'd.nama as pelajaran_id',
                    'e.nama as pelajaran_tipe_id',
                ])
                ->first();
        
        $return = NULL;
        switch ($soalPertanyaan->tipe) {
            case 'pg':
                $return = view(self::FOLDER . 'edit_pg')
                            ->with([
                                'url' => self::URL,
                                'soal' => $soal,
                                'soalPertanyaan' => $soalPertanyaan,
                                'soalPertanyaanJawaban' => $soalPertanyaan->soal_pertanyaan_jawabans()->orderBy('urutan', 'asc')->get(),
                                'benar' => $soalPertanyaan->soal_pertanyaan_jawabans()->where('benar', 1)->first()->urutan ?? '',
                            ]);
                break;

            case 'es':
                $return = view(self::FOLDER . 'edit_es')
                            ->with([
                                'url' => self::URL,
                                'soal' => $soal,
                                'soalPertanyaan' => $soalPertanyaan,
                            ]);
                break;

            case 'cu':
                $return = view(self::FOLDER . 'edit_cu')
                            ->with([
                                'url' => self::URL,
                                'soalPertanyaan' => $soalPertanyaan,
                                'soalPertanyaanJawaban' => $soalPertanyaan->soal_pertanyaan_jawabans()->orderBy('urutan', 'asc')->get(),
                            ]);
                break;
            
            default:
                $return = abort(404);
                break;
        }

        return $return;
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
        $row = SoalPertanyaan::findOrFail($id);

        $return = NULL;
        switch ($row->tipe) {
            case 'pg':
                $return = $this->validationUpdatePG($request, $row);
                break;

            case 'es':
                $return = $this->validationUpdateES($request, $row);
                break;

            case 'cu':
                $return = $this->validationUpdateCU($request, $row);
                break;
            
            default:
                $return = abort(404);
                break;
        }

        return $return;
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
        $row = SoalPertanyaan::findOrFail($id);
        $row->soal_pertanyaan_jawabans()->delete();
        $row->delete();

        return response()->json();
    }

    # store
    protected function validationStorePG($request)
    {
        $rules = [
            'soal' => 'required|string',
            'tipe' => 'required|string',
            'pertanyaan' => 'required|string',
            'tipe_pilihan_ganda' => 'required|string',
            'kunci_jawaban' => 'required|string',
        ];

        $tipePilihanGanda = strtolower($request->tipe_pilihan_ganda);

        if ($tipePilihanGanda == 'a-d') {
            $rules['jawaban_a'] = 'required|string';
            $rules['jawaban_b'] = 'required|string';
            $rules['jawaban_c'] = 'required|string';
            $rules['jawaban_d'] = 'required|string';
        } else {
            $rules['jawaban_a'] = 'required|string';
            $rules['jawaban_b'] = 'required|string';
            $rules['jawaban_c'] = 'required|string';
            $rules['jawaban_d'] = 'required|string';
            $rules['jawaban_e'] = 'required|string';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $getNomor = SoalPertanyaan::where('sekolah_id', session('sch_id'))
                            ->where('soal_id', $request->soal)
                            ->orderBy('nomor', 'desc')
                            ->limit(1)
                            ->first();

            $nomor = empty($getNomor) ? 1 : $getNomor->nomor + 1;

            $soalPertanyaan = SoalPertanyaan::create([
                'nomor' => $nomor,
                'pertanyaan' => $request->pertanyaan,
                'tipe' => $request->tipe,
                // 'tipe_jawaban' => $request->tipe_pilihan_ganda,
                'soal_id' => $request->soal,
                'sekolah_id' => session('sch_id'),
            ]);

            $explodeTipePilihanGanda = explode('-', $tipePilihanGanda);
            for ($i=$explodeTipePilihanGanda[0]; $i<=$explodeTipePilihanGanda[1]; $i++) {
                $jawaban = 'jawaban_' . $i;
                
                SoalPertanyaanJawaban::create([
                    'urutan' => $i,
                    'jawaban' => $request->{$jawaban},
                    'benar' => $i == $request->kunci_jawaban ? 1 : 0,
                    'soal_id' => $request->soal,
                    'soal_pertanyaan_id' => $soalPertanyaan->id,
                ]);
            }           

            DB::commit();

            return response()->json(['no' => $nomor + 1]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    protected function validationStoreES($request)
    {
        $rules = [
            'soal' => 'required|string',
            'tipe' => 'required|string',
            'pertanyaan' => 'required|string',
        ];

        $request->validate($rules);

        $getNomor = SoalPertanyaan::where('sekolah_id', session('sch_id'))
                        ->where('soal_id', $request->soal)
                        ->orderBy(DB::raw('CAST(nomor AS UNSIGNED)'), 'desc')
                        ->limit(1)
                        ->first();
        
        $nomor = empty($getNomor) ? 1 : $getNomor->nomor + 1;
        
        SoalPertanyaan::create([
            'nomor' => $nomor,
            'pertanyaan' => $request->pertanyaan,
            'tipe' => $request->tipe,
            'tipe_jawaban' => NULL,
            'soal_id' => $request->soal,
            'sekolah_id' => session('sch_id'),
        ]);

        return response()->json(['no' => $nomor + 1]);
    }

    protected function validationStoreCU($request)
    {
        $rules = [
            'soal' => 'required|string',
            'tipe' => 'required|string',
            'pertanyaan' => 'required|string',
            'tipe_jawaban' => 'required|string',
            'jawaban' => 'nullable|array',
        ];

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $getNomor = SoalPertanyaan::where('sekolah_id', session('sch_id'))
                        ->where('soal_id', $request->soal)
                        ->orderBy('nomor', 'desc')
                        ->limit(1)
                        ->first();
        
            $nomor = empty($getNomor) ? 1 : $getNomor->nomor + 1;
            
            $soalPertanyaan = SoalPertanyaan::create([
                'nomor' => $nomor,
                'pertanyaan' => $request->pertanyaan,
                'tipe' => $request->tipe,
                'tipe_jawaban' => $request->tipe_jawaban,
                'soal_id' => $request->soal,
                'sekolah_id' => session('sch_id'),
            ]);

            if ($request->tipe_jawaban == 'pg') {
                $jawaban = $request->jawaban;

                foreach ($jawaban as $key => $value) {
                    SoalPertanyaanJawaban::create([
                        'urutan' => $value['urutan'],
                        'jawaban' => $value['jawaban'],
                        'benar' => $value['kunci_jawaban'],
                        'soal_id' => $request->soal,
                        'soal_pertanyaan_id' => $soalPertanyaan->id,
                        'sekolah_id' => session('sch_id'),
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
    # end store

    # update
    protected function validationUpdatePG($request, $row)
    {
        $rules = [
            'pertanyaan' => 'required|string',
            'tipe_pilihan_ganda' => 'required|string',
            'kunci_jawaban' => 'required|string',
        ];

        $tipePilihanGanda = strtolower($request->tipe_pilihan_ganda);

        if ($tipePilihanGanda == 'a-d') {
            $rules['jawaban_a'] = 'required|string';
            $rules['jawaban_b'] = 'required|string';
            $rules['jawaban_c'] = 'required|string';
            $rules['jawaban_d'] = 'required|string';
        } else {
            $rules['jawaban_a'] = 'required|string';
            $rules['jawaban_b'] = 'required|string';
            $rules['jawaban_c'] = 'required|string';
            $rules['jawaban_d'] = 'required|string';
            $rules['jawaban_e'] = 'required|string';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $row->update([
                'pertanyaan' => $request->pertanyaan,
                // 'tipe_jawaban' => $request->tipe_pilihan_ganda,
            ]);

            if ($tipePilihanGanda == 'a-d') {
                for ($i='a'; $i <= 'd'; $i++) { 
                    $jawaban = 'jawaban_' . $i;
                    SoalPertanyaanJawaban::where('sekolah_id', session('sch_id'))
                        ->where('soal_pertanyaan_id', $row->id)
                        ->where('urutan', $i)
                        ->update([
                            'jawaban' => $request->{$jawaban},
                            'benar' => $i == $request->kunci_jawaban ? 1 : 0,
                        ]);
                }
            } else {
                for ($i='a'; $i <= 'e'; $i++) { 
                    $jawaban = 'jawaban_' . $i;
                    SoalPertanyaanJawaban::where('sekolah_id', session('sch_id'))
                        ->where('soal_pertanyaan_id', $row->id)
                        ->where('urutan', $i)
                        ->update([
                            'jawaban' => $request->{$jawaban},
                            'benar' => $i == $request->kunci_jawaban ? 1 : 0,
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

    protected function validationUpdateES($request, $row)
    {
        $rules = [
            'pertanyaan' => 'required|string',
        ];

        $request->validate($rules);
        
        $row->update([
            'pertanyaan' => $request->pertanyaan,
        ]);

        return response()->json();
    }

    protected function validationUpdateCU($request, $row)
    {
        $rules = [
            'tipe' => 'required|string',
            'pertanyaan' => 'required|string',
            'tipe_jawaban' => 'required|string',
            'jawaban' => 'nullable|array',
        ];

        $request->validate($rules);

        DB::beginTransaction();
        try {            
            $row->update([
                'pertanyaan' => $request->pertanyaan,
                'tipe' => $request->tipe,
                'tipe_jawaban' => $request->tipe_jawaban,
            ]);

            if ($request->tipe_jawaban == 'pg') {
                $jawaban = $request->jawaban;

                foreach ($jawaban as $key => $value) {
                    $soalPertanyaanJawaban = SoalPertanyaanJawaban::where('sekolah_id', session('sch_id'))
                            ->where('soal_pertanyaan_id', $row->id);

                    if ($soalPertanyaanJawaban->count() == 0) {
                        SoalPertanyaanJawaban::create([
                            'urutan' => $value['urutan'],
                            'jawaban' => $value['jawaban'],
                            'benar' => $value['kunci_jawaban'],
                            'soal_id' => $request->soal,
                            'soal_pertanyaan_id' => $row->id,
                            'sekolah_id' => session('sch_id'),
                        ]);
                    } else {
                        $soalPertanyaanJawaban->update([
                            'urutan' => $value['urutan'],
                            'jawaban' => $value['jawaban'],
                            'benar' => $value['kunci_jawaban'],
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }
    # end update
}
