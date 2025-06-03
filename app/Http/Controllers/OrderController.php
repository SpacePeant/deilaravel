<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
{
    $categories = DB::select('SELECT * FROM category');
    $menus = Menu::with('category', 'customizations')->get();

    // Misal kamu mau ambil semua data anak juga
    $anak = DB::select('SELECT * FROM anak');

    $menus->each(function($menu) {
        $menu->category_id = (string) $menu->category_id;

        $menu->customizations_grouped = $menu->customizations
            ->groupBy('opsi_kategori')
            ->map(function($items){
                return $items->pluck('opsi_nama')->unique()->values();
            });
    });

    // Kirim semua data ke view
    return view('get_cart', compact('menus', 'categories', 'anak'));
}


public function add(Request $request)
{
    $menuId = $request->input('menu_id');
    $quantity = $request->input('quantity', 1);
    $note = $request->input('note');
    $deliveryAddress = $request->input('delivery_address');
    $deliveryTime = $request->input('delivery_time');

    // Ambil dan normalisasi customizations dari input
    $customizations = [];
    foreach ($request->all() as $key => $value) {
        if (Str::startsWith($key, 'custom_')) {
            $kategori = Str::replaceFirst('custom_', '', $key);
            $kategoriFormatted = Str::title(Str::slug($kategori, ' '));
            $customizations[$kategoriFormatted] = $value;
        }
    }

    // Hitung kalori total
    $menuKalori = DB::table('menu')->where('id', $menuId)->value('kalori');
    $totalKalori = (int) $menuKalori;

    foreach ($customizations as $kategori => $opsiNama) {
        $opsiKalori = DB::table('customizations')
            ->where('menu_id', $menuId)
            ->where('opsi_kategori', $kategori)
            ->where('opsi_nama', $opsiNama)
            ->value('kalori');

        $totalKalori += (int) $opsiKalori;
    }

    // Loop semua anak dan hari untuk insert
    foreach ($request->input('anak_ids', []) as $anakId) {
        foreach ($request->input('delivery_days', []) as $hariIndo) {
            $hariLower = strtolower($hariIndo);

            // Gunakan helper getNextWeekdayDate($hariLower, $deliveryTime)
            $tanggalPengantaran = getNextWeekdayDate($hariLower, $deliveryTime);

            DB::table('cart')->insert([
                'child_id'    => $anakId,
                'day_of_week' => $hariLower,
                'menu_id'     => $menuId,
                'options'     => json_encode($customizations),
                'quantity'    => $quantity,
                'note'        => $note,
                'alamat'      => $deliveryAddress,
                'jam'         => $tanggalPengantaran,
                'kalori'      => $totalKalori, // ⬅️ masukkan hasil perhitungan di sini
            ]);
        }
    }

    return redirect()->back()->with('success', 'Pesanan berhasil dimasukkan untuk minggu depan!');
}

public function showMenu(Request $request)
{
    // Ambil kategori menu
    $categories = DB::table('category')->get();

    // Ambil data menu beserta customizations (misal disimpan dalam JSON)
    $menus = DB::table('menu')->get();
    $custom = DB::table('customizations')->get();

    return view('get_cart', [
        'categories' => $categories,
        'menus' => $menus,
        'custom' => $custom,
    ]);
}
}
