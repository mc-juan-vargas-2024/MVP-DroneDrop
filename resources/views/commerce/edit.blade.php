<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil de Comercio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('commerce.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nombre del Comercio')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $commerce->name)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Dirección')" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $commerce->address)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="opening_time" :value="__('Hora de Apertura')" />
                            <x-text-input id="opening_time" name="opening_time" type="time" class="mt-1 block w-full" :value="old('opening_time', $commerce->opening_time ? \Carbon\Carbon::parse($commerce->opening_time)->format('H:i') : '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('opening_time')" />
                        </div>
                        <div>
                            <x-input-label for="closing_time" :value="__('Hora de Cierre')" />
                            <x-text-input id="closing_time" name="closing_time" type="time" class="mt-1 block w-full" :value="old('closing_time', $commerce->closing_time ? \Carbon\Carbon::parse($commerce->closing_time)->format('H:i') : '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('closing_time')" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button>{{ __('Guardar Cambios') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
