<?php
/**
 * Cargo Photo Gallery Component — Photos with checkpoints and lightbox
 * 
 * @param array $params
 *   - photos: array — [{url, thumbnail, label, date, location, checkpoint}]
 *   - title: string — Gallery title
 *   - allow_upload: bool — Show upload button
 *   - upload_url: string — Upload endpoint
 */
function render_cargo_photo_gallery($params = []) {
    $photos       = $params['photos'] ?? [];
    $title        = $params['title'] ?? 'Photos de cargaison';
    $allow_upload = $params['allow_upload'] ?? false;
    $upload_url   = $params['upload_url'] ?? '';
    $gallery_id   = 'gallery-' . uniqid();
    ?>
    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-overflow-hidden"
         x-data="{ lightbox: false, currentIndex: 0, photos: <?php echo htmlspecialchars(json_encode(array_map(function($p) { return ['url' => $p['url'] ?? '', 'label' => $p['label'] ?? '', 'date' => $p['date'] ?? '', 'location' => $p['location'] ?? '']; }, $photos))); ?> }">
        
        <!-- Header -->
        <div class="tw-flex tw-items-center tw-justify-between tw-px-5 tw-py-3 tw-border-b tw-border-gray-100">
            <div class="tw-flex tw-items-center tw-gap-2">
                <i data-lucide="camera" class="tw-w-4 tw-h-4 tw-text-gray-500"></i>
                <h4 class="tw-text-sm tw-font-semibold tw-text-gray-700"><?php echo htmlspecialchars($title); ?></h4>
                <span class="tw-text-xs tw-text-gray-400">(<?php echo count($photos); ?>)</span>
            </div>
            <?php if ($allow_upload): ?>
                <button onclick="document.getElementById('photo-upload-<?php echo $gallery_id; ?>').click()"
                        class="tw-flex tw-items-center tw-gap-1.5 tw-px-3 tw-py-1.5 tw-text-xs tw-font-medium tw-rounded-lg tw-bg-blue-50 tw-text-blue-600 hover:tw-bg-blue-100 tw-transition-colors">
                    <i data-lucide="plus" class="tw-w-3.5 tw-h-3.5"></i>
                    Ajouter
                </button>
                <input type="file" id="photo-upload-<?php echo $gallery_id; ?>" accept="image/*" capture="environment" class="tw-hidden">
            <?php endif; ?>
        </div>

        <!-- Grid -->
        <?php if (!empty($photos)): ?>
        <div class="tw-p-4">
            <div class="tw-grid tw-grid-cols-2 sm:tw-grid-cols-3 md:tw-grid-cols-4 tw-gap-3">
                <?php foreach ($photos as $i => $photo): ?>
                    <div class="tw-group tw-relative tw-rounded-lg tw-overflow-hidden tw-cursor-pointer tw-aspect-square tw-bg-gray-100"
                         @click="currentIndex = <?php echo $i; ?>; lightbox = true">
                        <img src="<?php echo htmlspecialchars($photo['thumbnail'] ?? $photo['url'] ?? ''); ?>" 
                             alt="<?php echo htmlspecialchars($photo['label'] ?? ''); ?>"
                             class="tw-w-full tw-h-full tw-object-cover group-hover:tw-scale-105 tw-transition-transform tw-duration-300"
                             loading="lazy">
                        <!-- Overlay -->
                        <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-t tw-from-black/60 tw-to-transparent tw-opacity-0 group-hover:tw-opacity-100 tw-transition-opacity tw-duration-200">
                            <div class="tw-absolute tw-bottom-0 tw-left-0 tw-right-0 tw-p-2">
                                <?php if (!empty($photo['checkpoint'])): ?>
                                    <span class="tw-text-[10px] tw-text-white/80"><?php echo htmlspecialchars($photo['checkpoint']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($photo['date'])): ?>
                                    <p class="tw-text-[10px] tw-text-white/60"><?php echo htmlspecialchars($photo['date']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Checkpoint badge -->
                        <?php if (!empty($photo['checkpoint'])): ?>
                            <div class="tw-absolute tw-top-1.5 tw-left-1.5">
                                <span class="tw-inline-flex tw-items-center tw-px-1.5 tw-py-0.5 tw-rounded tw-text-[9px] tw-font-medium tw-bg-black/50 tw-text-white tw-backdrop-blur-sm">
                                    <?php echo htmlspecialchars($photo['checkpoint']); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
            <div class="tw-py-8 tw-text-center">
                <i data-lucide="image" class="tw-w-8 tw-h-8 tw-text-gray-300 tw-mx-auto tw-mb-2"></i>
                <p class="tw-text-sm tw-text-gray-400">Aucune photo disponible</p>
            </div>
        <?php endif; ?>

        <!-- Lightbox -->
        <div x-show="lightbox" x-cloak
             class="tw-fixed tw-inset-0 tw-z-[9999] tw-flex tw-items-center tw-justify-center tw-p-4"
             x-transition:enter="tw-transition tw-ease-out tw-duration-200"
             x-transition:enter-start="tw-opacity-0"
             x-transition:enter-end="tw-opacity-100"
             x-transition:leave="tw-transition tw-ease-in tw-duration-150"
             x-transition:leave-start="tw-opacity-100"
             x-transition:leave-end="tw-opacity-0"
             @keydown.escape.window="lightbox = false"
             @keydown.left.window="currentIndex = (currentIndex - 1 + photos.length) % photos.length"
             @keydown.right.window="currentIndex = (currentIndex + 1) % photos.length">
            
            <!-- Backdrop -->
            <div class="tw-fixed tw-inset-0 tw-bg-black/90" @click="lightbox = false"></div>
            
            <!-- Image -->
            <div class="tw-relative tw-max-w-4xl tw-max-h-[85vh] tw-w-full">
                <img :src="photos[currentIndex]?.url" :alt="photos[currentIndex]?.label" 
                     class="tw-mx-auto tw-max-h-[85vh] tw-object-contain tw-rounded-lg">
                
                <!-- Controls -->
                <button @click="lightbox = false" class="tw-absolute tw-top-2 tw-right-2 tw-p-2 tw-rounded-full tw-bg-white/10 hover:tw-bg-white/20 tw-text-white tw-transition-colors">
                    <i data-lucide="x" class="tw-w-5 tw-h-5"></i>
                </button>
                <button @click="currentIndex = (currentIndex - 1 + photos.length) % photos.length"
                        class="tw-absolute tw-left-2 tw-top-1/2 tw--translate-y-1/2 tw-p-2 tw-rounded-full tw-bg-white/10 hover:tw-bg-white/20 tw-text-white tw-transition-colors">
                    <i data-lucide="chevron-left" class="tw-w-6 tw-h-6"></i>
                </button>
                <button @click="currentIndex = (currentIndex + 1) % photos.length"
                        class="tw-absolute tw-right-2 tw-top-1/2 tw--translate-y-1/2 tw-p-2 tw-rounded-full tw-bg-white/10 hover:tw-bg-white/20 tw-text-white tw-transition-colors">
                    <i data-lucide="chevron-right" class="tw-w-6 tw-h-6"></i>
                </button>

                <!-- Info bar -->
                <div class="tw-absolute tw-bottom-0 tw-left-0 tw-right-0 tw-px-4 tw-py-3 tw-bg-gradient-to-t tw-from-black/60 tw-to-transparent tw-rounded-b-lg">
                    <p x-text="photos[currentIndex]?.label" class="tw-text-sm tw-font-medium tw-text-white"></p>
                    <div class="tw-flex tw-items-center tw-gap-3 tw-mt-0.5">
                        <span x-text="photos[currentIndex]?.date" class="tw-text-xs tw-text-white/70"></span>
                        <span x-text="photos[currentIndex]?.location" class="tw-text-xs tw-text-white/70"></span>
                    </div>
                    <p class="tw-text-xs tw-text-white/50 tw-mt-0.5" x-text="(currentIndex + 1) + ' / ' + photos.length"></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}
