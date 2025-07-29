<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight text-right">
            📋 All Services
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-sm sm:rounded-lg p-6 text-white">

                <!-- زر الرجوع و زر الإضافة -->
                <div class="mb-4 flex justify-between items-center">
                    <a href="{{ route('services.create') }}"
                        class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded">
                        ➕ Add New Service
                    </a>
                </div>

                <!-- جدول عرض الخدمات -->
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-700 text-white text-sm">
                                <th class="px-4 py-2 border">#</th>
                               
                                <th class="px-4 py-2 border text-right">Name</th>
                                <th class="px-4 py-2 border text-right">Description</th>
                                <th class="px-4 py-2 border text-right">Room Types</th>
                                <th class="px-4 py-2 border text-center">Actions</th>
                                 <th class="px-4 py-2 border text-center">Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $service)
                            <tr class="bg-gray-600 hover:bg-gray-500 text-sm">
                                <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>

                                

                                <td class="px-4 py-2 border text-right">{{ $service->name }}</td>
                                <td class="px-4 py-2 border text-right">{{ $service->description }}</td>
                                <td class="px-4 py-2 border text-right">
                                    @foreach ($service->roomTypes as $type)
                                    <span class="bg-gray-900 px-2 py-1 rounded text-xs">{{ $type->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <a href="{{ route('services.edit', $service->id) }}"
                                        class="inline-block px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">
                                        ✏️ Edit
                                    </a>
                                    <a href="{{ route('services.show', $service->id) }}"
                                        class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm">
                                        View
                                    </a>
                                    <form action="{{ route('services.destroy', $service->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @if($service->image && Storage::disk('public')->exists($service->image))
                                    <img src="{{ asset('storage/' . $service->image) }}"
                                        alt="{{ $service->name }}"
                                        class="mx-auto rounded-md h-20 w-20 object-contain">
                                    @else
                                  
                                    <img src="{{ asset('storage/default_service_image.png') }}"
                                        alt="{{ $service->name }}"
                                        class="mx-auto rounded-md h-20 w-20 object-contain">
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-300">No services found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6 text-left">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-black hover:bg-gray-700">
                            ← Back
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>