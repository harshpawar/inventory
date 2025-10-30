<?php

namespace App\Http\Controllers;

use App\Models\Manufacture;
use App\Models\ManufactureUsage;
use App\Models\InventoryMovement;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function manufactured(Request $request)
    {
       
        $validated = $request->validate([
            'from' => ['required','date'],
            'to' => ['required','date','after_or_equal:from'],
        ]);
       
        $records = Manufacture::with('product')
            ->whereBetween(DB::raw('DATE(manufactured_at)'), [$validated['from'], $validated['to']])
            ->orderBy('manufactured_at')
            ->get();
            
        return view('reports.manufactured', compact('records'));
    }

    public function inventoryUsage(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required','date'],
            'to' => ['required','date','after_or_equal:from'],
        ]);

        $usages = ManufactureUsage::with(['manufacture.product','inventoryItem'])
            ->whereHas('manufacture', function ($q) use ($validated) {
                $q->whereBetween('manufactured_at', [$validated['from'], $validated['to']]);
            })
            ->orderBy('created_at')
            ->get();

        return view('reports.inventory_usage', compact('usages'));
    }

    public function inventoryMovements(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required','date'],
            'to' => ['required','date','after_or_equal:from'],
            'inventory_item_id' => ['nullable','exists:inventory_items,id'],
        ]);

        $query = InventoryMovement::with(['inventoryItem','reference'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$validated['from'], $validated['to']])
            ->orderBy('created_at');

        if (!empty($validated['inventory_item_id'])) {
            $query->where('inventory_item_id', $validated['inventory_item_id']);
        }

        $movements = $query->get();
        $items = InventoryItem::orderBy('name')->get();

        return view('reports.inventory_movements', compact('movements','items'));
    }
}
