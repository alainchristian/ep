{{-- resources/views/layouts/sidebar/report-links.blade.php --}}
<a href="{{ route('reports.attendance') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('reports.attendance') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-chart-bar w-5"></i>
    <span class="ml-3">Attendance Reports</span>
</a>
