<x-admin-layout>
    <x-slot name="title">Edit Room</x-slot>

    <div class="mb-6">
        <h2 class="text-xl font-bold text-red-500 text-left">✏️ Edit Room Information</h2>
    </div>

    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow text-white text-left">
        @if ($errors->any())
            <div class="bg-red-700 text-white px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-red-500 mb-1">Room Number</label>
                <input type="text" name="room_number"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                    value="{{ old('room_number', $room->room_number) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-red-500 mb-1">Room Type</label>
                <select name="room_type_id"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                    required>
                    <option value="">-- Select Room Type --</option>
                    @foreach ($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-red-500 mb-1">Status</label>
                <select name="status"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                    required>
                    <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>

  <div class="flex justify-start gap-3 pt-2">
    <button type="submit"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow-sm">
        Update
    </button>

    <a href="{{ route('rooms.index') }}"
       class="bg-gray-800 hover:bg-gray-900 text-white hover:text-black-400 px-4 py-2 rounded shadow-sm">
       Back
    </a>
</div>
</x-admin-layout>
