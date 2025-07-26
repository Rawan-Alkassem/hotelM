<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            تفاصيل نوع الغرفة
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card bg-dark text-white p-4">

                <div class="mb-3">
                    <label class="form-label">اسم النوع:</label>
                    <div class="form-control bg-light text-dark">{{ $roomType->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف:</label>
                    <div class="form-control bg-light text-dark">{{ $roomType->description ?? '—' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">السعر:</label>
                    <div class="form-control bg-light text-dark">{{ $roomType->price }} $</div>
                </div>

                <a href="{{ route('room-types.index') }}" class="btn btn-secondary mt-3">رجوع</a>
            </div>
        </div>
    </div>
</x-app-layout>
