<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Historial de Entregas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl flex items-center gap-2 font-semibold">
                    {{ session('status') }}
                </div>
            @endif

            @forelse($deliveries as $delivery)
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="flex flex-wrap items-center justify-between px-6 py-4 gap-4">

                    {{-- Info principal --}}
                    <div class="flex-1 min-w-48">
                        <p class="text-xs text-gray-400 font-medium mb-1">🏪 Comercio</p>
                        <p class="font-semibold text-gray-800">{{ $delivery->order->commerce->name }}</p>
                    </div>
                    <div class="flex-1 min-w-48">
                        <p class="text-xs text-gray-400 font-medium mb-1">👤 Cliente</p>
                        <p class="font-semibold text-gray-800">{{ $delivery->order->user->name }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 font-medium mb-1">💵 Costo</p>
                        <p class="font-bold text-orange-500 text-lg">${{ number_format($delivery->cost, 0, ',', '.') }}</p>
                    </div>

                    {{-- Estado / Acción --}}
                    <div class="flex flex-col items-end gap-2 min-w-44">
                        @if($delivery->status === 'delivered')
                            <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-bold">
                                ✅ Entregado
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase">
                                {{ $delivery->status }}
                            </span>
                            <button
                                type="button"
                                onclick="abrirConfirmacion({{ $delivery->id }}, '{{ addslashes($delivery->order->user->name) }}', '{{ addslashes($delivery->order->commerce->name) }}')"
                                class="w-full bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white font-bold px-4 py-2.5 rounded-xl transition-all shadow-md text-sm flex items-center justify-center gap-2">
                                📦 Marcar como entregado
                            </button>
                        @endif
                    </div>

                </div>
            </div>
            @empty
            <div class="bg-white shadow-sm rounded-2xl p-12 text-center">
                <div class="text-5xl mb-4">📋</div>
                <p class="text-gray-500 font-medium">Aún no tienes entregas en tu historial.</p>
            </div>
            @endforelse

        </div>
    </div>

    {{-- ── MODAL DE CONFIRMACIÓN ── --}}
    <div id="modal-confirmacion" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 border border-orange-100">
            <div class="text-center mb-6">
                <div class="text-5xl mb-3">📦</div>
                <h3 class="text-xl font-bold text-gray-800">¿Confirmar entrega?</h3>
                <p class="text-gray-500 text-sm mt-1">Esta acción no se puede deshacer.</p>
            </div>

            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6 space-y-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-orange-600 w-20">🏪 Comercio:</span>
                    <span id="modal-comercio" class="text-gray-700 font-medium"></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-orange-600 w-20">👤 Cliente:</span>
                    <span id="modal-cliente" class="text-gray-700 font-medium"></span>
                </div>
            </div>

            <form id="form-completar" method="POST">
                @csrf
                <div class="flex gap-3">
                    <button type="button" onclick="cerrarModal()"
                        class="flex-1 py-2.5 px-4 rounded-xl border-2 border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 px-4 rounded-xl bg-green-600 hover:bg-green-700 text-white font-bold transition-colors shadow-md">
                        ✅ Sí, confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirConfirmacion(deliveryId, cliente, comercio) {
            document.getElementById('modal-cliente').textContent = cliente;
            document.getElementById('modal-comercio').textContent = comercio;
            document.getElementById('form-completar').action = '/courier/deliveries/' + deliveryId + '/complete';
            document.getElementById('modal-confirmacion').classList.remove('hidden');
        }
        function cerrarModal() {
            document.getElementById('modal-confirmacion').classList.add('hidden');
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });
        document.getElementById('modal-confirmacion').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</x-app-layout>
