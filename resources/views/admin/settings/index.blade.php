<x-layouts.dashboard>
    <x-slot name="header">Sistem Ayarları</x-slot>

    <div class="max-w-4xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Sistem Ayarları</h1>
            <p class="text-slate-500 mt-1">Uygulama genelindeki yapılandırmaları yönetin</p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <div class="space-y-6 pb-12">
                @foreach($settingsGrouped as $group => $settings)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">{{ $group }}</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        @foreach($settings as $setting)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-slate-50 last:border-0 pb-6 last:pb-0">
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700">{{ $setting->label ?? $setting->key }}</label>
                                @if($setting->description)
                                    <p class="text-xs text-slate-400 mt-1">{{ $setting->description }}</p>
                                @endif
                                <p class="text-[10px] font-mono text-slate-300 mt-1">{{ $setting->key }}</p>
                            </div>
                            <div class="col-span-2">
                                @if($setting->type === 'boolean')
                                    <select name="{{ $setting->key }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Evet / Aktif</option>
                                        <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Hayır / Pasif</option>
                                    </select>
                                @elseif($setting->type === 'integer')
                                    <input type="number" name="{{ $setting->key }}" value="{{ $setting->value }}" 
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                @else
                                    <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" 
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="flex justify-end gap-3">
                    <button type="reset" class="px-6 py-2 text-slate-700 font-medium hover:bg-slate-100 rounded-lg transition-colors">Yüklenenleri Geri Al</button>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Ayarları Kaydet</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
