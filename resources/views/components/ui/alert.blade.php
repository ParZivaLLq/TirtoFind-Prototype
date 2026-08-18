@props([
    'type' => 'info', // info, success, warning, danger
    'title' => null,
])

@php
$types = [
    'info' => 'bg-blue-50 text-blue-800 border-blue-200 icon-info',
    'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200 icon-check_circle',
    'warning' => 'bg-amber-50 text-amber-800 border-amber-200 icon-warning',
    'danger' => 'bg-red-50 text-red-800 border-red-200 icon-error',
];

$iconNames = [
    'info' => 'info',
    'success' => 'check_circle',
    'warning' => 'warning',
    'danger' => 'error',
];

$class = $types[$type] ?? $types['info'];
$icon = $iconNames[$type] ?? 'info';
@endphp

<div {{ $attributes->merge(['class' => 'p-4 rounded-xl border text-xs md:text-sm flex items-start gap-3 ' . $class]) }}>
    <span class="material-symbols-outlined text-lg flex-shrink-0 mt-0.5">{{ $icon }}</span>
    <div>
        @if($title)
            <div class="font-bold mb-0.5">{{ $title }}</div>
        @endif
        <div class="leading-relaxed">{{ $slot }}</div>
    </div>
</div>
