{{-- resources/views/layouts/sidebar/teaching-links.blade.php --}}
<a href="{{ route('my-eps.index') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('my-eps.*') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-chalkboard-teacher w-5"></i>
    <span class="ml-3">My EPs</span>
</a>
<a href="{{ route('attendance.create') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('attendance.create') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-clipboard-check w-5"></i>
    <span class="ml-3">Take Attendance</span>
</a>
