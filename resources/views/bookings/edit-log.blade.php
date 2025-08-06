<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Update Check In/Out Times for Booking #{{ $booking->id }}</h1>
            <a href="{{ route('bookings.info', $booking->id) }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Booking Info
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <form action="{{ route('bookings.updateLog', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Check In Time -->
                        <div>
                            <label for="check_in_time" class="block text-sm font-medium text-gray-700">Check In Time</label>
                            <input type="datetime-local" id="check_in_time" name="check_in_time"
                                   value="{{ $booking->checkInOutLog ? \Carbon\Carbon::parse($booking->checkInOutLog->check_in_time)->format('Y-m-d\TH:i') : '' }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Check Out Time -->
                        <div>
                            <label for="check_out_time" class="block text-sm font-medium text-gray-700">Check Out Time</label>
                            <input type="datetime-local" id="check_out_time" name="check_out_time"
                                   value="{{ $booking->checkInOutLog ? \Carbon\Carbon::parse($booking->checkInOutLog->check_out_time)->format('Y-m-d\TH:i') : '' }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Update Times
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
