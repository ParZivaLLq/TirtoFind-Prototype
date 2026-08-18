@props([
    'label' => null,
    'error' => null
])

<div class="space-y-1">
    @if($label)
        <label class="block text-xs font-semibold text-on-surface">{{ $label }}</label>
    @endif
    <select {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 bg-white rounded-xl border text-sm transition-all focus:outline-none focus:ring-2 focus:ring-primary/20 ' . ($error ? 'border-red-500 focus:border-red-500' : 'border-border-subtle focus:border-primary')]) }}>
        {{ $slot }}
    </select>
    @if($error)
        <p class="text-xs text-red-600 font-medium mt-0.5">{{ $error }}</p>
    @endif
</div>
