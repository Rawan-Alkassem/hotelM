<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Annual Occupancy Report</h1>

        <!-- Filter Year and Room Type -->
        <form method="GET" action="{{ route('hotelManager.yearlyOccupancy') }}" class="mb-6 bg-white p-4 rounded-lg shadow">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                    <select name="year" id="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="room_type_id" class="block text-sm font-medium text-gray-700">Room Type</label>
                    <select name="room_type_id" id="room_type_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">All Types</option>
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

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500">Number of Rooms</h3>
                <p class="text-2xl font-bold">{{ $summary['total_rooms'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500">Booking Rate</h3>
                <p class="text-2xl font-bold">{{ $summary['occupancy_rate'] }}%</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500">Available Rooms Rate</h3>
                <p class="text-2xl font-bold">{{ $summary['availability_rate'] }}%</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500">Total Bookings</h3>
                <p class="text-2xl font-bold">{{ $summary['total_bookings'] }}</p>
            </div>
        </div>

        <!-- Show Details for Selected Room Type Only -->
        @if($selectedRoomTypeId)
            @foreach($report as $typeName => $typeData)
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Details of {{ $typeName }}</h2>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Rooms</p>
                            <p class="text-lg font-bold">{{ $typeData['summary']['total_rooms'] }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Bookings</p>
                            <p class="text-lg font-bold">{{ $typeData['summary']['total_bookings'] }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Occupancy</p>
                            <p class="text-lg font-bold">
                                @php
                                    $typeOccupancyRate = $typeData['summary']['total_rooms'] > 0
                                        ? round(($typeData['summary']['total_occupied_days'] / ($typeData['summary']['total_rooms'] * 365)) * 100, 2)
                                        : 0;
                                @endphp
                                {{ $typeOccupancyRate }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Rate</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Available Rooms Rate</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Number of Bookings</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Booked Days</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Available Days</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($typeData['data'] as $monthData)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $monthData['month_name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $monthData['occupancy_rate'] }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        {{ $monthData['availability_rate'] }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $monthData['total_bookings'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $monthData['total_occupied_days'] }} days
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $monthData['available_room_days'] }} days
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('occupancyChart').getContext('2d');
            const reportData = @json($report);

            // Prepare chart data
            const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const datasets = [];
            const colors = [
                { bg: 'rgba(54, 162, 235, 0.7)', border: 'rgba(54, 162, 235, 1)' },
                { bg: 'rgba(255, 99, 132, 0.7)', border: 'rgba(255, 99, 132, 1)' },
                { bg: 'rgba(75, 192, 192, 0.7)', border: 'rgba(75, 192, 192, 1)' },
                { bg: 'rgba(153, 102, 255, 0.7)', border: 'rgba(153, 102, 255, 1)' }
            ];

            let colorIndex = 0;
            for (const [typeName, typeData] of Object.entries(reportData)) {
                const rates = [];
                for (let month = 1; month <= 12; month++) {
                    rates.push(typeData.data[month].occupancy_rate);
                }

                datasets.push({
                    label: `Occupancy Rate - ${typeName}`,
                    data: rates,
                    backgroundColor: colors[colorIndex].bg,
                    borderColor: colors[colorIndex].border,
                    borderWidth: 1
                });

                colorIndex = (colorIndex + 1) % colors.length;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Percentage'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Months of the Year'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label.split(' - ')[0] + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
