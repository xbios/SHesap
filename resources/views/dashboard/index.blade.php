<x-layouts.dashboard>
    <x-slot name="header">Dashboard</x-slot>

    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Hoş Geldiniz, {{ auth()->user()?->name ?? 'Kullanıcı' }}!</h1>
        <p class="text-slate-500 mt-1">İşte genel görünümünüz</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Toplam Kullanıcı</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">1,234</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">+12.5%</span>
                <span class="text-slate-400 ml-2">son 30 gün</span>
            </div>
        </div>

        <!-- Active Sessions -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Aktif Oturum</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">56</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">Çevrimiçi</span>
            </div>
        </div>

        <!-- Today's Logs -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Bugünkü Loglar</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">847</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-amber-600 font-medium">+23.1%</span>
                <span class="text-slate-400 ml-2">düne göre</span>
            </div>
        </div>

        <!-- System Health -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Sistem Durumu</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">Sağlıklı</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-emerald-600 font-medium">99.9%</span>
                <span class="text-slate-400 ml-2">uptime</span>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Son Aktiviteler</h3>
            </div>
            <div class="divide-y divide-slate-100">
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-medium">A</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-800">Admin kullanıcı giriş yaptı</p>
                        <p class="text-xs text-slate-500">5 dakika önce</p>
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-medium">+</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-800">Yeni kayıt oluşturuldu</p>
                        <p class="text-xs text-slate-500">12 dakika önce</p>
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-600 font-medium">!</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-800">Ayarlar güncellendi</p>
                        <p class="text-xs text-slate-500">1 saat önce</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Hızlı İşlemler</h3>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4">
                <button class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-8 h-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Yeni Kullanıcı</span>
                </button>
                <button class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-8 h-8 text-emerald-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Yeni Kayıt</span>
                </button>
                <button class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-8 h-8 text-amber-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Raporlar</span>
                </button>
                <button class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Ayarlar</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Confirm Dialog Component -->
    <x-confirm-dialog />
</x-layouts.dashboard>
