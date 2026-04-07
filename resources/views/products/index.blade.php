<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Catálogo (Comercio)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-6">
            <div class="flex justify-end">
                <a href="{{ route('products.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded shadow-sm transition-colors">
                    + Nuevo Producto
                </a>
            </div>

            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-orange-50 text-orange-700 text-sm border-b border-orange-100">
                            <th class="p-4">Imagen</th>
                            <th class="p-4">Nombre</th>
                            <th class="p-4">Precio</th>
                            <th class="p-4 text-center">Disponible</th>
                            <th class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="h-14 w-14 object-cover rounded-lg border border-gray-200">
                                @else
                                    <div class="h-14 w-14 rounded-lg bg-orange-50 flex items-center justify-center text-orange-300 border border-orange-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="p-4 text-gray-700">${{ number_format($product->price, 2) }}</td>
                            <td class="p-4 text-center">
                                @if($product->is_available)
                                    <span class="text-green-600 font-bold text-lg">✓</span>
                                @else
                                    <span class="text-red-500 font-bold text-lg">✗</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-orange-600 hover:text-orange-900 text-sm font-semibold">Editar</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">No has agregado ningún producto todavía.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
