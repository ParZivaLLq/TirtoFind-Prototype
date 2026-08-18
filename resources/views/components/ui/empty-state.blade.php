@props([
    'title' => 'Tidak ada data ditemukan',
    'description' => 'Belum ada data barang atau laporan yang tersedia saat ini.',
    'icon' => 'inbox'
])

<div {{ $attributes->merge(['class' => 'p-12 text-center border border-dashed border-border-subtle rounded-2xl bg-surface-container-low/50 space-y-3']) }}>
    <div class="w-14 h-14 bg-surface-container text-outline rounded-full flex items-center justify-center mx-auto">
        <span class="material-symbols-outlined text-3xl">{{ $icon }}</span>
    </div>
    <h3 class="text-base font-bold text-on-background">{{ $title }}</h3>
    <p class="text-xs text-on-surface-variant max-w-sm mx-auto leading-relaxed">{{ $description }}</p>
    @if(trim($slot))
        <div class="pt-2">
            {{ $slot }}
        </div>
    @endif
</div>
