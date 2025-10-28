<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manufacturing</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <a href="{{ route('manufactures.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">New Manufacture</a>
            </div>
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            <div class="bg-white shadow sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b p-2">Date</th>
                            <th class="border-b p-2">Product</th>
                            <th class="border-b p-2">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $r)
                        <tr>
                            <td class="border-b p-2">{{ $r->manufactured_at }}</td>
                            <td class="border-b p-2">{{ $r->product->name }}</td>
                            <td class="border-b p-2">{{ rtrim(rtrim(number_format($r->quantity, 6, '.', ''), '0'), '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $records->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


