<?php

namespace App\Http\Controllers\Sekolah;

use App\JenisUjian;
use App\DataTables\JenisUjiansDataTable;
use App\Rules\SekolahFieldUnique;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisUjianController extends Controller
{

    const FOLDER = 'sekolah.jenis_ujian.';
    const URL = '/sch/jenis-ujian';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JenisUjiansDataTable $dataTable)
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
        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
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
        Validator::make($request->all(), [
            'jenis' => 'required|string',
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request) {
                    $check = JenisUjian::where('nama', $val)
                                ->where('jenis', $request->jenis)
                                ->where('sekolah_id', session('sch_id'))
                                ->count();

                    if ($check !== 0) {
                        $fail("Data jenis ujian sudah tersedia.");
                    }
                }
            ]
        ])->validate();

        JenisUjian::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'sekolah_id' => session('sch_id'),
        ]);

        return redirect(self::URL);
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
        $row = JenisUjian::findOrFail($id);

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'row' => $row,
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
        $row = JenisUjian::findOrFail($id);

        Validator::make($request->all(), [
            'jenis' => 'required|string',
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request, $row) {
                    if ($row->nama !== $request->nama) {
                        $check = JenisUjian::where('nama', $val)
                                ->where('jenis', $request->jenis)
                                ->where('sekolah_id', session('sch_id'))
                                ->count();

                        if ($check !== 0) {
                            $fail("Data jenis ujian sudah tersedia.");
                        }
                    }
                }
            ]
        ])->validate();

        $row->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
        ]);

        return redirect(self::URL);
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
        JenisUjian::findOrFail($id)->delete();

        return response()->json();
    }
}
