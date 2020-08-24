<?php

namespace App\Http\Controllers\Sekolah;

use App\FileUpload;
use App\DataTables\FileUploadsDataTable;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //
    const FOLDER = 'sekolah.file_upload.';
    const URL = '/sch/file-upload';

    public function index(FileUploadsDataTable $dataTable)
    {
        return $dataTable->render(self::FOLDER . 'index', ['url' => self::URL]);
    }

    public function create()
    {
        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL,
                ]);
    }

    public function store(Request $request)
    {
        $nama_rule = $request->random_nama == 0 ? 'required' : 'nullable';

        $rules = [
            'nama' => 'string|max:255|' . $nama_rule,
            'random_nama' => 'required|string',
            'tipe' => 'required|string',
            'folder' => 'required|string',
            'file' => 'required|file',
        ];

        if ($request->tipe == 'image') {
            $rules['file'] = 'required|file|image';
        }

        if ($request->tipe == 'video') {
            $rules['file'] = 'required|file|mimes:mp4,mov,ogg,qt|max:20000';
        }

        if ($request->tipe == 'audio') {
            $rules['file'] = 'required|file|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav';
        }

        $val = Validator::make($request->all(), $rules);

        if ($val->fails()) {
            $resp = response()->json([
                'errors' => $val->errors()->all()
            ], 200);
        } else {
            #$filename = auth()->user()->username_sch . '_' . Carbon::now()->format('Ymd-Hsi') . '.' . $request->file->extension();

            $nama = $request->random_nama == 0 ? Str::slug($request->nama, '-') : Str::random(10);

            $filename = $nama . '_' . Carbon::now()->format('Ymd-Hsi') . '.' . $request->file->extension();
            $sch_id = session('sch_id');
            
            #$path = public_path("uploads/files/{$sch_id}/{$request->tipe}/{$request->folder}");
            $path = "uploads/files/{$sch_id}/{$request->tipe}/{$request->folder}";

            $request->file->move($path, $filename);
            $assets = asset($path . '/' . $filename);

            FileUpload::create([
                'nama' => $filename,
                'random_nama' => $request->random_nama,
                'tipe' => $request->tipe,
                'url' => $assets,
            ]);

            $resp = response()->json($assets);
        }

        return $resp;
    }

    public function destroy($id)
    {
        FileUpload::findOrFail($id)->delete();

        return response()->json();
    }
}
