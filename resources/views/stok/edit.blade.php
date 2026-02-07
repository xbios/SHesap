<x-layouts.dashboard>
    <x-slot name="header">Stok Kartı Düzenle</x-slot>

    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('stok.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Stok Kartı Düzenle</h1>
            <p class="text-slate-500 mt-1">{{ $stok->STOKKOD }} - {{ $stok->STOKADI }}</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('stok.update', $stok->SSTOKID) }}" method="POST" class="space-y-6 pb-12">
        @csrf
        @method('PUT')

        <!-- Temel Bilgiler Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Temel Stok Bilgileri
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Stok Kodu -->
                <div>
                    <label for="STOKKOD" class="block text-sm font-medium text-slate-700 mb-1">Stok Kodu *</label>
                    <input type="text" id="STOKKOD" name="STOKKOD" value="{{ old('STOKKOD', $stok->STOKKOD) }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('STOKKOD') border-red-500 @enderror">
                    @error('STOKKOD') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- E-Ticaret Kodu -->
                <div>
                    <label for="ETICARETKOD" class="block text-sm font-medium text-slate-700 mb-1">E-Ticaret Kodu</label>
                    <input type="text" id="ETICARETKOD" name="ETICARETKOD" value="{{ old('ETICARETKOD', $stok->ETICARETKOD) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Stok Adı -->
                <div class="lg:col-span-2">
                    <label for="STOKADI" class="block text-sm font-medium text-slate-700 mb-1">Stok Adı *</label>
                    <input type="text" id="STOKADI" name="STOKADI" value="{{ old('STOKADI', $stok->STOKADI) }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('STOKADI') border-red-500 @enderror">
                    @error('STOKADI') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Perakende Stok Adı -->
                <div>
                    <label for="STOKADI_PRKND" class="block text-sm font-medium text-slate-700 mb-1">Perakende Stok Adı</label>
                    <input type="text" id="STOKADI_PRKND" name="STOKADI_PRKND" value="{{ old('STOKADI_PRKND', $stok->STOKADI_PRKND) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Gruplama ve Birimler Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01" />
                    </svg>
                    Gruplama
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="STOKGRP1" class="block text-sm font-medium text-slate-700 mb-1">Grup 1</label>
                        <input type="text" id="STOKGRP1" name="STOKGRP1" value="{{ old('STOKGRP1', $stok->STOKGRP1) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="STOKGRP2" class="block text-sm font-medium text-slate-700 mb-1">Grup 2</label>
                        <input type="text" id="STOKGRP2" name="STOKGRP2" value="{{ old('STOKGRP2', $stok->STOKGRP2) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Birimler ve Kritik Seviye
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="STBIRIM" class="block text-sm font-medium text-slate-700 mb-1">Ana Birim</label>
                        <input type="text" id="STBIRIM" name="STBIRIM" value="{{ old('STBIRIM', $stok->STBIRIM) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="STBIRIM2" class="block text-sm font-medium text-slate-700 mb-1">Birim 2</label>
                        <input type="text" id="STBIRIM2" name="STBIRIM2" value="{{ old('STBIRIM2', $stok->STBIRIM2) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="STBIRIM2KATSAYI" class="block text-sm font-medium text-slate-700 mb-1">Kayıt Katsayısı</label>
                        <input type="number" step="any" id="STBIRIM2KATSAYI" name="STBIRIM2KATSAYI" value="{{ old('STBIRIM2KATSAYI', $stok->STBIRIM2KATSAYI) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="STKRITIK" class="block text-sm font-medium text-slate-700 mb-1">Kritik Stok</label>
                        <input type="number" step="any" id="STKRITIK" name="STKRITIK" value="{{ old('STKRITIK', $stok->STKRITIK) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Fiyatlandırma ve KDV Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Fiyatlandırma ve KDV
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Alış Fiyatı -->
                <div>
                    <label for="STALISFIYAT" class="block text-sm font-medium text-slate-700 mb-1">Alış Fiyatı</label>
                    <input type="number" step="any" id="STALISFIYAT" name="STALISFIYAT" value="{{ old('STALISFIYAT', $stok->STALISFIYAT) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Satış Fiyatı 1 -->
                <div>
                    <label for="STSATISFIYAT1" class="block text-sm font-medium text-slate-700 mb-1">Satış Fiyatı 1</label>
                    <input type="number" step="any" id="STSATISFIYAT1" name="STSATISFIYAT1" value="{{ old('STSATISFIYAT1', $stok->STSATISFIYAT1) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Satış Fiyatı 2 -->
                <div>
                    <label for="STSATISFIYAT2" class="block text-sm font-medium text-slate-700 mb-1">Satış Fiyatı 2</label>
                    <input type="number" step="any" id="STSATISFIYAT2" name="STSATISFIYAT2" value="{{ old('STSATISFIYAT2', $stok->STSATISFIYAT2) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- İskonto -->
                <div>
                    <label for="STISKONTO" class="block text-sm font-medium text-slate-700 mb-1">Genel İskonto (%)</label>
                    <input type="number" step="any" id="STISKONTO" name="STISKONTO" value="{{ old('STISKONTO', $stok->STISKONTO) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- KDV -->
                <div>
                    <label for="STKDV" class="block text-sm font-medium text-slate-700 mb-1">KDV Oranı (%)</label>
                    <select id="STKDV" name="STKDV" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="0" {{ old('STKDV', $stok->STKDV) == 0 ? 'selected' : '' }}>%0</option>
                        <option value="1" {{ old('STKDV', $stok->STKDV) == 1 ? 'selected' : '' }}>%1</option>
                        <option value="10" {{ old('STKDV', $stok->STKDV) == 10 ? 'selected' : '' }}>%10</option>
                        <option value="20" {{ old('STKDV', $stok->STKDV) == 20 ? 'selected' : '' }}>%20</option>
                    </select>
                </div>

                <!-- KDV 2 -->
                <div>
                    <label for="STKDV2" class="block text-sm font-medium text-slate-700 mb-1">KDV 2 Oranı (%)</label>
                    <input type="number" step="any" id="STKDV2" name="STKDV2" value="{{ old('STKDV2', $stok->STKDV2) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('stok.index') }}" class="px-6 py-2.5 text-slate-700 font-medium hover:text-slate-900 transition-colors">
                İptal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/30">
                Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</x-layouts.dashboard>
