<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title></title>

        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 0;
            }
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
            }
            .header {
                margin-bottom: 1em;
                text-align: center;
            }
            h1 {
                margin: 0;
                font-size: 16px;
            }
            h2 {
                margin: 0;
                font-size: 16px;
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
        <header>
            <table style="width: 100%; background-color: darkgrey">
                <tbody>
                    <tr>
                        <td class="header">
                            <h1><b>BERITA ACARA</b></h1>
                            <h2>
                                <b>{{ $data["seminar"]["name"] }}</b>
                            </h2>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>
        <main style="margin-top: 45px">
            <div class="body">
                <table style="width: 100%; background-color: rgb(228, 228, 228);">
                    <tbody>
                        <tr>
                            <td style="text-align: justify">
                                Pada hari ini, {{ \Carbon\Carbon::parse($data["seminar"]["date"])->format('l') }} tanggal {{ \Carbon\Carbon::parse($data["seminar"]["date"])->format('d') }} bulan {{ \Carbon\Carbon::parse($data["seminar"]["date"])->format('F') }} tahun {{ \Carbon\Carbon::parse($data["seminar"]["date"])->year }}, telah dilaksanakan {{ $data["seminar"]["name"] }} atas nama mahasiswa:
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td style="width: 150px">Nama</td>
                            <td style="width: 15px">:</td>
                            <td>{{ $data["student"]["name"] }}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px">Nim</td>
                            <td style="width: 15px">:</td>
                            <td>{{ $data["student"]["nim"] }}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px">Judul Tugas Akhir</td>
                            <td style="width: 15px">:</td>
                            <td style="text-align: justify">
                                {{ $data["thesis"]["title"] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td>
                                Dengan Susunan tim Pembimbing dalam Seminar ini
                                adalah sebagai berikut:
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%">
                    <tbody>
                        @foreach ($data['lecturers'] as $index => $lecturer)
                        <tr>
                            <td style="width: 15px">{{ $index + 1 . '.' }}</td>
                            <td>{{ $lecturer["name"] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                {{ $data["seminar"]["name"] }} ini dibuka oleh: {{ $data['lecturers'][0]['name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Pada jam:_______
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Catatan Seminar:
                            </td>
                        </tr>
                        <tr style="display: block; page-break-after: always; height: 700px;"></tr>
                    </tbody>
                </table>
                <table style="width: 100%;">
                    <tbody>
                        <tr style="display: block; page-break-after: always; height: 650px;"></tr>
                    </tbody>
                </table>
                <br>
                <table style="width: 100%; background-color: darkgrey;">
                    <tbody>
                        <tr>
                            <td>
                                {{ $data["seminar"]["name"] }} ini ditutup pada Jam:_______ dengan hasil / Putusan Seminar adalah sebagai berikut: Mahasiswa tersebut di atas dinyatakan:
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ $data['options'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Catatan:
                            </td>
                        </tr>
                        <tr style="display: block; page-break-after: always; height: 70px;"></tr>
                        <tr>
                            <td>
                                *) Pilih salah satu
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table style="width: 100%; text-align: center; font-weight: bold;">
                    <tbody>
                        <tr>
                            <td>
                                Pekanbaru, {{ \Carbon\Carbon::parse($data["seminar"]["date"])->format('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tim Pembimbing {{ $data["seminar"]["name"] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td style="width: 50%; padding-left: 25%;">Pembimbing Pendamping</td>
                            <td style="width: 50%; padding-left: 25%;">Pembimbing Utama</td>
                        </tr>
                        <tr style="display: block; page-break-after: always; height: 50px;"></tr>
                        <tr>
                            <td style="width: 50%; text-decoration: underline; padding-left: 25%;">{{ $data['lecturers'][1]['name'] }}</td>
                            <td style="width: 50%; text-decoration: underline; padding-left: 25%;">{{ $data['lecturers'][0]['name'] }}</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding-left: 25%;">{{ $data['lecturers'][1]['nip'] }}</td>
                            <td style="width: 50%; padding-left: 25%;">{{ $data['lecturers'][0]['nip'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>
