<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Anak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnakController extends Controller
{
    public function index()
    {
        $children = Anak::all();
        return view('anak', compact('children'));
    }

    public function pilih()
{
    $children = Anak::all();
    return view('pilihanak', compact('children'));
}
    
    public function add()
    {
        return view('add');
    }

    public function show($id)
    {
        $child = DB::table('anak')->where('id', $id)->first(); // ✅ this returns an object

        if (!$child) {
            abort(404, 'Data anak tidak ditemukan');
        }

        $umur = Carbon::parse($child->tanggal_lahir)->age;

        if ($child->gender === 'P') {
            $kalori = ($child->tinggi_cm * 3.10) + (($child->berat_kg * 9.25) + 447.6) - ($umur * 4.33);
        } else {
            $kalori = ($child->tinggi_cm * 4.8) + (($child->berat_kg * 13.4) + 88.4) - ($umur * 5.68);
        }

        $protein = $child->berat_kg * 1;
        $imgSrc = $child->gender === 'L' ? asset('images/cowok.png') : asset('images/cewek.png');

        return view('child', compact('child', 'umur', 'kalori', 'protein', 'imgSrc'));
    }


    public function destroy($id)
    {
        DB::table('anak')->where('id', $id)->delete();

        return redirect()->route('anak')->with('success', 'Data anak berhasil dihapus.');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',
            'tinggi' => 'required|numeric|min:0',
            'berat' => 'required|numeric|min:0',
            'alergi' => 'nullable|string|max:255',
        ]);

        Anak::create([
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'gender' => $validated['gender'],
            'tinggi_cm' => $validated['tinggi'],
            'berat_kg' => $validated['berat'],
            'alergi' => $validated['alergi'],
        ]);

        return redirect()->route('anak')->with('success', 'Data anak berhasil ditambahkan.');
    }
}
