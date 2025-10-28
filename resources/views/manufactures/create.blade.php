<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Manufacture</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('manufactures.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm">Product</label>
                        <select name="product_id" class="mt-1 w-full border rounded p-2">
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->code }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_id')" />
                    </div>
                    <div>
                        <label class="block text-sm">Quantity</label>
                        <input type="number" step="0.000001" name="quantity" value="{{ old('quantity', 1) }}" class="mt-1 w-full border rounded p-2">
                        <x-input-error :messages="$errors->get('quantity')" />
                    </div>
                    <div>
                        <label class="block text-sm">Manufactured At</label>
                        <input type="datetime-local" name="manufactured_at" value="{{ old('manufactured_at') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('manufactures.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


