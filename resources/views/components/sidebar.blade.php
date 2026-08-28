<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed inset-y-0 left-0 z-40 w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col transition-transform duration-300 ease-in-out">

    <!-- Brand -->
    <div class="px-5 py-5 border-b border-slate-100 dark:border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-white text-lg">manage_search</span>
            </div>
            <div>
                <div class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight">TirtoFind</div>
                <div class="text-[10px] text-slate-400 font-medium">Admin Console</div>
            </div>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">
        @php
            $navItems = [
                ['route' => 'admin.dashboard',      'icon' => 'dashboard',       'label' => 'Dashboard',      'match' => 'admin.dashboard'],
                ['route' => 'admin.found-items.index', 'icon' => 'inventory_2',  'label' => 'Barang Temuan',  'match' => 'admin.found-items*'],
                ['route' => 'admin.lost-reports.index','icon' => 'report_problem','label' => 'Laporan Hilang','match' => 'admin.lost-reports*'],
                ['route' => 'admin.claims.index',    'icon' => 'verified',        'label' => 'Klaim',          'match' => 'admin.claims*'],
                ['route' => 'admin.categories.index','icon' => 'category',        'label' => 'Kategori',       'match' => 'admin.categories*'],
                ['route' => 'admin.users.index',     'icon' => 'group',           'label' => 'Pengguna',       'match' => 'admin.users*'],
                ['route' => 'admin.analytics.index', 'icon' => 'bar_chart',       'label' => 'Analitik',       'match' => 'admin.analytics*'],
                ['route' => 'admin.ai-matching.index','icon' => 'auto_awesome',   'label' => 'AI Matching',    'match' => 'admin.ai-matching*'],
                ['route' => 'admin.ai-auto-desc.index','icon' => 'psychology',    'label' => 'AI Auto Desc',   'match' => 'admin.ai-auto-desc*'],
            ];
        @endphp

        @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all
                      {{ $active
                         ? 'bg-blue-600 text-white shadow-sm'
                         : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                <span class="material-symbols-outlined text-lg shrink-0">{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Bottom: Settings & Support -->
    <div class="px-3 py-3 border-t border-slate-100 dark:border-slate-800 space-y-0.5">
        <a href="{{ route('admin.settings.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all
                  {{ request()->routeIs('admin.settings*') ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
            <span class="material-symbols-outlined text-lg shrink-0">settings</span>
            <span>Pengaturan</span>
        </a>
        <a href="{{ route('contact') }}" target="_blank"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all">
            <span class="material-symbols-outlined text-lg shrink-0">help</span>
            <span>Bantuan</span>
        </a>
    </div>
</aside>
