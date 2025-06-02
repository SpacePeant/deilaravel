<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\Category;

class MenuController extends Controller
{
     public function index(Request $request)
    {
        $day = $request->query('day', 'Tidak diketahui');
        $selectedCategoryIdFromDropdown = $request->query('category_id'); // This is the INTEGER ID from the dropdown

        // Fetch all categories to populate the filter dropdown
        $categories = Category::all();

        // Start building the query for menu items
        $paketsQuery = Menu::query();

         if ($selectedCategoryIdFromDropdown) {
            $selectedCategory = Category::find($selectedCategoryIdFromDropdown);
            if ($selectedCategory) {
                $paketsQuery->where('category_id', $selectedCategory->nama);
            }
        }

        // Fetch the filtered (or unfiltered) menu items
        $pakets = $paketsQuery->get();

        return view('order', compact('day', 'pakets', 'categories', 'selectedCategoryIdFromDropdown'));
    }

    public function showGroupedMenu()
    {
        $categoriesWithMenus = Category::with('menus')->get();

        dd($categoriesWithMenus);
        return route('grouped', compact('categoriesWithMenus')); // <--- Ensure this matches your file
    }
}
