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
                $paketsQuery->where('category_id', $selectedCategoryIdFromDropdown);
            }
        }

        // Fetch the filtered (or unfiltered) menu items
        $pakets = $paketsQuery->get();

        return view('order', compact('day', 'pakets', 'categories', 'selectedCategoryIdFromDropdown'));
    }
    
    // New method for Energi Pagi
    public function showEnergiPagi()
    {
        // Change this line to match the capitalization in your categories.nama table
        // (which is 'Energi Pagi' according to your database insert statement)
        $targetCategoryName = 'Energi Pagi';

        $category = Category::where('nama', $targetCategoryName)->with('menus')->first();

        // dd($category); // Make sure this line is commented out or removed

        $categoriesWithMenus = collect();
        if ($category) {
            $categoriesWithMenus->push($category);
        }

        return view('categories.Energi-Pagi', compact('categoriesWithMenus'));
    }


public function showMenuPage()
{
    // Load categories and their related menus
    $categoriesWithMenus = Category::with('menus')->get();

    // Return to the view (update with your actual view file name)
    return view('categories.Energi-Pagi', compact('categoriesWithMenus'));
}

}


