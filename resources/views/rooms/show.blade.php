<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 leading-tight text-left">
            Room Details Number {{ $room->room_number }}
        </h2>
    </x-slot>

    <div class="py-6 bg- bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md max-w-lg mx-auto" dir="ltr">

                <!-- Room Number -->
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-left text-white">Room Number:</label>
                    <div class="bg-gray-700 text-white rounded px-4 py-3 select-text">
                        {{ $room->room_number }}
                    </div>
                </div>

                <!-- Room Type -->
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-left text-white">Room Type:</label>
                    <div class="bg-gray-700 text-white rounded px-4 py-3 select-text">
                        {{ $room->roomType->name ?? 'Not specified' }}
                    </div>
                </div>

                <!-- Room Status -->
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-left text-white">Room Status:</label>
                    <div class="bg-gray-700 text-white rounded px-4 py-3 select-text">
                        @if($room->status == 'available')
                            Available
                        @elseif($room->status == 'booked')
                            Booked
                        @elseif($room->status == 'maintenance')
                            Under Maintenance
                        @else
                            Unknown
                        @endif
                    </div>
                </div>

                <!-- Room Services (From Room Type) -->
                <div class="mb-6">
                    <label class="block text-white font-bold mb-2">Room Services:</label>
                    @if($room->roomType && $room->roomType->services->count())
                        <ul class="list-disc list-inside bg-gray-700 p-3 rounded">
                            @foreach($room->roomType->services as $service)
                                <li>{{ $service->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="bg-gray-700 p-3 rounded">No services assigned to this room type.</p>
                    @endif
                </div>

                <!-- Room Images with Swiper Slider -->
                @if($room->images && $room->images->count() > 0)
                    <div class="mb-6">
                        <label class="block text-white font-bold mb-2">Room Images:</label>

                        <!-- Swiper Container -->
                        <div class="swiper mySwiper rounded overflow-hidden shadow-lg">
                            <div class="swiper-wrapper">
                                @foreach($room->images as $image)
                                    <div class="swiper-slide flex justify-center">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="Room Image"
                                             class="object-cover rounded"
                                             style="width: 300px; height: 200px;">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                            <!-- Add Navigation -->
                            <div class="swiper-button-next text-white"></div>
                            <div class="swiper-button-prev text-white"></div>
                        </div>
                    </div>
                @else
                    <div class="mb-6">
                        <label class="block text-white font-bold mb-2">Room Images:</label>
                        <p class="bg-gray-700 p-3 rounded">No images uploaded for this room.</p>
                    </div>
                @endif

                <!-- Back Button -->
                <div class="flex space-x-4 mt-6 justify-start">
                    <a href="{{ route('rooms.index') }}"
                       class="bg-gray-700 hover:bg-gray-600 text-white font-semibold px-5 py-2 rounded transition">
                        ← Back
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Swiper CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.mySwiper', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                slidesPerView: 1,
                spaceBetween: 5,  // تم تقليل المسافة بين الشرائح
            });
        });
    </script>

</x-app-layout>
