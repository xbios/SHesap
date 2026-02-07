<x-layouts.dashboard>
    <x-slot name="header">Yeni Rol Oluştur</x-slot>

    <div class="max-w-4xl">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('roles.index') }}" class="p-2 text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Yeni Rol</h1>
                <p class="text-slate-500 mt-1">Sistem için yeni bir yetki grubu tanımlayın</p>
            </div>
        </div>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Rol Adı</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Örn: Editör"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Slug (Sistem Adı)</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" required placeholder="Örn: editor"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Yetki Seçimi</h3>
                    
                    <div class="space-y-8">
                        @foreach($permissions as $group => $items)
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-100 pb-1">{{ $group }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($items as $permission)
                                <label class="flex items-center gap-2 p-3 border border-slate-100 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        {{ is_array(old('permissions')) && in_array($permission->id, old('permissions')) ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                    <span class="text-sm text-slate-700">{{ $permission->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('roles.index') }}" class="px-6 py-2 text-slate-700 font-medium hover:bg-slate-100 rounded-lg transition-colors">Vazgeç</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Rolü Kaydet</button>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
