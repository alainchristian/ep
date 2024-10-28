<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EP Management System') }} - @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] {
                display: none !important;
            }

            /* Custom Scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #1F4320;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #97BC62;
                border-radius: 2px;
            }
        </style>
    </head>
<body class="font-sans antialiased">
    <div x-data="{
            sidebarOpen: window.innerWidth >= 1024,
            searchOpen: false,
            isMobile: window.innerWidth < 768,
            init() {
                this.$watch('sidebarOpen', value => {
                    if (window.innerWidth >= 1024) {
                        this.sidebarOpen = true;
                    }
                });

                window.addEventListener('resize', () => {
                    this.isMobile = window.innerWidth < 768;
                    if (window.innerWidth >= 1024) {
                        this.sidebarOpen = true;
                    }
                });
            }
        }"
        class="min-h-screen bg-gray-100">

        <!-- Mobile Toggle Button (Outside of the header) -->
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="fixed lg:hidden top-4 left-4 z-50 p-2 bg-[#2C5F2D] rounded-md text-white shadow-lg hover:bg-[#1F4320] focus:outline-none">
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                :class="{'hidden': sidebarOpen, 'block': !sidebarOpen}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"
                :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Mobile Overlay -->
        <div
            x-show="sidebarOpen && isMobile"
            @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden">
        </div>

        <!-- Top Navigation -->
        <div class="fixed top-0 right-0 z-20 w-full h-16 bg-white shadow-sm transition-all duration-300"
            :class="{'lg:pl-64': sidebarOpen}">
            <div class="flex items-center justify-between h-full px-4">
                <!-- Left Side -->
                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="hidden md:block">
                        <div class="relative">
                            <input type="text" placeholder="Search..."
                                class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Search Toggle -->
                    <button @click="searchOpen = !searchOpen" class="md:hidden text-gray-500 hover:text-gray-600">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- User Info -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden md:block text-right">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->FirstName }} {{ Auth::user()->LastName }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->Role }}</div>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-[#2C5F2D] flex items-center justify-center text-white font-medium">
                            {{ substr(Auth::user()->FirstName, 0, 1) }}{{ substr(Auth::user()->LastName, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Search Bar (Sliding) -->
            <div class="md:hidden"
                x-show="searchOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2">
                <div class="px-4 py-3 bg-white border-t">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="pt-16 transition-all duration-300" :class="{'lg:pl-64': sidebarOpen}">
            <div class="px-4 py-6 lg:px-8">
                <!-- Page Heading -->
                <header class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">@yield('header', 'Dashboard')</h1>
                </header>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
