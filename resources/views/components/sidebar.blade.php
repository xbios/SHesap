@props([
    'items' => []
])

@php
use App\Models\Role;

// Varsayılan menü yapısı - rol bazlı filtreleme uygulanır
$defaultItems = [
    [
        'name' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>',
        'roles' => null, // Herkes görebilir
    ],
    [
        'name' => 'Cari Hesaplar',
        'route' => 'cari.index',
        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
        'roles' => null, // Herkes görebilir
    ],
    [
        'name' => 'Stoklar',
        'route' => 'stok.index',
        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>',
        'roles' => null, // Herkes görebilir
    ],
];

$menuItems = count($items) > 0 ? $items : $defaultItems;
$user = auth()->user();
@endphp

<!-- Sidebar -->
<aside
    class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white z-40 transform transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <!-- Logo -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-700">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-lg font-bold">{{ config('app.name', 'SHesap') }}</span>
        </a>

        <!-- Close Button (Mobile) -->
        <button
            @click="sidebarOpen = false"
            class="lg:hidden p-1.5 rounded-lg hover:bg-slate-800 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="px-3 py-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        @foreach($menuItems as $item)
            @php
                $canView = true;

                // Rol kontrolü
                if (isset($item['roles']) && $item['roles'] !== null && $user) {
                    $canView = $user->hasRole($item['roles']);
                }

                // Yetki kontrolü
                if ($canView && isset($item['permission']) && $user) {
                    $canView = $user->hasPermission($item['permission']);
                }

                $isActive = request()->routeIs($item['route'] . '*');
            @endphp

            @if($canView)
                <a
                    href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group {{ $isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <span class="{{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' }}">
                        {!! $item['icon'] !!}
                    </span>
                    <span class="font-medium">{{ $item['name'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>
</aside>
