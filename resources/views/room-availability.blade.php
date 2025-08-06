<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Room Availability System</h1>
            <p class="text-gray-600 mt-2">Check real-time room availability and make reservations</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                <h2 class="text-xl font-semibold">Search Criteria</h2>
            </div>

            <form action="{{ route('rooms.availability') }}" method="GET" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Check-in Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Check-in Date</label>
                        <input type="date" name="date" value="{{ $date ?? '' }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <!-- Number of Days -->
                    <div>
                        <label for="days" class="block text-sm font-medium text-gray-700 mb-1">Number of Days</label>
                        <input type="number" name="days" min="1" value="{{ $days ?? 1 }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <!-- Room Type Filter -->
                    <div>
                        <label for="room_type" class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                        <select name="room_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Types</option>
                            <option value="SR" {{ $selectedRoomType == 'SR' ? 'selected' : '' }}>Standard Single (SR)</option>
                            <option value="DR" {{ $selectedRoomType == 'DR' ? 'selected' : '' }}>Standard Double (DR)</option>
                            <option value="VIPSR" {{ $selectedRoomType == 'VIPSR' ? 'selected' : '' }}>VIP Single (VIPSR)</option>
                            <option value="VIPDR" {{ $selectedRoomType == 'VIPDR' ? 'selected' : '' }}>VIP Double (VIPDR)</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg w-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Check Availability
                        </button>
                        <a href="{{ route('rooms.availability') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg w-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if($date)
            <!-- Search Results Summary -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-blue-800 mb-1">Search Results:</h3>
                        <div class="space-y-1">
                            @if($selectedRoomType)
                            <p class="text-sm text-blue-700">Room Type: {{ $selectedRoomType }}</p>
                            @endif
                            <p class="text-sm text-blue-700">Check-in: {{ $date->isoFormat('dddd, MMMM D, Y') }}</p>
                            <p class="text-sm text-blue-700">Number of Nights: {{ $days }}</p>
                            <p class="text-sm text-blue-700">Check-out: {{ $checkOutDate->isoFormat('dddd, MMMM D, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Available Rooms -->
                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold text-green-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Available Rooms ({{ $availableRooms->count() }})
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price/Night</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($availableRooms as $room)
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        {{ $room->room_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $room->roomType->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        ${{ number_format($room->roomType->cost_per_night, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            Available
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <form action="{{ route('bookings.confirm') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <input type="hidden" name="room_number" value="{{ $room->room_number }}">
                                            <input type="hidden" name="room_type" value="{{ $selectedRoomType ?? '' }}">
                                            <input type="hidden" name="check_in_date" value="{{ $date->format('Y-m-d') }}">
                                            <input type="hidden" name="check_out_date" value="{{ $checkOutDate->format('Y-m-d') }}">
                                            <input type="hidden" name="days" value="{{ $days }}">
                                            <input type="hidden" name="price_per_night" value="{{ $room->roomType->cost_per_night }}">
                                            <input type="hidden" name="total_price" value="{{ $room->roomType->cost_per_night * $days }}">

                                            <button type="submit" class="text-blue-600 hover:text-blue-900 font-medium">
                                                Book Now
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No rooms available for the selected criteria
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Booked Rooms -->
                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <div class="bg-red-50 px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Booked Rooms ({{ $bookedRooms->count() }})
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($bookedRooms as $room)
                                <tr class="hover:bg-red-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                        {{ $room->room_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $room->roomType->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                            Booked
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        @foreach($room->bookings as $booking)
                                            <div class="mb-2 last:mb-0 text-sm">
                                                <div>From: {{ $booking->check_in_date->format('M d, Y') }}</div>
                                                <div>To: {{ $booking->check_out_date->format('M d, Y') }}</div>
                                                <div>Status: {{ ucfirst($booking->status) }}</div>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No rooms are booked for the selected criteria
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <!-- Initial State - Before Search -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden text-center p-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Find available rooms</h3>
                <p class="mt-2 text-gray-500">
                    Please select your check-in date, duration, and room type to see availability
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
