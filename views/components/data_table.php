<?php
/**
 * Data Table Component — Responsive table with search, sort, pagination
 * 
 * @param array $params
 *   - id: string — Unique table ID
 *   - columns: array — [{key, label, sortable, class, width}]
 *   - data: array — Row data (array of associative arrays)
 *   - searchable: bool — Show search input
 *   - paginated: bool — Enable pagination
 *   - per_page: int — Items per page
 *   - empty_title: string — Empty state title
 *   - empty_description: string — Empty state description
 *   - actions: bool — Show actions column
 *   - row_link: string — PHP variable name for row link (e.g. 'view_url')
 */
function render_data_table($params = []) {
    $id          = $params['id'] ?? 'dt-' . uniqid();
    $columns     = $params['columns'] ?? [];
    $searchable  = $params['searchable'] ?? true;
    $paginated   = $params['paginated'] ?? true;
    $per_page    = $params['per_page'] ?? 15;
    $empty_title = $params['empty_title'] ?? 'Aucun résultat';
    $empty_desc  = $params['empty_description'] ?? 'Aucune donnée disponible pour le moment.';
    ?>
    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-overflow-hidden"
         x-data="{
            search: '',
            sortKey: '',
            sortAsc: true,
            page: 1,
            perPage: <?php echo intval($per_page); ?>,
            
            sort(key) {
                if (this.sortKey === key) { this.sortAsc = !this.sortAsc; }
                else { this.sortKey = key; this.sortAsc = true; }
            }
         }">
        
        <?php if ($searchable): ?>
        <!-- Search bar -->
        <div class="tw-px-5 tw-py-3 tw-border-b tw-border-gray-100">
            <div class="tw-relative tw-max-w-xs">
                <i data-lucide="search" class="tw-absolute tw-left-3 tw-top-1/2 tw--translate-y-1/2 tw-w-4 tw-h-4 tw-text-gray-400"></i>
                <input type="text" x-model="search" placeholder="Rechercher..."
                       class="tw-w-full tw-pl-9 tw-pr-4 tw-py-2 tw-text-sm tw-border tw-border-gray-200 tw-rounded-lg focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500/20 focus:tw-border-blue-300 tw-transition-all">
            </div>
        </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="tw-overflow-x-auto">
            <table class="tw-w-full tw-text-sm" id="<?php echo htmlspecialchars($id); ?>">
                <thead>
                    <tr class="tw-bg-gray-50/50">
                        <?php foreach ($columns as $col): ?>
                            <th class="tw-px-5 tw-py-3 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider tw-whitespace-nowrap <?php echo $col['class'] ?? ''; ?>"
                                <?php if (isset($col['width'])): ?>style="width: <?php echo htmlspecialchars($col['width']); ?>"<?php endif; ?>
                                <?php if (!empty($col['sortable'])): ?>
                                    @click="sort('<?php echo htmlspecialchars($col['key']); ?>')"
                                    class="tw-cursor-pointer hover:tw-text-gray-700 tw-select-none tw-px-5 tw-py-3 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider"
                                <?php endif; ?>>
                                <div class="tw-flex tw-items-center tw-gap-1">
                                    <?php echo htmlspecialchars($col['label'] ?? $col['key'] ?? ''); ?>
                                    <?php if (!empty($col['sortable'])): ?>
                                        <span class="tw-opacity-40" x-show="sortKey !== '<?php echo htmlspecialchars($col['key']); ?>'">
                                            <i data-lucide="chevrons-up-down" class="tw-w-3.5 tw-h-3.5"></i>
                                        </span>
                                        <span x-show="sortKey === '<?php echo htmlspecialchars($col['key']); ?>' && sortAsc">
                                            <i data-lucide="chevron-up" class="tw-w-3.5 tw-h-3.5 tw-text-blue-600"></i>
                                        </span>
                                        <span x-show="sortKey === '<?php echo htmlspecialchars($col['key']); ?>' && !sortAsc">
                                            <i data-lucide="chevron-down" class="tw-w-3.5 tw-h-3.5 tw-text-blue-600"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="tw-divide-y tw-divide-gray-100" id="<?php echo htmlspecialchars($id); ?>-body">
                    <!-- Rows will be rendered by PHP or AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($paginated): ?>
        <div class="tw-px-5 tw-py-3 tw-border-t tw-border-gray-100 tw-flex tw-items-center tw-justify-between">
            <p class="tw-text-xs tw-text-gray-500">
                Affichage de <span class="tw-font-medium tw-text-gray-700" x-text="((page - 1) * perPage) + 1"></span>
                à <span class="tw-font-medium tw-text-gray-700" x-text="Math.min(page * perPage, totalRows || 0)"></span>
                sur <span class="tw-font-medium tw-text-gray-700" x-text="totalRows || 0"></span>
            </p>
            <div class="tw-flex tw-items-center tw-gap-1">
                <button @click="if(page > 1) page--"
                        :disabled="page <= 1"
                        class="tw-px-2.5 tw-py-1.5 tw-text-xs tw-rounded-lg tw-border tw-border-gray-200 hover:tw-bg-gray-50 disabled:tw-opacity-40 disabled:tw-cursor-not-allowed tw-transition-colors">
                    <i data-lucide="chevron-left" class="tw-w-3.5 tw-h-3.5"></i>
                </button>
                <span class="tw-px-3 tw-py-1.5 tw-text-xs tw-font-medium tw-text-gray-700" x-text="page"></span>
                <button @click="page++"
                        class="tw-px-2.5 tw-py-1.5 tw-text-xs tw-rounded-lg tw-border tw-border-gray-200 hover:tw-bg-gray-50 tw-transition-colors">
                    <i data-lucide="chevron-right" class="tw-w-3.5 tw-h-3.5"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php
}
