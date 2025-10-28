<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-4">
                    <div><strong>Name:</strong> {{ $product->name }}</div>
                    <div><strong>Code:</strong> {{ $product->code }}</div>
                    <div><strong>Unit Cost:</strong> {{ rtrim(rtrim(number_format($product->unit_cost, 6, '.', ''), '0'), '.') }}</div>
                    <div><strong>Description:</strong> {{ $product->description }}</div>
                </div>
                <h3 class="font-semibold mb-2">Components</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b p-2">Inventory Item</th>
                            <th class="border-b p-2">SKU</th>
                            <th class="border-b p-2">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->components as $c)
                        <tr>
                            <td class="border-b p-2">{{ $c->inventoryItem->name }}</td>
                            <td class="border-b p-2">{{ $c->inventoryItem->sku }}</td>
                            <td class="border-b p-2">{{ rtrim(rtrim(number_format($c->quantity, 6, '.', ''), '0'), '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


