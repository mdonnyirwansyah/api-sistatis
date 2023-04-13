<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            margin-bottom: 1em;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        h2 {
            margin: 0;
            font-size: 24px;
        }

        p {
            margin: 0;
            font-size: 12px;
        }

        .logo {
            width: 100px;
        }

        hr {
            border: 1px solid;
            margin: 0.5px;
        }

        .body {
            font-size: 12px;
        }

    </style>
</head>
<body>
    <main>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 7em">
                        <img class="logo" src="{{ public_path('dist/img/logo-unri.png') }}" alt="Logo UNRI">
                    </td>
                    <td class="header">
                        <h1><b>Program Studi Teknik Sipil</b></h1>
                        <h2><b>Fakultas Teknik</b></h2>
                        <p>Kampus Bina Widya Jl. HR. Soebrantas Pekanbaru</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <hr style="margin-bottom: 1em;">
        <div class="body">
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td style="width: 100px;">Nomor</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['seminar']['number_of_letter'] }}</td>
                    </tr>
                    <tr>
                        <td style="width: 100px;">Lamp.</>
                        <td style="width: 15px;">:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td style="width: 100px;">Hal</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['seminar']['type'] }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>Kepada yth.</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%">
                <tbody>
                    @foreach ($data['lecturers'] as $index => $lecturer)
                    <tr>
                        <td style="width: 100px;">{!! $index == 0 ? 'Saudara' : null !!}</td>
                        <td style="width: 15px;">{{ $index + 1 . '.' }}</td>
                        <td>{{ $lecturer['name'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>Di _</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 1em">Pekanbaru</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td style="text-align: justify;">Dengan ini Kami mengundang Saudara untuk hadir pada {{ $data['seminar']['type'] }} untuk mahasiswa berikut:</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td style="width: 150px;">Nama</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['student']['name'] }}</td>
                    </tr>
                    <tr>
                        <td style="width: 150px;">Nim</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['student']['nim'] }}</td>
                    </tr>
                    <tr>
                        <td style="width: 150px;">Nomor HP</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['student']['phone'] }}</td>
                    </tr>
                    <tr>
                        <td style="width: 150px;">Judul Tugas Akhir</td>
                        <td style="width: 15px;">:</td>
                        <td style="text-align: justify;">{{ $data['thesis']['title'] }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>{{ $data['seminar']['type'] }} akan dilaksanakan pada:</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td style="width: 150px;">Hari /Tanggal</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['seminar']['date'] }}</td>
                    </tr>
                    <tr>
                        <td style="width: 150px;">Pukul</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['seminar']['time'] }} WIB</td>
                    </tr>
                    <tr>
                        <td style="width: 150px;">Tempat</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $data['seminar']['location'] }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>Demikian undangan ini disampaikan, atas perhatiannya diucapkan terima kasih</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td style="width: 40em;"></td>
                        <td>Pekanbaru, {{ $data['seminar']['validate_date'] }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40em;"></td>
                        <td>Koordinator Program Studi S1 Teknik Sipil</td>
                    </tr>
                    <tr>
                        <td style="width: 40em;"></td>
                        <td><img src="data:image/png;base64, {!! $data['sign'] !!}"></td>
                    </tr>
                    <tr>
                        <td style="width: 40em;"></td>
                        <td style="text-decoration: underline">Andy Hendri, ST., MT</td>
                    </tr>
                    <tr>
                        <td style="width: 40em;"></td>
                        <td>NIP. 19690717 199803 1 002</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <br>
            <table>
                <tbody>
                    <tr>
                        <td>NB: </td>
                    </tr>
                    <tr>
                        <td style="text-align: justify;">
                            <ul>
                                <li>Pembimbing 1 atau 2 HARUS hadir, kalau tidak terpenuhi maka {{ $data['seminar']['type'] }}
                                    dibatalkan.</li>
                                <li>Jika Penguji tidak dapat hadir maka koordinasikan dengan koordinator TA untuk mencari
                                    penguji pengganti</li>
                                <li>Tidak dibenarkan menguji di lain waktu yang telah ditentukan</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
