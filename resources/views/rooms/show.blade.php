<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray leading-tight text-left">
            Room Details Number {{ $room->room_number }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container mx-auto px-4">
            <div class="card bg-gray-800 text-white p-6 rounded-lg shadow-md" dir="ltr">

                <div class="mb-4">
                    <label class="form-label block mb-1 font-semibold text-left">Room Number:</label>
                    <div class="form-control bg-gray-200 text-gray-900 rounded px-3 py-2 text-left">{{ $room->room_number }}</div>
                </div>

                <div class="mb-4">
                    <label class="form-label block mb-1 font-semibold text-left">Room Type:</label>
                    <div class="form-control bg-gray-200 text-gray-900 rounded px-3 py-2 text-left">{{ $room->roomType->name ?? 'Not specified' }}</div>
                </div>

                <div class="mb-4">
                    <label class="form-label block mb-1 font-semibold text-left">Room Status:</label>
                    <div class="form-control bg-gray-200 text-gray-900 rounded px-3 py-2 text-left">
                        @if($room->status == 'available')
                            Available
                        @elseif($room->status == 'booked')
                            Booked
                        @elseif($room->status == 'maintenance')
                            Under Maintenance
                        @else
                            Unknown
                        @endif
                    </div>
                </div>

                <div class="flex space-x-4 mt-6 justify-start">
                    <a href="{{ route('rooms.index') }}" 
                       class="btn bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded">
                        ← Back
                    </a>

                    <a href="{{ route('rooms.edit', $room->id) }}" 
                       class="btn bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                        Edit Room
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
