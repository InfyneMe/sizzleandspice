<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel as Menu;
use App\Models\OrderedItemsModel;
use App\Models\OrdersModel;
use App\Models\TableModel as Table;
use App\Models\TableModel;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $category = $request->string('category')->toString();
        $search   = $request->string('q')->toString();

        // Base queries
        $menuQuery = Menu::query()->where('is_available', true);

        if ($category) {
            $menuQuery->where('category', $category);
        }

        if ($search) {
            $menuQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('ingredients', 'like', "%{$search}%");
            });
        }

        // Data sets
        $menu   = $menuQuery->orderBy('is_popular', 'desc')->orderBy('name')->get();
        $tables = Table::query()->where('status', 'available')->orderBy('number')->get();

        // Distinct categories for filter UI
        $categories = Menu::query()
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('order.index', compact('menu', 'tables', 'categories'));
    }

    public function store(Request $request){
        try {
            $validated = $request->validate([
                'order_type' => 'required|in:dine-in,takeaway',
                'table_id'   => 'nullable|exists:tables,id',
                'items'      => 'required|string', // will decode JSON
                'subtotal'   => 'required|numeric|min:0',
                'gst'        => 'required|numeric|min:0',
                'total'      => 'required|numeric|min:0',
                'customer_phone' => 'nullable|string|min:10|max:15',
            ]);
            $iteams = json_decode($validated['items'], true);
            if(empty($iteams)){
                return back()->with('error', 'No items in the order.');
            }

            $order = OrdersModel::create([
                'order_type'     => $validated['order_type'],
                'table_id'       => $validated['order_type'] === 'dine-in' ? $validated['table_id'] : null,
                'subtotal'       => $validated['subtotal'],
                'gst'            => $validated['gst'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'status'         => 'pending',
                'order_date'     => now(),
                'notes'          => null,
                'payment_mode'   => 'cash',
                'payment_status' => 'pending',
                'transaction_id' => null,
                'payment_date'   => null
            ]);

            if(!$order){
                return back()->with('error', 'Failed to create order. Please try again.');
            }

            $orderedItemsPayload = [];
            foreach($iteams as $item){
                $menuItem = Menu::find($item['menu_item_id']);
                if(!$menuItem){
                    return back()->with('error', 'Invalid menu item in the order.');
                }
                if($item['quantity'] <= 0){
                    return back()->with('error', 'Invalid quantity for menu item: ' . $menuItem->name);
                }
                $orderedItemsPayload[] = [
                    'order_id'   => $order->id,
                    'item_id'    => (int) $item['menu_item_id'],
                    'quantity'   => (int) ($item['quantity'] ?? 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if(empty($orderedItemsPayload)){
                return back()->with('error', 'No valid items to add to the order.');
            }

            OrderedItemsModel::insert($orderedItemsPayload);
            if($validated['order_type'] === 'dine-in' && $validated['table_id']){
                Table::where('id', $validated['table_id'])->update(['status' => 'occupied']);
            }

            return back()->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function currentOrders(){
        $orders = OrdersModel::with(['table'])
            ->whereIn('status', ['pending', 'preparing', 'served'])
            ->orderBy('order_date', 'desc')
            ->get();
        $orderedItems = OrderedItemsModel::with(['menuItem'])->whereIn('order_id', $orders->pluck('id'))->get()->groupBy('order_id');
        return view('order.current_orders', compact('orders', 'orderedItems'));
    }

    public function orderDetails($id){
        $order = OrdersModel::with(['table'])->find($id);
        if(!$order){
            return back()->with('error', 'Order not found.');
        }
        $orderedItems = OrderedItemsModel::with(['menuItem'])->where('order_id', $order->id)->get();
        $menu = Menu::where('is_available', true)->orderBy('is_popular', 'desc')->get();
        return view('order.order_details', compact('order', 'orderedItems', 'menu'));
    }

    public function updateItems(Request $request, $orderId)
    {
        $order = OrdersModel::findOrFail($orderId);

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.menu_item_id' => 'required|exists:menu,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Delete existing order items first
        $order->items()->delete();

        // Re-insert all updated items
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $menu = Menu::find($item['menu_item_id']);
            $lineTotal = $menu->price * $item['quantity'];
            $subtotal += $lineTotal;

            $order->items()->create([
                'item_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
            ]);
        }

        $gst = $subtotal * 0.05;
        $total = $subtotal + $gst;

        $order->update([
            'subtotal' => $subtotal,
            'gst' => $gst,
            'total' => $total,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order items updated successfully',
            'order' => $order->fresh('items'),
        ]);
    }

    public function updatePayment(Request $request, $id){
        try {
            if(!$id){
                return redirect()->back()->with('error', 'Id not found please try again');
            }
            $orders = OrdersModel::where('id', $id)->first();
            if(!$orders){
                return redirect()->back()->with('error', 'No orders found from this ID to Update.');
            }
            $field = ['transaction_id', 'status', 'payment_mode'];
            $data = $request->only($field);

            if($request->input('status') !==null && ($request->input('status') === 'completed' || $request->input('status') === 'cancelled')){
                if($orders->order_type !== 'takeaway'){
                    if(!$orders->table_id){
                        return redirect()->back()->with('error', 'Table not found form this order.Please contact support');
                    }
                    Table::where('id', $orders->table_id)->update(['status' => 'available']);
                }
            }
            if(!empty($data)){
                $orders->update($data);
            }
            return redirect()->back()->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function orderHistory(Request $request){
        try {
            $query = OrdersModel::query();

            // 🔍 Search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('customer_phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
                });
            }

            // 📅 Date range filter
            if ($request->filled('date_range')) {
                $dates = explode(' to ', $request->date_range);

                if (count($dates) === 2) {
                    $from = $dates[0] . " 00:00:00";
                    $to   = $dates[1] . " 23:59:59";
                    $query->whereBetween('order_date', [$from, $to]);
                }
            }


            // 📊 Get results (paginate)
            $orders = $query->latest()->paginate(10);

            return view('order.history', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
