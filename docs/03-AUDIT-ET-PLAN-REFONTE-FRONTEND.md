# AUDIT COMPLET & PLAN DE REFONTE FRONTEND — Monrespro Logistics

> **Date** : Juin 2025  
> **Périmètre** : Toute l'interface utilisateur (Admin, Employé, Client, Chauffeur)  
> **Objectif** : Documenter l'état actuel, justifier la refonte, détailler chaque interface et proposer un plan d'implémentation concret.

---

## TABLE DES MATIÈRES

1. [Résumé exécutif](#1-résumé-exécutif)
2. [Audit de l'architecture frontend actuelle](#2-audit-de-larchitecture-frontend-actuelle)
3. [Inventaire des problèmes UX/UI par rôle](#3-inventaire-des-problèmes-uxui-par-rôle)
4. [Pertinence de la refonte](#4-pertinence-de-la-refonte)
5. [Stack technique cible](#5-stack-technique-cible)
6. [Design System proposé](#6-design-system-proposé)
7. [Identité visuelle moderne & références UI](#7-identité-visuelle-moderne--références-ui)
8. [Inventaire détaillé de chaque interface](#8-inventaire-détaillé-de-chaque-interface)
9. [Système de workflow intégré](#9-système-de-workflow-intégré)
10. [Plan d'implémentation par phases](#10-plan-dimplémentation-par-phases)
11. [Fichiers impactés](#11-fichiers-impactés)
12. [Stratégie de test](#12-stratégie-de-test)
13. [Risques et mitigations](#13-risques-et-mitigations)

---

## 1. Résumé exécutif

La plateforme Monrespro Logistics repose sur DEPRIXA PRO, un système d'expédition et de logistique basé sur PHP 8.2 pur (sans framework). Le frontend actuel utilise **Bootstrap 4.1**, **jQuery 3.6.0**, et un mélange hétérogène de bibliothèques CSS/JS (Morris.js, Chart.js 2.x, Select2, SweetAlert2, DataTables 1.13.7, intlTelInput, Perfect Scrollbar, etc.).

**Constat principal** : L'interface est fonctionnelle mais souffre de problèmes majeurs de clarté, de cohérence visuelle, de guidage utilisateur et de maintenabilité. La refonte vers **Tailwind CSS 3.x** avec **Alpine.js 3.x** est **fortement recommandée**.

### Chiffres clés de l'audit

| Métrique | Valeur |
|---|---|
| Fichiers de vues PHP | ~120+ |
| Fichiers JS (dataJs/) | ~135 fichiers |
| Bibliothèques CSS distinctes | 12+ |
| Bibliothèques JS distinctes | 15+ |
| Modals Bootstrap | 17 fichiers |
| Fichiers de rapports | 83 fichiers |
| Rôles utilisateurs | 4 (Admin=9, Employé=2, Client=1, Chauffeur=3) |
| Sidebar : lignes PHP | 1342 lignes (un seul fichier) |

---

## 2. Audit de l'architecture frontend actuelle

### 2.1 Structure des fichiers

```
logistics.monrespro.com/
├── index.php                    # Routeur principal (redirige selon userlevel)
├── login.php                    # Page de connexion
├── *.php                        # ~60 fichiers PHP racine (routeurs simples)
├── views/
│   ├── inc/
│   │   ├── head_scripts.php     # CSS globaux (12+ libs)
│   │   ├── topbar.php           # Barre de navigation supérieure
│   │   ├── left_sidebar.php     # Sidebar (1342 lignes, 4 blocs conditionnels)
│   │   ├── footer.php           # Footer + JS globaux (15+ scripts)
│   │   └── preloader.php        # Animation de chargement
│   ├── dashboard/               # 9 fichiers de tableaux de bord
│   ├── courier/                 # 11 fichiers (expéditions)
│   ├── customer_packages/       # 13 fichiers (colis clients)
│   ├── pickup/                  # 4 fichiers (ramassages)
│   ├── consolidate/             # 8 fichiers
│   ├── consolidate_packages/    # 8 fichiers
│   ├── modals/                  # 17 modals Bootstrap
│   ├── reports/                 # 83 fichiers de rapports
│   ├── tools/                   # 77 fichiers utilitaires
│   └── ...
├── dataJs/                      # ~135 fichiers JS (logique AJAX)
└── assets/
    ├── template/                # Template Bootstrap (AdminWrap)
    ├── vendor/                  # Polices et icônes
    ├── css_main_deprixa/        # CSS login page
    └── custom_dependencies/     # jQuery etc.
```

### 2.2 Bibliothèques CSS chargées (par page)

| Fichier source | Bibliothèques |
|---|---|
| `head_scripts.php` | SweetAlert2 CSS, Google Fonts (Public Sans, Tajawal), Font Awesome, Tabler Icons, Flag Icons, uicons-regular-rounded, style.min.css (AdminWrap), customClassPagination, scroll-menu, DataTables CSS |
| `login.php` | Bootstrap 4 CSS, Material Design Icons, Unicons, style.css (Landrick theme), colors/default.css |
| `courier_add.php` | intlTelInput CSS, SweetAlert2 CSS, Select2 CSS, Bootstrap DateTimePicker CSS, Bootstrap Switch CSS, custom_switch CSS |
| `footer.php` | (aucun CSS supplémentaire) |

**Problème** : 12+ fichiers CSS chargés par page, provenant de 3 thèmes différents (AdminWrap pour le dashboard, Landrick pour le login, custom). Aucun système de design unifié.

### 2.3 Bibliothèques JS chargées (par page)

Chargées dans `footer.php` (sur CHAQUE page) :

| Script | Rôle |
|---|---|
| `jquery.min.js` | DOM manipulation |
| `popper.min.js` | Positionnement tooltips/dropdowns |
| `bootstrap.min.js` | Framework CSS interactif |
| `app.min.js` + `app.init.js` | Template AdminWrap |
| `app-style-switcher.js` | Changement de thème |
| `perfect-scrollbar.jquery.min.js` | Scroll custom sidebar |
| `sparkline.js` | Petits graphiques |
| `waves.js` | Effets visuels clic |
| `sidebarmenu.js` | Logique sidebar |
| `feather.min.js` | Icônes Feather |
| `custom.min.js` | Custom template |
| `Chart.min.js` (v2.8) | Graphiques |
| `load_notifications_all.js` | Notifications AJAX |
| `global.js` | Fonctions globales |
| `jquery.dataTables.js` | Tableaux interactifs |
| `sweetalert2.all.min.js` | Alertes modales |

**Problème** : 16+ scripts JS chargés sur chaque page, dont beaucoup ne sont pas nécessaires. Pas de bundling, pas de minification globale, pas de tree-shaking.

### 2.4 Patterns de code problématiques identifiés

#### a) Duplication massive du layout
Chaque fichier de vue (120+) contient le boilerplate complet HTML :
```php
<!DOCTYPE html>
<html>
<head>
    <?php include 'views/inc/head_scripts.php'; ?>
</head>
<body>
    <?php include 'views/inc/preloader.php'; ?>
    <div id="main-wrapper">
        <?php include 'views/inc/topbar.php'; ?>
        <?php include 'views/inc/left_sidebar.php'; ?>
        <div class="page-wrapper">
            <!-- contenu spécifique -->
        </div>
    </div>
    <?php include 'views/inc/footer.php'; ?>
</body>
</html>
```

#### b) Sidebar monolithique (1342 lignes)
Le fichier `left_sidebar.php` contient toute la navigation pour les 4 rôles dans un seul fichier avec des blocs `if/else` imbriqués :
- Lignes 1–930 : Admin (userlevel == 9)
- Lignes 933–1140 : Client (userlevel == 1)
- Lignes 1145–1337 : Chauffeur (userlevel == 3)
- Employé (userlevel == 2) : **pas de bloc distinct**, semble partager le menu admin

Le code du profil utilisateur + salutation est dupliqué 3 fois identiquement.

#### c) SQL inline dans les vues
Le dashboard admin (`views/dashboard/index.php`, 801 lignes) contient **des requêtes SQL directement dans le HTML** :
```php
<h4 class="text-primary mb-2">
    <?php
    $sql = "SELECT IFNULL(SUM(total_order), 0) as total 
            FROM cdb_add_order WHERE ...";
    $db->cdp_query($sql);
    // ...
    echo cdb_money_format($count->total);
    ?>
</h4>
```
Ce pattern se répète des dizaines de fois dans les vues de dashboard.

#### d) Logique conditionnelle excessive dans les templates
`courier_view.php` (1350 lignes) contient jusqu'à **7 niveaux d'imbrication** de conditions PHP pour afficher les boutons d'action :
```php
<?php if ($row_order->status_courier != 21) { ?>
    <?php if ($row_order->status_courier != 12) { ?>
        <?php if ($userData->userlevel == 9 || $userData->userlevel == 3 || ...) { ?>
            <?php if ($row_order->is_consolidate == 0) { ?>
                <?php if ($row_order->status_courier != 8) { ?>
                    <?php if ($row_order->status_courier != 21) { ?>
                        <?php if ($row_order->status_courier != 12) { ?>
                            <!-- Action -->
```

#### e) AJAX non structuré
Les fichiers `dataJs/` utilisent jQuery AJAX pur sans pattern cohérent :
```javascript
$.ajax({
    url: './ajax/courier/courier_list_ajax.php',
    data: parametros,
    success: function(data) {
        $(".outer_divx").html(data).fadeIn('slow');
    }
})
```
Le HTML est retourné directement par le serveur (pas de JSON API), rendant impossible le découplage frontend/backend futur.

### 2.5 Performance estimée

| Indicateur | État actuel | Cible |
|---|---|---|
| Nombre de requêtes HTTP/page | 30+ | < 10 |
| CSS total chargé | ~500KB+ | < 50KB (Tailwind purgé) |
| JS total chargé | ~800KB+ | < 150KB |
| Première peinture (FCP) | Lent (preloader visible) | < 1.5s |
| Pas de lazy loading | ✗ | ✓ |
| Pas de code splitting | ✗ | ✓ |

---

## 3. Inventaire des problèmes UX/UI par rôle

### 3.1 Admin (userlevel = 9)

| Page | Problème UX/UI | Sévérité |
|---|---|---|
| **Dashboard** (`index.php`) | Surcharge informationnelle — 8+ cartes de stats, graphiques Morris/Chart.js mélangés, aucune hiérarchie visuelle claire. Les KPIs importants (ventes du mois, paiements en attente) ne sont pas mis en avant. | Haute |
| **Dashboard** | Requêtes SQL inline ralentissent le rendu. Pas de mise en cache des compteurs. | Haute |
| **Sidebar** | 30+ éléments de menu avec sous-menus imbriqués. Aucune indication visuelle du module actif. Icônes incohérentes (mdi, fas, ti mélangés). | Haute |
| **Liste des expéditions** (`courier_list.php`) | Filtres basiques (recherche texte + dropdown statut). Pas de filtres par date, agence, chauffeur. Pagination AJAX sans URL, impossible de partager un lien vers une page spécifique. | Moyenne |
| **Détail expédition** (`courier_view.php`) | Menu d'actions dans un dropdown Bootstrap, conditions illisibles (7 niveaux). L'utilisateur ne sait pas quelles actions sont disponibles et pourquoi. Aucun workflow visuel. | Haute |
| **Formulaire expédition** (`courier_add.php`) | Formulaire monolithique de ~980 lignes. Select2 pour la sélection client. Pas de stepper/étapes. Tous les champs affichés en même temps. | Haute |
| **Preuves de paiement** (`payment_proofs_pending.php`) | Page fonctionnelle mais style incohérent avec le reste. Pas de pagination. Pas de filtre par type/date. Modal de rejet basique. | Moyenne |
| **Rapports** | 83 fichiers de rapports sans navigation unifiée. L'utilisateur doit savoir quelle page ouvrir. | Haute |

### 3.2 Client (userlevel = 1)

| Page | Problème UX/UI | Sévérité |
|---|---|---|
| **Dashboard client** (`dashboard_client.php`) | Affiche seulement des compteurs financiers (total, payé, en attente). Aucune vue des colis en cours, pas de timeline de suivi, pas d'actions rapides contextuelles. | Haute |
| **Sidebar client** | Affiche le casier virtuel (locker) mais sans explication. Le bouton principal "Créer Pickup" n'est pas explicite pour un client qui ne connaît pas le jargon logistique. | Haute |
| **Liste colis** (`customer_packages_list.php`) | Table brute avec statuts numériques/codes. Le client ne comprend pas où en est son colis sans cliquer sur chaque ligne. | Haute |
| **Pré-alerte** (`prealert_add.php`) | Formulaire technique. Le client doit connaître le tracking du site marchand. Aucune aide contextuelle. | Moyenne |
| **Paiement** (`payments_gateways_list.php`) | Liste de paiements sans contexte. Le client ne sait pas facilement quel colis il paie. | Moyenne |

### 3.3 Employé/Gestionnaire (userlevel = 2)

| Page | Problème UX/UI | Sévérité |
|---|---|---|
| **Dashboard** | Partage le même dashboard que l'Admin — peut être confus car l'employé n'a pas les mêmes droits. | Moyenne |
| **Sidebar** | Pas de bloc distinct dans `left_sidebar.php` pour userlevel == 2. L'employé voit probablement le menu admin complet, incluant des liens vers des pages auxquelles il n'a pas accès. | Haute |
| **Gestion consolidations** | Workflow de consolidation complexe (regroupement de colis en un envoi) sans guide visuel des étapes. | Haute |

### 3.4 Chauffeur (userlevel = 3)

| Page | Problème UX/UI | Sévérité |
|---|---|---|
| **Dashboard chauffeur** (`dashboard_driver.php`) | Compteurs basiques (envois assignés, livrés, en cours). Aucune vue carte/itinéraire. Pas de liste des livraisons du jour. | Haute |
| **Sidebar** | Accès à Pickup, Expéditions, Consolidations, Rapports, Profil. Correct mais pas optimisé pour usage mobile (chauffeur sur le terrain). | Haute |
| **Liste des pickups** | Pas de tri par proximité/urgence. Pas de statut visuel clair (à récupérer, en cours, terminé). | Moyenne |

### 3.5 Problèmes transversaux

| Problème | Détail |
|---|---|
| **Aucun workflow visuel** | Les statuts des entités (expéditions, colis, pickups) sont des badges textuels. L'utilisateur ne voit jamais une timeline/stepper montrant les étapes passées et à venir. |
| **Incohérence des icônes** | 4 bibliothèques d'icônes utilisées simultanément : Material Design Icons (`mdi`), Font Awesome (`fas`/`fa`), Tabler Icons (`ti`), Feather Icons, Unicons (`uil`). |
| **Pas de design system** | Couleurs, espacements, typographie, composants — tout varie d'une page à l'autre. |
| **Mobile non optimisé** | Le sidebar collapse est géré par JS ancien (Perfect Scrollbar). Pas de breakpoints cohérents. Le chauffeur sur mobile a une mauvaise expérience. |
| **Notifications rudimentaires** | Une clochette avec un compteur AJAX. Pas de catégorisation, pas de "marquer comme lu", pas de lien direct vers l'action requise. |
| **Internationalisation fragile** | Clés `$lang[]` avec noms incohérents (`left-menu-sidebar-2233333310`, `left1022`, `messagesform84`). Certains textes sont en dur en français. |
| **Modals Bootstrap non accessibles** | Les 17 modals utilisent `data-dismiss="modal"` (Bootstrap 4). Pas de gestion du focus, pas de fermeture Escape cohérente. |

---

## 4. Pertinence de la refonte

### 4.1 Pourquoi refondre ?

| Critère | Justification |
|---|---|
| **UX métier** | Le cœur de métier (logistique internationale vers l'Afrique) nécessite des workflows clairs. Aujourd'hui, un client ne peut pas comprendre intuitivement où en est son colis. |
| **Rétention utilisateurs** | Les clients (non-techniques) abandonneront la plateforme si l'interface reste cryptique. |
| **Efficacité opérationnelle** | Les employés et admins perdent du temps à naviguer dans des menus surchargés et des pages sans guidage. |
| **Maintenabilité** | Le code frontend actuel est un obstacle à toute évolution. Ajouter une fonctionnalité nécessite de modifier 5+ fichiers avec des patterns incohérents. |
| **Performance** | 30+ requêtes HTTP par page, 1.3MB+ de ressources non optimisées. |
| **Sécurité** | jQuery 3.6.0 et Bootstrap 4.1 ne reçoivent plus de mises à jour de sécurité. |
| **Mobile** | Les chauffeurs et clients utilisent principalement leur téléphone. L'interface actuelle n'est pas mobile-first. |

### 4.2 Pourquoi Tailwind CSS + Alpine.js ?

| Avantage | Détail |
|---|---|
| **Pas de refonte backend** | Tailwind et Alpine fonctionnent avec du PHP pur. Aucune modification de la logique serveur. |
| **Taille réduite** | Tailwind purgé : ~10-30KB CSS au lieu de ~500KB+. Alpine : ~15KB au lieu de jQuery+Bootstrap+plugins (~400KB+). |
| **Composants utilitaires** | Classes Tailwind directement dans le HTML PHP, comme le fait déjà Bootstrap mais de façon plus cohérente et moderne. |
| **Interactivité légère** | Alpine.js remplace jQuery pour les toggles, dropdowns, modals, tabs sans bundle complexe. |
| **Écosystème** | Plugins headlessUI, Heroicons, composants communautaires. |
| **Migration progressive** | On peut faire coexister Bootstrap et Tailwind temporairement avec un prefix. |

### 4.3 Ce qui ne change PAS

- **Backend PHP** : Aucun fichier dans `ajax/`, `helpers/`, `classes/` ne sera modifié.
- **Base de données** : Aucune migration de schéma.
- **Fichiers ionCube** : `loader.php`, `helpers/functions_money.php` et 4 autres fichiers protégés restent intouchés.
- **Routing** : Les URL restent les mêmes (`courier_list.php`, `index.php`, etc.).
- **Logique AJAX** : Les endpoints `ajax/*.php` restent identiques, seul le JS appelant est modernisé.

---

## 5. Stack technique cible

| Couche | Actuel | Cible |
|---|---|---|
| **CSS Framework** | Bootstrap 4.1 + AdminWrap + Landrick + custom | **Tailwind CSS 3.4** (via CDN puis build) |
| **CSS Supplémentaire** | 12+ fichiers | 1 fichier custom minimal |
| **JS Framework** | jQuery 3.6.0 | **Alpine.js 3.x** + Vanilla JS |
| **Icônes** | MDI + FA + Tabler + Feather + Unicons (5 libs) | **Lucide Icons** (1 seule lib, successeur de Feather) |
| **Tableaux** | DataTables 1.13.7 | **Simple DataTables** (vanilla) ou Alpine + custom |
| **Graphiques** | Chart.js 2.8 + Morris.js | **Chart.js 4.x** (moderne, tree-shakeable) |
| **Alertes** | SweetAlert2 | Conservé (compatible) ou Tailwind toast custom |
| **Selects** | Select2 (jQuery) | **Tom Select** (vanilla) ou Alpine custom |
| **Date Picker** | Bootstrap DateTimePicker | **Flatpickr** (vanilla) |
| **Modals** | Bootstrap Modal (jQuery) | Alpine.js + Tailwind modals |
| **Cartes** | Aucune | **Leaflet.js 1.9** + OpenStreetMap (cartes interactives, gratuit) |
| **Illustrations** | Aucune | **unDraw / Storyset** SVG personnalisées + icônes Lucide |
| **Galerie photos** | Aucune | **Alpine.js lightbox** custom (cargo photos, preuves paiement) |
| **Scrollbar** | Perfect Scrollbar (jQuery) | CSS native `overflow-y: auto` + `scrollbar-thin` |

---

## 6. Design System proposé

### 6.1 Palette de couleurs

```
Primary:     #2563EB (blue-600)    — Actions principales, liens
Secondary:   #7C3AED (violet-600)  — Accents, éléments secondaires
Success:     #16A34A (green-600)   — Statuts positifs (livré, payé)
Warning:     #F59E0B (amber-500)   — En attente, attention requise
Danger:      #DC2626 (red-600)     — Erreurs, suppressions, urgence
Info:        #0891B2 (cyan-600)    — Informations, en cours
Neutral:     #6B7280 (gray-500)    — Texte secondaire
Background:  #F9FAFB (gray-50)    — Fond de page
Surface:     #FFFFFF               — Cartes, modals
```

### 6.2 Typographie

```
Font Family: Inter (Google Fonts) — claire, professionnelle, excellente lisibilité
Headings:    font-semibold
  H1: text-2xl (24px)
  H2: text-xl (20px)
  H3: text-lg (18px)
Body:        text-sm (14px) / text-base (16px)
Small:       text-xs (12px)
```

### 6.3 Composants réutilisables à créer

| Composant | Fichier PHP | Usage |
|---|---|---|
| `Layout` | `views/inc/layout_start.php` + `layout_end.php` | Wrapper HTML complet (remplace le boilerplate dupliqué) |
| `Sidebar` | `views/inc/sidebar.php` | Navigation refactorisée, Alpine.js pour toggle |
| `Topbar` | `views/inc/topbar.php` | Barre supérieure modernisée |
| `Card` | Classes Tailwind | `bg-white rounded-xl shadow-sm border p-6` |
| `Badge/Status` | Classes Tailwind | Badges colorés avec icône pour chaque statut |
| `WorkflowTimeline` | `views/components/workflow_timeline.php` | Stepper horizontal/vertical pour les étapes |
| `StatsCard` | `views/components/stats_card.php` | Carte de statistique avec icône, valeur, label |
| `DataTable` | `views/components/data_table.php` | Table responsive avec tri, recherche, pagination |
| `Modal` | Alpine.js component | Modal accessible avec overlay, focus trap |
| `Alert/Toast` | Alpine.js component | Notifications inline et toast |
| `FormGroup` | Classes Tailwind | Label + input + erreur stylisé |
| `EmptyState` | `views/components/empty_state.php` | État vide avec illustration et CTA |
| `VehicleCard` | `views/components/vehicle_card.php` | Carte véhicule avec illustration, statut temps réel, infos route |
| `LockerVisual` | `views/components/locker_visual.php` | Représentation visuelle du casier virtuel client avec compartiments |
| `MapWidget` | `views/components/map_widget.php` | Widget carte interactive (Leaflet.js) pour localisation |
| `CargoPhotoGallery` | `views/components/cargo_photo_gallery.php` | Galerie photos de cargaison avec lightbox |
| `CapacityGauge` | `views/components/capacity_gauge.php` | Jauge visuelle de capacité (conteneur, consolidation) |
| `TrackingCard` | `views/components/tracking_card.php` | Carte de suivi avec photo véhicule, ETA, progression |
| `FilterChips` | `views/components/filter_chips.php` | Chips de filtrage colorés avec compteurs (actif/inactif) |
| `SplitPanelView` | Classes Tailwind + Alpine | Layout split-panel : liste à gauche, détail à droite |

---

## 7. Identité visuelle moderne & références UI

> **Exigence fondamentale** : L'interface finale doit avoir un rendu **moderne de type SaaS logistique premium**, avec des visuels riches, des illustrations, des cartes interactives et une mise en page aérée inspirée des meilleures plateformes de gestion de transport et de logistique.

### 7.1 Références visuelles et principes directeurs

L'interface cible s'inspire des dashboards logistiques modernes avec les caractéristiques suivantes :

| Principe | Description | Inspiration |
|---|---|---|
| **Split-panel layout** | Liste d'éléments à gauche, détail riche à droite (carte, infos, actions). L'utilisateur sélectionne un élément dans la liste et voit le détail sans changer de page. | Dashboard type "LoadSwift" — fuel prices avec liste + carte |
| **Cartes véhicules illustrées** | Chaque véhicule/expédition a une carte visuelle avec une **illustration ou photo du véhicule**, le numéro d'immatriculation, le statut en temps réel (On Route, Waiting, Delivered), le temps estimé d'arrivée. | Dashboard type tracking avec cards véhicules et statuts colorés |
| **Carte géographique intégrée** | Widget carte (Leaflet.js/OpenStreetMap) affichant les positions des véhicules, les points de collecte/livraison, avec des marqueurs colorés par statut et des popups informatifs. | Carte interactive avec pins et popups de prix/info |
| **Photos de cargaison** | Possibilité de visualiser les photos des colis/marchandises directement dans l'interface — galerie de "Cargo Photo Reports" avec points de contrôle (Point #1, Point #2) horodatés. | Section "Cargo Photo Reports" avec miniatures cliquables |
| **Jauges de capacité** | Visualisation du remplissage d'un conteneur ou d'une consolidation sous forme de **jauge circulaire avec pourcentage** (ex: "82% Current Truck Capacity"). | Jauge circulaire de capacité camion |
| **Chips de filtrage colorés** | Filtres par partenaire/agence sous forme de **chips colorés** avec compteurs, permettant de basculer rapidement entre les vues (Active, Inactive, All). | Chips colorés "Shipike", "Roambee", "Post Hawk" avec toggles |
| **Sidebar sombre et épurée** | Sidebar à fond sombre (#1A1A2E ou slate-900) avec icônes claires, badges de notification sur les items, avatar utilisateur en haut, bouton CTA en bas ("Create new request"). | Sidebar gauche sombre avec navigation verticale et badges |
| **Onglets de détail** | Sur la vue détail d'une entité : onglets horizontaux (Shipping Info, Vehicle Info, Documents, Company, Billing) pour organiser l'information sans surcharger. | Onglets horizontaux sur le panneau de détail |
| **Informations temps réel** | Affichage du temps écoulé, ETA, "57 min left", chronomètres — pour donner un sentiment de **suivi live**. | Indication "01:38:47 — 57 min. left" avec bouton "Change Route" |
| **Micro-interactions** | Survol des cards avec élévation, sélection avec bordure colorée, transitions fluides entre les vues. | Card sélectionnée avec bordure rouge et élévation |

### 7.2 Visualisation des casiers virtuels (Lockers)

Le **casier virtuel** est un concept central de Monrespro. Actuellement, il est affiché comme un simple texte `Casier: MRP-XXXX` dans la sidebar. 

**Refonte requise** — Le casier doit devenir un **élément visuel immersif** :

```
┌─────────────────────────────────────────────┐
│  🏷️  MON CASIER VIRTUEL                     │
│  ┌─────────────────────────────────────────┐ │
│  │                                         │ │
│  │   ┌─────┐  ┌─────┐  ┌─────┐  ┌─────┐  │ │
│  │   │ 📦  │  │ 📦  │  │     │  │     │  │ │
│  │   │ #01 │  │ #02 │  │ #03 │  │ #04 │  │ │
│  │   │ ✅  │  │ ⏳  │  │  —  │  │  —  │  │ │
│  │   └─────┘  └─────┘  └─────┘  └─────┘  │ │
│  │                                         │ │
│  │   Adresse de livraison :                │ │
│  │   Monrespro SARL                        │ │
│  │   Rue de la Logistique 42               │ │
│  │   1000 Bruxelles, Belgique              │ │
│  │   Ref: MRP-XXXX                         │ │
│  │                                         │ │
│  │   [📋 Copier l'adresse]  [📦 Pré-alerter] │ │
│  └─────────────────────────────────────────┘ │
│                                               │
│  2 colis en attente · 0 prêts à expédier     │
└─────────────────────────────────────────────┘
```

**Détails** :
- **Compartiments visuels** : Chaque colis dans le casier est représenté par un compartiment avec icône, numéro et statut (réceptionné ✅, en attente ⏳, vide —)
- **Adresse copiable** : L'adresse complète du hub Belgique est affichée avec un bouton "Copier" en un clic
- **Actions directes** : "Pré-alerter un nouvel achat" directement depuis la vue casier
- **Compteurs** : Nombre de colis présents, prêts à expédier, en attente de paiement
- **Animation** : Effet subtil quand un nouveau colis arrive (notification + compartiment qui s'illumine)

### 7.3 Illustrations et visuels par page

| Page | Visuels à intégrer |
|---|---|
| **Dashboard Admin** | Graphiques interactifs Chart.js 4 avec gradients, carte géographique des agences (Belgique, Kinshasa, Gabon) avec flux d'expéditions entre elles, illustrations SVG pour les états vides |
| **Dashboard Client** | Illustration du casier virtuel avec compartiments, carte de suivi de colis avec marqueurs animés, illustrations d'onboarding (SVG "Comment ça marche ?"), photos de colis si disponibles |
| **Dashboard Chauffeur** | Carte interactive avec itinéraire du jour et points de collecte/livraison, illustrations de véhicule avec jauge de chargement, photos des colis à récupérer |
| **Détail Expédition** | Carte du trajet (origine → destination) avec marqueur temps réel, photos de la cargaison (galerie "Cargo Photo Reports" avec horodatage), illustration du véhicule assigné avec N° plaque et capacité, timeline visuelle avec icônes par étape |
| **Liste Expéditions** | Vue split-panel (liste + carte), cards d'expédition avec mini-illustration véhicule, badges colorés animés par statut, filtres en chips avec compteurs |
| **Tracking Public** | Grande carte interactive centrée sur le colis, timeline verticale illustrée, estimation temps d'arrivée avec chronomètre, photo du dernier point de contrôle |
| **Consolidations** | Visualisation 3D simplifiée ou jauge de remplissage du conteneur (ex: "82% rempli"), liste des colis avec miniatures, drag & drop visuel pour ajouter/retirer des colis |
| **Pickups** | Carte des pickups en attente avec marqueurs urgence, card de chaque pickup avec adresse et photo du lieu (si dispo), chronomètre depuis la demande |
| **Preuves de paiement** | Preview inline des images/documents (reçus Mobile Money, captures d'écran de virement), comparaison visuelle montant attendu vs soumis, galerie zoomable |
| **Page de connexion** | Illustration pleine page (côté gauche) avec scène logistique moderne (avion, camion, colis), animation subtile (parallax ou fade-in), branding fort Monrespro |
| **Rapports** | Graphiques riches (barres, donuts, lignes) avec gradients Tailwind, cartes thermiques par période, mini-sparklines dans les tableaux |
| **Configuration** | Icônes illustrées par catégorie (tarifs = calculatrice, emails = enveloppe, statuts = étiquettes colorées), previews visuels des templates email |

### 7.4 Carte interactive — Spécifications

L'intégration d'une **carte interactive** est un élément clé de la modernisation :

**Technologie** : Leaflet.js (open-source, léger, ~40KB) + OpenStreetMap tiles (gratuit)

**Usages** :

| Vue | Usage de la carte |
|---|---|
| **Dashboard Admin** | Vue globale des 3 agences (Belgique, Kinshasa, Gabon) avec lignes de flux entre elles et compteurs d'expéditions en transit |
| **Dashboard Chauffeur** | Itinéraire du jour avec points de collecte/livraison numérotés par ordre |
| **Détail Expédition** | Trajet origine → destination avec marqueur de position actuelle |
| **Liste Expéditions** | Panel droit : carte montrant toutes les expéditions filtrées avec marqueurs colorés par statut |
| **Pickups** | Carte des demandes de pickup en attente avec rayon de proximité |
| **Tracking public** | Carte centrée sur le colis avec dernier statut connu |

**Marqueurs visuels** :
- 🟢 Vert : Livré / Terminé
- 🔵 Bleu : En transit
- 🟡 Jaune : En attente
- 🔴 Rouge : Problème / Urgence
- 📍 Pin animé : Position actuelle du colis/véhicule

### 7.5 Photos et galeries de cargaison

Chaque expédition/colis pourra afficher des **photos de vérification** :

- **Points de contrôle** : Photo à la réception au hub, photo avant expédition, photo à la livraison
- **Horodatage** : Chaque photo affiche la date, l'heure et le lieu (ex: "Point #1 Cargo Photo — Brussels Hub — 10:32 AM")
- **Galerie responsive** : Miniatures en grille avec lightbox pour zoom
- **Upload par l'employé/chauffeur** : Bouton "Add Photo" avec capture caméra sur mobile
- **Composant** : `CargoPhotoGallery` avec Tailwind grid + Alpine.js lightbox

### 7.6 Design des cartes d'entités (Entity Cards)

Chaque entité (expédition, colis, pickup) dans les listes sera affichée dans une **carte visuelle riche** au lieu d'une simple ligne de tableau :

```
┌──────────────────────────────────────────────────┐
│  ┌──────┐                                        │
│  │ 🚛   │  RE-74IR453TR5         🟢 On Route    │
│  │      │  Brussels → Kinshasa                   │
│  └──────┘                                        │
│                                                  │
│  ⏱ 02:47:24    📍 478 km    ⏳ 10 min. left     │
│  ──────────────────────●───── 87%                │
│                                                  │
│  Client: Jean Dupont    Chauffeur: Paul M.       │
│  Poids: 12.5 kg        Valeur: 450 EUR          │
└──────────────────────────────────────────────────┘
```

**Caractéristiques** :
- **Illustration véhicule** : Icône ou illustration SVG du type de véhicule (camion, avion, bateau)
- **Barre de progression** : Indicateur visuel du pourcentage de trajet accompli
- **Infos temps réel** : Chronomètre, distance restante, ETA
- **Statut proéminent** : Badge coloré avec texte clair (On Route, Waiting, Delivered, Problem)
- **Sélection** : Au clic, la carte s'encadre en couleur primaire et le détail s'affiche dans le panneau droit (split-panel)
- **Hover** : Élévation (shadow) + légère transition scale

### 7.7 Illustrations SVG et états vides

Chaque état vide ou page d'accueil utilisera des **illustrations SVG modernes** :

| Contexte | Illustration |
|---|---|
| Aucune expédition | Illustration camion vide avec "Aucune expédition en cours" + CTA "Créer une expédition" |
| Casier vide | Illustration casier ouvert vide avec "Votre casier est vide" + CTA "Faites votre premier achat" |
| Aucun pickup | Illustration carte vide avec "Aucun ramassage planifié" + CTA "Demander un ramassage" |
| Recherche sans résultat | Illustration loupe avec "Aucun résultat trouvé" + suggestion de modifier les filtres |
| Erreur de chargement | Illustration nuage avec éclair + "Impossible de charger les données" + bouton "Réessayer" |
| Première connexion client | Guide illustré en 3 étapes avec illustrations d'avion, colis, maison |
| Consolidation vide | Illustration conteneur ouvert vide + "Ajoutez des colis à cette consolidation" |

**Source** : Utiliser [unDraw](https://undraw.co/) ou [Storyset](https://storyset.com/) (illustrations SVG gratuites, personnalisables aux couleurs Monrespro).

### 7.8 Micro-animations et transitions

| Élément | Animation |
|---|---|
| **Chargement de page** | Skeleton loading (placeholders gris animés) au lieu du preloader spinner actuel |
| **Apparition des cards** | Fade-in + slide-up séquentiel (stagger) à l'arrivée sur la page |
| **Changement de statut** | Pulse sur le badge + confetti subtil pour "Livré" |
| **Notifications** | Toast slide-in depuis le haut droit avec auto-dismiss |
| **Sidebar** | Transition smooth open/close avec backdrop sur mobile |
| **Modals** | Fade + scale-in avec overlay blur |
| **Cartes sélectionnées** | Border-color transition + shadow elevation |
| **Nouveau colis dans le casier** | Glow animation sur le compartiment concerné |
| **Barre de progression** | Animation de remplissage smooth au chargement |
| **Compteurs** | Count-up animation (de 0 à la valeur finale) |

**Technologie** : CSS Tailwind transitions (`transition-all duration-300`) + Alpine.js `x-transition` + animations CSS `@keyframes` pour les cas spéciaux.

---

## 8. Inventaire détaillé de chaque interface

### 8.1 Page de connexion (`login.php`)

**État actuel** :
- Thème Landrick (différent du dashboard)
- Formulaire centré avec fond illustré
- Boutons de connexion rapide (demo mode)
- Lien tracking en pied de page

**Refonte proposée** :
- Split screen : illustration à gauche, formulaire à droite
- Branding Monrespro visible (logo, couleurs)
- Formulaire épuré : email/username + mot de passe + "Se souvenir de moi"
- Message d'accueil contextuel
- Lien "Mot de passe oublié" + "Créer un compte"
- Footer avec lien de tracking public
- 100% Tailwind, zéro Bootstrap

### 8.2 Dashboard Admin (`views/dashboard/index.php`)

**État actuel** (801 lignes) :
- 4 cartes de stats en haut (Ventes mensuelles avec lien)
- Bloc de 3 stats horizontales (Pickups, Expéditions, Colis clients)
- 4 barres de progression "Earning Reports" 
- Graphique Morris.js (ventes par mois)
- Tableaux des dernières commandes
- SQL inline dans le HTML

**Refonte proposée** :
- **Ligne 1** : 4 StatsCards claires — Revenus du mois, Expéditions actives, Colis en attente, Pickups en cours
- **Ligne 2** : Graphique Chart.js 4 (ventes mensuelles) + Répartition par type (donut)
- **Ligne 3** : "Actions requises" — Preuves de paiement en attente, Expéditions sans chauffeur, Colis non récupérés
- **Ligne 4** : Tableau des dernières activités avec workflow badges
- Toutes les données chargées via AJAX JSON (pas de SQL dans la vue)

### 8.3 Dashboard Client (`views/dashboard/dashboard_client.php`)

**État actuel** (549 lignes) :
- 3 cartes financières (Total, Payé, En attente)
- Table des dernières commandes basique
- Aucun guidage, aucune action rapide

**Refonte proposée** :
- **Bannière d'accueil** : "Bonjour [Prénom], votre casier virtuel est [LOCKER]" avec explication
- **Carte "Mes colis en cours"** : Timeline visuelle des colis avec statut
- **Actions rapides** : "Pré-alerter un achat", "Demander un ramassage", "Voir mes factures"
- **Résumé financier** : Compact, avec badge "X factures en attente"
- **Guide premier pas** (si nouveau client) : Stepper "1. Obtenez votre adresse → 2. Achetez en ligne → 3. Nous livrons"

### 8.4 Dashboard Chauffeur (`views/dashboard/dashboard_driver.php`)

**État actuel** (322 lignes) :
- Compteurs basiques (assignés, livrés, en transit)
- Liste des expéditions récentes

**Refonte proposée** :
- **"Mes livraisons du jour"** : Liste triée par priorité avec adresse, statut, bouton d'action
- **Stats compactes** : Livraisons effectuées aujourd'hui / cette semaine
- **Bouton principal** : "Scanner/Confirmer livraison"
- Design **mobile-first** (chauffeur en déplacement)

### 8.5 Liste des expéditions (`views/courier/courier_list.php`)

**État actuel** (220 lignes) :
- Filtres basiques dans une card
- Table AJAX avec pagination custom
- Statuts en badges textuels

**Refonte proposée** :
- **Barre de filtres** : Recherche, statut (chips cliquables), date range (Flatpickr), agence, chauffeur
- **Vue table** avec colonnes : N° suivi, Client, Destination, Statut (badge coloré avec icône), Date, Actions
- **Workflow badge** : Indicateur visuel compact montrant l'étape actuelle (ex: "3/6 En transit")
- **Actions inline** : Icônes d'action visibles au survol
- **Pagination URL** : Liens partageables avec paramètres de filtre dans l'URL

### 8.6 Détail d'expédition (`views/courier/courier_view.php`)

**État actuel** (1350 lignes) :
- Header avec N° de suivi
- Dropdown d'actions avec 7+ niveaux de conditions
- Détails dispersés dans des colonnes
- Aucune timeline de suivi visible

**Refonte proposée** :
- **Header compact** : N° suivi, statut actuel (gros badge), boutons d'action contextuels (seulement ceux disponibles, pas de dropdown caché)
- **Timeline workflow** (composant principal) : Stepper vertical montrant toutes les étapes avec dates
- **Onglets** : Informations, Articles, Paiements, Historique
- **Carte expéditeur/destinataire** : Côte à côte, clairement identifiés
- **Section paiement** : Montant, statut facture, bouton "Payer" ou "Vérifier preuve"

### 8.7 Formulaire de création d'expédition (`views/courier/courier_add.php`)

**État actuel** (980 lignes) :
- Formulaire monolithique, tous les champs affichés d'un coup
- Select2 pour client, chauffeur, pays
- Calcul de tarif en temps réel via AJAX
- Bootstrap Switch pour options

**Refonte proposée** :
- **Stepper multi-étapes** (Alpine.js) :
  1. **Expéditeur** : Sélection/création client
  2. **Destinataire** : Sélection/création destinataire
  3. **Détails colis** : Catégorie, poids, dimensions, articles
  4. **Options d'envoi** : Mode, service, délai de livraison
  5. **Récapitulatif & tarif** : Résumé complet avec prix calculé
  6. **Confirmation**
- Tom Select au lieu de Select2
- Validation inline avec messages d'erreur clairs
- Sauvegarde brouillon possible

### 8.8 Liste des colis clients (`views/customer_packages/customer_packages_list.php`)

**État actuel** (210 lignes) :
- Table AJAX avec boutons d'ajout (admin/employé)
- Filtres par statut
- Pas de différence visuelle entre les statuts

**Refonte proposée** :
- **Onglets de statut** : Tous, Réceptionnés, En attente paiement, Expédiés, Livrés
- **Cards sur mobile** : Vue card pour mobile, table pour desktop
- **Indicateur workflow** : Mini-stepper sur chaque ligne
- **Actions contextuelles** : "Convertir en expédition", "Vérifier paiement", etc.

### 8.9 Liste des pickups (`views/pickup/pickup_list.php`)

**État actuel** (177 lignes) :
- Table simple avec filtres basiques

**Refonte proposée** :
- Même pattern que les expéditions
- **Statuts visuels** : Demandé → Accepté → En route → Récupéré → Terminé
- **Indication urgence** : Badge pour les pickups demandés depuis > 24h

### 8.10 Consolidations (`views/consolidate/`)

**État actuel** (8 fichiers) :
- Liste, ajout, édition, vue, livraison
- Interface technique, pas adaptée au concept de "regroupement"

**Refonte proposée** :
- **Vue kanban** pour les consolidations (Préparation → En attente → Expédié → Livré)
- **Visualisation des colis inclus** : Liste des colis avec possibilité de drag & drop
- **Calcul automatique** : Poids total, volume, tarif groupé

### 8.11 Preuves de paiement (`views/tools/payment_proofs_pending.php`)

**État actuel** (105 lignes) :
- Table simple avec fichiers, boutons Approuver/Rejeter
- Modal de rejet basique
- Textes en dur en français

**Refonte proposée** :
- **Preview des fichiers** : Affichage inline des images (pas besoin d'ouvrir dans un nouvel onglet)
- **Informations contextuelles** : Montant attendu vs montant déclaré, historique des tentatives
- **Workflow** : En attente → En vérification → Approuvé/Rejeté
- **Notifications** : Auto-notification au client après action

### 8.12 Rapports (`views/reports/`, 83 fichiers)

**État actuel** :
- 83 fichiers PHP séparés pour chaque type de rapport
- Navigation via le sidebar uniquement
- Pas de page d'index des rapports

**Refonte proposée** :
- **Page hub de rapports** : Grille de cards catégorisées (Par agence, Par client, Par chauffeur, Financier, etc.)
- **Filtres unifiés** : Période, agence, type
- **Export** : Boutons PDF/Excel visibles
- **Graphiques modernisés** : Chart.js 4 avec tooltips interactifs

### 8.13 Configuration (`views/tools/`, 77 fichiers)

**État actuel** :
- 77 fichiers de configuration (tarifs, statuts, templates email, etc.)
- Navigation uniquement via le sidebar

**Refonte proposée** :
- **Page hub de configuration** : Catégories visuelles avec icônes
- **Formulaires améliorés** : Validation inline, preview des templates email
- **Audit trail** : Indication de la dernière modification

### 8.14 Topbar (`views/inc/topbar.php`)

**État actuel** (143 lignes) :
- Logo, toggle sidebar, drapeau langue, clochette notifications, profil dropdown
- Notifications dans un dropdown AJAX
- Son de notification (`notify.mp3`)

**Refonte proposée** :
- **Sticky topbar** Tailwind avec ombre subtile
- **Recherche globale** : Barre de recherche pour trouver un N° de suivi, client, etc.
- **Notifications** : Panel latéral (slide-over) au lieu d'un dropdown limité
- **Profil** : Menu dropdown avec avatar, nom, rôle, lien profil, déconnexion

### 8.15 Page de suivi public (`views/track.php`, `views/tracking.php`)

**État actuel** :
- Page de tracking accessible sans connexion
- Formulaire de recherche par N° de suivi

**Refonte proposée** :
- **Design marketing** cohérent avec la landing page
- **Timeline visuelle** du colis avec carte géographique simplifiée
- **Partage** : Bouton copier le lien de suivi

---

## 9. Système de workflow intégré

### 9.1 Principe

Chaque entité principale (Expédition, Colis client, Pickup, Consolidation) suit un **workflow à états** qui doit être visuellement explicite partout dans l'interface.

### 9.2 Workflow Expédition (Shipment/Courier)

```
[Créée] → [Acceptée] → [En préparation] → [Collectée] → [En transit] → [En douane] → [Arrivée] → [En livraison] → [Livrée]
                                                                                                              ↘ [Problème]
                                                                                               ↘ [Annulée]
```

**Composant visuel** : Stepper horizontal (desktop) / vertical (mobile) avec :
- Étapes passées : cercle plein + couleur success + date
- Étape actuelle : cercle animé + couleur primary + "En cours"
- Étapes futures : cercle vide + couleur grise
- Étape problème : cercle rouge + icône warning

### 9.3 Workflow Colis Client (Customer Package)

```
[Pré-alerté] → [Réceptionné au hub] → [En attente paiement] → [Payé] → [Intégré à expédition] → [En transit] → [Livré]
                                              ↘ [Preuve soumise] → [Preuve vérifiée] → [Payé]
```

### 9.4 Workflow Pickup

```
[Demandé] → [Accepté] → [Chauffeur assigné] → [En route] → [Récupéré] → [Livré au hub]
                                                                ↘ [Échec] → [Replanifié]
```

### 9.5 Workflow Consolidation

```
[Créée] → [Colis ajoutés] → [Fermée] → [Expédiée] → [En transit] → [Arrivée] → [Distribuée]
```

### 9.6 Workflow Preuve de paiement

```
[Soumise] → [En vérification] → [Approuvée] / [Rejetée → Nouvelle soumission]
```

### 9.7 Implémentation technique

Créer un fichier PHP `views/components/workflow_timeline.php` :

```php
<?php
/**
 * Composant Timeline Workflow
 * 
 * @param array $steps — [['label' => 'Créée', 'date' => '2025-01-15', 'status' => 'completed'], ...]
 * @param string $orientation — 'horizontal' | 'vertical'
 */
function render_workflow_timeline($steps, $orientation = 'horizontal') {
    // Génère le HTML Tailwind avec les étapes
}
```

Et un mapping PHP `helpers/workflow_maps.php` qui traduit les `status_courier` numériques en étapes de workflow lisibles.

---

## 10. Plan d'implémentation par phases

### Phase 1 — Fondations (Semaine 1-2)

| Tâche | Fichiers | Détail |
|---|---|---|
| 1.1 Intégrer Tailwind CSS | `views/inc/head_scripts.php` | Ajouter CDN Tailwind + config prefix pour coexistence Bootstrap |
| 1.2 Intégrer Alpine.js | `views/inc/footer.php` | Ajouter CDN Alpine.js |
| 1.3 Intégrer Lucide Icons | `views/inc/head_scripts.php` | Remplacer progressivement les 5 libs d'icônes |
| 1.4 Créer le layout wrapper | `views/inc/layout_start.php`, `layout_end.php` | Centraliser le boilerplate HTML |
| 1.5 Refondre la page de connexion | `login.php` | Premier livrable 100% Tailwind, split-screen avec illustration logistique |
| 1.6 Créer le design system | `assets/css/design-system.css` | Variables, classes utilitaires custom |
| 1.7 Sourcer les illustrations SVG | `assets/svg/` | Télécharger et personnaliser les illustrations unDraw/Storyset aux couleurs Monrespro (casier, camion, avion, colis, carte vide, erreur, onboarding) |
| 1.8 Intégrer Leaflet.js | `views/inc/head_scripts.php` | CDN Leaflet.js + OpenStreetMap tiles pour cartes interactives |

**Livrable** : Page de login modernisée avec illustration, Tailwind + Leaflet.js fonctionnels, bibliothèque d'illustrations SVG prête.

### Phase 2 — Layout global + Dashboards (Semaine 3-4)

| Tâche | Fichiers | Détail |
|---|---|---|
| 2.1 Refondre la sidebar | `views/inc/left_sidebar.php` | Refactoriser en sections par rôle, Alpine.js pour toggle, Tailwind styling |
| 2.2 Refondre la topbar | `views/inc/topbar.php` | Nouveau design, recherche globale, notifications panel |
| 2.3 Refondre le footer | `views/inc/footer.php` | Nettoyage des scripts, chargement conditionnel |
| 2.4 Dashboard Admin | `views/dashboard/index.php` | Nouveau layout avec StatsCards, Chart.js 4, carte Leaflet des agences (Belgique/Kinshasa/Gabon) avec flux d'expéditions, actions requises |
| 2.5 Dashboard Client | `views/dashboard/dashboard_client.php` | **Composant casier virtuel visuel** avec compartiments, carte de suivi colis, illustrations onboarding, actions rapides |
| 2.6 Dashboard Chauffeur | `views/dashboard/dashboard_driver.php` | **Carte Leaflet itinéraire du jour**, cards véhicules illustrées, livraisons du jour, design mobile-first |
| 2.7 Composant LockerVisual | `views/components/locker_visual.php` | Casier virtuel avec compartiments visuels, compteurs, adresse copiable, animations d'arrivée |
| 2.8 Composant MapWidget | `views/components/map_widget.php` | Widget carte Leaflet réutilisable avec marqueurs colorés par statut |
| 2.9 Skeleton loading | CSS Tailwind `@keyframes` | Remplacer le preloader spinner par des placeholders gris animés (skeleton screens) |
| 2.10 Count-up animations | Alpine.js + CSS | Animations de compteurs (de 0 à valeur finale) sur les StatsCards |

**Livrable** : Tous les dashboards modernisés avec visuels riches — casier interactif, cartes Leaflet, illustrations, skeleton loading.

### Phase 3 — Workflows + Listes (Semaine 5-7)

| Tâche | Fichiers | Détail |
|---|---|---|
| 3.1 Composant WorkflowTimeline | `views/components/workflow_timeline.php` | Composant réutilisable stepper |
| 3.2 Mapping workflow | `helpers/workflow_maps.php` | Traduction status → étapes |
| 3.3 Composant Badge/Status | Classes Tailwind | Badges visuels cohérents |
| 3.4 Composant VehicleCard | `views/components/vehicle_card.php` | Carte véhicule illustrée avec N° plaque, statut temps réel, barre de progression trajet, ETA |
| 3.5 Composant FilterChips | `views/components/filter_chips.php` | Chips colorés avec compteurs (par partenaire, agence, statut) et toggles actif/inactif |
| 3.6 Composant TrackingCard | `views/components/tracking_card.php` | Carte de suivi avec illustration véhicule, chronomètre, distance restante |
| 3.7 Liste des expéditions | `views/courier/courier_list.php` + `dataJs/courier.js` | **Layout split-panel** (liste VehicleCards à gauche + carte Leaflet à droite), FilterChips, workflow badges |
| 3.8 Détail expédition | `views/courier/courier_view.php` | Timeline, onglets (Shipping Info / Documents / Billing), **carte trajet Leaflet**, galerie CargoPhotos, actions contextuelles |
| 3.9 Composant CargoPhotoGallery | `views/components/cargo_photo_gallery.php` | Galerie photos avec points de contrôle horodatés, lightbox zoom, bouton "Add Photo" |
| 3.10 Liste colis clients | `views/customer_packages/customer_packages_list.php` | Onglets de statut, mini-stepper, cards sur mobile |
| 3.11 Liste pickups | `views/pickup/pickup_list.php` | **Carte Leaflet des pickups en attente**, statuts visuels, badge urgence |
| 3.12 Consolidations | `views/consolidate/*.php` | Vue améliorée avec workflow, **jauge de capacité** (CapacityGauge), drag & drop colis |
| 3.13 Composant CapacityGauge | `views/components/capacity_gauge.php` | Jauge circulaire de remplissage conteneur (ex: "82% rempli") |

**Livrable** : Toutes les listes principales avec visuels riches — split-panel + carte, vehicle cards illustrées, galeries photos, jauges de capacité.

### Phase 4 — Formulaires + Actions (Semaine 8-9)

| Tâche | Fichiers | Détail |
|---|---|---|
| 4.1 Stepper formulaire expédition | `views/courier/courier_add.php` + `dataJs/courier_add.js` | Multi-étapes avec Alpine.js |
| 4.2 Remplacer Select2 | Tous les formulaires | Tom Select (vanilla) |
| 4.3 Remplacer DateTimePicker | Tous les formulaires | Flatpickr |
| 4.4 Modals Tailwind | `views/modals/*.php` | Remplacement des 17 modals Bootstrap |
| 4.5 Page preuves de paiement | `views/tools/payment_proofs_pending.php` | **Preview inline des images** (reçus Mobile Money, virements), galerie zoomable, comparaison montant attendu vs soumis, workflow visuel |
| 4.6 Formulaire pré-alerte | `views/prealert/prealert_add.php` | Aide contextuelle avec illustrations, guidage step-by-step |
| 4.7 Page tracking public | `views/track.php`, `views/tracking.php` | **Grande carte Leaflet** centrée sur colis, timeline illustrée, chronomètre ETA, photo dernier point de contrôle |
| 4.8 Empty states illustrés | `views/components/empty_state.php` | Intégration des illustrations SVG sur toutes les pages (aucun résultat, casier vide, erreur, première connexion) |

**Livrable** : Tous les formulaires modernisés, tracking public illustré, preuves de paiement avec preview visuel, empty states SVG.

### Phase 5 — Rapports, Config & Polish (Semaine 10-11)

| Tâche | Fichiers | Détail |
|---|---|---|
| 5.1 Hub rapports | `views/reports/index.php` (nouveau) | Page d'index des rapports avec grille de cards illustrées par catégorie |
| 5.2 Moderniser rapports | `views/reports/*.php` | Chart.js 4 avec gradients Tailwind, mini-sparklines dans les tableaux, cartes thermiques |
| 5.3 Hub configuration | `views/tools/index.php` (nouveau) | Page d'index configuration avec icônes illustrées par catégorie, previews templates email |
| 5.4 Micro-animations finales | CSS + Alpine.js | Fade-in stagger sur les cards, pulse sur badges de statut, confetti sur "Livré", transitions modals avec blur |
| 5.5 Retrait Bootstrap | `views/inc/head_scripts.php`, `footer.php` | Supprimer Bootstrap CSS/JS |
| 5.6 Retrait jQuery | `views/inc/footer.php`, `dataJs/*.js` | Migration vers vanilla/Alpine |
| 5.7 Audit accessibilité | Toutes les vues | Focus, contraste, aria-labels |
| 5.8 Cohérence visuelle globale | Toutes les vues | Vérification que toutes les illustrations, cartes, galeries et animations sont cohérentes sur l'ensemble des pages |
| 5.9 Test complet | — | Parcours Admin, Client, Employé, Chauffeur avec validation des visuels sur mobile/tablette/desktop |

**Livrable** : Frontend entièrement modernisé avec identité visuelle premium — illustrations, cartes interactives, galeries photos, animations fluides, Bootstrap/jQuery retirés.

---

## 11. Fichiers impactés

### 11.1 Fichiers à modifier (priorité haute)

| Fichier | Lignes | Impact |
|---|---|---|
| `login.php` | 265 | Refonte complète du HTML/CSS |
| `views/inc/head_scripts.php` | 30 | Ajout Tailwind, retrait progressif ancien CSS |
| `views/inc/footer.php` | 41 | Ajout Alpine.js, nettoyage scripts |
| `views/inc/left_sidebar.php` | 1342 | Refactorisation complète |
| `views/inc/topbar.php` | 143 | Nouveau design |
| `views/dashboard/index.php` | 801 | Refonte complète |
| `views/dashboard/dashboard_client.php` | 549 | Refonte complète |
| `views/dashboard/dashboard_driver.php` | 322 | Refonte complète |
| `views/courier/courier_list.php` | 220 | Refonte design + filtres |
| `views/courier/courier_view.php` | 1350 | Refonte avec workflow |
| `views/courier/courier_add.php` | 980 | Stepper multi-étapes |
| `views/customer_packages/customer_packages_list.php` | 210 | Refonte design |
| `views/pickup/pickup_list.php` | 177 | Refonte design |
| `views/tools/payment_proofs_pending.php` | 105 | Refonte avec preview |
| `views/modals/*.php` | 17 fichiers | Migration vers Alpine.js modals |

### 11.2 Fichiers à créer

| Fichier | Rôle |
|---|---|
| `views/inc/layout_start.php` | Début du layout HTML commun |
| `views/inc/layout_end.php` | Fin du layout HTML commun |
| `views/components/workflow_timeline.php` | Composant timeline réutilisable |
| `views/components/stats_card.php` | Composant carte statistique |
| `views/components/data_table.php` | Composant table de données |
| `views/components/empty_state.php` | Composant état vide avec illustration SVG |
| `views/components/vehicle_card.php` | Carte véhicule illustrée avec statut temps réel |
| `views/components/locker_visual.php` | Représentation visuelle du casier virtuel client |
| `views/components/map_widget.php` | Widget carte interactive Leaflet.js |
| `views/components/cargo_photo_gallery.php` | Galerie photos de cargaison avec lightbox |
| `views/components/capacity_gauge.php` | Jauge visuelle de capacité (consolidation/conteneur) |
| `views/components/tracking_card.php` | Carte de suivi avec illustration véhicule et ETA |
| `views/components/filter_chips.php` | Chips de filtrage colorés avec compteurs |
| `helpers/workflow_maps.php` | Mapping des statuts vers workflows |
| `assets/css/tailwind-custom.css` | Directives @layer et classes custom |
| `assets/svg/` | Dossier d'illustrations SVG (unDraw/Storyset) personnalisées aux couleurs Monrespro |
| `tailwind.config.js` | Configuration Tailwind (si build) |

### 11.3 Fichiers JS à moderniser (dataJs/)

Les ~135 fichiers JS dans `dataJs/` devront être progressivement migrés :
- Remplacer `$.ajax()` par `fetch()` ou wrapper Alpine
- Remplacer les manipulations DOM jQuery par Alpine.js data binding
- Remplacer Morris.js par Chart.js 4
- Remplacer Select2 par Tom Select

### 11.4 Fichiers à NE PAS toucher

| Fichier/Dossier | Raison |
|---|---|
| `loader.php` | ionCube protégé |
| `helpers/functions_money.php` | ionCube protégé |
| `ajax/*.php` | Backend PHP (hors périmètre) |
| `helpers/querys.php` | Backend PHP |
| `classes/*.php` | Backend PHP |
| `config/*.php` | Configuration serveur |

---

## 12. Stratégie de test

### 12.1 Tests manuels par rôle

| Rôle | Parcours de test |
|---|---|
| **Admin** | Login → Dashboard → Créer expédition → Visualiser → Assigner chauffeur → Mettre à jour statut → Vérifier preuve paiement → Rapports → Configuration |
| **Client** | Login → Dashboard → Pré-alerter achat → Voir colis → Payer → Suivre expédition → Profil |
| **Employé** | Login → Dashboard → Lister expéditions → Traiter colis → Consolidation → Rapports |
| **Chauffeur** | Login → Dashboard → Voir pickups assignés → Confirmer récupération → Livrer → Profil |

**Identifiants** : admin / admin123

### 12.2 Critères de validation

- [ ] Toutes les fonctionnalités existantes restent opérationnelles
- [ ] Aucune régression sur les appels AJAX
- [ ] Responsive : mobile (375px), tablette (768px), desktop (1280px+)
- [ ] Workflow timeline visible sur chaque entité
- [ ] Casier virtuel visuel avec compartiments sur le dashboard client
- [ ] Carte Leaflet interactive sur les pages : dashboard admin, dashboard chauffeur, liste expéditions, détail expédition, pickups, tracking public
- [ ] Galerie photos de cargaison fonctionnelle avec lightbox sur le détail expédition
- [ ] Illustrations SVG sur tous les états vides (aucun résultat, casier vide, erreur, première connexion)
- [ ] Vehicle cards illustrées avec barre de progression et ETA sur les listes
- [ ] Jauge de capacité visuelle sur les consolidations
- [ ] Skeleton loading au lieu du spinner sur toutes les pages
- [ ] Micro-animations fluides (fade-in cards, count-up compteurs, pulse badges)
- [ ] Temps de chargement < 2s sur connexion standard
- [ ] Accessibilité : navigation clavier, contraste WCAG AA
- [ ] Pas de dépendance Bootstrap/jQuery résiduelle (fin Phase 5)

### 12.3 Test de régression progressive

Chaque phase doit être testée indépendamment avant de passer à la suivante. La coexistence Bootstrap + Tailwind (avec prefix) permet de ne casser aucune page non encore migrée.

---

## 14. Suivi de réalisation

> **Mise à jour** : Mars 2026 — Progression de la refonte frontend

### ✅ Ce qui a été fait (Phase 1 à 4 — en cours)

| Phase | Tâche | Statut | Fichiers impactés |
|-------|-------|--------|-------------------|
| **Phase 1** | Intégration Tailwind CSS avec préfixe `tw-` | ✅ **Complété** | `views/inc/head_scripts.php`, `assets/css/tailwind-custom.css` |
| **Phase 1** | Composant `StatsCard` | ✅ **Créé** | `views/components/stats_card.php` |
| **Phase 1** | Layout partials | ✅ **Créés** | `views/inc/layout_start.php`, `layout_end.php` |
| **Phase 2** | Dashboard Admin (`index.php`) | ✅ **Refondu** | Cards modernes, KPIs visuels, progression bars, Lucide icons |
| **Phase 2** | Dashboard Client (`dashboard_client.php`) | ✅ **Refondu** | Welcome banner, summary cards, stat counters, Lucide icons |
| **Phase 2** | Dashboard Chauffeur (`dashboard_driver.php`) | ✅ **Refondu** | Shipment counters, pickup cards, Tailwind styling |
| **Phase 3** | Liste Expéditions (`courier_list.php`) | ✅ **Refondu** | Search, filters, bulk actions, Tailwind cards |
| **Phase 3** | Liste Colis Clients (`customer_packages_list.php`) | ✅ **Refondu** | Modern list layout, Alpine.js dropdowns |
| **Phase 3** | Liste Pickups (`pickup_list.php`) | ✅ **Refondu** | Tailwind styling, Lucide icons |
| **Phase 3** | Liste Consolidations (`consolidate_list.php`, `consolidate_packages_list.php`) | ✅ **Refondu** | Filters, status dropdowns, Tailwind UI |
| **Phase 3** | Listes Outils — Toutes les listes `tools/*_list.php` | ✅ **Refondu** | 20+ listes refondues |
| **Phase 3** | Liste Rapports (`reports_list.php`) | ✅ **Refondu** | Grid de cards avec Lucide icons, Tailwind styling |
| **Phase 3** | Liste Comptes Recevable (`accounts_receivable.php`) | ✅ **Refondu** | Date range, search, select2 customer, agency filter, bulk actions |
| **Phase 3** | Payment Gateways lists | ✅ **Refondu** | 4 fichiers `payments_gateways_list.php` |
| **Phase 3** | Locations — Villes, Pays, États | ✅ **Refondu** | `cities_list.php`, `countries_list.php`, `states_list.php` |
| **Phase 3** | Customers & Drivers lists | ✅ **Refondu** | `customers_list.php`, `drivers_list.php` |
| **Phase 3** | Prealert & Notifications | ✅ **Refondu** | `prealert_list.php`, `notifications_list.php` |
| **Phase 3** | Recipients lists | ✅ **Refondu** | `recipients_list.php`, `recipients_admin_list.php` |
| **Phase 3** | **Sidebar moderne** | ✅ **Refondu** | `views/inc/left_sidebar_modern.php` — Tailwind dark theme + Alpine.js + Lucide Icons. CSS overrides dans `tailwind-custom.css` pour positionnement fixe, mini-sidebar toggle, responsive mobile. |
| **Phase 3** | **Topbar moderne** | ✅ **Refondu** | `views/inc/topbar.php` — Tailwind + Alpine.js. Notifications panel, user dropdown avec gradient header, toggle sidebar desktop/mobile. |
| **Phase 4** | **CSS global formulaires/cards/modals** | ✅ **Complété** | `assets/css/tailwind-custom.css` — ~350 lignes de CSS qui modernisent globalement `.card`, `.form-control`, `.custom-select`, `.btn-*`, Select2, DataTables, modals, tables, labels. Appliqué à TOUTES les pages sans modifier le HTML. |
| **Phase 4** | **Formulaire `courier_add.php`** | ✅ **Refondu** | Header moderne avec Lucide icon, stepper visuel 4 étapes avec ancres, sections avec headers Lucide, icônes migrées (briefcase, calculator, save, package, book-open, users, hash, settings-2, boxes). PHP et JS préservés. |
| **Phase 4** | **Formulaire `courier_edit.php`** | ✅ **Refondu** | Header `package-check` + stepper 4 étapes (`#step-tracking`, `#step-parties`, `#step-details`, `#step-items`). 15 icônes FA/MDI → Lucide : mail, plus, calendar, truck, paperclip, trash-2, calculator, save, briefcase, boxes, book-open, user, hash, settings-2, users. PHP/JS/AJAX préservés. |
| **Phase 4** | **Icônes modals (11 fichiers)** | ✅ **Complété** | `views/modals/*.php` — Glyphicons/FA → Lucide : trash-2, mail, x-circle, check-circle, plus-circle, pencil, list, credit-card, package. Bootstrap JS conservé (risque AJAX). |
| **Phase 4** | **Formulaire `consolidate_add.php`** | ✅ **Refondu** | Header `package-plus` + stepper 4 étapes (`#step-tracking`, `#step-parties`, `#step-details`, `#step-items`). 13 icônes FA/MDI/Themify → Lucide : mail, plus, user, users, hash, settings-2, book-open, calendar, credit-card, truck, paperclip, trash-2, briefcase, boxes, search, package. PHP/JS/AJAX préservés. |
| **Phase 4** | **Formulaire `consolidate_edit.php`** | ✅ **Refondu** | Header `package-check` + stepper 4 étapes (`#step-tracking`, `#step-parties`, `#step-details`, `#step-items`). 13 icônes FA/MDI → Lucide : plus, user, users, hash, settings-2, book-open, calendar, credit-card, truck, paperclip, trash-2, search, package. Section fichiers existants préservée. PHP/JS/AJAX préservés. |
| **Phase 4** | **Formulaire `customer_packages_add.php`** | ✅ **Refondu** | Header `package-plus` + stepper 4 étapes (`#step-tracking`, `#step-sender`, `#step-details`, `#step-items`). 15 icônes FA/MDI/Themify → Lucide : package-plus, hash, user, message-circle, mail, plus, book-open, box, calendar, truck, paperclip, trash-2, boxes, briefcase, save. PHP/JS/AJAX préservés. |

### 📊 Statistiques de progression

| Métrique | Valeur |
|----------|--------|
| **Fichiers refondus** | ~71+ fichiers PHP (listes, dashboards, formulaires, modals) |
| **Composants créés** | 1 (`StatsCard`) |
| **CSS global ajouté** | ~350 lignes (modernise cards, forms, buttons, tables, modals, Select2, DataTables) |
| **Icônes migrées** | Font Awesome/MDI/Glyphicons/Themify → Lucide Icons (~90% complété) |
| **Formulaires refondus** | `courier_add.php`, `courier_edit.php`, `consolidate_add.php`, `consolidate_edit.php`, `customer_packages_add.php` (header + stepper 4 étapes + Lucide) |
| **Modals migrés (icônes)** | 11 fichiers `views/modals/*.php` — icônes Lucide, Bootstrap JS conservé |
| **Sidebar** | ✅ Moderne (Tailwind dark + Alpine.js + Lucide) |
| **Topbar** | ✅ Moderne (Tailwind + Alpine.js + notifications/user dropdown) |

### 🔧 Ce qui reste à faire (Phase 4 → 5)

| Priorité | Élément | Statut | Notes |
|----------|---------|--------|-------|
| Haute | Modals — icônes Lucide | ✅ **Complété** | 11 fichiers migrés. Bootstrap JS conservé (trop risqué AJAX). CSS global les modernise visuellement. |
| Haute | Formulaire `courier_edit.php` | ✅ **Complété** | Header + stepper + 15 icônes Lucide + 4 section anchors. |
| Haute | Formulaire `consolidate_add.php` | ✅ **Complété** | Header + stepper + 13 icônes Lucide + 4 section anchors. |
| Haute | Formulaire `consolidate_edit.php` | ✅ **Complété** | Header + stepper + 13 icônes Lucide + 4 section anchors. |
| Haute | Formulaire `customer_packages_add.php` | ✅ **Complété** | Header + stepper + 15 icônes Lucide + 4 section anchors. |
| Haute | Formulaires restants (`customer_packages_edit.php`, `consolidate_package_add.php`, etc.) | 🔶 En attente | Même pattern : header + stepper + Lucide icons. CSS global déjà appliqué. |
| Moyenne | Page de connexion (`login.php`) | ❌ Non refondue | Thème Landrick différent |
| Moyenne | Workflow timeline component | ❌ Non créé | Composant stepper pour afficher les étapes d'un envoi |
| Moyenne | VehicleCard component | ❌ Non créé | Cards véhicules illustrées |
| Basse | Cartes Leaflet | ❌ Non intégrées | Maps widget pour tracking |
| Basse | CargoPhotoGallery | ❌ Non créé | Galerie photos de cargaison |
| Basse | Retrait Bootstrap complet | ❌ Non fait | Dépend encore des JS Bootstrap pour modals |

### ⚠️ Problèmes résolus

#### 1. ~~Sidebar — INCOHÉRENCE MAJEURE~~ → ✅ RÉSOLU
- **Solution** : `left_sidebar_modern.php` avec Tailwind dark theme (`#0f172a`), Lucide Icons, Alpine.js toggle
- **CSS** : Overrides dans `tailwind-custom.css` — positionnement fixe, `mini-sidebar` toggle (70px), responsive mobile avec overlay backdrop
- **Toggle** : Desktop = `mini-sidebar` class, Mobile = `show-sidebar` class sur `#main-wrapper`

#### 2. ~~Topbar — Ancien design~~ → ✅ RÉSOLU
- **Solution** : `topbar.php` avec header moderne Tailwind, notifications slide-over panel, user dropdown avec gradient header
- **CSS** : `topbar-modern` fixé en haut à droite de la sidebar, suit le toggle mini-sidebar
- Legacy topbar caché (`display:none`) pour compatibilité JS

#### 3. ~~Formulaires — Pas encore modernisés~~ → ✅ PARTIELLEMENT RÉSOLU
- **CSS global** : ~350 lignes dans `tailwind-custom.css` modernisent TOUS les formulaires (cards arrondies, inputs avec focus bleu, buttons colorés, Select2, DataTables, modals)
- **`courier_add.php`** : Header avec Lucide icon + stepper visuel 4 étapes + sections avec anchors + icons migrées
- **`courier_edit.php`** : Header `package-check` + stepper 4 étapes + 15 icônes Lucide + 4 section anchors (`#step-tracking`, `#step-parties`, `#step-details`, `#step-items`)
- **`consolidate_add.php`** : Header `package-plus` + stepper 4 étapes + 13 icônes Lucide + 4 section anchors
- **`consolidate_edit.php`** : Header `package-check` + stepper 4 étapes + 13 icônes Lucide + 4 section anchors
- **`customer_packages_add.php`** : Header `package-plus` + stepper 4 étapes + 15 icônes Lucide + 4 section anchors
- **Modals** : 11 fichiers `views/modals/*.php` — icônes Glyphicons/FA → Lucide (Bootstrap JS conservé)
- **Reste** : `customer_packages_edit.php`, `consolidate_package_add.php`, etc. bénéficient du CSS global, headers/icons à migrer

---

## 15. Conclusion de l'état actuel

La refonte a atteint un **niveau de cohérence visuelle élevé** :
- ✅ Sidebar et Topbar modernes (Tailwind + Lucide + Alpine.js)
- ✅ Dashboards refondus (3 dashboards)
- ✅ 30+ pages listes refondues
- ✅ CSS global modernisant tous les formulaires/cards/modals/tables
- ✅ Formulaires `courier_add.php`, `courier_edit.php`, `consolidate_add.php`, `consolidate_edit.php` et `customer_packages_add.php` avec stepper 4 étapes et Lucide Icons
- ✅ 11 modals — icônes migrées vers Lucide (Bootstrap JS conservé, CSS global les modernise)
- 🔶 Formulaires restants (`customer_packages_edit.php`, `consolidate_package_add.php`, etc.) à migrer (même pattern)

**Prochaine priorité** : Refondre `customer_packages_edit.php` et `consolidate_package_add.php` avec le même pattern header + stepper + Lucide icons.

---

## 13. Risques et mitigations

| Risque | Probabilité | Impact | Mitigation |
|---|---|---|---|
| Conflit CSS Bootstrap/Tailwind | Haute | Moyen | Utiliser le prefix Tailwind (`tw-`) pendant la transition |
| Régression fonctionnelle AJAX | Moyenne | Haute | Tester chaque endpoint après modification JS |
| Performance dégradée (2 frameworks CSS) | Moyenne | Moyen | Transition rapide, purge Tailwind agressive |
| Fichiers ionCube incompatibles | Faible | Haute | Ne jamais modifier ces fichiers, vérifier les appels |
| Résistance au changement utilisateurs | Moyenne | Moyen | Communication préalable, guide utilisateur |
| Complexité des 135 fichiers JS | Haute | Haute | Migration progressive, pas de big bang |
| Perte de fonctionnalités cachées | Moyenne | Haute | Audit exhaustif avant chaque phase |

---

## Conclusion

La refonte frontend de Monrespro Logistics est **hautement pertinente et nécessaire**. L'interface actuelle, héritée de DEPRIXA PRO, n'est pas adaptée au public cible (clients non-techniques en Afrique, chauffeurs sur mobile, employés multi-agences).

La migration vers **Tailwind CSS + Alpine.js** avec une **identité visuelle moderne de type SaaS logistique premium** permettra :
- Une **réduction de 70%** du poids des assets CSS/JS
- Une **expérience utilisateur guidée** grâce aux workflows visuels
- Une **interface riche et immersive** — cartes interactives Leaflet, illustrations SVG, galeries photos de cargaison, casier virtuel visuel, vehicle cards illustrées, jauges de capacité, chronomètres et barres de progression temps réel
- Une **maintenabilité accrue** grâce aux composants réutilisables (20+ composants PHP/Alpine)
- Une **interface mobile-first** adaptée aux usages terrain (chauffeurs, clients)
- Des **micro-animations fluides** — skeleton loading, fade-in, count-up, confetti, transitions modals avec blur

L'objectif n'est pas simplement de "moderniser le CSS", mais de **transformer radicalement l'expérience utilisateur** en offrant une interface au niveau des meilleures plateformes SaaS de logistique, avec des visuels qui rendent chaque étape du processus claire, engageante et intuitive.

Le plan en 5 phases sur 11 semaines permet une migration progressive sans interruption de service, avec des livrables testables à chaque étape.
