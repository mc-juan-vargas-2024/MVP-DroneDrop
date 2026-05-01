<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Carrito') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 bg-green-50 text-green-800 p-4 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="bg-white p-10 shadow-sm sm:rounded-xl text-center border border-gray-100">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tu carrito está vacío</h3>
                    <p class="mt-1 text-sm text-gray-500">Empieza a explorar nuestros comercios para agregar productos.</p>
                    <div class="mt-6">
                        <a href="{{ route('commerce.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Explorar Restaurantes y Tiendas
                        </a>
                    </div>
                </div>
            @else
                @foreach($orders as $order)
                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 mb-8 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-800">Pedido a {{ $order->commerce->name }}</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Pendiente</span>
                    </div>
                    
                    <div class="p-6">
                        <table class="w-full text-left mb-6">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                                    <th class="pb-3 font-semibold">Producto</th>
                                    <th class="pb-3 font-semibold text-center w-24">Cant.</th>
                                    <th class="pb-3 font-semibold text-right w-32">Precio</th>
                                    <th class="pb-3 font-semibold text-right w-32">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="py-4 text-sm text-gray-900 font-medium">{{ $item->product->name }}</td>
                                    <td class="py-4 text-sm text-gray-500 text-center">{{ $item->quantity }}</td>
                                    <td class="py-4 text-sm text-gray-500 text-right">${{ number_format($item->price, 2) }}</td>
                                    <td class="py-4 text-sm text-gray-900 text-right font-semibold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="bg-indigo-50/50 rounded-lg p-5 mb-6 border border-indigo-100/50 flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Subtotal de Productos:</span>
                            <span class="text-2xl font-bold text-indigo-700">${{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        <form action="{{ route('orders.checkout', $order->id) }}" method="POST">
                            @csrf
                            <h4 class="text-md font-bold text-gray-800 mb-4">Detalles de Envío y Pago</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <x-input-label for="method" :value="__('Método de Entrega (Estimado)')" class="mb-1" />
                                    <select name="method" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="motocicleta">Motocicleta - $20 (Aprox 30 mins)</option>
                                        <option value="bicicleta">Bicicleta - $10 (Aprox 45 mins)</option>
                                        <option value="dron">Dron Express - $50 (Aprox 15 mins)</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">El costo se sumará a tu pedido.</p>
                                </div>
                                <div>
                                    <x-input-label for="payment_method" :value="__('Método de Pago')" class="mb-1" />
                                    <select name="payment_method" id="payment_method"
                                        onchange="togglePayuNote(this.value)"
                                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="contra_entrega">💵 Pago Contra Entrega</option>
                                        <option value="tarjeta_credito">💳 Tarjeta de Crédito (PayU)</option>
                                        <option value="tarjeta_debito">🏦 PSE / Débito (PayU)</option>
                                    </select>
                                    <p id="payu-note" class="text-xs text-orange-600 mt-1 hidden font-semibold">
                                        🔒 Serás redirigido al portal seguro de PayU para pagar.
                                    </p>
                                </div>
                            </div>
                            
                            <input type="hidden" name="delivery_cost" value="20" id="cost_input">
                            
                            <div class="flex justify-end pt-4 border-t border-gray-100">
                                <x-primary-button class="px-8 py-3 text-base">
                                    {{ __('Confirmar y Pagar Pedido') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        function togglePayuNote(val) {
            const note = document.getElementById('payu-note');
            note.classList.toggle('hidden', val === 'contra_entrega');
        }
    </script>

</x-app-layout>
