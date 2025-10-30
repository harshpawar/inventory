<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Manufacture;
use App\Models\ManufactureUsage;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManufactureController extends Controller
{
    public function index()
    {
        $records = Manufacture::with('product')->latest()->paginate(15);
        return view('manufactures.index', compact('records'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('manufactures.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'quantity' => ['required','numeric','gt:0'],
            'manufactured_at' => ['nullable','date'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::with('components')->findOrFail($validated['product_id']);

            $requiredByItemId = [];
            foreach ($product->components as $component) {
                $requiredQty = $component->quantity * $validated['quantity'];
                $requiredByItemId[$component->inventory_item_id] = ($requiredByItemId[$component->inventory_item_id] ?? 0) + $requiredQty;
            }

            if (empty($requiredByItemId)) {
                abort(422, 'Product has no components defined');
            }

            $items = InventoryItem::whereIn('id', array_keys($requiredByItemId))
                ->lockForUpdate()->get()->keyBy('id');

            foreach ($requiredByItemId as $itemId => $need) {
                
                $item = $items[$itemId] ?? null;
                if (!$item) {
                    abort(422, 'Component inventory item missing');
                }
                if ($item->stock < $need) {
                    abort(422, "Insufficient stock for item {$item->sku}");
                }
            }

            $manufacture = Manufacture::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'quantity' => $validated['quantity'],
                'manufactured_at' => $validated['manufactured_at'] ?? now(),
            ]);

            foreach ($requiredByItemId as $itemId => $need) {
                $item = $items[$itemId];
                $item->update(['stock' => $item->stock - $need]);
                ManufactureUsage::create([
                    'manufacture_id' => $manufacture->id,
                    'inventory_item_id' => $itemId,
                    'quantity' => $need,
                ]);
                InventoryMovement::create([
                    'inventory_item_id' => $itemId,
                    'change' => -1 * (float) $need,
                    'reason' => 'manufacture',
                    'reference_type' => Manufacture::class,
                    'reference_id' => $manufacture->id,
                ]);
            }
        });

        return redirect()->route('manufactures.index')->with('status','Manufactured successfully and inventory deducted');
    }
}
