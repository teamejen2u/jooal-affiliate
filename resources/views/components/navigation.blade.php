<!-- resources/views/components/navigation.blade.php -->
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
    <div class="flex justify-around">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500' }}">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span class="text-xs mt-1">Utama</span>
        </a>
        <a href="{{ route('missions') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('missions') ? 'text-indigo-600' : 'text-gray-500' }}">
            <i data-lucide="award" class="w-5 h-5"></i>
            <span class="text-xs mt-1">Misi</span>
        </a>
        <a href="{{ route('rewards') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('rewards') ? 'text-indigo-600' : 'text-gray-500' }}">
            <i data-lucide="gift" class="w-5 h-5"></i>
            <span class="text-xs mt-1">Ganjaran</span>
        </a>
        <a href="{{ route('brands') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('brands') ? 'text-indigo-600' : 'text-gray-500' }}">
            <i data-lucide="external-link" class="w-5 h-5"></i>
            <span class="text-xs mt-1">Jenama</span>
        </a>
    </div>
</div>