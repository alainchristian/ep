{{-- resources/views/students/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Student')
@section('header', 'Create New Student')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('students.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unique ID -->
                <div>
                    <label for="UniqueID" class="block text-sm font-medium text-gray-700">Student ID</label>
                    <input type="text"
                           name="UniqueID"
                           id="UniqueID"
                           value="{{ old('UniqueID') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D] focus:ring-opacity-50"
                           required>
                    @error('UniqueID')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Family -->
                <div>
                    <label for="FamilyID" class="block text-sm font-medium text-gray-700">Family</label>
                    <select name="FamilyID"
                            id="FamilyID"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D] focus:ring-opacity-50"
                            required>
                        <option value="">Select Family</option>
                        @foreach($families as $family)
                            <option value="{{ $family->FamilyID }}" {{ old('FamilyID') == $family->FamilyID ? 'selected' : '' }}>
                                {{ $family->FamilyName }} ({{ $family->FamilyMana }})
                            </option>
                        @endforeach
                    </select>
                    @error('FamilyID')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- First Name -->
                <div>
                    <label for="FirstName" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text"
                           name="FirstName"
                           id="FirstName"
                           value="{{ old('FirstName') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D] focus:ring-opacity-50"
                           required>
                    @error('FirstName')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="LastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text"
                           name="LastName"
                           id="LastName"
                           value="{{ old('LastName') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2C5F2D] focus:ring focus:ring-[#2C5F2D] focus:ring-opacity-50"
                           required>
                    @error('LastName')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio"
                                   name="Gender"
                                   value="Male"
                                   class="form-radio text-[#2C5F2D] focus:ring-[#2C5F2D]"
                                   {{ old('Gender') == 'Male' ? 'checked' : '' }}
                                   required>
                            <span class="ml-2">Male</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio"
                                   name="Gender"
                                   value="Female"
                                   class="form-radio text-[#2C5F2D] focus:ring-[#2C5F2D]"
                                   {{ old('Gender') == 'Female' ? 'checked' : '' }}
                                   required>
                            <span class="ml-2">Female</span>
                        </label>
                    </div>
                    @error('Gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('students.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2C5F2D]">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#2C5F2D] hover:bg-[#1F4320] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2C5F2D]">
                    Create Student
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Tips -->
    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-yellow-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Tips</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Student ID must be unique and follows the format YYYYNNNNN</li>
                        <li>Make sure to select the correct family</li>
                        <li>Names should be entered as they appear on official documents</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add any JavaScript for form validation or enhancement here
    document.addEventListener('DOMContentLoaded', function() {
        // Example: Auto-format Student ID
        const uniqueIdInput = document.getElementById('UniqueID');
        uniqueIdInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 9) value = value.substr(0, 9);
            e.target.value = value;
        });
    });
</script>
@endpush
@endsection
