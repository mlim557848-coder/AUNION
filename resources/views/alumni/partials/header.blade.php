<nav class="bg-red-700 text-white">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-red-700 font-bold text-xl">A</div>
            <div>
                <h1 class="text-2xl font-bold">aunion</h1>
                <p class="text-xs opacity-75 -mt-1">Alumni Portal</p>
            </div>
        </div>
        <div class="flex items-center gap-6 text-sm">
            <span>Welcome Back, {{ auth()->user()->name }}</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="hover:underline">Exit</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>

    <div class="bg-red-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex gap-8 text-sm">
                <a href="{{ route('alumni.dashboard') }}" class="py-3 border-b-4 border-white font-medium">Home</a>
                <a href="{{ route('alumni.profile') }}" class="py-3 hover:text-white">My Profile</a>
                <a href="{{ route('alumni.network') }}" class="py-3 hover:text-white">Alumni Network</a>
                <a href="{{ route('alumni.events') }}" class="py-3 hover:text-white">Events</a>
                <a href="{{ route('alumni.announcements') }}" class="py-3 hover:text-white">Announcements</a>
            </div>
        </div>
    </div>
</nav>