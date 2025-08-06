<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
  <div class="text-sm">
                        <p class="text-red-500 font-semibold">
                            Role: {{ Auth::user()->getRoleNames()->first() }}
                        </p>

                        <p class="text-green-500 font-semibold mt-1">
                            {{ __("You're logged in!") }}
                        </p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('rooms.index') }}"
                           class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded text-center transition">
                            🛏️ Manage Rooms
                        </a>

                        <a href="{{ route('room-types.index') }}"
                           class="block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded text-center transition">
                            🏷️ Manage Room Types
                        </a>

                        <a href="{{ route('services.index') }}"
                           class="block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded text-center transition">
                            🛎️ Manage Room Services
                        </a>
                    </div>

                  

                    @role('Admin')
                        <a href="{{ route('employeesmanagement.index') }}"
                           class="block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-4 rounded text-center transition">
                            👥 Employees Management
                        </a>
                    @endrole

                    <a href="{{ route('bookings.index') }}"
                       class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded text-center transition">
                        📅 Bookings Management
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
