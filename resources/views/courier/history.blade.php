<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Entregas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('status'))
                    <div class="mb-6 bg-green-50 text-green-800 border border-green-200 p-4 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm">
                            <th class="p-4 rounded-tl-lg font-semibold">Comercio</th>
                            <th class="p-4 font-semibold">Cliente</th>
                            <th class="p-4 font-semibold">Costo</th>
                            <th class="p-4 rounded-tr-lg font-semibold text-right">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($deliveries as $delivery)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 border-b border-gray-100 text-sm">{{ $delivery->order->commerce->name }}</td>
                            <td class="p-4 border-b border-gray-100 text-sm">{{ $delivery->order->user->name }}</td>
                            <td class="p-4 border-b border-gray-100 text-sm font-bold text-indigo-600">${{ number_format($delivery->cost, 2) }}</td>
                            <td class="p-4 border-b border-gray-100 text-right">
                                <span class="px-2 py-1 rounded bg-{{ $delivery->status === 'delivered' ? 'green' : 'indigo' }}-100 text-{{ $delivery->status === 'delivered' ? 'green' : 'indigo' }}-800 text-xs font-semibold">
                                    {{ strtoupper($delivery->status) }}
                                </span>
                                @if($delivery->status !== 'delivered')
                                    <form action="{{ route('courier.complete', $delivery->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="text-xs w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-2 rounded">
                                            Completar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">Aún no tienes entregas en tu historial.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
