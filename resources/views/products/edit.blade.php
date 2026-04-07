<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 inline-block w-full relative">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4 text-right absolute top-6 right-6">
                        <label for="is_available" class="inline-flex items-center cursor-pointer">
                            <input id="is_available" type="checkbox" class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500" name="is_available" {{ $product->is_available ? 'checked' : '' }}>
                            <span class="ms-2 text-sm font-semibold text-gray-700">{{ __('Disponible') }}</span>
                        </label>
                    </div>

                    <div class="mb-4 mt-8">
                        <x-input-label for="name" :value="__('Nombre del Producto')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Descripción')" />
                        <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" rows="3">{{ old('description', $product->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Precio ($)')" />
                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full md:w-1/3" :value="old('price', $product->price)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Imagen del Producto')" />
                        @if($product->image_path)
                            <div class="mt-2 mb-3">
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagen actual"
                                    class="h-32 w-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Imagen actual. Sube otra para reemplazarla.</p>
                            </div>
                        @endif
                        <input id="image" name="image" type="file" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer" />
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, WEBP — máx. 2MB</p>
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-4 border-t border-gray-100">
                        <x-primary-button>{{ __('Guardar Cambios') }}</x-primary-button>
                        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
