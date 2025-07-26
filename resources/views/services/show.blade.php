<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-500 leading-tight text-right">
            📄 Service Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-md text-white">

               

                <!-- تفاصيل الخدمة -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-white">🧾 Service Name:</h3>
                    <p class="text-gray-300">{{ $service->name }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-white">📝 Description:</h3>
                    <p class="text-gray-300">{{ $service->description ?? '—' }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-white">🏨 Linked Room Types:</h3>
                    @if($service->roomTypes->isNotEmpty())
                        <ul class="list-disc pr-6 text-gray-300">
                            @foreach($service->roomTypes as $type)
                                <li>{{ $type->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-400">No room types linked.</p>
                    @endif
                </div>



                 <!-- صورة الخدمة -->
                <div class="mb-6 text-center">
                    @if($service->image && Storage::disk('public')->exists($service->image))
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="mx-auto rounded-md max-h-64 object-cover">
                    @else
                        <img src="{{ asset('storage/default_service_image.png') }}" alt="Default Service Image" class="mx-auto rounded-md max-h-64 object-cover">
                    @endif
                </div>


                <div class="mt-6 text-left">
                    <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-black hover:bg-gray-700">
                        ← Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
