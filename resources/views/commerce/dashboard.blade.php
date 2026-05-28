<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Commerce Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-yellow-100 border border-yellow-300 text-yellow-800 text-sm">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            @if(session('status'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-300 text-green-800 text-sm">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome back, Commerce Owner!") }}
                    <div class="mt-4">
                        <a href="{{ route('commerce.profile.edit') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Manage Profile</a>
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-green-600 text-white rounded ml-2">Manage Products</a>
                        <a href="{{ route('commerce.orders') }}" class="px-4 py-2 bg-yellow-600 text-white rounded ml-2">View Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
