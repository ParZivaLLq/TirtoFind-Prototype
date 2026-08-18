@props([
    'variant' => 'primary', // primary, secondary, danger, outline, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'icon' => null,
])

@php
$baseClasses = "inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer";

$variants = [
    'primary' => 'bg-primary-container text-white hover:bg-primary focus:ring-primary/40 shadow-xs',
    'secondary' => 'bg-surface-container-high text-on-surface hover:bg-surface-container-highest focus:ring-outline/30',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500/40 shadow-xs',
    'outline' => 'border border-border-subtle bg-white text-on-surface hover:bg-surface-container focus:ring-primary/20',
    'ghost' => 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface focus:ring-outline/20',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs gap-1.5',
    'md' => 'px-4 py-2 text-sm gap-2',
    'lg' => 'px-6 py-3 text-base gap-2.5',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
    @endif
    {{ $slot }}
</button>
