<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-100" >
            Monthly Occupancy Report {{ $monthName }} {{ $year }}
            @if($selectedRoomTypeId)
                ({{ $roomType->name }})
            @endif
        </h1>

        <!-- فلترة الشهر والسنة ونوع الغرفة -->
        <form method="GET" action="{{ route('hotelManager.monthlyOccupancy') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-100">month</label>
                    <select name="month" id="month" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        @foreach($months as $key => $name)
                            <option value="{{ $key }}" {{ $key == $month ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-100">year</label>
                    <select name="year" id="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="room_type_id" class="block text-sm font-medium text-gray-100"> room type</label>
                    <select name="room_type_id" id="room_type_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">All Types </option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ $type->id == $selectedRoomTypeId ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
View Report
                    </button>
                </div>
            </div>
        </form>

        <!-- بطاقات النسب -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500">

Number of Rooms


                </h3>
                <p class="text-2xl font-bold">{{ $totalRooms }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500"> Booking Percentage</h3>
                <p class="text-2xl font-bold">{{ $occupancyRate }}%</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500">  Available Rooms Percentage
</h3>
                <p class="text-2xl font-bold">{{ $availabilityRate }}%</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500"> Total Bookings </h3>
                <p class="text-2xl font-bold">{{ $totalBookings }}</p>
            </div>
        </div>

        <!-- جدول الإشغال اليومي -->
     <div class="bg-white p-6 rounded-lg shadow mb-8">
    <h2 class="text-xl font-semibold mb-4">Daily Occupancy </h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                      <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Occupied Rooms</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Available Rooms</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($dailyOccupancy as $day => $data)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $day }} {{ $monthName }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $data['occupied'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $data['available'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $dailyRate = $totalRooms > 0 ? ($data['occupied'] / $totalRooms) * 100 : 0;
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $dailyRate >= 80 ? 'bg-red-100 text-red-800' :
                               ($dailyRate >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ round($dailyRate) }}%
                        </span>
                    </td>
                </tr>
                @endforeach

                <!-- صف المجموع -->
                <tr class="bg-gray-100 font-bold">
                    <td class="px-6 py-4 whitespace-nowrap">total</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $totalOccupiedSum }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $totalAvailableSum }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $totalDays = count($dailyOccupancy);
                            $avgDailyRate = $totalDays > 0 ? ($totalOccupiedSum / ($totalDays * $totalRooms)) * 100 : 0;
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Average: {{ round($avgDailyRate) }}%
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    </div>
</x-app-layout>
