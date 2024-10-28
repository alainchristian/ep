{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Students -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Students</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalStudents ?? 0) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3 rounded-b-xl">
                <a href="{{ route('students.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all students →</a>
            </div>
        </div>

        <!-- Active EPs -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active EPs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($activeEPs ?? 0) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3 rounded-b-xl">
                <a href="{{ route('eps.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">View all EPs →</a>
            </div>
        </div>

        <!-- Current Rotation -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Current Rotation</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            @if(isset($currentRotation))
                                {{ $currentRotation->Year }} - R{{ $currentRotation->RotationNumber }}
                            @else
                                No Active Rotation
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3 rounded-b-xl">
                <a href="{{ route('rotations.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">View all rotations →</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Quick Actions Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('attendance.create') }}"
                   class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Take Attendance</p>
                        <p class="text-xs text-gray-500">Record daily attendance</p>
                    </div>
                </a>

                <a href="{{ route('reports.attendance') }}"
                   class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">View Reports</p>
                        <p class="text-xs text-gray-500">Check attendance reports</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
            <div class="space-y-4">
                <!-- Activity items would go here -->
                <p class="text-sm text-gray-500">No recent activity to display.</p>
            </div>
        </div>
    </div>
</div>
@endsection
