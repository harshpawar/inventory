<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventory Item</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 space-y-2">
                <div><strong>Name:</strong> {{ $inventoryItem->name }}</div>
                <div><strong>SKU:</strong> {{ $inventoryItem->sku }}</div>
                <div><strong>Unit:</strong> {{ $inventoryItem->unit }}</div>
                <div><strong>Stock:</strong> {{ rtrim(rtrim(number_format($inventoryItem->stock, 6, '.', ''), '0'), '.') }}</div>
                <div><strong>Description:</strong> {{ $inventoryItem->description }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


