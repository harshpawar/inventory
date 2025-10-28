<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = InventoryItem::orderBy('name')->paginate(15);
        return view('inventory_items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory_items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'sku' => ['required','string','max:255','unique:inventory_items,sku'],
            'unit' => ['required','string','max:50'],
            'stock' => ['nullable','numeric','min:0'],
            'description' => ['nullable','string'],
        ]);

        InventoryItem::create($validated);
        return redirect()->route('inventory-items.index')->with('status','Inventory item created');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        return view('inventory_items.show', compact('inventoryItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        return view('inventory_items.edit', compact('inventoryItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'sku' => ['required','string','max:255','unique:inventory_items,sku,'.$inventoryItem->id],
            'unit' => ['required','string','max:50'],
            'description' => ['nullable','string'],
        ]);
        $inventoryItem->update($validated);
        return redirect()->route('inventory-items.index')->with('status','Inventory item updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();
        return redirect()->route('inventory-items.index')->with('status','Inventory item deleted');
    }

    public function adjust(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'delta' => ['required','numeric'],
        ]);
        DB::transaction(function () use ($inventoryItem, $validated) {
            $inventoryItem->lockForUpdate();
            $new = $inventoryItem->stock + $validated['delta'];
            if ($new < 0) {
                abort(422, 'Insufficient stock');
            }
            $inventoryItem->update(['stock' => $new]);
        });
        return back()->with('status','Stock adjusted');
    }
}
