<!-- resources/views/brands/index.blade.php -->
@extends('layouts.app')

@section('title', 'Brands')

@section('content')
<div class="p-4 space-y-6">
    <h2 class="text-xl font-bold mb-4">Jenama Rakan Kongsi</h2>
    
    <div class="grid grid-cols-1 gap-4">
        @foreach($brands as $brand)
            <div class="bg-white rounded-xl p-4 shadow-sm">
                @include('components.brand-card', ['brand' => $brand])
            </div>
        @endforeach
    </div>
    
    <!-- Affiliate Link Modal -->
    <div id="link-modal" class="fixed inset-0 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md relative z-10">
                <h3 class="text-lg font-medium mb-2" id="modal-brand-name">Pautan Affiliate</h3>
                <p class="text-sm text-gray-500 mb-4">Salin pautan di bawah dan kongsikan dengan pelanggan anda.</p>
                
                <div class="flex">
                    <input 
                        type="text" 
                        id="affiliate-link" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        readonly
                    >
                    <button 
                        id="copy-affiliate-link" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg"
                    >
                        <i data-lucide="copy" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="mt-4 bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Info Komisyen:</p>
                    <p class="text-sm" id="modal-commission">Komisen: </p>
                </div>
                
                <button id="close-link-modal" class="mt-4 w-full py-2 border border-gray-300 rounded-lg text-gray-700">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Generate affiliate link
        $('.generate-link').click(function() {
            const brandId = $(this).data('brand-id');
            const brandName = $(this).closest('.flex').find('h3').text();
            const commission = $(this).closest('.flex').find('p:contains("Komisen")').text();
            
            $.ajax({
                url: `/brands/${brandId}/generate-link`,
                type: 'POST',
                beforeSend: function() {
                    $(this).prop('disabled', true).text('Memproses...');
                }.bind(this),
                success: function(response) {
                    // Show modal with link
                    $('#modal-brand-name').text(`Pautan Affiliate: ${brandName}`);
                    $('#modal-commission').text(commission);
                    $('#affiliate-link').val(response.link);
                    $('#link-modal').removeClass('hidden');
                    
                    // Re-enable button
                    $(this).prop('disabled', false).text('Dapatkan Pautan');
                }.bind(this),
                error: function() {
                    alert('Gagal menjana pautan. Sila cuba lagi.');
                    $(this).prop('disabled', false).text('Dapatkan Pautan');
                }.bind(this)
            });
        });
        
        // Close modal
        $('#close-link-modal').click(function() {
            $('#link-modal').addClass('hidden');
        });
        
        // Click outside to close
        $(document).mouseup(function(e) {
            const container = $("#link-modal > div > div:last-child");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('#link-modal').addClass('hidden');
            }
        });
        
        // Copy affiliate link
        $('#copy-affiliate-link').click(function() {
            const copyText = document.getElementById("affiliate-link");
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