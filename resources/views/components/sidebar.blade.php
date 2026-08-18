<aside x-data="{ open: true }" 
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-100 border-r border-slate-200 dark:border-slate-800 flex flex-col transition-transform duration-300 ease-in-out">
    
    <!-- Header / Brand Console Title -->
    <div class="p-6 pb-4">
        <h1 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Admin Console</h1>
        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Terminal Tirtonadi Staff</p>
    </div>

    <!-- Nav Links (The Anchor) -->
    <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-lg">dashboard</span>
            <span>Dashboard</span>
        </a>

        <!-- Items -->
        <a href="{{ route('admin.found-items.index') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.found-items*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-lg">inventory_2</span>
            <span>Items</span>
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.lost-reports.index') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.lost-reports*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-lg">report_problem</span>
            <span>Reports</span>
        </a>

        <!-- Claims -->
        <a href="{{ route('admin.claims.index') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.claims*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-lg">verified</span>
            <span>Claims</span>
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.categories.index') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.categories*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-lg">category</span>
            <span>Categories</span>
        </a>

        <!-- Users -->
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-lg">group</span>
            <span>Users</span>
        </a>
    </nav>

    <!-- Bottom Sidebar Section -->
    <div class="p-3 border-t border-slate-200 dark:border-slate-800 space-y-1">
        <!-- Smart Matching Button -->
        <a href="{{ route('admin.ai-matching.index') }}" 
           class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 mb-2">
            <span class="material-symbols-outlined text-base">auto_awesome</span>
            <span>Smart Matching</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('admin.settings.index') }}" 
           class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.settings*') ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-lg">settings</span>
            <span>Settings</span>
        </a>

        <!-- Support -->
        <a href="{{ route('contact') }}" target="_blank"
           class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800 transition-all">
            <span class="material-symbols-outlined text-lg">help</span>
            <span>Support</span>
        </a>
    </div>
</aside>
