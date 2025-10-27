{{-- resources/views/partials/detail-row.blade.php --}}

<div class="flex items-start">
    <p class="w-1/3 text-sm font-medium text-gray-400">{{ $label }}:</p>
    <p class="w-2/3 text-base text-white font-bold">{{ $value }}
        @if(isset($subvalue) && $subvalue)
            <span class="text-gray-500 text-sm ml-2">({{ $subvalue }})</span>
        @endif
    </p>
</div>