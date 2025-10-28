<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventory Usage Report</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-sm">From</label>
                        <input type="date" name="from" value="{{ request('from', now()->toDateString()) }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm">To</label>
                        <input type="date" name="to" value="{{ request('to', now()->toDateString()) }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div class="flex items-end">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
                    </div>
                </form>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b p-2">Date</th>
                            <th class="border-b p-2">Product</th>
                            <th class="border-b p-2">Inventory Item</th>
                            <th class="border-b p-2">SKU</th>
                            <th class="border-b p-2">Quantity Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usages as $u)
                        <tr>
                            <td class="border-b p-2">{{ $u->manufacture->manufactured_at->toDateTimeString() }}</td>
                            <td class="border-b p-2">{{ $u->manufacture->product->name }}</td>
                            <td class="border-b p-2">{{ $u->inventoryItem->name }}</td>
                            <td class="border-b p-2">{{ $u->inventoryItem->sku }}</td>
                            <td class="border-b p-2">{{ rtrim(rtrim(number_format($u->quantity, 6, '.', ''), '0'), '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


