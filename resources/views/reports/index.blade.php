<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Profit and Services Report</h2>
            {{-- <a href="{{ route('reports.profitReport') }}"
                class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-lg shadow-md hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 text-sm">
                View Profits
            </a> --}}
        </div>
    </x-slot>

    <div class="p-6 max-w-6xl mx-auto">
        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Revenue</h3>
            <p class="text-2xl font-bold text-green-600">{{ number_format($totalRevenue, 2) }} USD</p>
        </div>

        <!-- Most Requested Services -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Most used Services</h3>
            <ul class="space-y-2">
                @foreach($popularServices as $service)
                    <li class="flex justify-between items-center bg-gray-100 rounded-lg px-4 py-2">
                        <span class="text-gray-700 font-medium">{{ $service->name }}</span>
                        <span class="text-sm text-gray-500">{{ $service->usage_count }} Uses</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
