<x-layouts.dashboard>
    <x-slot name="header">Yeni Cari Hesap</x-slot>

    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('cari.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Yeni Cari Hesap</h1>
            <p class="text-slate-500 mt-1">Yeni bir cari hesap oluşturun</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('cari.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Temel Bilgiler</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cari Kodu -->
                <div>
                    <label for="CRKOD" class="block text-sm font-medium text-slate-700 mb-1">Cari Kodu *</label>
                    <input type="text" id="CRKOD" name="CRKOD" value="{{ old('CRKOD') }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('CRKOD') border-red-500 @enderror">
                    @error('CRKOD')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cari İsim -->
                <div>
                    <label for="CRISIM" class="block text-sm font-medium text-slate-700 mb-1">Cari İsim *</label>
                    <input type="text" id="CRISIM" name="CRISIM" value="{{ old('CRISIM') }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('CRISIM') border-red-500 @enderror">
                    @error('CRISIM')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Yetkili -->
                <div>
                    <label for="CRYETKILI" class="block text-sm font-medium text-slate-700 mb-1">Yetkili</label>
                    <input type="text" id="CRYETKILI" name="CRYETKILI" value="{{ old('CRYETKILI') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Rota -->
                <div>
                    <label for="CRROTA" class="block text-sm font-medium text-slate-700 mb-1">Rota</label>
                    <input type="text" id="CRROTA" name="CRROTA" value="{{ old('CRROTA') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">İletişim Bilgileri</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Adres -->
                <div class="md:col-span-2">
                    <label for="CRADRES" class="block text-sm font-medium text-slate-700 mb-1">Adres</label>
                    <textarea id="CRADRES" name="CRADRES" rows="2"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('CRADRES') }}</textarea>
                </div>

                <!-- Şehir -->
                <div>
                    <label for="CRSEHIR" class="block text-sm font-medium text-slate-700 mb-1">Şehir</label>
                    <input type="text" id="CRSEHIR" name="CRSEHIR" value="{{ old('CRSEHIR') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="CREMAIL" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" id="CREMAIL" name="CREMAIL" value="{{ old('CREMAIL') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('CREMAIL') border-red-500 @enderror">
                    @error('CREMAIL')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telefon -->
                <div>
                    <label for="CRTEL" class="block text-sm font-medium text-slate-700 mb-1">Telefon</label>
                    <input type="text" id="CRTEL" name="CRTEL" value="{{ old('CRTEL') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Telefon 2 -->
                <div>
                    <label for="CRTEL2" class="block text-sm font-medium text-slate-700 mb-1">Telefon 2</label>
                    <input type="text" id="CRTEL2" name="CRTEL2" value="{{ old('CRTEL2') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- GSM -->
                <div>
                    <label for="CRGSM" class="block text-sm font-medium text-slate-700 mb-1">GSM</label>
                    <input type="text" id="CRGSM" name="CRGSM" value="{{ old('CRGSM') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Vergi Bilgileri</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Vergi Dairesi -->
                <div>
                    <label for="CRVERGD" class="block text-sm font-medium text-slate-700 mb-1">Vergi Dairesi</label>
                    <input type="text" id="CRVERGD" name="CRVERGD" value="{{ old('CRVERGD') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Vergi No -->
                <div>
                    <label for="CRVERGNO" class="block text-sm font-medium text-slate-700 mb-1">Vergi No</label>
                    <input type="text" id="CRVERGNO" name="CRVERGNO" value="{{ old('CRVERGNO') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('cari.index') }}" class="px-6 py-2.5 text-slate-700 font-medium hover:text-slate-900 transition-colors">
                İptal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                Kaydet
            </button>
        </div>
    </form>
</x-layouts.dashboard>
