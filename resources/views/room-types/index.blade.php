<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight">
            Room Types
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-md sm:rounded-lg p-6 text-white space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('room-types.create') }}"
                       class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded transition">
                        ➕ Add Room Type
                    </a>

                    <a href="{{ route('room-types.view') }}"
                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded transition">
                        📋 View Room Types
                    </a>
                </div>

                <div class="pt-4 text-left">
                    <a href="{{ route('dashboard') }}"
                       class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded">
                        ← Back to Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
