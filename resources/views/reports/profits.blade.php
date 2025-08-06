<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            تقارير الأرباح
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-700 dark:text-gray-100">ملخص الأرباح</h3>

                <table class="min-w-full text-center border border-gray-300 dark:border-gray-600">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="p-3">الفترة</th>
                            <th class="p-3">الأرباح (ل.س)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                        <tr><td class="border p-2">الشهر الحالي ({{ \Carbon\Carbon::now()->format('F Y') }})</td><td>{{ number_format($profits['this_month']) }}</td></tr>
                        <tr><td class="border p-2">الشهر الماضي</td><td>{{ number_format($profits['last_month']) }}</td></tr>
                        <tr><td class="border p-2">السنة الحالية ({{ date('Y') }})</td><td>{{ number_format($profits['this_year']) }}</td></tr>
                        <tr><td class="border p-2">السنة الماضية ({{ date('Y') - 1 }})</td><td>{{ number_format($profits['last_year']) }}</td></tr>

                        @foreach ($profits['last_4_weeks'] as $week => $amount)
                            <tr><td class="border p-2">الأسبوع {{ $week }}</td><td>{{ number_format($amount) }}</td></tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-8">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-100 mb-2">تفاصيل إضافية:</h4>
                    <ul class="list-disc pl-6 text-gray-600 dark:text-gray-300">
                        <li>إجمالي الحجوزات: {{ $profits['total_bookings'] }}</li>
                        <li>أعلى شهر ربحًا: {{ $profits['top_month'] }} ({{ number_format($profits['top_month_value']) }} ل.س)</li>
                        <li>متوسط الأرباح الشهرية: {{ number_format($profits['monthly_average']) }} ل.س</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
