@props([
    'variant' => 'found', // found, lost, claimed, pending, danger, info
])

@php
$variants = [
    'found' => 'bg-emerald-500/10 text-emerald-700 border-emerald-500/20',
    'lost' => 'bg-amber-500/10 text-amber-700 border-amber-500/20',
    'claimed' => 'bg-blue-500/10 text-blue-700 border-blue-500/20',
    'pending' => 'bg-purple-500/10 text-purple-700 border-purple-500/20',
    'danger' => 'bg-red-500/10 text-red-700 border-red-500/20',
    'info' => 'bg-sky-500/10 text-sky-700 border-sky-500/20',
];

$classes = "inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold border " . ($variants[$variant] ?? $variants['found']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
