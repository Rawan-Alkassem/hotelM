<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            عرض أنواع الغرف
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">

                @if ($roomTypes->isEmpty())
                    <div class="alert alert-info">لا توجد أنواع غرف حالياً.</div>
                @else
                    <table class="table table-bordered table-dark text-white">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الوصف</th>
                                <th>السعر</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomTypes as $type)
                                <tr>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->description ?? '—' }}</td>
                                    <td>{{ number_format($type->price, 2) }} $</td>
                                    <td>
                                        <a href="{{ route('room-types.show', $type->id) }}" class="btn btn-primary btn-sm">عرض</a>
                                        <a href="{{ route('room-types.edit', $type->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                        <form action="{{ route('room-types.destroy', $type->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <a href="{{ route('room-types.index') }}" class="btn btn-secondary mt-4">رجوع</a>

            </div>
        </div>
    </div>
</x-app-layout>
