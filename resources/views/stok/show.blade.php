<x-layouts.dashboard>
    <x-slot name="header">Stok Kartı Detayı</x-slot>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('stok.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Stok Kartı Detayı</h1>
                <p class="text-slate-500 mt-1">{{ $stok->STOKKOD }} - {{ $stok->STOKADI }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('stok.edit', $stok->SSTOKID) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Düzenle
            </a>
            <form action="{{ route('stok.destroy', $stok->SSTOKID) }}" method="POST" class="inline" x-data
                @submit.prevent="$dispatch('confirm-dialog', {
                    title: 'Stok Kartını Sil',
                    message: 'Bu stok kartını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.',
                    action: () => $el.submit()
                })">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Sil
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Stok Bilgileri</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6">
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">Stok Kodu</p>
                        <p class="text-lg font-bold text-slate-800 mt-1">{{ $stok->STOKKOD }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">E-Ticaret Kodu</p>
                        <p class="text-lg font-medium text-slate-800 mt-1">{{ $stok->ETICARETKOD ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-slate-500 uppercase font-medium">Stok Adı</p>
                        <p class="text-lg font-medium text-slate-800 mt-1">{{ $stok->STOKADI }}</p>
                    </div>
                    @if($stok->STOKADI_PRKND)
                        <div class="sm:col-span-2">
                            <p class="text-xs text-slate-500 uppercase font-medium">Perakende Stok Adı</p>
                            <p class="text-slate-800 mt-1">{{ $stok->STOKADI_PRKND }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">Grup 1</p>
                        <p class="text-slate-800 mt-1">{{ $stok->STOKGRP1 ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">Grup 2</p>
                        <p class="text-slate-800 mt-1">{{ $stok->STOKGRP2 ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Fiyatlandırma -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Fiyatlandırma</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="p-4 bg-slate-50 rounded-lg">
                        <p class="text-xs text-slate-500 uppercase font-medium mb-1">Alış Fiyatı</p>
                        <p class="text-xl font-bold text-slate-800">{{ number_format($stok->STALISFIYAT, 2) }}</p>
                    </div>
                    <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-100">
                        <p class="text-xs text-indigo-500 uppercase font-medium mb-1">Satış Fiyatı 1</p>
                        <p class="text-xl font-bold text-indigo-700">{{ number_format($stok->STSATISFIYAT1, 2) }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-lg">
                        <p class="text-xs text-slate-500 uppercase font-medium mb-1">Satış Fiyatı 2</p>
                        <p class="text-xl font-bold text-slate-800">{{ number_format($stok->STSATISFIYAT2, 2) }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">KDV Oranı</p>
                        <p class="text-lg font-medium text-slate-800 mt-1">%{{ number_format($stok->STKDV, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">KDV 2</p>
                        <p class="text-lg font-medium text-slate-800 mt-1">%{{ number_format($stok->STKDV2, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">İskonto</p>
                        <p class="text-lg font-medium text-slate-800 mt-1">%{{ number_format($stok->STISKONTO, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Birim ve Durum</h2>
                <div class="space-y-6">
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">Ana Birim</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded">{{ $stok->STBIRIM ?? 'ADET' }}</span>
                        </div>
                    </div>
                    @if($stok->STBIRIM2)
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-medium">İkincil Birim</p>
                            <p class="text-slate-800 mt-1">{{ $stok->STBIRIM2 }} (1 {{ $stok->STBIRIM2 }} = {{ $stok->STBIRIM2KATSAYI }} {{ $stok->STBIRIM }})</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-medium">Kritik Seviye</p>
                        @if($stok->STKRITIK > 0)
                            <p class="text-lg font-medium text-amber-600 mt-1">{{ number_format($stok->STKRITIK, 2) }} {{ $stok->STBIRIM }}</p>
                        @else
                            <p class="text-slate-400 mt-1 italic text-sm">Tanımlanmamış</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Log Summary -->
            @php
                $activityLog = \App\Models\ActivityLog::where('model_type', get_class($stok))
                    ->where('model_id', $stok->SSTOKID)
                    ->latest()
                    ->first();
            @endphp
            @if($activityLog)
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Son İşlem</h2>
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700 capitalize">{{ $activityLog->action }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $activityLog->created_at->diffForHumans() }}</p>
                            <p class="text-xs text-slate-400 mt-1">Yapan: {{ $activityLog->user->name ?? 'Sistem' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('logs.index', ['model' => 'Stok', 'id' => $stok->SSTOKID]) }}" class="mt-4 block text-center text-xs text-indigo-600 hover:text-indigo-700 font-medium">
                        Tüm Geçmişi Gör →
                    </a>
                </div>
            @endif
        </div>
    </div>

    <x-confirm-dialog />
</x-layouts.dashboard>
