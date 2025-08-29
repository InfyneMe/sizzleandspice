<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel;
use App\Models\OrderedItemsModel as OrderedItem;
use App\Models\OrdersModel;

class HomeController extends Controller
{
    public function index()
    {
        $totalOrders = OrdersModel::count();
        $totalTakeaway = OrdersModel::where('order_type', 'takeaway')->count();
        $totalCancelled = OrdersModel::where('status', 'cancelled')->count();
        $totalPending = OrdersModel::where('status', 'pending')->count();

        // Dummy growth % (replace with real logic)
        $monthlyGrowth = 12.5;
        $dailyGrowth = 3.2;

        // Most ordered item aggregation example
        $mostOrdered = OrderedItem::selectRaw('item_id, SUM(quantity) as quantity')
            ->groupBy('item_id')
            ->orderByDesc('quantity')
            ->first();

        $mostOrderedItem = null;
        if ($mostOrdered) {
            $mostOrderedItem = $mostOrdered->menuItem; // Assuming relation exists
            $mostOrderedItem->quantity = $mostOrdered->quantity;
        }

        // Category totals: example assuming menuItem has 'category' column (starter, main_course, drinks, dessert)
        $categoryTotalsData = OrderedItem::join('menu', 'ordered_items.item_id', '=', 'menu.id')
            ->selectRaw('menu.category, SUM(ordered_items.quantity) AS total')
            ->groupBy('menu.category')
            ->pluck('total', 'category');

        // Prepare category totals with default zero
        $categoryTotals = [
            'starter' => $categoryTotalsData['starter'] ?? 0,
            'main_course' => $categoryTotalsData['main_course'] ?? 0,
            'drinks' => $categoryTotalsData['drinks'] ?? 0,
            'dessert' => $categoryTotalsData['dessert'] ?? 0,
        ];

        // Recent 5 orders
        $recentOrders = OrdersModel::orderByDesc('order_date')->limit(5)->get();

        return view('home.dashboard', compact(
            'totalOrders',
            'totalTakeaway',
            'totalCancelled',
            'totalPending',
            'monthlyGrowth',
            'dailyGrowth',
            'mostOrderedItem',
            'categoryTotals',
            'recentOrders'
        ));
    }

}
