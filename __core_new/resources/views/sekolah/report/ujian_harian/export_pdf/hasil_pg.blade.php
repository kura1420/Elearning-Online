<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> {{ $ujianHarian->nomor_induk . ' - ' . $ujianHarian->nama }} </title>
    <style>
    /* .column {
        float: left;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .page-break {
        page-break-after: always;
    } */
    </style>
</head>
<body>	
    <table width="100%">
        <tr>
            <td width="50px"><b>Judul</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ $ujianHarian->soal_text }} </td>

            <td rowspan="2" width="30%">
                <img src="{{ asset('assets/img/logo.png') }}" style="width: 120px;">
            </td>
        </tr>

        <tr>
            <td width="50px"><b>Pelajaran</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ $ujianHarian->pelajaran_text }} </td>
        </tr>

        <tr>
            <td width="150px"><b>Pelajaran Tipe</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ $ujianHarian->pelajaran_tipe_text }} </td>
        </tr>
    </table>

    <hr>

    <table width="100%">
        <tr>
            <td width="100px"><b>Nomor Induk</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ $ujianHarian->nomor_induk }} </td>

            <td width="50px"><b>Nilai</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ $ujianHarian->nilai }} </td>
        </tr>

        <tr>
            <td width="150px"><b>Siswa</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ $ujianHarian->nama }} </td>

            <td width="150px"><b>Tlg. Pengerjaan</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ date('d/M/Y, H:i', strtotime($ujianHarian->tanggal_selesai)) }} WIB </td>
        </tr>

        <tr>
            <td width="50px"><b>Kelas</b></td>
            <td width="2px"><b>:</b></td>
            <td> {{ $ujianHarian->kelas_text }} </td>
			
			<td width="50px"></td>
            <td width="2px"></td>
            <td></td>
        </tr>
    </table>

    <hr>

    <h4><b>Soal Pilihan Ganda</b></h4>

    @foreach ($soalPertanyaanJawabanSiswas as $soalPertanyaanJawabanSiswa)
    <table border="0" width="100%">
        <tr>
            <td width="3%">{{ $loop->iteration }}.</td>
            <td>@php echo $soalPertanyaanJawabanSiswa->pertanyaan; @endphp</td>
        </tr>
    </table>

        @php $jawabans = \App\SoalPertanyaanJawaban::where('soal_pertanyaan_id', $soalPertanyaanJawabanSiswa->id)->orderBy('urutan', 'asc')->get(); @endphp
        @foreach ($jawabans as $jawaban)
        <table border="0" width="100%" style="padding-left:3%;">
            <tr>
                <td width="3%">{{ $jawaban->urutan }}.</td>
                <td>
                    @php echo $jawaban->jawaban; @endphp
                </td>
            </tr>
        </table>
        @endforeach

    <table border="0">
        <tr>
            <td><b>Kunci</b></td>
            <td><b>:</b></td>
            <td> {{ $soalPertanyaanJawabanSiswa->kunci }} </td>
        </tr>
        <tr>
            <td><b>Dijawab</b></td>
            <td><b>:</b></td>
            <td> {{ $soalPertanyaanJawabanSiswa->dijawab }} </td>
        </tr>
    </table>
    @endforeach
</body>
</html>