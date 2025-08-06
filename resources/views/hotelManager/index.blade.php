<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">لوحة تحكم مدير الفندق</h1>

        <!-- أزرار التقارير -->
        <div class="flex flex-wrap gap-4 mb-8">
            <a href="{{ route('hotelManager.yearlyOccupancy') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
               عرض الإشغال السنوي
            </a>
            <a href="{{ route('hotelManager.monthlyOccupancy') }}"
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
               عرض الإشغال الشهري
            </a>
            {{-- <a href="{{ route('hotelManager.occupancy.by-type') }}"
               class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
               عرض الإشغال حسب النوع
            </a> --}}




            <a href="{{ route('reports.profitReport') }}"
               class="bg-red-700 hover:bg-red-900 text-white font-bold py-2 px-4 rounded">
            $   عرض تقارير الارباح
            </a>



            <a href="{{ route('reports.index') }}"
               class="bg-blue-900 hover:bg-green-1000 text-white font-bold py-2 px-4 rounded">
               تقارير استخدام الخدمات
            </a>


        </div>

        <!-- باقي المحتوى الأصلي -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- بطاقات الإحصائيات -->
        </div>
    </div>
</x-app-layout>
