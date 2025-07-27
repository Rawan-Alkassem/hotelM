{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('employeesmanagement.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Full Name</label>
                        <input type="text" name="full_name" required class="form-control w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
                        <input type="email" name="email" required class="form-control w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Password</label>
                        <input type="password" name="password" required class="form-control w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="form-control w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Role</label>
                        <select name="role" class="form-control w-full">
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                        <a href="{{ route('employeesmanagement.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> --}}



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="POST" action="{{ route('employeesmanagement.store') }}">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required
                               class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('full_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select name="role" required
                                class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            Add Employee
                        </button>
                        <a href="{{ route('employeesmanagement.index') }}"
                           class="ml-3 text-gray-700 dark:text-gray-300 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
