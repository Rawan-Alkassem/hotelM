<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight text-right">
            ✏️ Edit Service
        </h2>
    </x-slot>

    <div class="py-8 ">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-md text-white">

                <form method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- الاسم + الوصف + الصورة الحالية -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-start">
                        <!-- الاسم والوصف -->
                        <div class="md:col-span-2 space-y-4">
                            <!-- اسم الخدمة -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-white mb-1">Service Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}"
                                       class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded">
                            </div>

                            <!-- وصف الخدمة -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-white mb-1">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded">{{ old('description', $service->description) }}</textarea>
                            </div>
                        </div>

                        <!-- صورة الخدمة الحالية -->
                        <div class="text-center">
                            @if($service->image && file_exists(public_path('storage/' . $service->image)))
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                     class="mx-auto rounded-md h-20 w-20 object-contain border border-gray-600">
                            @else
                                <img src="{{ asset('images/default_service_image.png') }}" alt="Default Image"
                                     class="mx-auto rounded-md h-20 w-20 object-contain border border-gray-600">
                            @endif
                            <p class="text-gray-400 mt-2 text-sm">Current Image</p>
                            
                        </div>
                     
                    </div>

                    <!-- رفع صورة جديدة -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-white mb-1">Upload New Image</label>
                        <input type="file" name="image" id="image"
                               class="w-full bg-gray-800 text-white border border-gray-600 rounded p-2" accept="image/*">
                        <small class="text-gray-400">Leave blank to keep current image.</small>
                    </div>

                    <!-- أنواع الغرف -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-white mb-2">Assign to Room Types</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($roomTypes as $roomType)
                                <label class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <input type="checkbox" name="room_types[]" value="{{ $roomType->id }}"
                                           {{ in_array($roomType->id, $selectedRoomTypes) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-yellow-500 bg-gray-700 border-gray-600 rounded">
                                    <span class="text-white text-sm">{{ $roomType->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- زر التحديث -->
                    <div class="flex justify-end mt-6 gap-4">
                        <button type="submit"
                                class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded">
                            Update Service
                        </button>

                        <a href="{{ route('services.index') }}"
                           class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded">
                            ← Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
