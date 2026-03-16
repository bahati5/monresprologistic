        </div>
        <!-- End Page wrapper -->
    </div>
    <!-- End Main Wrapper -->

    <!-- Footer -->
    <footer class="tw-py-4 tw-px-6 tw-text-center tw-text-xs tw-text-gray-400 tw-border-t tw-border-gray-100">
        &copy; <?php echo date('Y') . ' ' . $core->site_name; ?> - <?php echo $lang['foot']; ?>
    </footer>

    <!-- Note: Alpine.js is loaded in head_scripts.php -->

    <!-- Legacy JS (kept during transition) -->
    <script src="assets/template/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/template/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/template/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/template/dist/js/app.min.js"></script>
    <script src="assets/template/dist/js/app.init.js"></script>
    <script src="assets/template/dist/js/app-style-switcher.js"></script>
    <script src="assets/template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/template/assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="assets/template/dist/js/waves.js"></script>
    <script src="assets/template/dist/js/sidebarmenu.js"></script>
    <script src="assets/template/dist/js/feather.min.js"></script>
    <script src="assets/template/dist/js/custom.min.js"></script>

    <script src="dataJs/load_notifications_all.js"></script>
    <script src="assets/template/dist/js/global.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="assets/template/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        // Initialize on Turbo navigation as well
        document.addEventListener('turbo:load', function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>

    <!-- Global Alpine.js utilities -->
    <script>
        document.addEventListener('alpine:init', () => {
            // Toast notification store
            Alpine.store('toasts', {
                items: [],
                add(message, type = 'info', duration = 4000) {
                    const id = Date.now();
                    this.items.push({ id, message, type });
                    setTimeout(() => this.remove(id), duration);
                },
                remove(id) {
                    this.items = this.items.filter(item => item.id !== id);
                }
            });

            // Modal store
            Alpine.store('modal', {
                open: false,
                title: '',
                content: '',
                show(title, content) {
                    this.title = title;
                    this.content = content;
                    this.open = true;
                },
                close() {
                    this.open = false;
                    this.title = '';
                    this.content = '';
                }
            });
        });

        // Count-up animation utility
        function animateCountUp(el, target, duration = 1000) {
            let start = 0;
            const step = (timestamp) => {
                if (!start) start = timestamp;
                const progress = Math.min((timestamp - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target).toLocaleString();
                if (progress < 1) requestAnimationFrame(step);
                else el.textContent = target.toLocaleString();
            };
            requestAnimationFrame(step);
        }

        // Copy to clipboard utility
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                if (typeof Alpine !== 'undefined' && Alpine.store('toasts')) {
                    Alpine.store('toasts').add('Copié dans le presse-papiers !', 'success', 2000);
                }
            });
        }
    </script>

    <!-- Toast Notification Container -->
    <div x-data class="tw-fixed tw-bottom-4 tw-right-4 tw-z-[10000] tw-flex tw-flex-col-reverse tw-gap-2 tw-pointer-events-none">
        <template x-for="toast in $store.toasts.items" :key="toast.id">
            <div class="tw-pointer-events-auto toast-enter tw-flex tw-items-center tw-gap-3 tw-px-4 tw-py-3 tw-rounded-lg tw-shadow-lg tw-border tw-min-w-[280px]"
                 :class="{
                    'tw-bg-green-50 tw-border-green-200 tw-text-green-800': toast.type === 'success',
                    'tw-bg-red-50 tw-border-red-200 tw-text-red-800': toast.type === 'error',
                    'tw-bg-amber-50 tw-border-amber-200 tw-text-amber-800': toast.type === 'warning',
                    'tw-bg-blue-50 tw-border-blue-200 tw-text-blue-800': toast.type === 'info'
                 }">
                <i :data-lucide="toast.type === 'success' ? 'check-circle' : toast.type === 'error' ? 'alert-circle' : toast.type === 'warning' ? 'alert-triangle' : 'info'" class="tw-w-5 tw-h-5 tw-shrink-0"></i>
                <span x-text="toast.message" class="tw-text-sm tw-font-medium"></span>
                <button @click="$store.toasts.remove(toast.id)" class="tw-ml-auto tw-opacity-60 hover:tw-opacity-100">
                    <i data-lucide="x" class="tw-w-4 tw-h-4"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- Global Modal -->
    <div x-data x-show="$store.modal.open" x-cloak
         class="tw-fixed tw-inset-0 tw-z-[9998] tw-flex tw-items-center tw-justify-center tw-p-4"
         x-transition:enter="tw-transition tw-ease-out tw-duration-200"
         x-transition:enter-start="tw-opacity-0"
         x-transition:enter-end="tw-opacity-100"
         x-transition:leave="tw-transition tw-ease-in tw-duration-150"
         x-transition:leave-start="tw-opacity-100"
         x-transition:leave-end="tw-opacity-0">
        <div class="tw-fixed tw-inset-0 tw-bg-black/40 modal-backdrop-blur" @click="$store.modal.close()"></div>
        <div class="tw-relative tw-bg-white tw-rounded-xl tw-shadow-2xl tw-w-full tw-max-w-lg tw-max-h-[85vh] tw-overflow-y-auto"
             x-transition:enter="tw-transition tw-ease-out tw-duration-200"
             x-transition:enter-start="tw-opacity-0 tw-scale-95"
             x-transition:enter-end="tw-opacity-100 tw-scale-100"
             x-transition:leave="tw-transition tw-ease-in tw-duration-150"
             x-transition:leave-start="tw-opacity-100 tw-scale-100"
             x-transition:leave-end="tw-opacity-0 tw-scale-95">
            <div class="tw-flex tw-items-center tw-justify-between tw-px-6 tw-py-4 tw-border-b tw-border-gray-100">
                <h3 x-text="$store.modal.title" class="tw-text-lg tw-font-semibold tw-text-gray-800"></h3>
                <button @click="$store.modal.close()" class="tw-p-1 tw-rounded-lg hover:tw-bg-gray-100 tw-transition-colors">
                    <i data-lucide="x" class="tw-w-5 tw-h-5 tw-text-gray-400"></i>
                </button>
            </div>
            <div class="tw-px-6 tw-py-4" x-html="$store.modal.content"></div>
        </div>
    </div>

    <?php if (isset($extra_js)) echo $extra_js; ?>

</body>
</html>
