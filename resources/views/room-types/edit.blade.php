<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            تعديل نوع الغرفة
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card bg-dark text-white p-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('room-types.update', $roomType->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">اسم النوع</label>
                        <input type="text" name="name" id="name" class="form-control"
                               style="background-color: #374151; color: white; border-color: #4b5563;"
                               value="{{ old('name', $roomType->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea name="description" id="description" rows="3" class="form-control"
                                  style="background-color: #374151; color: white; border-color: #4b5563;">{{ old('description', $roomType->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">السعر (بالدولار)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" class="form-control"
                               style="background-color: #374151; color: white; border-color: #4b5563;"
                               value="{{ old('price', $roomType->price) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">تحديث</button>
                    <a href="{{ route('room-types.index') }}" class="btn btn-secondary">رجوع</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
