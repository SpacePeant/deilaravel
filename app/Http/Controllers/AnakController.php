<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;

class AnakController extends Controller
{
    public function index()
    {
        $children = Child::all(); // Retrieves all children from the database
        return view('anak', ['children' => $children]);
    }
}
