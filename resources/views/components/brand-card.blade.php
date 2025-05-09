<!-- resources/views/components/brand-card.blade.php -->
<div class="flex items-center">
    <div class="h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden mr-4">
        @if($brand->logo)
            <img src="{{ asset('storage/brands/' . $brand->logo) }}" alt="{{ $brand->name }}" class="w-12 h-12 object-contain">
        @else
            <img src="{{ asset('images/default-brand.png') }}" alt="{{ $brand->name }}" class="w-12 h-12 object-contain">
        @endif
    </div>
    <div class="flex-1">
        <h3 class="font-medium">{{ $brand->name }}</h3>
        <p class="text-sm text-gray-500">Komisen: {{ $brand->commission_rate }}</p>
        <div class="flex items-center mt-1">
            <div class="w-2 h-2 rounded-full bg-green-500 mr-1"></div>
            <span class="text-xs text-green-600">Aktif</span>
        </div>
    </div>
    <button 
        class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-medium generate-link"
        data-brand-id="{{ $brand->id }}"
    >
        Dapatkan Pautan
    </button>
</div>