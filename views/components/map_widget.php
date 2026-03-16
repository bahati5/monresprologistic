<?php
/**
 * Map Widget Component — Leaflet.js interactive map
 * 
 * @param array $params
 *   - id: string — Unique map container ID
 *   - height: string — CSS height (default: '300px')
 *   - center: array — [lat, lng]
 *   - zoom: int — Zoom level (default: 6)
 *   - markers: array — [{lat, lng, label, status, popup}]
 *   - routes: array — [{from:[lat,lng], to:[lat,lng], color}]
 *   - class: string — Additional CSS classes
 */
function render_map_widget($params = []) {
    $id      = $params['id'] ?? 'map-' . uniqid();
    $height  = $params['height'] ?? '300px';
    $center  = $params['center'] ?? [4.0383, 21.7587]; // Central Africa
    $zoom    = $params['zoom'] ?? 4;
    $markers = $params['markers'] ?? [];
    $routes  = $params['routes'] ?? [];
    $class   = $params['class'] ?? '';

    $status_colors = [
        'delivered' => '#16A34A',
        'transit'   => '#2563EB',
        'waiting'   => '#F59E0B',
        'problem'   => '#DC2626',
        'default'   => '#6B7280',
    ];
    ?>
    <div class="tw-rounded-xl tw-overflow-hidden tw-border tw-border-gray-200 tw-bg-white <?php echo htmlspecialchars($class); ?>">
        <div id="<?php echo htmlspecialchars($id); ?>" style="height: <?php echo htmlspecialchars($height); ?>; width: 100%; z-index: 1;"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof L === 'undefined') return;

        var map = L.map('<?php echo htmlspecialchars($id); ?>', {
            scrollWheelZoom: false,
            attributionControl: true
        }).setView([<?php echo floatval($center[0]); ?>, <?php echo floatval($center[1]); ?>], <?php echo intval($zoom); ?>);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var statusColors = <?php echo json_encode($status_colors); ?>;

        // Custom circle marker factory
        function createMarker(lat, lng, status, label, popup) {
            var color = statusColors[status] || statusColors['default'];
            var marker = L.circleMarker([lat, lng], {
                radius: 8,
                fillColor: color,
                color: '#fff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.9
            }).addTo(map);

            if (popup) {
                marker.bindPopup(
                    '<div style="font-family:Inter,sans-serif;font-size:13px;">' +
                    '<strong>' + (label || '') + '</strong>' +
                    '<br>' + popup +
                    '</div>'
                );
            } else if (label) {
                marker.bindTooltip(label, { permanent: false, direction: 'top', offset: [0, -10] });
            }
            return marker;
        }

        // Add markers
        <?php foreach ($markers as $m): ?>
        createMarker(
            <?php echo floatval($m['lat'] ?? 0); ?>,
            <?php echo floatval($m['lng'] ?? 0); ?>,
            '<?php echo htmlspecialchars($m['status'] ?? 'default'); ?>',
            '<?php echo htmlspecialchars($m['label'] ?? ''); ?>',
            '<?php echo htmlspecialchars($m['popup'] ?? ''); ?>'
        );
        <?php endforeach; ?>

        // Add routes
        <?php foreach ($routes as $r): ?>
        L.polyline([
            [<?php echo floatval($r['from'][0] ?? 0); ?>, <?php echo floatval($r['from'][1] ?? 0); ?>],
            [<?php echo floatval($r['to'][0] ?? 0); ?>, <?php echo floatval($r['to'][1] ?? 0); ?>]
        ], {
            color: '<?php echo htmlspecialchars($r['color'] ?? '#2563EB'); ?>',
            weight: 2,
            opacity: 0.6,
            dashArray: '8, 8'
        }).addTo(map);
        <?php endforeach; ?>

        // Fit bounds if markers exist
        <?php if (!empty($markers)): ?>
        var bounds = [];
        <?php foreach ($markers as $m): ?>
        bounds.push([<?php echo floatval($m['lat'] ?? 0); ?>, <?php echo floatval($m['lng'] ?? 0); ?>]);
        <?php endforeach; ?>
        if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [30, 30] });
        }
        <?php endif; ?>

        // Invalidate size after render (fixes display issues in hidden containers)
        setTimeout(function() { map.invalidateSize(); }, 200);

        // Store map reference globally for external access
        window['mapInstance_<?php echo htmlspecialchars($id); ?>'] = map;
    });
    </script>
    <?php
}
