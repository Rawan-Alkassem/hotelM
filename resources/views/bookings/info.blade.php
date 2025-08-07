<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Booking Information #{{ $booking->id }}</h1>
            <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Bookings
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Customer Information -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Customer Details</h3>
                        <div class="space-y-3">
                            <p><span class="font-medium">Name:</span> {{ $booking->user->full_name }}</p>
                            <p><span class="font-medium">Email:</span> {{ $booking->user->email }}</p>
                            <p><span class="font-medium">Phone:</span> {{ $booking->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Booking Information -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Booking Details</h3>
                        <div class="space-y-3">
                            <p><span class="font-medium">Room:</span> {{ $booking->room->room_number }} ({{ $booking->room->roomType->name }})</p>
                            <p><span class="font-medium">Status:</span>
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                                    @elseif($booking->status == 'finished') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                            <p><span class="font-medium">Dates:</span>
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d') }}
                                to
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d') }}
                            </p>
                            <p><span class="font-medium">Total Price:</span> ${{ number_format($booking->total_price, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Check In/Out Logs -->
<div class="border border-gray-200 rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Check In/Out Logs</h3>
        <a href="{{ route('bookings.editLog', $booking->id) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm">
            Update Times
        </a>
    </div>

    @if($booking->checkInOutLog)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receptionist</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $booking->checkInOutLog->receptionist->full_name ?? 'System' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($booking->checkInOutLog->check_in_time)
                                {{ \Carbon\Carbon::parse($booking->checkInOutLog->check_in_time)->format('Y-m-d H:i') }}
                            @else
                                <span class="text-gray-400">Not checked in</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($booking->checkInOutLog->check_out_time)
                                {{ \Carbon\Carbon::parse($booking->checkInOutLog->check_out_time)->format('Y-m-d H:i') }}
                            @else
                                <span class="text-gray-400">Not checked out</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No check in/out log available for this booking.</p>
    @endif
</div>
            </div>
        </div>
    </div>
</x-app-layout>
