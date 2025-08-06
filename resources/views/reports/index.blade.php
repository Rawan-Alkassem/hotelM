{{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center"> </div>

<div class="container">
    <h1>تقرير الأرباح والخدمات</h1>
 </div>
           <a href="{{ route('reports.profitReport') }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
profits
                                        </a>
    <div class="card my-4 p-4">
        <h3>إجمالي الأرباح:</h3>
        <p>{{ number_format($totalRevenue, 2) }} ل.س</p>
    </div>

    <div class="card my-4 p-4">
        <h3>الخدمات الأكثر طلباً:</h3>
        <ul>
            @foreach($popularServices as $service)
                <li>{{ $service->name }} - {{ $service->usage_count }} استخدام</li>
            @endforeach
        </ul>
    </div>
           <a href="{{ route('reports.profitReport') }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
profits
                                        </a>
</div>

</x-app-layout> --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">تقرير الأرباح والخدمات</h2>
            {{-- <a href="{{ route('reports.profitReport') }}"
                class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-lg shadow-md hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 text-sm">
                مشاهدة الأرباح
            </a> --}}
        </div>
    </x-slot>

    <div class="p-6 max-w-6xl mx-auto">
        <!-- إجمالي الأرباح -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">إجمالي الأرباح</h3>
            <p class="text-2xl font-bold text-green-600">{{ number_format($totalRevenue, 2) }} ل.س</p>
        </div>

        <!-- الخدمات الأكثر طلباً -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">الخدمات الأكثر طلباً</h3>
            <ul class="space-y-2">
                @foreach($popularServices as $service)
                    <li class="flex justify-between items-center bg-gray-100 rounded-lg px-4 py-2">
                        <span class="text-gray-700 font-medium">{{ $service->name }}</span>
                        <span class="text-sm text-gray-500">{{ $service->usage_count }} استخدام</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
