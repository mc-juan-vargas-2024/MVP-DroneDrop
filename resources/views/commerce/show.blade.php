<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $commerce->name }} - Catálogo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                    <a href="{{ route('orders.cart') }}" class="underline font-bold ml-2">Ver mi Carrito</a>
                </div>
            @endif

            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:1.5rem;">
                @forelse ($products as $product)
                    <div style="background:white; border-radius:12px; border:1px solid #f0f0f0; box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden; display:flex; flex-direction:column; transition: box-shadow .2s;">
                        {{-- Imagen del producto --}}
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}"
                                 alt="{{ $product->name }}"
                                 style="width:100%; height:150px; object-fit:cover; display:block; flex-shrink:0;">
                        @else
                            <div style="width:100%; height:150px; background:#fff7f0; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:2rem;height:2rem;color:#fdba74;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div style="padding:1rem; display:flex; flex-direction:column; flex:1;">
                            <h3 style="font-weight:700; font-size:.95rem; color:#1a1a1a; margin-bottom:.25rem;">{{ $product->name }}</h3>
                            <p style="font-size:.8rem; color:#6b7280; margin-bottom:.75rem; flex:1;">{{ $product->description ?? 'Sin descripción.' }}</p>
                            <p style="font-weight:700; font-size:1.25rem; color:#f97316; margin-bottom:.75rem;">${{ number_format($product->price, 2) }}</p>
                            <form action="{{ route('orders.add', $product->id) }}" method="POST">
                                @csrf
                                <div style="display:flex; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.1);">
                                    <input type="number" name="quantity" value="1" min="1"
                                           style="width:3rem; border:1px solid #d1d5db; border-right:none; text-align:center; padding:.4rem; font-size:.85rem; outline:none;">
                                    <button type="submit"
                                            style="flex:1; background:#f97316; color:white; border:none; padding:.5rem .75rem; cursor:pointer; font-weight:600; font-size:.85rem; display:flex; align-items:center; justify-content:center; gap:.3rem; transition:background .2s;"
                                            onmouseover="this.style.background='#ea6c00'" onmouseout="this.style.background='#f97316'">
                                        <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Agregar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1; text-align:center; padding:2.5rem; background:white; border-radius:12px; border:2px dashed #e5e7eb; color:#9ca3af;">
                        Este comercio aún no tiene productos disponibles.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
