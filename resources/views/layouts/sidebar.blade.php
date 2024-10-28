{{-- resources/views/layouts/sidebar.blade.php --}}
<!-- Top Navigation Bar -->
<div class="fixed top-0 right-0 z-20 w-full h-16 bg-white shadow-sm pl-64">
    <div class="flex items-center justify-between h-full px-6">
        <!-- Search Bar -->
        <div class="flex-1 max-w-xl">
            <div class="relative">
                <input type="text"
                       placeholder="Search..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#2C5F2D] focus:border-transparent">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <div class="text-sm font-medium text-gray-900">{{ Auth::user()->FirstName }} {{ Auth::user()->LastName }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->Role }}</div>
            </div>
            <div class="h-10 w-10 rounded-full bg-[#2C5F2D] flex items-center justify-center text-white font-medium">
                {{ substr(Auth::user()->FirstName, 0, 1) }}{{ substr(Auth::user()->LastName, 0, 1) }}
            </div>
        </div>
    </div>
</div>

<!-- Sidebar Backdrop -->
<div x-show="sidebarOpen"
     class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
     @click="sidebarOpen = false"
     x-cloak></div>

<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-30 w-64 bg-[#2C5F2D] transform transition duration-300 lg:transform-none lg:translate-x-0 flex flex-col"
     :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
     x-cloak>

    <!-- Logo -->
    <div class="flex items-center justify-between h-16 px-6 bg-[#1F4320]">
        <div class="flex items-center">
            <span class="text-xl font-bold text-white">EP Management</span>
        </div>
        <!-- Close button - Only show on mobile -->
        <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 pt-6 overflow-y-auto custom-scrollbar">
        <div class="space-y-6">
            <!-- Keep your existing menu structure but add x-data for collapsible sections -->

            <!-- Main Menu (keep as is) -->
            <div>
                <span class="text-xs font-semibold text-[#97BC62] uppercase tracking-wider">
                    Main Menu
                </span>
                <a href="{{ route('dashboard') }}"
                   class="mt-3 flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </div>

            @if(auth()->user()->isAdmin())
            <!-- Administration with collapsible sections -->
            <div x-data="{ open: true }">
                <span class="text-xs font-semibold text-[#97BC62] uppercase tracking-wider flex items-center justify-between cursor-pointer"
                      @click="open = !open">
                    <span>Administration</span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': !open }"></i>
                </span>
                <div class="mt-3 space-y-1" x-show="open" x-collapse>
                    <!-- Keep your existing admin links -->
                    @include('layouts.sidebar.admin-links')
                </div>
            </div>
            @endif

            @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
            <!-- Teaching with collapsible sections -->
            <div x-data="{ open: true }">
                <span class="text-xs font-semibold text-[#97BC62] uppercase tracking-wider flex items-center justify-between cursor-pointer"
                      @click="open = !open">
                    <span>Teaching</span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': !open }"></i>
                </span>
                <div class="mt-3 space-y-1" x-show="open" x-collapse>
                    <!-- Keep your existing teaching links -->
                    @include('layouts.sidebar.teaching-links')
                </div>
            </div>
            @endif

            <!-- Reports with collapsible sections -->
            <div x-data="{ open: true }">
                <span class="text-xs font-semibold text-[#97BC62] uppercase tracking-wider flex items-center justify-between cursor-pointer"
                      @click="open = !open">
                    <span>Reports</span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': !open }"></i>
                </span>
                <div class="mt-3 space-y-1" x-show="open" x-collapse>
                    <!-- Keep your existing reports links -->
                    @include('layouts.sidebar.report-links')
                </div>
            </div>
        </div>
    </nav>

    <!-- User Profile Section at Bottom -->
    <div class="flex-shrink-0 border-t border-[#97BC62]/20 bg-[#1F4320] p-4">
        <div class="flex items-center">
            <div class="h-10 w-10 rounded-full bg-[#2C5F2D] flex items-center justify-center text-white font-medium">
                {{ substr(Auth::user()->FirstName, 0, 1) }}{{ substr(Auth::user()->LastName, 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ Auth::user()->FirstName }} {{ Auth::user()->LastName }}</p>
                <p class="text-xs text-[#97BC62]">{{ Auth::user()->Role }}</p>
            </div>
        </div>
        <!-- Keep your existing logout form -->
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit"
                    class="w-full flex items-center px-4 py-2 text-sm text-white/80 hover:text-white hover:bg-[#2C5F2D] rounded-lg">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="ml-3">Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Custom Scrollbar Style -->
<style>
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
