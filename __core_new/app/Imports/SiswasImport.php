<?php

namespace App\Imports;

use App\User;
use App\Siswa;
use App\SiswaKelas;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswasImport implements ToModel, WithHeadingRow
{

    private $tahunAjaran, $kelas;

    public function __construct($tahunAjaran, $kelas)
    {
        $this->tahunAjaran = $tahunAjaran;
        $this->kelas = $kelas;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (isset($row['nomor_induk'])) {
            $user = User::where('username', session('sch_shortname') . '_' . strtolower($row['nomor_induk']))->count();
            $siswa = Siswa::where('nomor_induk', $row['nomor_induk'])->count();

            if ($user == 0 && $siswa == 0) {
                DB::transaction(function () use ($row) {
                    $tanggal_lahir = isset($row['tanggal_lahir']) ? Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d') : NULL;

                    $user = User::create([
                        'name' => $row['nama'],
                        'email' => strtolower($row['email']),
                        'username' => session('sch_shortname') . '_' . strtolower($row['nomor_induk']),
                        'username_sch' => strtolower($row['nomor_induk']),
                        'password' => bcrypt(date('dmY', strtotime($tanggal_lahir))), # 19062019
                        'level' => 'ss',
                        'active' => 1,
                        'type' => 'sch',
                    ]);
        
                    $siswa = Siswa::create([                
                        'nomor_induk' => $row['nomor_induk'],
                        'nama' => $row['nama'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'tempat_lahir' => $row['tempat_lahir'],
                        'tanggal_lahir' => $tanggal_lahir,
                        'alamat' => $row['alamat'],
                        'email' => strtolower($row['email']),
                        'handphone' => $row['handphone'],
                        'telp' => $row['telp'],
                        'perbarui_password' => NULL,
                        'user_id' => $user->id,
                    ]);
        
                    return SiswaKelas::create([
                        'aktif' => 1,
                        'keterangan' => NULL,
                        'tahun_ajaran_id' => $this->tahunAjaran,
                        'siswa_id' => $siswa->id,
                        'kelas_id' => $this->kelas,
                    ]);
                });
            }
        }
    }
}
