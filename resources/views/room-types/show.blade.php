<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Room Type Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-md rounded-lg p-6 text-white space-y-6">

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Name:</label>
                    <div class="bg-white text-gray-800 rounded px-4 py-2">
                        {{ $roomType->name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Description:</label>
                    <div class="bg-white text-gray-800 rounded px-4 py-2">
                        {{ $roomType->description ?? '—' }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Price (USD):</label>
                    <div class="bg-white text-gray-800 rounded px-4 py-2">
                        {{ number_format($roomType->price, 2) }} $
                    </div>
                </div>

                <!-- Services section -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Services:</label>
                    <div class="bg-white text-gray-800 rounded px-4 py-2">
                        @if($roomType->services && $roomType->services->count() > 0)
                            <ul class="list-disc pl-5">
                                @foreach ($roomType->services as $service)
                                    <li>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            — No services assigned —
                        @endif
                    </div>
                </div>

                <div class="flex space-x-4 pt-6">
                    <a href="{{ route('room-types.edit', $roomType->id) }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                        Edit
                    </a>

                    <form action="{{ route('room-types.destroy', $roomType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room type?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded">
                            Delete
                        </button>
                    </form>

                    <a href="{{ route('room-types.view') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded">
                        ← Back to Room Types
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
