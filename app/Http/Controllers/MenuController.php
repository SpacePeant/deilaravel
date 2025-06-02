<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\Category;

class MenuController extends Controller
{
     public function index(Request $request)
    {
        // Get the 'day' from the request, with a default value
        $day = $request->query('day', 'Tidak diketahui');

        // Get the 'category_id' from the request.
        // If "All Categories" is selected, the value will be empty, which resolves to falsey.
        $selectedCategoryId = $request->query('category_id');

        // Fetch all categories to populate the filter dropdown
        $categories = Category::all();

        // Start building the query for pakets using your Menu model
        $paketsQuery = Menu::query();

        // Apply filter if a specific category_id is present and not empty
        if ($selectedCategoryId) {
            $paketsQuery->where('category_id', $selectedCategoryId);
        }

        // Fetch the filtered (or unfiltered if no category selected) pakets
        $pakets = $paketsQuery->get();

        // Pass all necessary data to the view
        return view('order', compact('day', 'pakets', 'categories', 'selectedCategoryId'));
    }
}
