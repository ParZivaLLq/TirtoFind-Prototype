@props([
    'label' => null,
    'icon' => null,
    'error' => null,
    'type' => 'text'
])

<div class="space-y-1">
    @if($label)
        <label class="block text-xs font-semibold text-on-surface">{{ $label }}</label>
    @endif
    <div class="relative">
        @if($icon)
            <span class="material-symbols-outlined absolute left-3 top-2.5 text-outline text-lg">{{ $icon }}</span>
        @endif
        <input type="{{ $type }}" {{ $attributes->merge(['class' => 'w-full py-2.5 rounded-xl border text-sm transition-all focus:outline-none focus:ring-2 focus:ring-primary/20 ' . ($icon ? 'pl-9 pr-4' : 'px-4') . ' ' . ($error ? 'border-red-500 focus:border-red-500' : 'border-border-subtle focus:border-primary')]) }} />
    </div>
    @if($error)
        <p class="text-xs text-red-600 font-medium mt-0.5">{{ $error }}</p>
    @endif
</div>
