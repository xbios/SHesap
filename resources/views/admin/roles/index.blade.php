<x-layouts.dashboard>
    <x-slot name="header">Rol Yönetimi</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Roller</h1>
            <p class="text-slate-500 mt-1">Sistem rollerini ve yetkilerini yönetin</p>
        </div>
        <a href="{{ route('roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Yeni Rol Ekle
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($roles as $role)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('roles.edit', $role->id) }}" class="p-2 text-slate-400 hover:text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </a>
                </div>
            </div>
            <h3 class="text-lg font-bold text-slate-800">{{ $role->name }}</h3>
            <p class="text-xs font-mono text-slate-400 mb-4">{{ $role->slug }}</p>
            
            <p class="text-sm text-slate-600 mb-6 flex-grow">
                {{ $role->description ?? 'Bu rol için bir açıklama girilmedi.' }}
            </p>

            <div class="pt-4 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Yetkiler ({{ $role->permissions->count() }})</p>
                <div class="flex flex-wrap gap-1">
                    @forelse($role->permissions->take(5) as $permission)
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-medium rounded capitalize">
                            {{ $permission->name }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-400 italic">Hiç yetki atanmamış.</span>
                    @endforelse
                    @if($role->permissions->count() > 5)
                        <span class="text-[10px] text-slate-400 font-medium">+{{ $role->permissions->count() - 5 }} daha</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-layouts.dashboard>
