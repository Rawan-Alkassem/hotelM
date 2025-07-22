@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">تعديل الحجز #{{ $booking->id }}</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">المستخدم</label>
                    <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700">الغرفة</label>
                    <select id="room_id" name="room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $booking->room_id == $room->id ? 'selected' : '' }}>{{ $room->room_number }} ({{ $room->roomType->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">حالة الحجز</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>ملغى</option>
                        <option value="finished" {{ $booking->status == 'finished' ? 'selected' : '' }}>منتهي</option>
                    </select>
                </div>

                <div>
                    <label for="check_in_date" class="block text-sm font-medium text-gray-700">تاريخ الدخول</label>
                    {{-- <input type="date" id="check_in_date" name="check_in_date" value="{{ $booking->check_in_date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"> --}}
                <input type="date" id="check_in_date" name="check_in_date" 
       value="{{ \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d') }}" 
       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700">تاريخ الخروج</label>
                    {{-- <input type="date" id="check_out_date" name="check_out_date" value="{{ $booking->check_out_date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"> --}}
                <input type="date" id="check_out_date" name="check_out_date" 
       value="{{ \Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d') }}" 
       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    تحديث الحجز
                </button>
                <a href="{{ route('bookings.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection