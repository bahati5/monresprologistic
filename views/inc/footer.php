        <footer class="footer text-center">
            &copy <?php echo date('Y') . ' ' . $core->site_name; ?> - <?php echo $lang['foot'] ?>
        </footer>


        <script src="assets/template/assets/libs/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap tether Core JavaScript -->
        <script src="assets/template/assets/libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="assets/template/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- apps -->
        <script src="assets/template/dist/js/app.min.js"></script>
        <script src="assets/template/dist/js/app.init.js"></script>
        <script src="assets/template/dist/js/app-style-switcher.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="assets/template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
        <script src="assets/template/assets/extra-libs/sparkline/sparkline.js"></script>
        <!--Wave Effects -->
        <script src="assets/template/dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="assets/template/dist/js/sidebarmenu.js"></script> 
        <!--Custom JavaScript -->
        <script src="assets/template/dist/js/feather.min.js"></script>
        <script src="assets/template/dist/js/custom.min.js"></script>


        <script src="assets/template/assets/extra-libs/chart.js-2.8/Chart.min.js"></script>

        <script src="dataJs/load_notifications_all.js"> </script>

        <script src="assets/template/dist/js/global.js"></script>

        <!-- start - This is for export functionality only -->
      
         <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

        <script src="assets/template/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

        <!-- Chart.js 4 (modern, loaded alongside legacy Chart.js 2.8 for transition) -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

        <!-- Note: Alpine.js is loaded in head_scripts.php -->

        <!-- Initialize Lucide Icons (DOMContentLoaded for initial load) -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
            // Re-initialize icons after AJAX content loads
            document.addEventListener('ajaxComplete', function() {
                if (typeof lucide !== 'undefined') lucide.createIcons();
                if (typeof feather !== 'undefined') feather.replace();
            });
        </script>

        <!-- Fallback: ensure Bootstrap tabs/pills and modals work even if data-api fails -->
        <script>
        $(document).ready(function() {
            // Force-bind tab/pill clicks via jQuery delegation
            $(document).off('click.bs.tab.data-api').on('click.bs.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            // Force-bind modal triggers via jQuery delegation
            $(document).off('click.bs.modal.data-api').on('click.bs.modal.data-api', '[data-toggle="modal"]', function(e) {
                e.preventDefault();
                var target = $(this).attr('data-target') || $(this).attr('href');
                if (target) {
                    $(target).modal('show');
                }
            });
        });
        </script>

        <!-- Global Alpine.js utilities -->
        <script>
            document.addEventListener('alpine:init', () => {
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

            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    if (typeof Alpine !== 'undefined' && Alpine.store('toasts')) {
                        Alpine.store('toasts').add('Copié !', 'success', 2000);
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


