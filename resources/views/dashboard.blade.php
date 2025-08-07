 {{-- <x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="container mt-4">
                        <a href="{{ route('rooms.index') }}" class="btn btn-primary" style="display: block; margin-bottom: 10px;">
                            🛏️Manage Rooms
                        </a>
                        <a href="{{ route('room-types.index') }}" class="btn btn-secondary" style="display: block; margin-bottom: 10px;">
                            🏷️ Manage Room Types
                        </a>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary" style="display: block; margin-bottom: 10px;">
                            🏷️ Manage Room Services
                        </a>
                    </div>

                    <div style="color: red "> {{ Auth::user()->getRoleNames()->first() }}


                    </div>
                </div>

                    {{ __("You're logged in!") }}
                   <div style="color: green " > {{ Auth::user()->getRoleNames()->first() }}

                </div> --}}
{{--
                @if(Auth::user()->getRoleNames()->first() == "Admin")
 <div style="color: blue " >  <a href="{{ route('employeesmanagement.index') }}" >
employees management                        </a>   </div>
                @endif --}}
{{--
                @role('Admin')
    <div style="color: blue">
        <a href="{{ route('employeesmanagement.index') }}">Employees Management</a>
    </div>
@endrole

                  <div style="color: red " >  <a href="{{ route('bookings.index') }}" >
                           Bookings Management
                        </a>   </div>

                          <div style="color: blue " >  <a href="{{ route('hotelManager.index') }}" >
                           hotel management
                        </a>   </div>
                        </div>

            </div>
        </div>
    </div>
</x-app-layout> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="space-y-4 max-w-md mx-auto">
   {{-- Role display --}}
                    <div class="text-center text-gray-700 dark:text-gray-300 font-medium mt-4">
                        Role: <span class="text-white-600 dark:text-white-400">{{ Auth::user()->getRoleNames()->first() }}</span>
                    </div>

@role('Admin')
                    {{-- Buttons for management --}}
                    <a href="{{ route('rooms.index') }}"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded transition">
                        🛏️ Manage Rooms
                    </a>
@endrole

@role('Admin')
                    <a href="{{ route('room-types.index') }}"
                        class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded transition">
                        🏷️ Manage Room Types
                    </a>
@endrole

@role('Admin')
                    <a href="{{ route('services.index') }}"
                        class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded transition">
                        🏷️ Manage Room Services
                    </a>
   @endrole


                    {{-- Conditional links for roles --}}
                    @role('Admin')
                        <a href="{{ route('employeesmanagement.index') }}"
                           class="block w-full text-center bg-blue-800 hover:bg-blue-900 text-white font-semibold py-3 rounded transition mt-6">
                            Employees Management
                        </a>
                    @endrole
@hasanyrole('Admin|Receptionist')
                    <a href="{{ route('bookings.index') }}"
                       class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded transition mt-4">
                        Bookings Management
                    </a>
@endhasanyrole


@hasanyrole('Admin|Receptionist|Hotel Manager')
<a href="{{ route('hotelManager.index') }}"
                       class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded transition mt-4">
                        Hotel Reports
                    </a>

                    @endhasanyrole

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
