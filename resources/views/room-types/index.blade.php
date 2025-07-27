<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight">
            Room Types
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">

              

                <a href="{{ route('room-types.create') }}"
                    class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded mb-2">
                    ➕ Add Room Type
                </a>
                <br>
                <a href="{{ route('room-types.view') }}"
                    class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
                    📋 View Room Types
                </a>

            </div>
          <div class="mt-6 text-left">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-black hover:bg-gray-700">
                    ← Back
                </a>
            </div>

            
    </div>
</x-app-layout>
