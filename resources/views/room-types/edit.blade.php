<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 leading-tight">
            Edit Room Type
        </h2>
    </x-slot>

    <div class="py-4 bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="card bg-gray-800 text-white p-6 rounded-lg shadow-md">

                @if ($errors->any())
                    <div class="alert alert-danger bg-red-700 text-white p-3 rounded mb-4">
                        <ul class="mb-0 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('room-types.update', $roomType->id) }}" method="POST" class="space-y-5" dir="ltr">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block mb-1 font-semibold text-white">Type Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full rounded border border-gray-600 bg-gray-700 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name', $roomType->name) }}">
                    </div>

                    <div>
                        <label for="description" class="block mb-1 font-semibold text-white">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full rounded border border-gray-600 bg-gray-700 text-white px-3 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $roomType->description) }}</textarea>
                    </div>

                    <div>
                        <label for="price" class="block mb-1 font-semibold text-white">Price (USD)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" required
                            class="w-full rounded border border-gray-600 bg-gray-700 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('price', $roomType->price) }}">
                    </div>

                    <!-- خدمات مع اختيار الخدمات الحالية -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-white mb-2">Select Services</label>
                        <div class="space-y-2 bg-gray-700 p-4 rounded border border-gray-600 max-h-64 overflow-y-auto">
                            @foreach ($services as $service)
                                <label class="flex items-center space-x-2 text-sm">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                        class="form-checkbox text-blue-500 bg-gray-600 border-gray-500 rounded"
                                        {{ in_array($service->id, old('services', $roomType->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span>{{ $service->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                            Update
                        </button>
                        <a href="{{ route('room-types.view') }}" 
                           class="btn btn-secondary bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
