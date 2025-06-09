<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function index()
{
    $cartItems = DB::table('orders as o')
        ->leftJoin('anak as a', 'a.id', '=', 'o.child_id')
        ->leftJoin('menu as m', 'm.id', '=', 'o.menu_id')
        ->select(
            'o.order_id',
            'a.id as anak_id',
            'a.nama as anak_nama',
            'a.tanggal_lahir',
            'a.tinggi_cm',
            'a.berat_kg',
            'a.gender',
            'o.day_of_week',
            'm.id as menu_id',
            'm.nama as menu_nama',
            'o.options',
            'o.quantity',
            'o.note',
            'o.alamat',
            'o.kalori',
            'o.jam',
            'm.harga',
            'm.gambar'
        )
        ->orderBy('a.nama')
        ->orderBy('o.day_of_week')
        ->orderBy('m.nama')
        ->get();

    $grouped = [];

    foreach ($cartItems as $item) {
        $anak = $item->anak_nama;
        $hari = $item->day_of_week;

        if (!isset($grouped[$anak])) {
            $grouped[$anak] = [];
        }

        if (!isset($grouped[$anak][$hari])) {
            $grouped[$anak][$hari] = [
                'menus' => [],
                'kalori_total' => 0,
                'kalori_ideal' => 0
            ];
        }

        $options = json_decode($item->options, true);

        // Masukkan data menu ke array 'menus'
        $grouped[$anak][$hari]['menus'][] = [
            'menu_id' => $item->menu_id,
            'menu_nama' => $item->menu_nama,
            'options' => $options,
            'quantity' => $item->quantity,
            'note' => $item->note,
            'alamat' => $item->alamat,
            'kalori' => $item->kalori,
            'jam' => $item->jam,
            'harga' => $item->harga,
            'gambar' => $item->gambar,
            'order_id' => $item->order_id
        ];

        // Tambahkan kalori ke total harian
        $grouped[$anak][$hari]['kalori_total'] = ($grouped[$anak][$hari]['kalori_total'] ?? 0) + ((int)$item->kalori * (int)$item->quantity);

        // Hitung kalori ideal hanya sekali per anak
        if ($grouped[$anak][$hari]['kalori_ideal'] == 0) {
            $umur = \Carbon\Carbon::parse($item->tanggal_lahir)->age;
            $tinggi = (float)$item->tinggi_cm;
            $berat = (float)$item->berat_kg;
            $gender = $item->gender;

            if ($gender == 'P') {
                $kaloriIdeal = ($tinggi * 3.10) + (($berat * 9.25) + 447.6) - ($umur * 4.33);
            } else {
                $kaloriIdeal = ($tinggi * 4.8) + (($berat * 13.4) + 88.4) - ($umur * 5.68);
            }

            $grouped[$anak][$hari]['kalori_ideal'] = round($kaloriIdeal);
        }
    }

    

    return view('details', [
        'groupedCart' => $grouped
    ]);
}
}
