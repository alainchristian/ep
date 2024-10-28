{{-- resources/views/layouts/sidebar/admin-links.blade.php --}}
<a href="{{ route('students.index') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('students.*') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-users w-5"></i>
    <span class="ml-3">Students</span>
</a>
<a href="{{ route('families.index') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('families.*') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-house-user w-5"></i>
    <span class="ml-3">Families</span>
</a>
<a href="{{ route('eps.index') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('eps.*') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-book w-5"></i>
    <span class="ml-3">EP Programs</span>
</a>
<a href="{{ route('rotations.index') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('rotations.*') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-sync w-5"></i>
    <span class="ml-3">Rotations</span>
</a>
<a href="{{ route('users.index') }}"
   class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('users.*') ? 'bg-[#1F4320] text-white' : 'text-white/80 hover:bg-[#1F4320] hover:text-white' }}">
    <i class="fas fa-user-cog w-5"></i>
    <span class="ml-3">Users</span>
</a>
