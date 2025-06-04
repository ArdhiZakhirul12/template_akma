<?php

if (!function_exists('toRupiah')) {
    function toRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}

// if (!function_exists('toRupiahForm')) {
//     function toRupiah($number)
//     {
//         return number_format($number, 0, ',', '.');
//     }
// }
