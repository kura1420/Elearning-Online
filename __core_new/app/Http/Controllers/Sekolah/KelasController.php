<?php

namespace App\Http\Controllers\Sekolah;

use App\Kelas;
use Validator;
use App\Rules\SekolahFieldUnique;
use App\DataTables\KelasDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelasController extends Controller
{

    const FOLDER = 'sekolah.kelas.';
    const URL = '/sch/kelas';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KelasDataTable $dataTable)
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
                    'url' => self::URL
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
                new SekolahFieldUnique('kelas')
            ],
            'keterangan' => 'nullable|string',
        ])->validate();

        Kelas::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
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
        $row = Kelas::findOrFail($id);

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
        $row = Kelas::findOrFail($id);

        $unique_nama = $row->nama !== $request->nama ? new SekolahFieldUnique('kelas') : NULL;

        Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:255',
                $unique_nama
            ],
            'keterangan' => 'nullable|string',
        ])->validate();

        $row->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
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
        Kelas::findOrFail($id)->delete();

        return response()->json();
    }
}
