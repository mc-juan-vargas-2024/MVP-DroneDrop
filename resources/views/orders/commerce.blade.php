<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedidos Recibidos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl flex items-center gap-2 font-semibold">
                    ✅ {{ session('status') }}
                </div>
            @endif

            @forelse($orders as $order)
            <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">

                {{-- Cabecera del pedido --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div>
                        <span class="text-xs text-gray-400 font-medium">Pedido</span>
                        <p class="font-bold text-lg text-gray-800">#{{ $order->id }}</p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-400 font-medium">Cliente</span>
                        <p class="font-semibold text-gray-700">👤 {{ $order->user->name }}</p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-400 font-medium">Dirección entrega</span>
                        <p class="font-semibold text-gray-700">📍 {{ $order->delivery_address ?? $order->address ?? 'No especificada' }}</p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-400 font-medium">Dirección comercio</span>
                        <p class="font-semibold text-gray-700">🏪 {{ $order->commerce->address ?? auth()->user()->address ?? 'No especificada' }}</p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-400 font-medium">Total</span>
                        <p class="font-bold text-orange-500 text-lg">${{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        @php
                            $statusMap = [
                                'confirmed'  => ['label' => 'Nuevo',      'color' => 'bg-blue-100 text-blue-800'],
                                'in_process' => ['label' => 'En proceso', 'color' => 'bg-orange-100 text-orange-800'],
                                'ready'      => ['label' => 'Listo',      'color' => 'bg-green-100 text-green-800'],
                                'delivered'  => ['label' => 'Entregado',  'color' => 'bg-gray-100 text-gray-600'],
                            ];
                            $s = $statusMap[$order->status] ?? ['label' => strtoupper($order->status), 'color' => 'bg-gray-100 text-gray-600'];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $s['color'] }}">
                            {{ $s['label'] }}
                        </span>
                    </div>
                </div>

                {{-- Productos del pedido --}}
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">🛒 Productos</p>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">{{ $item->quantity }}</span>
                                <span class="text-gray-700 font-medium">{{ $item->product->name }}</span>
                            </div>
                            <span class="text-gray-500">${{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Acciones --}}
                @if($order->status === 'confirmed')
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    <form action="{{ route('commerce.orders.status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="in_process">
                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-2.5 rounded-xl transition-colors shadow-md flex items-center gap-2">
                            ✅ Aceptar Pedido
                        </button>
                    </form>
                </div>
                @elseif($order->status === 'in_process')
                <div class="px-6 py-4 border-t border-orange-100 bg-orange-50 flex justify-end">
                    <form action="{{ route('commerce.orders.status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="ready">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-2.5 rounded-xl transition-colors shadow-md flex items-center gap-2">
                            🍽️ Marcar como Listo
                        </button>
                    </form>
                </div>
                @elseif($order->status === 'ready')
                <div class="px-6 py-4 border-t border-green-100 bg-green-50 flex justify-end">
                    <span class="text-green-600 font-semibold text-sm">✅ Listo — esperando repartidor...</span>
                </div>
                @elseif($order->status === 'delivered')
                <div class="px-6 py-4 border-t border-green-100 bg-green-50 flex justify-end">
                    <span class="text-green-600 font-semibold text-sm">✅ Entregado</span>
                </div>
                @endif

            </div>
            @empty
            <div class="bg-white shadow-sm rounded-2xl p-12 text-center">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-gray-500 font-medium">No hay pedidos nuevos por el momento.</p>
            </div>
            @endforelse

        </div>
    </div>
</x-app-layout>