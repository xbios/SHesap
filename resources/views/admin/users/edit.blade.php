<x-layouts.dashboard>
    <x-slot name="header">Kullanıcı Düzenle</x-slot>

    <div class="max-w-3xl">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('users.index') }}" class="p-2 text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Kullanıcı Düzenle</h1>
                <p class="text-slate-500 mt-1">{{ $user->name }} profilini güncelleyin</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Ad Soyad</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">E-posta Adresi</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg">
                        <p class="text-sm font-medium text-slate-800 mb-2">Şifre Güncelleme</p>
                        <p class="text-xs text-slate-500 mb-4">Şifreyi değiştirmek istemiyorsanız alanları boş bırakın.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Yeni Şifre</label>
                                <input type="password" name="password" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                                @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Şifre Tekrar</label>
                                <input type="password" name="password_confirmation" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Roller</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($roles as $role)
                            <label class="flex items-center gap-2 p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                    {{ in_array($role->id, old('roles', $userRoleIds)) ? 'checked' : '' }}
                                    class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                <span class="text-sm text-slate-700">{{ $role->name }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('roles') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <button type="button" x-data @click="$dispatch('confirm-dialog', {
                        title: 'Kullanıcıyı Sil',
                        message: 'Bu kullanıcıyı silmek istediğinizden emin misiniz?',
                        action: () => document.getElementById('delete-form').submit()
                    })" class="text-red-600 text-sm font-medium hover:underline">Hesabı Sil</button>

                    <div class="flex gap-3">
                        <a href="{{ route('users.index') }}" class="px-6 py-2 text-slate-700 font-medium hover:bg-slate-100 rounded-lg transition-colors">Vazgeç</a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">Yeniden Kaydet</button>
                    </div>
                </div>
            </form>

            <form id="delete-form" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    <x-confirm-dialog />
</x-layouts.dashboard>
