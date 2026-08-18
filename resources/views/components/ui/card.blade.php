@props([
    'hover' => true,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-border-subtle overflow-hidden ' . ($hover ? 'soft-shadow hover:border-primary transition-all duration-300' : 'shadow-xs')]) }}>
    {{ $slot }}
</div>
