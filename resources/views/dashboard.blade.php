 <x-app-layout>


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

                </div>
{{--
                @if(Auth::user()->getRoleNames()->first() == "Admin")
 <div style="color: blue " >  <a href="{{ route('employeesmanagement.index') }}" >
employees management                        </a>   </div>
                @endif --}}

                @role('Admin')
    <div style="color: blue">
        <a href="{{ route('employeesmanagement.index') }}">Employees Management</a>
    </div>
@endrole

                  <div style="color: red " >  <a href="{{ route('bookings.index') }}" >
                           Bookings Management
                        </a>   </div>
                        </div>

            </div>
        </div>
    </div>
</x-app-layout>