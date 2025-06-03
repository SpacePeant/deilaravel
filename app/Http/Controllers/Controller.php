<?php

namespace App\Http\Controllers;

abstract class Controller
{
//     <?php

// use Carbon\Carbon;

// if (!function_exists('getNextWeekdayDate')) {
//     function getNextWeekdayDate(string $hari, string $jam): Carbon
//     {
//         $hariList = [
//             'senin'  => 1,
//             'selasa' => 2,
//             'rabu'   => 3,
//             'kamis'  => 4,
//             'jumat'  => 5,
//         ];

//         $targetDay = $hariList[strtolower($hari)] ?? 1;
//         $now = new DateTime();
//         $today = (int)$now->format('N'); // 1 = Senin

//         $diff = ($targetDay - $today + 7); // Selalu ke minggu depan
//         $now->modify("+$diff days");

//         return Carbon::parse($now->format('Y-m-d') . ' ' . $jam);
//     }
// }

}
