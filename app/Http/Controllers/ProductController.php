<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComponent;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::withCount('components')->orderBy('name')->paginate(15);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventory = InventoryItem::orderBy('name')->get();
        return view('products.create', compact('inventory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:255','unique:products,code'],
            'description' => ['nullable','string'],
            'unit_cost' => ['nullable','numeric','min:0'],
            'components' => ['array'],
            'components.*.inventory_item_id' => ['required','exists:inventory_items,id'],
            'components.*.quantity' => ['required','numeric','gt:0'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::create($validated);
            if (!empty($validated['components'])) {
                foreach ($validated['components'] as $component) {
                    ProductComponent::create([
                        'product_id' => $product->id,
                        'inventory_item_id' => $component['inventory_item_id'],
                        'quantity' => $component['quantity'],
                    ]);
                }
            }
        });
        return redirect()->route('products.index')->with('status','Product created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('components.inventoryItem');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('components');
        $inventory = InventoryItem::orderBy('name')->get();
        return view('products.edit', compact('product','inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:255','unique:products,code,'.$product->id],
            'description' => ['nullable','string'],
            'unit_cost' => ['nullable','numeric','min:0'],
            'components' => ['array'],
            'components.*.inventory_item_id' => ['required','exists:inventory_items,id'],
            'components.*.quantity' => ['required','numeric','gt:0'],
        ]);

        DB::transaction(function () use ($product, $validated) {
            $product->update($validated);
            $product->components()->delete();
            if (!empty($validated['components'])) {
                foreach ($validated['components'] as $component) {
                    ProductComponent::create([
                        'product_id' => $product->id,
                        'inventory_item_id' => $component['inventory_item_id'],
                        'quantity' => $component['quantity'],
                    ]);
                }
            }
        });
        return redirect()->route('products.index')->with('status','Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('status','Product deleted');
    }
}
