<!-- resources/views/components/header.blade.php -->
<div class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 px-4 py-3 flex justify-between items-center z-10">
    <h1 class="font-bold text-lg">Pusat Affiliate</h1>
    <div class="flex items-center space-x-3">
        <button class="p-2 relative">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
        </button>
        <a href="{{ route('profile') }}" class="h-8 w-8 rounded-full bg-gray-200 overflow-hidden">
            @if(auth()->user()->profile_pic)
                <img src="{{ asset('storage/profiles/' . auth()->user()->profile_pic) }}" alt="Profile" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('images/default-avatar.png') }}" alt="Profile" class="w-full h-full object-cover">
            @endif
        </a>
    </div>
</div>