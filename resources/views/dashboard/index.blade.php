<!-- resources/views/dashboard/index.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-4 space-y-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-4 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Jumlah Pendapatan</p>
                <h2 class="text-2xl font-bold">{{ $user->formatted_earnings }}</h2>
            </div>
            <div class="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <p class="text-sm text-gray-500">Jualan</p>
            <h3 class="text-xl font-bold">{{ $user->sales_count }}</h3>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <p class="text-sm text-gray-500">Klik</p>
            <h3 class="text-xl font-bold">{{ $user->click_count }}</h3>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <p class="text-sm text-gray-500">Penukaran</p>
            <h3 class="text-xl font-bold">{{ number_format($user->conversion_rate, 1) }}%</h3>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <p class="text-sm text-gray-500">Kedudukan</p>
            <h3 class="text-xl font-bold">#{{ $user->rank ?? '-' }}</h3>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Misi Aktif</h3>
            <a href="{{ route('missions') }}" class="text-sm text-indigo-600 flex items-center">
                Lihat semua <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
        
        <div class="space-y-4">
            @forelse($missions as $mission)
                @include('components.mission-card', ['mission' => $mission])
            @empty
                <p class="text-sm text-gray-500">Tiada misi aktif buat masa ini.</p>
            @endforelse
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Jenama Teratas</h3>
            <a href="{{ route('brands') }}" class="text-sm text-indigo-600 flex items-center">
                Lihat semua <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
        
        <div class="flex space-x-4 overflow-x-auto pb-2">
            @foreach($brands as $brand)
                <div class="flex flex-col items-center min-w-[80px]">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                        @if($brand->logo)
                            <img src="{{ asset('storage/brands/' . $brand->logo) }}" alt="{{ $brand->name }}" class="w-10 h-10 object-contain">
                        @else
                            <img src="{{ asset('images/default-brand.png') }}" alt="{{ $brand->name }}" class="w-10 h-10 object-contain">
                        @endif
                    </div>
                    <p class="text-xs font-medium mt-2">{{ $brand->name }}</p>
                    <p class="text-xs text-gray-500">{{ $brand->commission_rate }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection