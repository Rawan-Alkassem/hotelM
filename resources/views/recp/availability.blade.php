// resources/views/reception/availability.blade.php
{{-- @extends('layouts.reception') --}}

{{-- @section('content') --}}
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">بحث عن غرف متاحة</h1>
    
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        {{-- <form action="{{ route('reception.check-availability') }}" method="POST"> --}}
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- تاريخ الدخول -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">تاريخ الدخول</label>
                    <input type="date" name="check_in" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                           min="{{ now()->format('Y-m-d') }}" required>
                </div>
                
                <!-- تاريخ الخروج -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">تاريخ الخروج</label>
                    <input type="date" name="check_out" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                           min="{{ now()->addDay()->format('Y-m-d') }}" required>
                </div>
                
                <!-- نوع الغرفة -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">نوع الغرفة</label>
                    <select name="room_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">الكل</option>
                        {{-- @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                
                <!-- زر البحث -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        بحث عن غرف
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- نتائج البحث -->
    @isset($availableRooms)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <h2 class="px-6 py-4 bg-gray-100 text-lg font-semibold">الغرف المتاحة</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right">رقم الغرفة</th>
                        <th class="px-6 py-3 text-right">النوع</th>
                        <th class="px-6 py-3 text-right">السعر/ليلة</th>
                        <th class="px-6 py-3 text-right">الطابق</th>
                        <th class="px-6 py-3 text-right">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($availableRooms as $room)
                    <tr>
                        <td class="px-6 py-4">{{ $room->room_number }}</td>
                        <td class="px-6 py-4">{{ $room->roomType->name }}</td>
                        <td class="px-6 py-4">{{ number_format($room->roomType->price, 2) }} ر.س</td>
                        <td class="px-6 py-4">{{ $room->floor }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('reception.create-booking', ['room' => $room->id]) }}?check_in={{ request('check_in') }}&check_out={{ request('check_out') }}"
                               class="text-blue-600 hover:text-blue-900">حجز</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endisset
</div>
{{-- @endsection --}}