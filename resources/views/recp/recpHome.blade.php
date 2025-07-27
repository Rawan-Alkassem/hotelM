{{-- @extends('layouts.app') --}}
<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- {{ __('Dashboard') }} --}}
            hamza
            
        </h2>
        <br>
           <a href="{{ route('bookings.index') }}" class="btn btn-primary">
                           Bookings Management
                        </a>
    </x-slot>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">لوحة تحكم موظف الاستقبال</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>مرحباً بك، {{ Auth::user()->name }}!</h3>
                    <p>أنت الآن في لوحة تحكم موظف الاستقبال.</p>

                    <!-- محتوى الصفحة -->
                    <div class="mt-4">
                        <a href="{{ route('bookings.index') }}" class="btn btn-primary">
                           Bookings Management
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</x-app-layout>
