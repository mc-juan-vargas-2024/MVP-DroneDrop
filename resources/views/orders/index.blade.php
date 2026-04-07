<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-6">

            {{-- Tabla de pedidos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-orange-100">
                    <h3 class="font-bold text-lg mb-0 text-orange-700">📋 Historial de Pedidos</h3>
                </div>
                <div class="p-0">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-orange-50 text-orange-700 text-sm uppercase">
                                <th class="p-4 rounded-tl-lg font-semibold">ID</th>
                                <th class="p-4 font-semibold">Comercio</th>
                                <th class="p-4 font-semibold">Fecha</th>
                                <th class="p-4 font-semibold">Total</th>
                                <th class="p-4 rounded-tr-lg text-right font-semibold">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $order)
                            <tr class="hover:bg-orange-50 transition-colors">
                                <td class="p-4 text-sm text-gray-900 font-medium">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $order->commerce->name }}</td>
                                <td class="p-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-4 text-sm text-gray-900 font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="p-4 text-sm text-right">
                                    <span class="px-2.5 py-1 rounded inline-flex text-xs font-semibold
                                        {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'in_process' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ str_contains($order->status, 'cancel') ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">No tienes pedidos anteriores.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mapa de seguimiento --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-orange-100">
                    <h3 class="font-bold text-lg text-orange-700">🗺️ Seguimiento de Entrega</h3>
                    <p class="text-sm text-gray-500 mt-1">Zona de cobertura de entregas — Bucaramanga, Colombia</p>
                </div>
                <div class="w-full" style="height: 400px;">
                    <iframe
                        width="100%"
                        height="100%"
                        style="border:0;"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63537.44890823!2d-73.17263!3d7.11392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e683f43a4c1a8d7%3A0xd31d6f8e86a5b6de!2sBucaramanga%2C+Santander!5e0!3m2!1ses!2sco!4v1700000000000">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
