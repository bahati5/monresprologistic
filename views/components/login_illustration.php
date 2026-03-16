<?php
/**
 * Login Page Illustration — Logistics-themed SVG
 */
function render_login_illustration() { ?>
<svg viewBox="0 0 600 600" fill="none" xmlns="http://www.w3.org/2000/svg" class="tw-w-full tw-h-full tw-max-w-lg tw-mx-auto">
    <!-- Background circles -->
    <circle cx="300" cy="300" r="250" fill="#EFF6FF" opacity="0.5"/>
    <circle cx="300" cy="300" r="180" fill="#DBEAFE" opacity="0.4"/>
    
    <!-- Ground -->
    <ellipse cx="300" cy="440" rx="200" ry="15" fill="#E0E7FF" opacity="0.6"/>
    
    <!-- Warehouse -->
    <rect x="80" y="250" width="180" height="180" rx="8" fill="white" stroke="#93C5FD" stroke-width="2"/>
    <rect x="80" y="240" width="180" height="20" rx="4" fill="#2563EB"/>
    <text x="170" y="254" text-anchor="middle" fill="white" font-size="10" font-weight="600" font-family="Inter,sans-serif">HUB BRUXELLES</text>
    
    <!-- Warehouse door -->
    <rect x="140" y="360" width="60" height="70" rx="4" fill="#DBEAFE" stroke="#93C5FD" stroke-width="1.5"/>
    <circle cx="190" cy="395" r="3" fill="#93C5FD"/>
    
    <!-- Warehouse windows -->
    <rect x="95" y="270" width="30" height="25" rx="3" fill="#DBEAFE"/>
    <rect x="135" y="270" width="30" height="25" rx="3" fill="#DBEAFE"/>
    <rect x="175" y="270" width="30" height="25" rx="3" fill="#DBEAFE"/>
    <rect x="215" y="270" width="30" height="25" rx="3" fill="#DBEAFE"/>
    
    <!-- Packages in warehouse -->
    <rect x="95" y="320" width="25" height="25" rx="3" fill="#FDE68A" stroke="#F59E0B" stroke-width="1"/>
    <rect x="105" y="310" width="25" height="25" rx="3" fill="#FED7AA" stroke="#FB923C" stroke-width="1"/>
    <rect x="215" y="330" width="20" height="20" rx="3" fill="#BBF7D0" stroke="#22C55E" stroke-width="1"/>
    <rect x="225" y="320" width="20" height="20" rx="3" fill="#A7F3D0" stroke="#22C55E" stroke-width="1"/>
    
    <!-- Truck -->
    <g transform="translate(320, 340)">
        <!-- Truck body -->
        <rect x="0" y="20" width="120" height="70" rx="6" fill="white" stroke="#2563EB" stroke-width="2"/>
        <rect x="0" y="15" width="120" height="15" rx="4" fill="#2563EB"/>
        <text x="60" y="27" text-anchor="middle" fill="white" font-size="8" font-weight="600" font-family="Inter,sans-serif">MONRESPRO</text>
        
        <!-- Truck cabin -->
        <rect x="120" y="35" width="55" height="55" rx="6" fill="#2563EB"/>
        <rect x="130" y="42" width="35" height="25" rx="4" fill="#93C5FD"/>
        
        <!-- Wheels -->
        <circle cx="30" cy="95" r="14" fill="white" stroke="#1E3A8A" stroke-width="3"/>
        <circle cx="30" cy="95" r="5" fill="#1E3A8A"/>
        <circle cx="95" cy="95" r="14" fill="white" stroke="#1E3A8A" stroke-width="3"/>
        <circle cx="95" cy="95" r="5" fill="#1E3A8A"/>
        <circle cx="155" cy="95" r="14" fill="white" stroke="#1E3A8A" stroke-width="3"/>
        <circle cx="155" cy="95" r="5" fill="#1E3A8A"/>
        
        <!-- Packages visible -->
        <rect x="15" y="40" width="18" height="18" rx="2" fill="#FDE68A" stroke="#F59E0B" stroke-width="1"/>
        <rect x="38" y="40" width="18" height="18" rx="2" fill="#BFDBFE" stroke="#3B82F6" stroke-width="1"/>
        <rect x="61" y="40" width="18" height="18" rx="2" fill="#BBF7D0" stroke="#22C55E" stroke-width="1"/>
        <rect x="84" y="40" width="18" height="18" rx="2" fill="#FECACA" stroke="#EF4444" stroke-width="1"/>
    </g>
    
    <!-- Airplane -->
    <g transform="translate(350, 100) rotate(-15)">
        <path d="M0 25 L80 15 L90 0 L85 15 L120 20 L85 25 L90 40 L80 25 L0 35 L10 30 L0 25Z" fill="#2563EB" opacity="0.8"/>
        <!-- Contrail -->
        <line x1="-10" y1="30" x2="-60" y2="35" stroke="#93C5FD" stroke-width="2" stroke-dasharray="6 4" opacity="0.5"/>
        <line x1="-10" y1="25" x2="-55" y2="28" stroke="#93C5FD" stroke-width="1.5" stroke-dasharray="4 3" opacity="0.3"/>
    </g>
    
    <!-- Route dots (warehouse to truck) -->
    <circle cx="275" cy="390" r="3" fill="#2563EB" opacity="0.3"/>
    <circle cx="290" cy="385" r="3" fill="#2563EB" opacity="0.4"/>
    <circle cx="305" cy="380" r="3" fill="#2563EB" opacity="0.5"/>
    <circle cx="320" cy="375" r="3" fill="#2563EB" opacity="0.6"/>
    
    <!-- Globe/Africa outline (simplified) -->
    <g transform="translate(450, 170)">
        <circle cx="50" cy="50" r="45" fill="white" stroke="#93C5FD" stroke-width="1.5"/>
        <path d="M45 20 C50 25, 60 30, 55 45 C50 55, 60 65, 55 75 C50 80, 40 78, 35 70 C30 60, 35 50, 40 45 C42 35, 40 25, 45 20Z" fill="#DBEAFE" stroke="#93C5FD" stroke-width="1"/>
        <!-- Pin on Africa -->
        <circle cx="48" cy="55" r="4" fill="#2563EB"/>
        <circle cx="48" cy="55" r="2" fill="white"/>
    </g>
    
    <!-- Location pin (destination) -->
    <g transform="translate(520, 380)">
        <path d="M15 0C6.7 0 0 6.7 0 15C0 26.3 15 40 15 40S30 26.3 30 15C30 6.7 23.3 0 15 0Z" fill="#DC2626"/>
        <circle cx="15" cy="15" r="6" fill="white"/>
    </g>
    
    <!-- Dashed route line to destination -->
    <path d="M495 435 Q510 410, 530 400" stroke="#DC2626" stroke-width="1.5" stroke-dasharray="4 3" fill="none" opacity="0.5"/>
    
    <!-- Floating package -->
    <g transform="translate(150, 140)">
        <rect x="0" y="0" width="40" height="40" rx="6" fill="white" stroke="#F59E0B" stroke-width="2">
            <animateTransform attributeName="transform" type="translate" values="0,0; 0,-8; 0,0" dur="3s" repeatCount="indefinite"/>
        </rect>
        <path d="M0 15 L40 15" stroke="#F59E0B" stroke-width="1.5"/>
        <path d="M20 0 L20 40" stroke="#F59E0B" stroke-width="1.5"/>
        <animateTransform attributeName="transform" type="translate" values="150,140; 150,132; 150,140" dur="3s" repeatCount="indefinite"/>
    </g>
    
    <!-- Decorative elements -->
    <circle cx="100" cy="170" r="4" fill="#DBEAFE"/>
    <circle cx="500" cy="280" r="5" fill="#DBEAFE"/>
    <circle cx="420" cy="150" r="3" fill="#E0E7FF"/>
    <circle cx="200" cy="480" r="4" fill="#E0E7FF"/>
</svg>
<?php } ?>
