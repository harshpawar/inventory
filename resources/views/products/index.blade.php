<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Products
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">New Product</a>
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
                                <th class="border-b p-2">Code</th>
                                <th class="border-b p-2">Components</th>
                                <th class="border-b p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="border-b p-2">{{ $product->name }}</td>
                                    <td class="border-b p-2">{{ $product->code }}</td>
                                    <td class="border-b p-2">{{ $product->components_count }}</td>
                                    <td class="border-b p-2 space-x-2">
                                        <a class="text-indigo-600" href="{{ route('products.edit', $product) }}">Edit</a>
                                        <a class="text-gray-600" href="{{ route('products.show', $product) }}">View</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $products->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


