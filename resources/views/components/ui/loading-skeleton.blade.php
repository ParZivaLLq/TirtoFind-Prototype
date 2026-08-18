@props([
    'count' => 3
])

<div class="space-y-4 animate-pulse">
    @for($i = 0; $i < $count; $i++)
        <div class="h-16 bg-slate-200/70 rounded-xl w-full"></div>
    @endfor
</div>
