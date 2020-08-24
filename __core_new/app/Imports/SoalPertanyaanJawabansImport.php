<?php

namespace App\Imports;

use App\Soal;
use App\SoalPertanyaan;
use App\SoalPertanyaanJawaban;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalPertanyaanJawabansImport implements ToModel, WithHeadingRow
{

    private $soal;

    public function __construct($soal)
    {
        $this->soal = $soal;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $soal = Soal::findOrFail($this->soal);

        switch ($soal->tipe) {
            case 'pg':
                $soalPertanyaan = SoalPertanyaan::where('soal_id', $soal->id)->where('nomor', $row['no_pertanyaan']);

                if ($soalPertanyaan->count() !== 0) {
                    set_time_limit(0);
                    
                    DB::transaction(function () use ($row, $soal, $soalPertanyaan) {
                        return SoalPertanyaanJawaban::create([
                            'urutan' => $row['urutan'],
                            'jawaban' => $row['jawaban'] ?? '-',
                            'benar' => $row['benar'],
                            'soal_id' => $soal->id,
                            'soal_pertanyaan_id' => $soalPertanyaan->first()->id,
                            'sekolah_id' => session('sch_id'),
                        ]);
                    });
                }                
                break;

            case 'es':
                # code...
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
