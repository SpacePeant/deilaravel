<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
public function index()
{
    $cartItems = DB::table('cart as c')
        ->leftJoin('anak as a', 'a.id', '=', 'c.child_id')
        ->leftJoin('menu as m', 'm.id', '=', 'c.menu_id')
        ->select(
            'c.cart_id',
            'a.id as anak_id',
            'a.nama as anak_nama',
            'a.tanggal_lahir',
            'a.tinggi_cm',
            'a.berat_kg',
            'a.gender',
            'c.day_of_week',
            'm.id as menu_id',
            'm.nama as menu_nama',
            'c.options',
            'c.quantity',
            'c.note',
            'c.alamat',
            'c.kalori',
            'c.jam',
            'm.harga',
            'm.gambar'
        )
        ->orderBy('a.nama')
        ->orderBy('c.day_of_week')
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
            'cart_id' => $item->cart_id
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

    $totalHarga = DB::table('cart as c')
        ->leftJoin('menu as m', 'm.id', '=', 'c.menu_id')
        ->select(DB::raw('SUM(c.quantity * m.harga) as total'))
        ->value('total');

    return view('keranjang', [
        'groupedCart' => $grouped,
        'totalHarga' => $totalHarga ?? 0
    ]);
}
public function updateQuantity(Request $request)
{
    // Ambil request
    $cartId = $request->cart_id;
    $delta = (int) $request->delta;

    // Ambil data cart dulu
    $cart = DB::table('cart')->where('cart_id', $cartId)->first();
    if (!$cart) {
        return response()->json(['success' => false, 'message' => 'Cart item not found']);
    }

    $newQuantity = $cart->quantity + $delta;

    if ($newQuantity > 0) {
        DB::table('cart')->where('cart_id', $cartId)->update(['quantity' => $newQuantity]);
    } else {
        DB::table('cart')->where('cart_id', $cartId)->delete();
        $newQuantity = 0;
    }

    // Hitung total harga
    $totalHarga = DB::table('cart as c')
        ->leftJoin('menu as m', 'm.id', '=', 'c.menu_id')
        ->select(DB::raw('SUM(c.quantity * m.harga) as total'))
        ->value('total') ?? 0;

    $anakId = $cart->child_id;
    $hari = $cart->day_of_week;

    // Hitung kalori total
    $kaloriTotal = DB::table('cart as c')
        ->leftJoin('menu as m', 'm.id', '=', 'c.menu_id')
        ->where('c.child_id', $anakId)
        ->where('c.day_of_week', $hari)
        ->select(DB::raw('SUM(c.quantity * m.kalori) as kalori_total'))
        ->value('kalori_total') ?? 0;

    // Ambil data anak dari tabel children
    $anakData = DB::table('anak')->where('id', $anakId)->first();
    $nama = $anakData->nama;
    $kaloriIdeal = 0;
    if ($anakData) {
        $umur = Carbon::parse($anakData->tanggal_lahir)->age;
        $tinggi = (float) $anakData->tinggi_cm;
        $berat = (float) $anakData->berat_kg;
        $gender = $anakData->gender;

        if ($gender == 'P') {
            $kaloriIdeal = ($tinggi * 3.10) + (($berat * 9.25) + 447.6) - ($umur * 4.33);
        } else {
            $kaloriIdeal = ($tinggi * 4.8) + (($berat * 13.4) + 88.4) - ($umur * 5.68);
        }

        $kaloriIdeal = round($kaloriIdeal);
    }

    return response()->json([
        'success' => true,
        'quantity' => $newQuantity,
        'totalHarga' => $totalHarga,
        'kaloriTotal' => $kaloriTotal,
        'kaloriIdeal' => $kaloriIdeal,
        'anakId' => $nama,
        'hari' => $hari,
    ]);
}

}
