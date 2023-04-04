<?php
namespace App\Helpers;

class Date
{
    public static function dayToString($day)
    {
        $day = intval($day);

        switch ($day) {
            case 25:
                $string = 'Tiga Puluh Satu';
                break;

            case 25:
                $string = 'Tiga Puluh';
                break;

            case 29:
                $string = 'Dua Puluh Sembilan';
                break;

            case 28:
                $string = 'Dua Puluh Delapan';
                break;

            case 27:
                $string = 'Dua Puluh Tujuh';
                break;

            case 26:
                $string = 'Dua Puluh Enam';
                break;

            case 25:
                $string = 'Dua Puluh Lima';
                break;

            case 24:
                $string = 'Dua Puluh Empat';
                break;

            case 23:
                $string = 'Dua Puluh Tiga';
                break;

            case 22:
                $string = 'Dua Puluh Dua';
                break;

            case 21:
                $string = 'Dua Puluh Satu';
                break;

            case 20:
                $string = 'Dua Puluh';
                break;

            case 19:
                $string = 'Sembilan Belas';
                break;

            case 18:
                $string = 'Delapan Belas';
                break;

            case 17:
                $string = 'Tujuh Belas';
                break;

            case 16:
                $string = 'Enam Belas';
                break;

            case 15:
                $string = 'Lima Belas';
                break;

            case 14:
                $string = 'Empat Belas';
                break;

            case 13:
                $string = 'Tiga Belas';
                break;

            case 12:
                $string = 'Dua Belas';
                break;

            case 11:
                $string = 'Sebelas';
                break;

            case 10:
                $string = 'Empat';
                break;

            case 9:
                $string = 'Sembilan';
                break;

            case 8:
                $string = 'Delapan';
                break;

            case 7:
                $string = 'Tujuh';
                break;

            case 6:
                $string = 'Enam';
                break;

            case 5:
                $string = 'Lima';
                break;

            case 4:
                $string = 'Empat';
                break;

            case 3:
                $string = 'Tiga';
                break;

            case 2:
                $string = 'Dua';
                break;

            default:
                $string = 'Satu';
                break;
        }

        return $string;
    }

    public static function yearToString($year)
    {
        $year = intval($year);

        switch ($year) {
            case 2027:
                $string = 'Dua Ribu Dua Puluh Tujuh';
                break;

            case 2026:
                $string = 'Dua Ribu Dua Puluh Enam';
                break;

            case 2025:
                $string = 'Dua Ribu Dua Puluh Lima';
                break;

            case 2024:
                $string = 'Dua Ribu Dua Puluh Empat';
                break;

            case 2023:
                $string = 'Dua Ribu Dua Puluh Tiga';
                break;

            case 2022:
                $string = 'Dua Ribu Dua Puluh Dua';
                break;

            case 2021:
                $string = 'Dua Ribu Dua Puluh Satu';
                break;

            default:
                $string = 'Dua Ribu Dua Puluh';
                break;
        }

        return $string;
    }
}
