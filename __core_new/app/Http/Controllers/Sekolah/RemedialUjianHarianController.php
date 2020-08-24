<?php

namespace App\Http\Controllers\Sekolah;

use App\RemedialUjianHarian;
use App\RemedialUjianHarianSiswa;
use App\RemedialUjianHarianHasil;
use App\Rules\SekolahFieldUnique;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RemedialUjianHarianController extends Controller
{

    const FOLDER = 'sekolah.remedial_ujian_harian.';
    const URL = '/sch/remedial-ujian-harian';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tahunAjarans = \App\TahunAjaran::where('sekolah_id', session('sch_id'))
                            ->orderBy('created_at', 'asc')
                            ->get();

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
        $tampilkan_nilai = $request->tampilkan_nilai == 1 ? 'required|numeric' : 'nullable';

        $request->validate([
            'tanggal' => 'required|date|after:' . Carbon::yesterday()->format('m/d/Y'),
            'waktu_mulai' => 'required|string|after:' . Carbon::now()->format('Hi'),
            'waktu_habis' => 'required|string|after:' . $waktu_mulai,
            'tampilkan_nilai' => 'nullable|string',
            'alert_simpan_jawaban' => 'required|string',
            'batas_kelulusan' => $tampilkan_nilai,
            'pertanyaan_acak' => 'nullable|string',
            'ujian_harian' => 'required|string',
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request) {
                    $check = RemedialUjianHarian::where('sekolah_id', session('sch_id'))
                                ->where('ujian_harian_id', $request->ujian_harian)
                                ->where('judul', $val)
                                ->count();

                    if ($check !== 0) {
                        $fail("Data ujian sudah tersedia.");
                    }
                }
            ],

            'list_siswa_remedial' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $total_waktu_pengerjaan = Carbon::parse($request->waktu_mulai)->diffInMinutes($request->waktu_habis);

            $remedialUjianHarian = RemedialUjianHarian::create([
                'judul' => $request->judul,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_habis' => $request->waktu_habis,
                'total_waktu_pengerjaan' => $total_waktu_pengerjaan,
                'tampilkan_nilai' => isset($request->tampilkan_nilai) ? $request->tampilkan_nilai : NULL,
                'alert_simpan_jawaban' => $request->alert_simpan_jawaban,
                'batas_kelulusan' => isset($request->batas_kelulusan) ? $request->batas_kelulusan : NULL,
                'pertanyaan_acak' => $request->pertanyaan_acak,
                'ujian_harian_id' => $request->ujian_harian,                
                'sekolah_id' => session('sch_id'),
            ]);

            $list_siswa_remedial = $request->list_siswa_remedial;
            foreach ($list_siswa_remedial as $lsr) {
                $check = RemedialUjianHarianSiswa::where('status', 'BR')
                            ->where('siswa_id', $lsr['siswa'])
                            ->where('ujian_harian_id', $request->ujian_harian)
                            ->where('remedial_ujian_harian_id', $remedialUjianHarian->id)
                            ->where('sekolah_id', session('sch_id'))
                            ->count();

                if ($check == 0) {
                    RemedialUjianHarianSiswa::create([
                        'status' => 'BR',
                        'siswa_id' => $lsr['siswa'],
                        'ujian_harian_id' => $request->ujian_harian,
                        'remedial_ujian_harian_id' => $remedialUjianHarian->id,
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
    }
}
