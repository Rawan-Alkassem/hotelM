<x-app-layout>
   <div class="container mx-auto px-4 py-2">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
    </div>
    <div class="container mx-auto px-4 py-8">   
        <div class="max-w-3xl mx-auto">
            <!-- Booking Confirmation Card -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 text-white">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <h2 class="text-xl font-semibold">Booking Confirmation</h2>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <!-- Booking Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Room Details -->
                        <div>
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Room Details</h3>
                            </div>
                            <div class="space-y-3 pl-7">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Room Number:</span>
                                    <span class="font-medium">{{ $bookingDetails['room_number'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Room Type:</span>
                                    <span class="font-medium">{{ $bookingDetails['room_type'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Price/Night:</span>
                                    <span class="font-medium">${{ number_format($bookingDetails['price'], 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div>
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Booking Details</h3>
                            </div>
                            <div class="space-y-3 pl-7">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-in Date:</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($bookingDetails['check_in_date'])->isoFormat('dddd, MMMM D, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-out Date:</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($bookingDetails['check_out_date'])->isoFormat('dddd, MMMM D, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Number of Nights:</span>
                                    <span class="font-medium">{{ $bookingDetails['days'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Price:</span>
                                    <span class="font-medium text-blue-600">${{ number_format($bookingDetails['total_price'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 flex flex-col sm:flex-row justify-end gap-4">
                        <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            <div class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </div>
                        </a>


                      <form action="{{ route('booking.confirm') }}" method="POST" class="w-full sm:w-auto">
    @csrf
    <input type="hidden" name="room_id" value="{{ $bookingDetails['room_id'] }}">
    <input type="hidden" name="check_in_date" value="{{ $bookingDetails['check_in_date'] }}">
    <input type="hidden" name="check_out_date" value="{{ $bookingDetails['check_out_date'] }}">
    <input type="hidden" name="total_price" value="{{ $bookingDetails['total_price'] }}">
    <input type="hidden" name="receptionist_id" value="{{ Auth::id() }}">

    <button type="submit" class="w-full px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
        <div class="flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Confirm Booking
        </div>
    </button>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
