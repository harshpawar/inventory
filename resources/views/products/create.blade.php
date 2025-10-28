<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Product</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('products.store') }}" class="space-y-4" id="product-form">
                    @csrf
                    <div>
                        <label class="block text-sm">Name</label>
                        <input name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded p-2">
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <label class="block text-sm">Code</label>
                        <input name="code" value="{{ old('code') }}" class="mt-1 w-full border rounded p-2">
                        <x-input-error :messages="$errors->get('code')" />
                    </div>
                    <div>
                        <label class="block text-sm">Unit Cost</label>
                        <input type="number" step="0.000001" name="unit_cost" value="{{ old('unit_cost', 0) }}" class="mt-1 w-full border rounded p-2">
                        <x-input-error :messages="$errors->get('unit_cost')" />
                    </div>
                    <div>
                        <label class="block text-sm">Description</label>
                        <textarea name="description" class="mt-1 w-full border rounded p-2">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold">Components</h3>
                            <button type="button" onclick="addRow()" class="px-2 py-1 bg-gray-800 text-white rounded">Add Component</button>
                        </div>
                        <table class="w-full text-left border-collapse mt-2" id="components-table">
                            <thead>
                                <tr>
                                    <th class="border-b p-2">Inventory Item</th>
                                    <th class="border-b p-2">Quantity per Product</th>
                                    <th class="border-b p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <x-input-error :messages="$errors->get('components')" />
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="component-row">
        <tr>
            <td class="border-b p-2">
                <select class="border rounded p-2 w-full" name="components[INDEX][inventory_item_id]">
                    <option value="">Select item</option>
                    @foreach ($inventory as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sku }})</option>
                    @endforeach
                </select>
            </td>
            <td class="border-b p-2">
                <input type="number" step="0.000001" class="border rounded p-2 w-full" name="components[INDEX][quantity]" placeholder="0">
            </td>
            <td class="border-b p-2">
                <button type="button" onclick="this.closest('tr').remove()" class="text-red-600">Remove</button>
            </td>
        </tr>
    </template>

    <script>
        let idx = 0;
        function addRow() {
            const tpl = document.getElementById('component-row').content.cloneNode(true);
            tpl.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace('INDEX', idx);
            });
            document.querySelector('#components-table tbody').appendChild(tpl);
            idx++;
        }
    </script>
</x-app-layout>


