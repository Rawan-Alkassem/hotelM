<x-admin-layout>
    <x-slot name="title">Add New Room</x-slot>

    <h2 class="font-semibold text-xl text-black leading-tight text-left mb-6">
        ➕ Add New Room
    </h2>

    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow-md text-black">
        @if ($errors->any())
            <div class="bg-red-700 text-black px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            input.form-control,
            select.form-control {
                color: white !important;
                background-color: black !important;
            }
        </style>

        <form action="{{ route('rooms.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="room_number" class="block text-sm font-medium mb-1">Room Number</label>
                <input type="text" name="room_number" id="room_number"
                       class="form-control w-full rounded-md p-2"
                       value="{{ old('room_number') }}" required>
            </div>

            <div>
                <label for="room_type_id" class="block text-sm font-medium mb-1">Room Type</label>
                <select name="room_type_id" id="room_type_id"
                        class="form-control w-full rounded-md p-2" required>
                    <option value="">Select Room Type</option>
                    @foreach ($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium mb-1">Room Status</label>
                <select name="status" id="status"
                        class="form-control w-full rounded-md p-2" required>
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>

            <div class="flex space-x-4 mt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-balck font-semibold px-4 py-2 rounded">
                    ➕ Add Room
                </button>
                <a href="{{ route('rooms.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-black font-semibold px-4 py-2 rounded">
                    ← Back
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
