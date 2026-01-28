@props([
    'title' => 'Emin misiniz?',
    'message' => 'Bu işlem geri alınamaz.',
    'confirmText' => 'Evet, Sil',
    'cancelText' => 'İptal',
    'confirmClass' => 'bg-red-600 hover:bg-red-700',
])

<div
    x-data="{
        show: false,
        action: null,
        title: '{{ $title }}',
        message: '{{ $message }}',
        open(options = {}) {
            if (options.title) this.title = options.title;
            if (options.message) this.message = options.message;
            if (options.action) this.action = options.action;
            this.show = true;
        },
        close() {
            this.show = false;
            this.action = null;
        },
        confirm() {
            if (this.action) {
                this.action();
            }
            this.close();
        }
    }"
    x-on:confirm-dialog.window="open($event.detail)"
    x-show="show"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm"
        @click="close()"
    ></div>

    <!-- Dialog -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden"
            @click.stop
        >
            <div class="p-6">
                <!-- Icon -->
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="mt-4 text-center">
                    <h3 class="text-lg font-semibold text-slate-900" x-text="title"></h3>
                    <p class="mt-2 text-sm text-slate-500" x-text="message"></p>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex gap-3">
                    <button
                        @click="close()"
                        type="button"
                        class="flex-1 px-4 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors"
                    >
                        {{ $cancelText }}
                    </button>
                    <button
                        @click="confirm()"
                        type="button"
                        class="flex-1 px-4 py-2.5 text-sm font-medium text-white {{ $confirmClass }} rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                    >
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
