<x-app-layout>
    <x-slot name="title">Rooms List</x-slot>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-left mb-6">
        Rooms List
    </h2>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-left">

            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between">
                <a href="{{ route('rooms.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-red hover:bg-blue-700">
                    + Add New Room
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200 text-gray-900 text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-xs font-medium uppercase">#</th>
                            <th class="px-4 py-2 text-xs font-medium uppercase">Room Number</th>
                            <th class="px-4 py-2 text-xs font-medium uppercase">Type</th>
                            <th class="px-4 py-2 text-xs font-medium uppercase">Price</th>
                            <th class="px-4 py-2 text-xs font-medium uppercase">Status</th>
                            <th class="px-4 py-2 text-xs font-medium uppercase">Created</th>
                            <th class="px-4 py-2 text-xs font-medium uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($rooms as $room)
                            <tr>
                                <td class="px-4 py-2">{{ $room->id }}</td>
                                <td class="px-4 py-2">{{ $room->room_number }}</td>
                                <td class="px-4 py-2">{{ $room->roomType->name }}</td>
                                <td class="px-4 py-2">${{ number_format($room->roomType->price, 2) }}</td>
                                <td class="px-4 py-2">
                                    @php $status = $room->status; @endphp
                                    @if ($status === 'available')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    @elseif ($status === 'reserved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                                    @endif
                                            {{ ucfirst($status) }}
                                        </span>
                                </td>
                                <td class="px-4 py-2">{{ $room->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('rooms.show', $room->id) }}" class="text-blue-600 hover:underline text-sm">View</a>
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="text-yellow-600 hover:underline text-sm ms-3">Edit</a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="inline ms-3" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm bg-transparent border-0 p-0">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No rooms found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-left">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-black hover:bg-gray-700">
                    ← Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
