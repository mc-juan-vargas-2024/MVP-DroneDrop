<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Commerce Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome back, Commerce Owner!") }}
                    <div class="mt-4">
                        <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded">Manage Profile</a>
                        <a href="#" class="px-4 py-2 bg-green-600 text-white rounded ml-2">Manage Products</a>
                        <a href="#" class="px-4 py-2 bg-yellow-600 text-white rounded ml-2">View Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
