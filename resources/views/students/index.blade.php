{{-- resources/views/students/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Students')
@section('header', 'Students Management')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Students List</h2>
            <p class="mt-1 text-sm text-gray-600">Manage student information and assignments</p>
        </div>
        <div>
            <a href="{{ route('students.create') }}"
               class="inline-flex items-center px-4 py-2 bg-[#2C5F2D] text-white rounded-lg hover:bg-[#1F4320] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2C5F2D]">
                <i class="fas fa-plus mr-2"></i>
                Add Student
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('students.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D] focus:ring-opacity-50"
                       placeholder="Search by name or ID...">
            </div>
            <div>
                <label for="family" class="block text-sm font-medium text-gray-700">Family</label>
                <select name="family"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D] focus:ring-opacity-50">
                    <option value="">All Families</option>
                    @foreach($families ?? [] as $family)
                        <option value="{{ $family->FamilyID }}" {{ request('family') == $family->FamilyID ? 'selected' : '' }}>
                            {{ $family->FamilyName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D] focus:ring-opacity-50">
                    <option value="">All</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#2C5F2D] hover:bg-[#1F4320] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2C5F2D]">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Family</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($students as $student)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $student->UniqueID }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-[#2C5F2D] flex items-center justify-center text-white">
                                    {{ substr($student->FirstName, 0, 1) }}{{ substr($student->LastName, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $student->FirstName }} {{ $student->LastName }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $student->family->FamilyName }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $student->Gender }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('students.show', $student) }}"
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student) }}"
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to deactivate this student?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No students found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
