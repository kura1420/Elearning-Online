<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Summary</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th><b>Total Siswa</b></th>
                <th><b>Benar</b></th>
                <th><b>Salah</b></th>
                <th><b>Tidak Dijawab</b></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td> {{ $row->total_siswa }} </td>
                <td> {{ $row->total_benar }} </td>
                <td> {{ $row->total_salah }} </td>
                <td> {{ $row->total_tidak_dijawab }} </td>
            </tr>
        </tbody>
    </table>
</body>
</html>