<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
           Room Types
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-sm sm:rounded-lg p-6 text-white">

                @if ($roomTypes->isEmpty())
                    <div class="bg-blue-100 text-blue-800 font-semibold px-4 py-3 rounded">
                        لا توجد أنواع غرف حالياً.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-700 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Description</th>
                                    <th class="px-4 py-2 text-left">Price</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-600">
                                @foreach ($roomTypes as $type)
                                    <tr>
                                        <td class="px-4 py-2">{{ $type->name }}</td>
                                        <td class="px-4 py-2">{{ $type->description ?? '—' }}</td>
                                        <td class="px-4 py-2">{{ number_format($type->price, 2) }} $</td>
                                        <td class="px-4 py-2 space-x-2">
                                            <a href="{{ route('room-types.show', $type->id) }}"
                                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                View
                                            </a>
                                            <a href="{{ route('room-types.edit', $type->id) }}"
                                               class="inline-block bg-gray-900 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('room-types.destroy', $type->id) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    DELETE
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('room-types.index') }}"
                       class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded">
                        ← Back t
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
