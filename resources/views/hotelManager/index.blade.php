<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Hotel Manager Dashboard</h1>

        <!-- أزرار التقارير -->
        <div class="flex flex-wrap gap-4 mb-8">
            <a href="{{ route('hotelManager.yearlyOccupancy') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
Annual Occupancy Report
            </a>
            <a href="{{ route('hotelManager.monthlyOccupancy') }}"
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
monthly Occupancy Report
            </a>
            {{-- <a href="{{ route('hotelManager.occupancy.by-type') }}"
               class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
               عرض الإشغال حسب النوع
            </a> --}}




            <a href="{{ route('reports.profitReport') }}"
               class="bg-red-700 hover:bg-red-900 text-white font-bold py-2 px-4 rounded">
$ Profit Reports Display
      </a>



            <a href="{{ route('reports.index') }}"
               class="bg-blue-900 hover:bg-green-1000 text-white font-bold py-2 px-4 rounded">
Service Usage Reports
            </a>


        </div>

        <!-- باقي المحتوى الأصلي -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- بطاقات الإحصائيات -->


        </div>

     <div class="mt-6 text-left">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700">
                    ← Back
                </a>
            </div>

    </div>
</x-app-layout>
