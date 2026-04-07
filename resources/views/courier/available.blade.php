<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entregas Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($deliveries as $delivery)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <span class="font-bold text-lg">Paga: ${{ number_format($delivery->cost, 2) }}</span>
                        <span class="text-xs bg-indigo-100 text-indigo-800 font-semibold px-2 py-1 rounded">{{ strtoupper($delivery->method) }}</span>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-semibold text-gray-700">Recoger en:</p>
                        <p class="text-sm text-gray-600">{{ $delivery->order->commerce->name }} ({{ $delivery->order->commerce->address }})</p>
                    </div>
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-gray-700">Entregar a:</p>
                        <p class="text-sm text-gray-600">{{ $delivery->order->user->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Tiempo est: {{ $delivery->estimated_time }} min</p>
                    </div>
                    <form action="{{ route('courier.accept', $delivery->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded transition-colors text-center">
                            Aceptar Entrega
                        </button>
                    </form>
                </div>
                @empty
                <div class="col-span-2 text-center p-10 bg-white shadow-sm sm:rounded-lg text-gray-500">
                    No hay entregas disponibles en este momento.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
