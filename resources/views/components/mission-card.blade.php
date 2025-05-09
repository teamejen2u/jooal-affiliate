<!-- resources/views/components/mission-card.blade.php -->
<div class="flex items-center">
    <div class="mr-3">
        @if($mission->pivot->completed)
            <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
        @else
            <div class="h-5 w-5 rounded-full border-2 border-gray-300"></div>
        @endif
    </div>
    <div class="flex-1">
        <p class="text-sm {{ $mission->pivot->completed ? 'text-gray-500' : 'text-gray-700' }}">
            {{ $mission->title }}
        </p>
        @if(!$mission->pivot->completed)
            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ min(($mission->pivot->progress / $mission->target_value) * 100, 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                {{ $mission->pivot->progress }}/{{ $mission->target_value }} selesai
            </p>
        @endif
        
        @if($mission->pivot->completed)
            <div class="mt-1 flex">
                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-green-500 mr-1"></i>
                <p class="text-xs text-green-600">Selesai</p>
            </div>
        @endif
    </div>
    <div class="text-xs font-medium text-gray-500">
        {{ $mission->reward_points }} mata
    </div>
</div>