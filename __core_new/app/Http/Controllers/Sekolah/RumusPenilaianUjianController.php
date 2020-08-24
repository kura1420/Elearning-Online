<?php

namespace App\Http\Controllers\Sekolah;

use App\RumusPenilaianUjian;
use App\DataTables\RumusPenilaianUjiansDataTable;
use App\Rules\SekolahFieldUnique;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RumusPenilaianUjianController extends Controller
{

    const FOLDER = 'sekolah.rumus_penilaian_ujian.';
    const URL = '/sch/rumus-penilaian-ujian';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RumusPenilaianUjiansDataTable $dataTable)
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
            'nama' => [
                'required',
                'string',
                'max:255',
                new SekolahFieldUnique('rumus_penilaian_ujians')
            ],
            'benar' => 'required|numeric',
            'salah' => 'required|numeric',
        ])->validate();

        RumusPenilaianUjian::create([
            'nama' => $request->nama,
            'benar' => $request->benar,
            'salah' => $request->salah,
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
        $row = RumusPenilaianUjian::findOrFail($id);

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
        $row = RumusPenilaianUjian::findOrFail($id);

        $unique_nama = $row->nama !== $request->nama ? new SekolahFieldUnique('rumus_penilaian_ujians') : NULL;

        Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:255',
                $unique_nama
            ],
            'benar' => 'required|numeric',
            'salah' => 'required|numeric',
        ])->validate();

        $row->update([
            'nama' => $request->nama,
            'benar' => $request->benar,
            'salah' => $request->salah,
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
        RumusPenilaianUjian::findOrFail($id)->delete();

        return response()->json();
    }
}
