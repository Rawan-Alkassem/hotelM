<x-app-layout>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Booking #{{ $booking->id }}</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Error!</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display Middleware Error Messages -->
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Error!</p>
            <p>{{ session('error') }}</p>
            @if (session('overlapping'))
                <p class="mt-2 font-semibold">Overlapping Bookings:</p>
                <ul class="list-disc list-inside">
                    @foreach (session('overlapping') as $booking)
                        <li>
                            Booking #: {{ $booking['id'] }} |
                            From: {{ $booking['check_in_date'] }} |
                            To: {{ $booking['check_out_date'] }} |
                            Status: {{ $booking['status'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hidden field for current user -->
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                    <select id="room_type" name="room_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Room Type</option>
                        <option value="SR" {{ $booking->room->room_type == 'SR' ? 'selected' : '' }}>Single Room</option>
                        <option value="DR" {{ $booking->room->room_type == 'DR' ? 'selected' : '' }}>Double Room</option>
                        <option value="VIPSR" {{ $booking->room->room_type == 'VIPSR' ? 'selected' : '' }}>VIP Single Room</option>
                        <option value="VIPDR" {{ $booking->room->room_type == 'VIPDR' ? 'selected' : '' }}>VIP Double Room</option>
                    </select>
                </div>

                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                    <select id="room_id" name="room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                data-type="{{ $room->room_type }}"
                                {{ $booking->room_id == $room->id ? 'selected' : '' }}>
                                {{ $room->room_number }} ({{ $room->roomType->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Booking Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="finished" {{ $booking->status == 'finished' ? 'selected' : '' }}>Finished</option>
                    </select>
                </div>

                <div>
                    <label for="check_in_date" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                    <input type="date" id="check_in_date" name="check_in_date"
                           value="{{ \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                  @error('check_in_date') border-red-500 @enderror">
                    @error('check_in_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                    <input type="date" id="check_out_date" name="check_out_date"
                           value="{{ \Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                  @error('check_out_date') border-red-500 @enderror">
                    @error('check_out_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Update Booking
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
    const currentRoomId = "{{ $booking->room_id }}";

    // Initialize room filtering
    filterRoomsByType();

    roomTypeSelect.addEventListener('change', filterRoomsByType);

    function filterRoomsByType() {
        const selectedType = roomTypeSelect.value;

        // Clear current options except the first one
        roomSelect.innerHTML = '';
        roomSelect.appendChild(roomOptions[0]);

        if (selectedType) {
            // Filter and show only rooms of selected type
            roomOptions.forEach(option => {
                if (option.value && option.dataset.type === selectedType) {
                    roomSelect.appendChild(option);
                }
            });
        } else {
            // Show all rooms if no type selected
            roomOptions.forEach(option => {
                roomSelect.appendChild(option);
            });
        }

        // Re-select the current room if available
        if (currentRoomId) {
            roomSelect.value = currentRoomId;
        }
    }
});
</script>
</x-app-layout>
