<x-app-layout>
    <x-slot name="title">Add New Room</x-slot>

    <h2 class="font-semibold text-xl text-white leading-tight text-left mb-6">
        ➕ Add New Room
    </h2>

    <div class="max-w-3xl mx-auto bg-gray-800 p-6 rounded-lg shadow-md text-white">
        @if ($errors->any())
            <div class="bg-gray-700 text-black px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- <style>
            input.form-control,
            select.form-control {
                color: white !important;
                background-color: gray !important;
            }
        </style> -->

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="room_number" class="block text-sm font-medium mb-1">Room Number</label>
                <input type="text" name="room_number" id="room_number"
                       class="form-control w-full rounded-md p-2 bg-gray-800"
                       value="{{ old('room_number') }}" required>
            </div>

            <div>
                <label for="room_type_id" class="block text-sm font-medium mb-1">Room Type</label>
                <select name="room_type_id" id="room_type_id"
                        class="form-control w-full rounded-md p-2 bg-gray-800 " required>
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
                        class="form-control w-full rounded-md p-2 bg-gray-800 " required>
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <!-- <div class="mb-4">
    <label for="images" class="block text-white font-bold mb-2">Room Images</label>
    <input type="file" name="images[]" id="images" multiple
           class="w-full p-2 border rounded bg-gray-800 text-white">
</div> -->
<div id="images-wrapper">
  <div class="image-input mb-4 flex items-center space-x-2">
    <input type="file" name="images[]" class="w-full p-2 border rounded bg-gray-800 text-white" />
    <button type="button" id="add-image-btn" class="bg-green-700 text-white px-3 rounded">+</button>
  </div>
</div>

            <div class="flex space-x-4 mt-4">
                <button type="submit" class="bg-green-900 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">
                    ➕ Add Room
                </button>
                <a href="{{ route('rooms.index') }}"
                   class="bg-gray-900 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded">
                    ← Back
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
<script>
document.getElementById('add-image-btn').addEventListener('click', function() {
    const wrapper = document.getElementById('images-wrapper');

    // إنشاء div جديد للحقل مع زر حذف
    const newInputDiv = document.createElement('div');
    newInputDiv.classList.add('image-input', 'mb-4', 'flex', 'items-center', 'space-x-2');

    // حقل رفع جديد
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.name = 'images[]';
    newInput.classList.add('w-full', 'p-2', 'border', 'rounded', 'bg-gray-800', 'text-white');

    // زر حذف للحقل الجديد
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.textContent = '-';
    removeBtn.classList.add('bg-red-600', 'text-white', 'px-3', 'rounded');
    removeBtn.addEventListener('click', () => {
        wrapper.removeChild(newInputDiv);
    });

    newInputDiv.appendChild(newInput);
    newInputDiv.appendChild(removeBtn);

    wrapper.appendChild(newInputDiv);
});
</script>
