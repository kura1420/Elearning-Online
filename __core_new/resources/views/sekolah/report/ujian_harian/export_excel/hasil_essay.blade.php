<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Soal dan Jawaban</title>
</head>
<body>
    <table>
        <tr>
            <td><b>Judul</b></td>
            <td><b>:</b></td>
            <td> {{ $ujianHarian->soal_text }} </td>

            <td></td>
            <td>
                <img src="assets/img/logo.png" width="50px" height="50px">
            </td>
        </tr>
        <tr>
            <td><b>Pelajaran</b></td>
            <td><b>:</b></td>
            <td> {{ $ujianHarian->pelajaran_text }} </td>
        </tr>
        <tr>
            <td><b>Pelajaran Tipe</b></td>
            <td><b>:</b></td>
            <td> {{ $ujianHarian->pelajaran_tipe_text }} </td>
        </tr>
        <tr>
            <td><b>No. Induk</b></td>
            <td><b>:</b></td>
            <td> {{ $ujianHarian->nomor_induk }} </td>
        </tr>
        <tr>
            <td><b>Siswa</b></td>
            <td><b>:</b></td>
            <td> {{ $ujianHarian->nama }} </td>
        </tr>
        <tr>
            <td><b>Kelas</b></td>
            <td><b>:</b></td>
            <td> {{ $ujianHarian->kelas_text }} </td>
        </tr>
        <tr>
            <td><b>Nilai</b></td>
            <td><b>:</b></td>
            <td> {{ $ujianHarian->nilai }} </td>
        </tr>
        <tr>
            <td><b>Tlg. Pengerjaan</b></td>
            <td><b>:</b></td>
            <td> {{ date('d/M/Y, H:i', strtotime($ujianHarian->tanggal_selesai)) }} WIB </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th><b>No.</b></th>
                <th><b>Pertanyaan</b></th>
                <th><b>Dijawab</b></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($soalPertanyaanJawabanSiswas as $soalPertanyaanJawabanSiswa)
            <tr>
                <td> {{ $soalPertanyaanJawabanSiswa->nomor }} </td>
                <td> {{ $soalPertanyaanJawabanSiswa->pertanyaan }} </td>
                <td> {{ $soalPertanyaanJawabanSiswa->essay }} </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>