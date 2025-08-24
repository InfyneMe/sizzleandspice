<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TableModel;

class TableController extends Controller
{
    public function index(Request $request)
    {
       $q = TableModel::query();

        if ($request->filled('number')) {
            $q->where('number', (int) $request->number);
        }
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('capacity')) {
            $q->where('capacity', (int) $request->capacity);
        }

        $tables = $q->orderBy('number')->paginate(12);

        // Optional aggregated stats
        $total = TableModel::count();
        $active = TableModel::where('status', 'active')->count();
        $inactive = TableModel::where('status', 'inactive')->count();

        return view('table.index', compact('tables', 'total', 'active', 'inactive'));
    }

    public function tableCreate()
    {
        return view('table.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => ['required','integer','min:1','unique:tables,number'],
            'status' => ['required','in:active,inactive'],
            'capacity' => ['required','integer','in:2,3,4,5,6'],
            'qr_link' => ['nullable','url','max:2048'],
            'notes' => ['nullable','string','max:255'],
        ]);

        TableModel::create($validated);

        return redirect()->route('table')->with('success', 'Table created successfully.');
    }
}
