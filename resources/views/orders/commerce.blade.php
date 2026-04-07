<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedidos Recibidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-100">
                    <h3 class="font-bold text-lg">Pedidos Entrantes</h3>
                </div>
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm">
                            <th class="p-4">Pedido ID</th>
                            <th class="p-4">Cliente</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Estado</th>
                            <th class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                        <tr>
                            <td class="p-4">#{{ $order->id }}</td>
                            <td class="p-4">{{ $order->user->name }}</td>
                            <td class="p-4">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">{{ strtoupper($order->status) }}</span>
                            </td>
                            <td class="p-4 text-right">
                                <form action="{{ route('commerce.orders.status', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="in_process">
                                    <button type="submit" class="text-xs bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700">Aceptar Pedido</button>
                                </form>
                                <form action="{{ route('commerce.orders.status', $order->id) }}" method="POST" class="inline ml-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit" class="text-xs bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Listo</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">No hay pedidos nuevos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
