<?php

namespace App\Imports;

use App\User;
use App\Guru;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GurusImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (isset($row['username'])) {
            $user = User::where('username', session('sch_shortname') . '_' . strtolower($row['username']))->count();
            $guru = Guru::where('nomor_induk', $row['nomor_induk'])->count();

            if ($user == 0 && $guru == 0) {      
                DB::transaction(function () use ($row) {
                    $user = User::create([
                        'name' => $row['nama'],
                        'email' => strtolower($row['email']),
                        'username' => session('sch_shortname') . '_' . strtolower($row['username']),
                        'username_sch' => strtolower($row['username']),
                        'password' => bcrypt($row['password']),
                        'level' => 'gr',
                        'active' => 1,
                        'type' => 'sch',
                    ]);
    
                    return Guru::create([
                        'nomor_induk' => $row['nomor_induk'],
                        'nama' => $row['nama'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'tempat_lahir' => $row['tempat_lahir'],
                        'tanggal_lahir' => isset($row['tanggal_lahir']) ? Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d') : NULL,
                        'alamat' => $row['alamat'],
                        'email' => strtolower($row['email']),
                        'handphone' => $row['handphone'],
                        'telp' => $row['telp'],
                        'tanggal_masuk' => isset($row['tanggal_masuk']) ? Date::excelToDateTimeObject($row['tanggal_masuk'])->format('Y-m-d') : NULL,
                        'tanggal_keluar' => NULL,
                        'jabatan' => $row['jabatan'],
        
                        'user_id' => $user->id,
                    ]);
                });
            }
        }        
    }
}
