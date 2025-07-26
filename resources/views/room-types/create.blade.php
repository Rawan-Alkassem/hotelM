<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight text-left">
            ➕ Add Room Type
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gray-800 text-white shadow-md rounded-lg p-6">

                @if ($errors->any())
                <div class="bg-red-700 text-white rounded px-4 py-3 mb-6">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('room-types.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- الاسم والسعر بجانب بعض -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-red-400 mb-1">Room Type Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                class="block w-full bg-gray-800 border border-gray-600 text-white rounded px-3 py-2 focus:ring-2 focus:ring-red-500">
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-red-400 mb-1">Price (USD)</label>
                            <input
                                type="number"
                                name="price"
                                id="price"
                                step="0.01"
                                min="0"
                                value="{{ old('price') }}"
                                required
                                class="block w-full bg-gray-800 border border-gray-600 text-white rounded px-3 py-2 focus:ring-2 focus:ring-red-500">
                        </div>
                    </div>

                    <!-- الوصف -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-red-400 mb-1">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="block w-full bg-gray-800 border border-gray-600 text-white rounded px-3 py-2 focus:ring-2 focus:ring-red-500">{{ old('description') }}</textarea>
                    </div>

                    <!-- اختيار الخدمات -->
                   
                    <div class="mb-4">
    <label class="block text-sm font-medium text-red-400 mb-2">Select Services</label>
    <div class="space-y-2 bg-gray-800 p-4 rounded border border-gray-600">
        @foreach ($services as $service)
            <label class="flex items-center space-x-2 text-sm">
                <input type="checkbox" name="services[]" value="{{ $service->id }}"
                    class="form-checkbox text-red-500 bg-gray-700 border-gray-600 rounded">
                <span>{{ $service->name }}</span>
            </label>
        @endforeach
    </div>
</div>

                    <!-- أزرار الحفظ والرجوع -->
                    <div class="flex justify-start gap-4 pt-4">
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded font-semibold shadow">
                            💾 Save
                        </button>
                        <a href="{{ route('room-types.index') }}"
                            class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded font-semibold shadow">
                            ← Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>