<?php

if (!function_exists('toRupiah')) {
    function toRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('toTerbilang')) {
    function toTerbilang($angka)
    {
        $angka = abs($angka);
        $huruf = [
            "", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        ];
    
        if ($angka < 12) {
            return $huruf[$angka];
        } elseif ($angka < 20) {
            return toTerbilang($angka - 10) . " belas";
        } elseif ($angka < 100) {
            return toTerbilang(intval($angka / 10)) . " puluh " . toTerbilang($angka % 10);
        } elseif ($angka < 200) {
            return "seratus " . toTerbilang($angka - 100);
        } elseif ($angka < 1000) {
            return toTerbilang(intval($angka / 100)) . " ratus " . toTerbilang($angka % 100);
        } elseif ($angka < 2000) {
            return "seribu " . toTerbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return toTerbilang(intval($angka / 1000)) . " ribu " . toTerbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return toTerbilang(intval($angka / 1000000)) . " juta " . toTerbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return toTerbilang(intval($angka / 1000000000)) . " miliar " . toTerbilang($angka % 1000000000);
        } else {
            return "angka terlalu besar";
        }
    }
}

// if (!function_exists('toRupiahForm')) {
//     function toRupiah($number)
//     {
//         return number_format($number, 0, ',', '.');
//     }
// }
