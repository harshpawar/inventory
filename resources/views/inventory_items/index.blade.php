<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inventory Items
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <a href="{{ route('inventory-items.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">New Item</a>
            </div>

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b p-2">Name</th>
                                <th class="border-b p-2">SKU</th>
                                <th class="border-b p-2">Unit</th>
                                <th class="border-b p-2">Stock</th>
                                <th class="border-b p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="border-b p-2">{{ $item->name }}</td>
                                    <td class="border-b p-2">{{ $item->sku }}</td>
                                    <td class="border-b p-2">{{ $item->unit }}</td>
                                    <td class="border-b p-2">{{ rtrim(rtrim(number_format($item->stock, 6, '.', ''), '0'), '.') }}</td>
                                    <td class="border-b p-2 space-x-2">
                                        <a class="text-indigo-600" href="{{ route('inventory-items.edit', $item) }}">Edit</a>
                                        <form action="{{ route('inventory-items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600">Delete</button>
                                        </form>
                                        <form action="{{ route('inventory-items.adjust', $item) }}" method="POST" class="inline-flex items-center space-x-1">
                                            @csrf
                                            <input type="number" step="0.000001" name="delta" class="border rounded p-1 w-28" placeholder="± Quantity">
                                            <button class="px-2 py-1 bg-gray-800 text-white rounded">Adjust</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


