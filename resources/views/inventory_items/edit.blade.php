<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Inventory Item</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('inventory-items.update', $inventoryItem) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm">Name</label>
                        <input name="name" value="{{ old('name', $inventoryItem->name) }}" class="mt-1 w-full border rounded p-2">
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <label class="block text-sm">SKU</label>
                        <input name="sku" value="{{ old('sku', $inventoryItem->sku) }}" class="mt-1 w-full border rounded p-2">
                        <x-input-error :messages="$errors->get('sku')" />
                    </div>
                    <div>
                        <label class="block text-sm">Unit</label>
                        <input name="unit" value="{{ old('unit', $inventoryItem->unit) }}" class="mt-1 w-full border rounded p-2">
                        <x-input-error :messages="$errors->get('unit')" />
                    </div>
                    <div>
                        <label class="block text-sm">Description</label>
                        <textarea name="description" class="mt-1 w-full border rounded p-2">{{ old('description', $inventoryItem->description) }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('inventory-items.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


