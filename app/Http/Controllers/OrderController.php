<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $paketId = $request->query('paket');
        $day = $request->query('day');

        $paket = Menu::findOrFail($paketId);

        return view('order.show', compact('paket', 'day')); // <--- Changed view path
    }
}
