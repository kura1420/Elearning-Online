<?php

namespace App\Imports;

use App\SoalPertanyaan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalPertanyaansImport implements ToModel, WithHeadingRow
{

    private $soal, $tipe;

    public function __construct($soal, $tipe)
    {
        $this->soal = $soal;
        $this->tipe = $tipe;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        set_time_limit(0);

        DB::transaction(function () use ($row) {
            return SoalPertanyaan::create([
                'nomor' => $row['nomor'],
                'pertanyaan' => $row['pertanyaan'] ?? '-',
                'tipe' => $this->tipe,
                // 'tipe_jawaban' => $row['tipe_pilihan_ganda'],
                'soal_id' => $this->soal,
                'sekolah_id' => session('sch_id'),
            ]);
        });
    }
}
