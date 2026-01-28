<x-layouts.dashboard>
    <x-slot name="header">Cari Detay</x-slot>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('cari.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $cari->CRISIM }}</h1>
                <p class="text-slate-500 mt-1">Cari Kodu: {{ $cari->CRKOD }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('cari.edit', $cari->CRID) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Düzenle
            </a>
            <form action="{{ route('cari.destroy', $cari->CRID) }}" method="POST" class="inline" x-data
                @submit.prevent="$dispatch('confirm-dialog', {
                    title: 'Cari Hesabı Sil',
                    message: '{{ $cari->CRISIM }} silinecek. Bu işlem geri alınamaz. Emin misiniz?',
                    action: () => $el.submit()
                })">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Sil
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Temel Bilgiler -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Temel Bilgiler
            </h2>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">Cari Kodu</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRKOD }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">Cari İsim</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRISIM }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">Yetkili</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRYETKILI ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm text-slate-500">Rota</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRROTA ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- İletişim Bilgileri -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                İletişim Bilgileri
            </h2>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">Telefon</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRTEL ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">Telefon 2</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRTEL2 ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">GSM</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRGSM ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm text-slate-500">Email</dt>
                    <dd class="text-sm font-medium text-slate-800">
                        @if($cari->CREMAIL)
                            <a href="mailto:{{ $cari->CREMAIL }}" class="text-indigo-600 hover:text-indigo-700">{{ $cari->CREMAIL }}</a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Adres Bilgileri -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Adres Bilgileri
            </h2>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">Şehir</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRSEHIR ?? '-' }}</dd>
                </div>
                <div class="py-2">
                    <dt class="text-sm text-slate-500 mb-1">Adres</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRADRES ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Vergi Bilgileri -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                </svg>
                Vergi Bilgileri
            </h2>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <dt class="text-sm text-slate-500">Vergi Dairesi</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRVERGD ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm text-slate-500">Vergi No</dt>
                    <dd class="text-sm font-medium text-slate-800">{{ $cari->CRVERGNO ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <x-confirm-dialog />
</x-layouts.dashboard>
