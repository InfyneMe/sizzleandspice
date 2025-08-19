<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel as Menu;

class MenueController extends Controller
{
   public function index(){
        // Get all menu items
        $allItems = Menu::all();
        
        // Get items by category
        $indianItems = Menu::byCategory('Indian')->get();
        $chineseItems = Menu::byCategory('Chinese')->get();
        $healthyItems = Menu::byCategory('Healthy')->get();
        
        // Get counts for stats
        $indianCount = $indianItems->count();
        $chineseCount = $chineseItems->count();
        $healthyCount = $healthyItems->count();
        $totalCount = $allItems->count();
        
        // Get status counts
        $availableCount = Menu::where('status', 'available')->count();
        $outOfStockCount = Menu::where('status', 'out_of_stock')->count();
        $lowStockCount = Menu::where('status', 'low_stock')->count();
        
        return view('home.menue', compact(
            'allItems',
            'indianItems',
            'chineseItems', 
            'healthyItems',
            'indianCount',
            'chineseCount',
            'healthyCount',
            'totalCount',
            'availableCount',
            'outOfStockCount',
            'lowStockCount'
        ));
    }

    public function create()
    {
        return view('home.create-menue');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:menu,name'],
            'category' => ['required', 'string'],
            'dietary_info' => ['nullable', 'string', 'in:veg,non_veg,vegan,gluten_free,both'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:available,out_of_stock,low_stock'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'is_popular' => ['boolean'],
            'preparation_time' => ['nullable', 'integer', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'is_available' => ['boolean'],
        ]);

        Menu::create($request->all());

        return redirect()->route('menu')->with('success', 'Menu item created successfully!');
    }
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:menu,name,' . $menu->id],
            'category' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:available,out_of_stock,low_stock'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'is_popular' => ['boolean'],
            'dietary_info' => ['nullable', 'string'],
            'preparation_time' => ['nullable', 'integer', 'min:0'],
        ]);

        $menu->update($request->all());

        return redirect()->route('menu')->with('success', 'Menu item updated successfully!');
    }


}
