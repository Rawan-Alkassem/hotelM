<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Booking</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            <!-- Hidden field for current user -->
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                    <select id="room_type" name="room_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Room Type</option>
                        <option value="SR">Single Room</option>
                        <option value="DR">Double Room</option>
                        <option value="VIPSR">VIP Single Room</option>
                        <option value="VIPDR">VIP Double Room</option>
                    </select>
                </div>

                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                    <select id="room_id" name="room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a room</option>
                            @foreach($rooms as $room)
    <option value="{{ $room->id }}" 
        data-type="@php
            $lastTwo = substr($room->room_number, -2);
            $lastFive = substr($room->room_number, -5);
            echo $lastFive == 'VIPSR' ? 'VIPSR' : ($lastFive == 'VIPDR' ? 'VIPDR' : ($lastTwo == 'SR' ? 'SR' : 'DR'));
        @endphp">
        {{ $room->room_number }} ({{ $room->roomType->name }})
    </option>
@endforeach
                    </select>
                </div>

                <div>
                    <label for="check_in_date" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                    <input type="date" id="check_in_date" name="check_in_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                    <input type="date" id="check_out_date" name="check_out_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Save Booking
                </button>
                <a href="{{ route('bookings.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomTypeSelect = document.getElementById('room_type');
    const roomSelect = document.getElementById('room_id');
    const roomOptions = Array.from(roomSelect.options);

    roomTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Clear current options except the first one
        roomSelect.innerHTML = '';
        roomSelect.appendChild(roomOptions[0]);
        
        if (selectedType) {
            // Filter and show only rooms of selected type
            roomOptions.forEach(option => {
                if (option.dataset.type === selectedType) {
                    roomSelect.appendChild(option);
                }
            });
        } else {
            // Show all rooms if no type selected
            roomOptions.forEach(option => {
                roomSelect.appendChild(option);
            });
        }
    });
});
</script>
</x-app-layout>