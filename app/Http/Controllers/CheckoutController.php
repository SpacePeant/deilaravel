<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
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
            $grouped[$anak][$hari] = [];
        }

        // Decode options JSON jadi array
        $options = json_decode($item->options, true);

        $grouped[$anak][$hari][] = [
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
            'cart_id' =>$item->cart_id
        ];
    }

    $totalHarga = DB::table('cart as c')
        ->leftJoin('menu as m', 'm.id', '=', 'c.menu_id')
        ->select(DB::raw('SUM(c.quantity * m.harga) as total'))
        ->value('total');  // langsung ambil nilai totalnya

    return view('checkout', [
        'groupedCart' => $grouped,
        'totalHarga' => $totalHarga ?? 0,  // jika null, pakai 0
    ]);
}
public function checkoutAll()
{
    // Ambil semua data cart
    $cartItems = DB::table('cart')->get();

    if ($cartItems->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Cart kosong']);
    }

    // Hitung total harga semua cart (quantity * harga menu)
    $totalHarga = DB::table('cart as c')
        ->join('menu as m', 'm.id', '=', 'c.menu_id')
        ->sum(DB::raw('c.quantity * m.harga'));

    // Insert ke tabel od (order) dan dapatkan od_id
    $od_id = DB::table('od')->insertGetId([
        'total' => $totalHarga,
    ]);

    // Masukkan semua cart ke orders
    foreach ($cartItems as $item) {
        DB::table('orders')->insert([
            'child_id' => $item->child_id,
            'day_of_week' => $item->day_of_week,
            'menu_id' => $item->menu_id,
            'options' => $item->options,
            'quantity' => $item->quantity,
            'note' => $item->note,
            'alamat' => $item->alamat,
            'kalori' => $item->kalori,
            'jam' => $item->jam ?? now(),
            'od_id' => $od_id,
        ]);
    }

    // Kosongkan tabel cart seluruhnya
    DB::table('cart')->delete();

    return response()->json(['success' => true, 'message' => 'Checkout berhasil', 'order_id' => $od_id]);
}
}
