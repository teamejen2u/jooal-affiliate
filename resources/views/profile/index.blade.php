<!-- resources/views/profile/index.blade.php -->
@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="p-4 space-y-6">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="flex flex-col items-center pb-6 border-b border-gray-200">
            <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden mb-4 relative group">
                @if($user->profile_pic)
                    <img src="{{ asset('storage/profiles/' . $user->profile_pic) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Profil" class="w-full h-full object-cover">
                @endif
                
                <label for="profile_pic" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                    <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                </label>
                <input type="file" id="profile_pic" name="profile_pic" class="hidden" accept="image/*">
            </div>
            
            <div class="w-full mb-4">
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name', $user->name) }}" 
                    class="text-xl font-bold text-center w-full border-none focus:ring-0 focus:outline-none" 
                    placeholder="Your Name"
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                @enderror
            </div>
            
            <p class="text-gray-500">Affiliate {{ ucfirst($user->level) }}</p>
            
            <div class="mt-4 w-full">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium">Tahap Affiliate</span>
                    <span class="text-sm">{{ ucfirst($user->level) }} ({{ $user->xp_points }}/1000 XP)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="
                        {{ $user->level == 'bronze' ? 'bg-yellow-600' : 
                           ($user->level == 'silver' ? 'bg-gray-400' : 
                            ($user->level == 'gold' ? 'bg-yellow-400' : 'bg-purple-500')) }} 
                        h-2.5 rounded-full" 
                        style="width: {{ min(($user->xp_points / 1000) * 100, 100) }}%">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="space-y-4 mt-4">
            <h3 class="text-lg font-medium">Maklumat Akaun</h3>
            
            <div class="space-y-3">
                <div class="flex flex-col">
                    <label class="text-gray-600 mb-1 text-sm">E-mel</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="email@example.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Nombor Telefon</span>
                    <span class="font-medium">+60{{ $user->phone_number }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Ahli Sejak</span>
                    <span class="font-medium">{{ $user->joined_at->format('d M Y') }}</span>
                </div>
                
                <div class="flex flex-col">
                    <label class="text-gray-600 mb-1 text-sm">Kaedah Pembayaran</label>
                    <select 
                        name="payment_method" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <option value="">Pilih kaedah pembayaran</option>
                        <option value="paypal" {{ old('payment_method', $user->payment_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="bank_transfer" {{ old('payment_method', $user->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Pemindahan Bank</option>
                        <option value="ewallet" {{ old('payment_method', $user->payment_method) == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Kod Rujukan</span>
                    <span class="font-medium">{{ $user->referral_code }}</span>
                </div>
            </div>
        </div>
        
        <div class="mt-6 flex justify-between">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Kembali</a>
            
            <button 
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Preview profile image before upload
        $('#profile_pic').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(this).siblings('img').attr('src', e.target.result);
                }.bind(this);
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush