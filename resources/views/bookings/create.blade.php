<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Booking</h1>


    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">error!</p>
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
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            <div>
        <label for="customer_search" class="block text-sm font-medium text-gray-700">Customer</label>
        <div class="mt-1 relative">
            <input type="text" id="customer_search" name="customer_search"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="Search by full name">
            <div id="customer_results" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md hidden"></div>
        </div>
        <select id="user_id" name="user_id" class="mt-2 hidden block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">Select a customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" data-fullname="{{ $customer->full_name }}">
                    {{ $customer->full_name }} ({{ $customer->email }})
                </option>
            @endforeach
        </select>
        @error('user_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
            <!-- Hidden field for current user -->
            <input type="hidden" name="receptionist_id" value="{{ Auth::user()->id }}">

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
                 @error('check_in_date')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
                </div>

                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                    <input type="date" id="check_out_date" name="check_out_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('check_out_date')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
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
    const customerSearch = document.getElementById('customer_search');
    const customerResults = document.getElementById('customer_results');
    const userIdSelect = document.getElementById('user_id');

    customerSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        if (searchTerm.length < 2) {
            customerResults.classList.add('hidden');
            return;
        }

        const options = Array.from(userIdSelect.options);
        const filtered = options.filter(option =>
            option.textContent.toLowerCase().includes(searchTerm)
        );

        if (filtered.length > 0) {
            customerResults.innerHTML = '';
            filtered.forEach(option => {
                if (option.value) {
                    const div = document.createElement('div');
                    div.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                    div.textContent = option.textContent;
                    div.onclick = () => {
                        customerSearch.value = option.dataset.fullname;
                        userIdSelect.value = option.value;
                        customerResults.classList.add('hidden');
                    };
                    customerResults.appendChild(div);
                }
            });
            customerResults.classList.remove('hidden');
        } else {
            customerResults.classList.add('hidden');
        }
    });

    // إخفاء النتائج عند النقر خارجها
    document.addEventListener('click', function(e) {
        if (!customerResults.contains(e.target) && e.target !== customerSearch) {
            customerResults.classList.add('hidden');
        }
    });
});
</script>
</x-app-layout>
