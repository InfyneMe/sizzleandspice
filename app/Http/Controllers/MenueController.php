<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel as Menu;

class MenueController extends Controller
{
    public function index(){
        // Get all menu items
        $allItems = Menu::all();

        // Items by category
        $indianItems = Menu::byCategory('Indian')->get();
        $chineseItems = Menu::byCategory('Chinese')->get();
        $healthyItems = Menu::byCategory('Healthy')->get();

        // Counts for stats
        $indianCount = $indianItems->count();
        $chineseCount = $chineseItems->count();
        $healthyCount = $healthyItems->count();
        $totalCount = $allItems->count();

        // Status counts
        $availableCount = Menu::where('status', 'available')->count();
        $outOfStockCount = Menu::where('status', 'out_of_stock')->count();
        $lowStockCount = Menu::where('status', 'low_stock')->count();

        // Optional: counts by course_type (for future widgets or filters)
        $starterCount = Menu::where('course_type', 'starter')->count();
        $mainCourseCount = Menu::where('course_type', 'main_course')->count();
        $dessertCount = Menu::where('course_type', 'dessert')->count();
        $drinkCount = Menu::where('course_type', 'drink')->count();

        // Optional: counts by quantity
        $halfCount = Menu::where('quantity', 'half')->count();
        $fullCount = Menu::where('quantity', 'full')->count();

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
            'lowStockCount',
            'starterCount',
            'mainCourseCount',
            'dessertCount',
            'drinkCount',
            'halfCount',
            'fullCount'
        ));
    }

    public function create()
    {
        return view('home.create-menue');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:Indian,Chinese,Healthy'],
            'dietary_info' => ['nullable', 'string', 'in:veg,non_veg,vegan,gluten_free,both'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:available,out_of_stock,low_stock'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'is_popular' => ['nullable', 'boolean'],
            'preparation_time' => ['nullable', 'integer', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'is_available' => ['nullable', 'boolean'],
            'quantity' => ['required', 'in:half,full'],
            'course_type' => ['required', 'in:starter,main_course,dessert,drink'],
        ]);

        if (!empty($validated['discount_price']) && $validated['discount_price'] >= $validated['price']) {
            return back()
                ->withErrors(['discount_price' => 'Discount price must be less than the regular price.'])
                ->withInput();
        }

        $validated['is_popular'] = (bool) $request->boolean('is_popular');
        $validated['is_available'] = $request->has('is_available')
            ? (bool) $request->boolean('is_available')
            : true;

        if ($request->id) {
            // ✅ UPDATE
            $menu = Menu::findOrFail($request->id);
            $menu->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'],
                'price' => $validated['price'],
                'image' => $menu->image, // keep old image for now
                'status' => $validated['status'],
                'is_popular' => $validated['is_popular'],
                'rating' => $validated['rating'],
                'ingredients' => $menu->ingredients ?? [], // keep old or update later
                'dietary_info' => $validated['dietary_info'] ?? null,
                'preparation_time' => $validated['preparation_time'] ?? null,
                'is_available' => $validated['is_available'],
                'discount_price' => $validated['discount_price'] ?? null,
                'quantity' => $validated['quantity'],
                'course_type' => $validated['course_type'],
            ]);

            return redirect()->route('menu')->with('success', 'Menu item updated successfully!');
        } else {
            // ✅ CREATE
            Menu::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'],
                'price' => $validated['price'],
                'image' => null, // will handle file upload later
                'status' => $validated['status'],
                'is_popular' => $validated['is_popular'],
                'rating' => $validated['rating'],
                'ingredients' => [], // empty for now
                'dietary_info' => $validated['dietary_info'] ?? null,
                'preparation_time' => $validated['preparation_time'] ?? null,
                'is_available' => $validated['is_available'],
                'discount_price' => $validated['discount_price'] ?? null,
                'quantity' => $validated['quantity'],
                'course_type' => $validated['course_type'],
            ]);

            return redirect()->route('menu')->with('success', 'Menu item created successfully!');
        }

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
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('home.create-menue', compact('menu'));
    }
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu')->with('success', 'Menu item deleted successfully!');
    }


}
