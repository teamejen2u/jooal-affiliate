<!-- resources/views/rewards/index.blade.php -->
@extends('layouts.app')

@section('title', 'Rewards')

@section('content')
<div class="p-4 space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Ganjaran</h2>
        <div class="text-sm font-medium bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
            {{ $user->xp_points }} Mata
        </div>
    </div>
    
    <div class="grid grid-cols-1 gap-4">
        @foreach($rewards as $reward)
            <div class="bg-white rounded-xl p-4 shadow-sm">
                @include('components.reward-card', ['reward' => $reward])
            </div>
        @endforeach
    </div>
    
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-4 text-white">
        <div class="flex items-center">
            <div class="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                <i data-lucide="gift" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-medium">Jemput Rakan & Dapatkan Ganjaran</h3>
                <p class="text-sm opacity-80">Dapat 500 mata setiap rujukan</p>
            </div>
        </div>
        <button 
            id="get-referral-link"
            class="mt-4 w-full bg-white text-indigo-600 py-2 rounded-lg font-medium text-sm"
        >
            Dapatkan Pautan Rujukan
        </button>
    </div>
    
    <!-- Referral Link Modal -->
    <div id="referral-modal" class="fixed inset-0 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md relative z-10">
                <h3 class="text-lg font-medium mb-4">Pautan Rujukan Anda</h3>
                <div class="flex">
                    <input 
                        type="text" 
                        id="referral-link" 
                        value="{{ route('login') }}?ref={{ $user->referral_code }}" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        readonly
                    >
                    <button 
                        id="copy-link" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg"
                    >
                        <i data-lucide="copy" class="w-5 h-5"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-500 mt-2">Kongsi pautan ini dengan rakan-rakan anda untuk mendapatkan 500 mata untuk setiap pendaftaran.</p>
                <button id="close-modal" class="mt-4 w-full py-2 border border-gray-300 rounded-lg text-gray-700">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Referral link modal
        $('#get-referral-link').click(function() {
            $('#referral-modal').removeClass('hidden');
        });
        
        $('#close-modal').click(function() {
            $('#referral-modal').addClass('hidden');
        });
        
        // Click outside to close
        $(document).mouseup(function(e) {
            const container = $("#referral-modal > div > div:last-child");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('#referral-modal').addClass('hidden');
            }
        });
        
        // Copy referral link
        $('#copy-link').click(function() {
            const copyText = document.getElementById("referral-link");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            
            // Show copied message
            $(this).html('<i data-lucide="check" class="w-5 h-5"></i>');
            lucide.createIcons();
            
            setTimeout(() => {
                $(this).html('<i data-lucide="copy" class="w-5 h-5"></i>');
                lucide.createIcons();
            }, 2000);
        });
    });
</script>
@endpush