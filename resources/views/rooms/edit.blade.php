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

        <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Room Number --}}
            <div>
                <label class="block text-sm font-medium text-red-500 mb-1">Room Number</label>
                <input type="text" name="room_number"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                    value="{{ old('room_number', $room->room_number) }}" required>
            </div>

            {{-- Room Type --}}
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

            {{-- Status --}}
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

            {{-- Services --}}
            @if(isset($roomTypeServices) && count($roomTypeServices) > 0)
                <div>
                    <label class="block text-sm font-medium text-red-500 mb-1">Services</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($room->roomType->services as $service)
                            <label class="flex items-center space-x-2 bg-gray-800 px-3 py-2 rounded">
                                <input type="checkbox" name="services[]"
                                    value="{{ $service->id }}"
                                    {{ isset($roomServices) && in_array($service->id, $roomServices) ? 'checked' : '' }}
                                    class="text-red-500 focus:ring-red-500">
                                <span>{{ $service->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Upload Multiple Images --}}
            <div id="images-wrapper" class="mb-4">
                <div class="image-input flex items-center space-x-2">
                    <input type="file" name="images[]" class="w-full p-2 border rounded bg-gray-800 text-white" />
                    <button type="button" id="add-image-btn" class="bg-green-700 text-white px-3 rounded">+</button>
                </div>
            </div>

            {{-- Show Existing Images with delete option --}}
            @if($room->images && count($room->images) > 0)
              <div class="mt-4">
    <p class="text-sm text-gray-400 mb-2">Existing Images:</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($room->images as $image)
            <div class="relative group border rounded overflow-hidden" style="border-color:#444;">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Room Image"
                    style="width:100%; height:150px; object-fit:cover; display:block; border-radius:0.5rem;" />

                {{-- زر الحذف في الزاوية --}}
               <button type="button"
    style="position:absolute; top:6px; right:6px; background-color:rgba(220,38,38,0.85); color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:20px; line-height:22px; cursor:pointer; display:flex; justify-content:center; align-items:center;"
    onclick="removeExistingImage({{ $image->id }}, this)"
    title="Remove Image">
    &times;
</button>


                {{-- إخفاء الصورة عند الحذف --}}
                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="hidden" />
            </div>
        @endforeach
    </div>
</div>

            @endif

            {{-- Buttons --}}
            <div class="flex justify-start gap-3 pt-2">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow-sm">
                    Update
                </button>

                <a href="{{ route('rooms.index') }}"
                   class="bg-gray-800 hover:bg-gray-900 text-white hover:text-gray-400 px-4 py-2 rounded shadow-sm">
                   Back
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>

<script>
function updateRemoveButtons() {
    const wrapper = document.getElementById('images-wrapper');
    const inputs = wrapper.querySelectorAll('.image-input');
    inputs.forEach((div, index) => {
        const btn = div.querySelector('button.remove-image-btn');
        if (btn) {
            btn.style.display = inputs.length > 1 ? 'inline-block' : 'none';
        }
    });
}

document.getElementById('add-image-btn').addEventListener('click', function() {
    const wrapper = document.getElementById('images-wrapper');

    const newInputDiv = document.createElement('div');
    newInputDiv.classList.add('image-input', 'flex', 'items-center', 'space-x-2');

    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.name = 'images[]';
    newInput.classList.add('w-full', 'p-2', 'border', 'rounded', 'bg-gray-800', 'text-white');

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.textContent = '-';
    removeBtn.classList.add('bg-red-600', 'text-white', 'px-3', 'rounded', 'remove-image-btn');
    removeBtn.addEventListener('click', () => {
        wrapper.removeChild(newInputDiv);
        updateRemoveButtons();
    });

    newInputDiv.appendChild(newInput);
    newInputDiv.appendChild(removeBtn);

    wrapper.appendChild(newInputDiv);
    updateRemoveButtons();
});

// عند تحميل الصفحة
updateRemoveButtons();

function removeExistingImage(imageId, btn) {
    const imageDiv = btn.closest('div.relative');
    imageDiv.style.display = 'none';

    const checkbox = imageDiv.querySelector('input[type="checkbox"]');
    if (checkbox) {
        checkbox.checked = true;
    }
}
</script>
