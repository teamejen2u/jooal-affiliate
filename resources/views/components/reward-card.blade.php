<!-- resources/views/components/reward-card.blade.php -->
<div class="flex items-center">
    <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-xl mr-4">
        {!! $reward->icon !!}
    </div>
    <div class="flex-1">
        <h3 class="font-medium">{{ $reward->title }}</h3>
        <p class="text-sm text-gray-500">{{ $reward->amount }}</p>
    </div>
    <form action="{{ route('rewards.redeem', $reward) }}" method="POST">
        @csrf
        <button 
            type="submit"
            class="px-4 py-2 rounded-lg text-sm font-medium {{ $reward->is_available && auth()->user()->xp_points >= $reward->points_required ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
            {{ (!$reward->is_available || auth()->user()->xp_points < $reward->points_required) ? 'disabled' : '' }}
        >
            {{ $reward->is_available ? 'Tebus' : 'Terkunci' }}
        </button>
    </form>
</div>