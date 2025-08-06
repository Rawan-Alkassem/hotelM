<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight text-right">
            ➕ Add New Service
        </h2>
    </x-slot>

    <div class="py-8 ">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-sm sm:rounded-lg p-6 text-white">

                <!-- رجوع للخلف -->
                <button onclick="history.back()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700 mb-4">
                    ← Back
                </button>

                <!-- عرض أخطاء التحقق -->
                @if ($errors->any())
                    <div class="mb-4 text-red-400">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- فورم إضافة خدمة -->
                <!-- مهم: enctype لتفعيل رفع الملفات -->
                <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    <!-- اسم الخدمة -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-white mb-1">Service Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded">
                    </div>

                    <!-- وصف الخدمة -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-white mb-1">Description</label>
                        <textarea name="description" id="description"
                            class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded"
                            rows="3">{{ old('description') }}</textarea>
                    </div>

                    <!-- رفع صورة الخدمة -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-white mb-1">Service Image (optional)</label>
                        <input type="file" name="image" id="image" 
                            class="w-full text-white bg-gray-800 border border-gray-600 rounded p-2" accept="image/*">
                        <small class="text-gray-400">Allowed file types: jpg, png, jpeg, gif</small>
                    </div>
<!-- ربط الخدمة بأنواع الغرف باستخدام checkboxes -->
<div class="mb-4">
    <label class="block text-sm font-medium text-white mb-2">Assign to Room Types</label>
    <div class="space-y-2">
        @foreach ($roomTypes as $roomType)
            <label class="flex flex-row-reverse items-center bg-gray-700 p-2 rounded text-white">
                <span class="text-sm">{{ $roomType->name }}</span>

                <input type="checkbox" name="room_types[]" value="{{ $roomType->id }}"
                    class="form-checkbox text-green-500 ml-2"
                    {{ is_array(old('room_types')) && in_array($roomType->id, old('room_types')) ? 'checked' : '' }}>
                
            </label>
        @endforeach
    </div>
</div>


                    <!-- زر الحفظ -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded">
                            Save Service
                        </button>
                    </div>
     <div class="mt-6 text-left">
                <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-black hover:bg-gray-700">
                    ← Back
                </a>
            </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
