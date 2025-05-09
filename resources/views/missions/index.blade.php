<!-- resources/views/missions/index.blade.php -->
@extends('layouts.app')

@section('title', 'Missions')

@section('content')
<div class="p-4 space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Misi</h2>
        <div class="text-sm font-medium text-indigo-600">
            {{ $user->xp_points }} XP Diperoleh
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-4 shadow-sm mb-4">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-lg font-medium">Misi Harian</h3>
            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                Reset dalam {{ now()->endOfDay()->diffForHumans(null, true) }}
            </span>
        </div>
        
        <div class="space-y-4">
            @forelse($dailyMissions as $mission)
                @include('components.mission-card', ['mission' => $mission])
            @empty
                <p class="text-sm text-gray-500">Tiada misi harian buat masa ini.</p>
            @endforelse
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <h3 class="text-lg font-medium mb-4">Misi Pencapaian</h3>
        
        <div class="space-y-5">
            @forelse($achievementMissions as $mission)
                <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                    @include('components.mission-card', ['mission' => $mission])
                    
                    @if($mission->pivot->completed && !$mission->pivot->reward_claimed)
                        <form action="{{ route('missions.claim', $mission) }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-2 px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg">
                                Tuntut Ganjaran
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">Tiada misi pencapaian buat masa ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection