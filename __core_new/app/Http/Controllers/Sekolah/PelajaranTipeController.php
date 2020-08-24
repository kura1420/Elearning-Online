<?php

namespace App\Http\Controllers\Sekolah;

use App\PelajaranTipe;
use App\DataTables\PelajaranTipesDataTable;
use Validator;
use App\Rules\SekolahFieldUnique;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PelajaranTipeController extends Controller
{

    const FOLDER = 'sekolah.pelajaran_tipe.';
    const URL = '/sch/tipe-pelajaran';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PelajaranTipesDataTable $dataTable)
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
        $pelajarans = \App\Pelajaran::where('sekolah_id', session('sch_id'))->orderBy('nama', 'asc')->get();

        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                    'pelajarans' => $pelajarans,
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
            'pelajaran' => 'required|string',
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request) {
                    $check = PelajaranTipe::where('sekolah_id', session('sch_id'))
                                ->where('nama', $val)
                                ->where('pelajaran_id', $request->pelajaran)
                                ->count();

                    if ($check !== 0) {
                        $fail("Data tipe pelajaran di pelajaran tersebut sudah tersedia.");
                    }
                }
            ],
        ])->validate();

        PelajaranTipe::create([
            'nama' => $request->nama,
            'pelajaran_id' => $request->pelajaran,
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
        $row = PelajaranTipe::findOrFail($id);

        $pelajarans = \App\Pelajaran::where('sekolah_id', session('sch_id'))->orderBy('nama', 'asc')->get();

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'pelajarans' => $pelajarans,
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
        $row = PelajaranTipe::findOrFail($id);

        Validator::make($request->all(), [
            'pelajaran' => 'required|string',
            'nama' => [
                'required',
                'string',
                'max:255',
                function ($attr, $val, $fail) use ($request, $row) {
                    if ($row->nama !== $request->nama) {
                        $check = PelajaranTipe::where('sekolah_id', session('sch_id'))
                                    ->where('nama', $val)
                                    ->where('pelajaran_id', $request->pelajaran)
                                    ->count();

                        if ($check !== 0) {
                            $fail("Data tipe pelajaran di pelajaran tersebut sudah tersedia.");
                        }
                    }
                }
            ]
        ])->validate();

        $row->update([
            'nama' => $request->nama,
            'pelajaran_id' => $request->pelajaran,
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
        PelajaranTipe::findOrFail($id)->delete();

        return response()->json();
    }
}
