@props(['language', 'label' => null, 'icon'=> false])

@if($language)
<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-black border tracking-wider ' . $language->getBadgeColor()]) }}>
    @if($icon)
    <i class="fa-solid fa-tag mr-1 text-[10px] opacity-70"></i>
    @endif

    @if($label)
    <span class="mr-1 text-[9px] uppercase opacity-70 font-bold">{{ $label }}:</span>
    @endif

    {{ strtoupper($language->code) }}
</span>
@endif