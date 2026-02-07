<x-layouts.dashboard>
    <x-slot name="header">Aktivite Logları</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Loglar</h1>
        <p class="text-slate-500 mt-1">Sistem üzerindeki tüm değişiklikleri ve işlemleri izleyin</p>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Tarih</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Kullanıcı</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">İşlem</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Model / ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">IP / Cihaz</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($logs as $log)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm font-medium text-slate-700">{{ $log->created_at->format('d.m.Y H:i') }}</p>
                        <p class="text-[10px] text-slate-400 font-mono">{{ $log->created_at->diffForHumans() }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center text-[10px] font-bold">
                                {{ substr($log->user->name ?? 'S', 0, 1) }}
                            </div>
                            <span class="text-xs text-slate-600 font-medium">{{ $log->user->name ?? 'Sistem' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                            {{ $log->action === 'create' ? 'bg-green-50 text-green-700 border border-green-100' : '' }}
                            {{ $log->action === 'update' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                            {{ $log->action === 'delete' ? 'bg-red-50 text-red-700 border border-red-100' : '' }}
                            {{ in_array($log->action, ['login', 'logout']) ? 'bg-slate-50 text-slate-700 border border-slate-100' : '' }}
                        ">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($log->model_type)
                            <p class="text-xs text-slate-700 font-medium">{{ class_basename($log->model_type) }}</p>
                            <p class="text-[10px] text-slate-400 font-mono">ID: {{ $log->model_id }}</p>
                        @else
                            <span class="text-[10px] text-slate-400 italic">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-xs text-slate-500 font-mono">{{ $log->ip_address }}</p>
                        <p class="text-[10px] text-slate-400 truncate max-w-[150px]" title="{{ $log->user_agent }}">{{ $log->user_agent }}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</x-layouts.dashboard>
