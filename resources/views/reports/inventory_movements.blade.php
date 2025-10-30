<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventory Movements Report</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-6 gap-3">
                    <div>
                        <label class="block text-sm">From</label>
                        <input type="date" name="from" value="{{ request('from', now()->toDateString()) }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm">To</label>
                        <input type="date" name="to" value="{{ request('to', now()->toDateString()) }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm">Inventory Item</label>
                        <select name="inventory_item_id" class="mt-1 w-full border rounded p-2">
                            <option value="">All items</option>
                            @foreach ($items as $it)
                                <option value="{{ $it->id }}" @selected(request('inventory_item_id') == $it->id)>{{ $it->name }} ({{ $it->sku }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
                    </div>
                </form>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b p-2">Date</th>
                            <th class="border-b p-2">Inventory Item</th>
                            <th class="border-b p-2">SKU</th>
                            <th class="border-b p-2">Change</th>
                            <th class="border-b p-2">Reason</th>
                            <th class="border-b p-2">Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movements as $m)
                        <tr>
                            <td class="border-b p-2">{{ $m->created_at->toDateTimeString() }}</td>
                            <td class="border-b p-2">{{ $m->inventoryItem->name }}</td>
                            <td class="border-b p-2">{{ $m->inventoryItem->sku }}</td>
                            <td class="border-b p-2 {{ $m->change < 0 ? 'text-red-600' : 'text-green-700' }}">{{ rtrim(rtrim(number_format($m->change, 6, '.', ''), '0'), '.') }}</td>
                            <td class="border-b p-2 capitalize">{{ str_replace('_',' ', $m->reason) }}</td>
                            <td class="border-b p-2">
                                @if ($m->reason === 'manufacture' && $m->reference)
                                    Manufacture #{{ $m->reference_id }}
                                @elseif ($m->reason === 'adjustment')
                                    Manual Adjustment
                                @elseif ($m->reason === 'initial')
                                    Initial Stock
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>



