
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Employees Management
            </h2>
            <a href="{{ route('employeesmanagement.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                + Add Employee
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-3 rounded">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="mb-4 text-red-600 bg-red-100 border border-red-300 p-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-lg font-bold text-gray-700 dark:text-gray-100 mb-4">Users with Roles (Except Customers)</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-900 border rounded">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">#</th>
                                <th class="py-3 px-6">Full Name</th>
                                <th class="py-3 px-6">Email</th>
                                <th class="py-3 px-6">Role</th>
                                <th class="py-3 px-6">Registered At</th>
                                <th class="py-3 px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-200 text-sm">
                            @forelse($users as $index => $user)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <td class="py-3 px-6">{{ $index + 1 }}</td>
                                    <td class="py-3 px-6">{{ $user->full_name }}</td>
                                    <td class="py-3 px-6">{{ $user->email }}</td>
                                    <td class="py-3 px-6">{{ $user->getRoleNames()->implode(', ') }}</td>
                                    <td class="py-3 px-6">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="py-3 px-6 space-x-2">
                                        <form action="{{ route('employeesmanagement.destroy', $user) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                                Delete
                                            </button>
                                        </form>

                                        <a href="{{ route('employeesmanagement.edit-role', $user) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                            Change Role
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-500 dark:text-gray-400">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 text-left">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700">
                    ← Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

