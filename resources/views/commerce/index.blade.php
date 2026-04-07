<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comercios Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('commerce.index') }}" class="mb-6 flex">
                <input type="text" name="search" placeholder="Buscar comercio..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-l-md w-full" value="{{ request('search') }}">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-r-md font-medium transition-colors">Buscar</button>
            </form>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($commerces as $commerce)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="p-6 text-gray-900 flex flex-col items-start h-full">
                            <div class="w-full flex justify-between items-start mb-2">
                                <h3 class="font-bold text-xl text-gray-800">{{ $commerce->name }}</h3>
                                <div class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Abierto</div>
                            </div>
                            <p class="text-sm text-gray-500 mb-4 flex-grow">{{ $commerce->address }}</p>
                            <span class="text-xs text-gray-500 mb-6 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $commerce->opening_time ?: '08:00:00' }} - {{ $commerce->closing_time ?: '20:00:00' }}
                            </span>
                            <a href="{{ route('commerce.show', $commerce->id) }}" class="mt-auto bg-indigo-50 hover:bg-indigo-100 text-indigo-700 hover:text-indigo-800 font-semibold py-2.5 px-4 rounded-lg w-full text-center transition-colors">
                                Ver Catálogo
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 text-gray-500">
                        No se encontraron comercios.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
