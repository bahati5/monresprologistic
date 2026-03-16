# Plan de Test — Branding MonResPro & Workflows

> **Date :** 15 mars 2026  
> **Objectif :** Valider le branding MonResPro, les workflows fonctionnels et les performances de l'application.  
> **URL locale :** `http://localhost/logistics.monrespro.com/`

---

## Résumé des tests autonomes (Cascade)

| Test automatisé | Résultat |
|---|---|
| PHP syntax check — `left_sidebar_onepanel.php` | ✅ OK |
| PHP syntax check — `load_notifications_modern.php` | ✅ OK |
| PHP syntax check — `login.php` | ✅ OK |
| PHP syntax check — `forgot-password.php` | ✅ OK |
| PHP syntax check — `sign-up.php` | ✅ OK |
| PHP syntax check — `head_scripts.php` | ✅ OK |
| CSS validité — `tailwind-custom.css` | ✅ OK |
| Grep anciennes couleurs teal (#0d9488, #2dd4bf, #14b8a6) | ✅ 0 résultat |
| Grep anciennes couleurs indigo (#6366f1, #818cf8) | ✅ 0 résultat |
| Grep anciennes couleurs blue générique (#3b82f6, #2563eb) | ✅ 0 résultat |
| Cohérence nouvelles couleurs MonResPro dans sidebar | ✅ Vérifié |
| Cohérence nouvelles couleurs MonResPro dans notifications | ✅ Vérifié |
| Cohérence nouvelles couleurs MonResPro dans CSS global | ✅ Vérifié |
| Optimisation performance — suppression setInterval Lucide | ✅ Vérifié |
| Optimisation performance — lazy-load Leaflet/Flatpickr/TomSelect | ✅ Vérifié |
| Fix sidebar expansion — inline width removed | ✅ Vérifié |
| Fix login/signup — top gap removed | ✅ Vérifié |
| Fix signup scroll — only form scrolls | ✅ Vérifié |
| **Fix selects inscription — Select2 → Tom Select** | ✅ **Remplacé par Tom Select moderne** |
| **Fix selects fonctionnels — recherche pays/état/ville** | ✅ **AJAX fonctionnel avec Tom Select** |

---

## Palette de référence MonResPro

| Rôle | Couleur | Aperçu |
|---|---|---|
| Primary | `#1a7fb5` | 🟦 Bleu MonResPro |
| Light / Active | `#5bb8e0` | 🔵 Bleu clair |
| Dark / Hover | `#15699a` | 🔷 Bleu foncé |
| Sidebar BG | `#0b1120` | ⬛ Navy sombre |
| Badge notif | `#ef4444` | 🔴 Rouge |

---

## Tests manuels à effectuer

### 1. Page de connexion (`login.php`) — Branding + Layout + Fonctionnel

- [✅] **1.1** Ouvrir `http://localhost/logistics.monrespro.com/login.php`
- [✅] **1.2** Le panneau gauche (illustration) a un dégradé bleu MonResPro (pas violet/indigo)
- [✅] **1.3** Le bouton "Se connecter" est bleu MonResPro (`#1a7fb5`), pas bleu générique
- [✅] **1.4** Au survol du bouton, il devient bleu foncé (`#15699a`)
- [✅] **1.5** Le lien "Mot de passe oublié" est bleu MonResPro
- [✅ ] **1.6** Le lien "Inscription" est bleu MonResPro
- [✅ ] **1.7** Les champs de saisie au focus ont un contour bleu MonResPro (pas bleu standard)
- [✅] **1.8** Le logo s'affiche correctement en haut du formulaire
- [✅] **1.9** Le preloader affiche le nom du site
- [✅] **1.10** **LAYOUT :** Pas de gap blanc en haut de la page (pleine hauteur viewport)
- [✅] **1.11** **LAYOUT :** Le panneau de droite (formulaire) est scrollable indépendamment
- [✅] **1.12** **FONCTIONNEL :** Se connecter avec des identifiants valides fonctionne → redirige vers `index.php`
- [✅ oui mais le message est en anglais] **1.13** **FONCTIONNEL :** Se connecter avec des identifiants invalides affiche une erreur
- [✅] **1.14** **FONCTIONNEL :** La case "Se souvenir de moi" fonctionne (cookie créé)
- [✅] **1.15** **FONCTIONNEL :** Le lien "Inscription" redirige vers `sign-up.php`

### 2. Page mot de passe oublié (`forgot-password.php`)

- [✅] **2.1** Ouvrir `http://localhost/logistics.monrespro.com/forgot-password.php`
- [✅] **2.2** La page s'affiche sans erreur PHP
- [✅] **2.3** Le meta "keywords" contient "Monrespro" (pas "Deprixa") — vérifier via `Ctrl+U` (source)
- [x La page a un style totalement différent du design systeme et j'ai ces erreurs : GET http://localhost/logistics.monrespro.com/plugin/whatsapp-chat-support.css net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:37  GET http://localhost/logistics.monrespro.com/plugin/components/Font%20Awesome/css/font-awesome.min.css net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:27  GET http://localhost/logistics.monrespro.com/assets/assets/js/jquery.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:28  GET http://localhost/logistics.monrespro.com/assets/assets/js/jquery-ui.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:29  GET http://localhost/logistics.monrespro.com/assets/assets/js/jquery.ui.touch-punch.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:30  GET http://localhost/logistics.monrespro.com/assets/assets/js/jquery.wysiwyg.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:31  GET http://localhost/logistics.monrespro.com/assets/assets/js/global.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:32  GET http://localhost/logistics.monrespro.com/assets/assets/js/custom.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:33  GET http://localhost/logistics.monrespro.com/assets/assets/js/checkbox.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:308  GET http://localhost/logistics.monrespro.com/plugin/demo.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:309  GET http://localhost/logistics.monrespro.com/plugin/components/moment/moment.min.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:310  GET http://localhost/logistics.monrespro.com/plugin/components/moment/moment-timezone-with-data.min.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:311  GET http://localhost/logistics.monrespro.com/plugin/whatsapp-chat-support.js net::ERR_ABORTED 404 (Not Found)Comprendre cette erreur
forgot-password.php:314 Uncaught TypeError: $(...).whatsappChatSupport is not a function
    at forgot-password.php:314:29
(anonyme) @ forgot-password.php:314Comprendre cette erreur] **2.4** Le bouton "Envoyer" est fonctionnel

### 3. Page d'inscription (`sign-up.php`) — Branding + Layout + Fonctionnel

> **Note :** Les selects pays/état/ville ont été remplacés par **Tom Select** (plus moderne et fiable que Select2). La recherche fonctionne en temps réel via AJAX.

- [✅] **3.1** Ouvrir `http://localhost/logistics.monrespro.com/sign-up.php`
- [✅] **3.2** La page s'affiche sans erreur PHP
- [✅] **3.3** Le meta "keywords" contient "Monrespro" (pas "Deprixa") — vérifier via `Ctrl+U`
- [✅] **3.4** Le formulaire d'inscription s'affiche correctement
- [✅] **3.5** **LAYOUT :** Pas de gap blanc en haut de la page (pleine hauteur viewport)
- [✅] **3.6** **LAYOUT :** Le visuel à gauche reste fixe (ne scroll pas avec le formulaire)
- [✅] **3.7** **LAYOUT :** Seul le formulaire à droite est scrollable
- [✅] **3.8** **FONCTIONNEL — Select Pays :** Le sélecteur de pays est **recherchable et fonctionnel**
  - Cliquer dans le champ → taper "fran" → voir "France" apparaître
  - Sélectionner un pays → le champ État se débloque et charge les états
- [✅] **3.9** **FONCTIONNEL — Select État :** Le sélecteur d'état fonctionne après avoir choisi un pays
- [✅] **3.10** **FONCTIONNEL — Select Ville :** Le sélecteur de ville fonctionne après avoir choisi un état
- [✅] **3.11** **FONCTIONNEL :** Validation email en temps réel (AJAX check_email)
- [✅] **3.12** **FONCTIONNEL :** Les mots de passe doivent correspondre
- [✅] **3.13** **FONCTIONNEL :** L'inscription avec données valides crée un compte client
- [✅] **3.14** **FONCTIONNEL :** Après inscription, redirection vers la page de login
- [✅] **3.15** **FONCTIONNEL :** Le lien "J'ai déjà un compte" redirige vers `login.php`

### 4. Sidebar — Logo, couleurs et expansion/collapse

- [✅ ] **4.1** Se connecter en tant qu'**Admin** → la sidebar s'affiche
- [ ✅] **4.2** Le logo en haut affiche monrespro
- [ ✅] **4.3** Le fond de la sidebar est navy sombre (`#0b1120`), pas noir pur
- [ ✅] **4.4** Le bouton de réduction (chevron ←) fonctionne → sidebar se réduit
- [ ✅] **4.5** Quand réduite : largeur passe à 72px (rail d'icônes uniquement)
- [✅ ] **4.6** Quand réduite : le texte des menus est masqué, seules les icônes restent visibles
- [ ✅] **4.7** Quand réduite : un bouton bleu `#1a7fb5` apparaît en haut à gauche pour ré-ouvrir
- [✅ ] **4.8** **CRITIQUE — Expansion :** Cliquer sur le bouton expand → la sidebar s'élargit à 260px
- [ ✅] **4.9** **CRITIQUE — Expansion :** Le texte des menus réapparaît quand la sidebar est élargie
- [ ✅] **4.10** **CRITIQUE — Expansion :** La transition d'expansion est fluide (pas de blocage à 72px)
- [✅ ] **4.11** L'état réduit/ouvert est conservé après rechargement de page (localStorage)

### 5. Sidebar — Navigation et items actifs

- [ X] **5.1** La page active dans le menu a un fond bleu subtil `rgba(26,127,181,0.12)` et texte `#5bb8e0`
- [✅ ] **5.2** Les éléments inactifs sont gris clair, pas d'ancienne couleur teal visible
- [ ✅] **5.3** Au survol d'un item inactif, léger fond blanc apparaît
- [ ✅] **5.4** Les groupes de menu se déplient/replient avec animation fluide
- [ ✅] **5.5** Les sous-groupes fonctionnent également
- [ ✅] **5.6** Cliquer sur un lien de menu → naviguer vers la bonne page
- [✅ ] **5.7** La barre de recherche a un focus bleu MonResPro (bordure)

### 6. Sidebar — Section basse (footer)

- [✅ ] **6.1** Le lien "Notifications" est visible avec icône cloche
- [ ✅] **6.2** Le badge de notification (rouge) s'affiche si des notifications existent
- [✅] **6.3** Le lien "Paramètres" est visible (admin uniquement)
- [✅ ] **6.4** Le lien "Aide" est visible
- [✅ ] **6.5** La carte utilisateur en bas affiche le nom, rôle et avatar

### 7. Dropdown utilisateur (sidebar)

- [ ✅] **7.1** Cliquer sur la carte utilisateur → dropdown vers le haut s'ouvre
- [ OUI sauf que sur le contenu de la page , on ne pas le contenue des parametres des profils] **7.2** "Mon profil" est cliquable et redirige vers la bonne page
- [✅ ] **7.3** "Déconnexion" fonctionne → retour à la page de login

### 8. Notifications — Panneau dropdown

- [ ✅] **8.1** Cliquer sur "Notifications" dans le footer de la sidebar
- [✅ ] **8.2** Un panneau s'ouvre vers le haut avec une bordure subtile bleu MonResPro
- [ ✅] **8.3** **Header du panneau** : dégradé bleu MonResPro (`#1a7fb5` → `#15699a`), pas indigo
- [ ✅] **8.4** L'icône cloche dans le header est blanche
- [✅ ] **8.5** Le compteur de notifications s'affiche (ex: "3 Notifications")
- [ ✅] **8.6** Le bouton "Tout marquer lu" a un fond semi-transparent blanc, hover plus clair
- [ ✅] **8.7** **Items de notification** : icône cloche bleu clair `#5bb8e0` sur fond `rgba(26,127,181,0.15)`
- [ ✅] **8.8** Au survol d'un item, fond subtil et bouton "X" apparaît
- [ ✅] **8.9** Cliquer sur le texte d'une notification → redirige vers la bonne page
- [ ] **8.10** Cliquer sur "X" → la notification disparaît avec animation
- [✅] **8.11** **Lien footer** : "Voir toutes les notifications" est bleu MonResPro `#5bb8e0`
- [✅] **8.12** Au survol du lien footer, le bleu devient plus clair
- [✅] **8.13** S'il n'y a aucune notification → affiche "Aucune notification" avec icône grise

### 9. Notifications — Fonctionnel

- [ ] **9.1** Cliquer "Tout marquer lu" → toutes les notifications disparaissent
- [ ✅] **9.2** Le badge rouge dans la sidebar se met à jour (disparaît si 0)
- [ ] **9.3** Les notifications se rechargent automatiquement toutes les 25 secondes
- [ ✅] **9.4** "Voir toutes les notifications" → redirige vers `notifications_list.php`

### 10. Formulaires dans l'application (CSS global + Fonctionnel)

- [ ✅] **10.1** Ouvrir une page de formulaire (ex: `courier_add.php` ou `customers_add.php`)
- [✅ ] **10.2** Les champs de saisie au focus ont un contour bleu MonResPro `#1a7fb5`
- [✅ ] **10.3** Les Select2 dropdowns au focus/open ont un contour bleu MonResPro
- [ ✅] **10.4** L'option sélectionnée dans un Select2 dropdown a un fond bleu MonResPro
- [✅ ] **10.5** Les checkboxes cochées sont bleu MonResPro (pas bleu standard)
- [✅ ] **10.6** Le bouton `.btn-info` est bleu MonResPro `#1a7fb5`
- [ x] **10.7** Les icônes dans les titres de cartes (`.card-title i`) sont bleu MonResPro
- [ ✅] **10.8** Les titres de page (`.page-title i`) ont une icône bleu MonResPro
- [x ] **10.9** **FONCTIONNEL — Expédition :** Créer une nouvelle expédition fonctionne
- [ x] **10.10** **FONCTIONNEL — Expédition :** Le tracking s'affiche après création
- [ ] **10.11** **FONCTIONNEL — Client :** Ajouter un nouveau client fonctionne
- [✅] **10.12** **FONCTIONNEL — Validation :** Les champs requis bloquent la soumission si vides
- [✅] **10.13** **FONCTIONNEL — Upload :** Les pièces jointes s'uploadent correctement
- [x] **10.14** **PERFORMANCE :** Les pages de formulaire chargent en < 3 secondes

### 11. Tableaux DataTables (CSS global)

- [✅ ] **11.1** Ouvrir une page avec tableau (ex: `courier_list.php` ou `customers_list.php`)
- [✅ ] **11.2** La pagination active a un fond bleu MonResPro `#1a7fb5`
- [ ✅] **11.3** Aucune couleur teal ou indigo visible dans la pagination

### 12. Mobile / Responsive

- [✅ ] **12.1** Réduire la fenêtre du navigateur en largeur < 1024px
- [✅ ] **12.2** Un bouton hamburger bleu MonResPro apparaît en haut à gauche
- [x] **12.3** Cliquer dessus → la sidebar s'ouvre en overlay
- [✅] **12.4** Les couleurs sont identiques à la version desktop
- [x] **12.5** Naviguer fonctionne normalement en mobile
- [✅] **12.6** Le formulaire d'inscription s'affiche correctement en mobile (pas de visuel gauche)
- [✅] **12.7** Le formulaire de login s'affiche correctement en mobile

### 13. Rôles utilisateur — Sidebar adaptée + Workflows

- [ ✅] **13.1** Se connecter en tant qu'**Admin** → sidebar affiche les menus admin complets
- [cdn.tailwindcss.com should not be used in production. To use Tailwind CSS in production, install it as a PostCSS plugin or use the Tailwind CLI: https://tailwindcss.com/docs/installation
(anonymous) @ VM6441:64Understand this warning
VM6751 index.php:12 Uncaught TypeError: Cannot redefine property: location
    at Object.defineProperty (<anonymous>)
    at VM6751 index.php:12:12
    at VM6751 index.php:24:3Understand this error
VM6829:12 Uncaught TypeError: Cannot redefine property: location
    at Object.defineProperty (<anonymous>)
    at <anonymous>:12:12
    at <anonymous>:24:3
    at T.proto.<computed> [as replaceWith] (101.js:1:3440)
    at PageRenderer.renderElement (turbo.es2017-esm.js:4737:21)
    at PageRenderer.assignNewBody (turbo.es2017-esm.js:4912:16)
    at turbo.es2017-esm.js:4818:18
    at Bardo.preservingPermanentElements (turbo.es2017-esm.js:1795:11)
    at PageRenderer.preservingPermanentElements (turbo.es2017-esm.js:1896:17)
    at PageRenderer.replaceBody (turbo.es2017-esm.js:4816:16)Understand this error
(index):64 cdn.tailwindcss.com should not be used in production. To use Tailwind CSS in production, install it as a PostCSS plugin or use the Tailwind CLI: https://tailwindcss.com/docs/installation
(anonymous) @ (index):64Understand this warning
load_notifications_all.js:1 Uncaught SyntaxError: Identifier 'intervalMe' has already been declared (at load_notifications_all.js:1:1)Understand this error
VM6870:12 Uncaught TypeError: Cannot redefine property: location
    at Object.defineProperty (<anonymous>)
    at <anonymous>:12:12
    at <anonymous>:24:3
    at T.proto.<computed> [as replaceWith] (101.js:1:3440)
    at PageRenderer.renderElement (turbo.es2017-esm.js:4737:21)
    at PageRenderer.assignNewBody (turbo.es2017-esm.js:4912:16)
    at turbo.es2017-esm.js:4818:18
    at Bardo.preservingPermanentElements (turbo.es2017-esm.js:1795:11)
    at PageRenderer.preservingPermanentElements (turbo.es2017-esm.js:1896:17)
    at PageRenderer.replaceBody (turbo.es2017-esm.js:4816:16)Understand this error
VM6255 cdn.min.js:5 Uncaught TypeError: Cannot convert undefined or null to objectUnderstand this error
cdn.min.js:5 Uncaught TypeError: Cannot convert undefined or null to objectUnderstand this error
(index):64 cdn.tailwindcss.com should not be used in production. To use Tailwind CSS in production, install it as a PostCSS plugin or use the Tailwind CLI: https://tailwindcss.com/docs/installation
(anonymous) @ (index):64Understand this warning
load_notifications_all.js:1 Uncaught SyntaxError: Identifier 'intervalMe' has already been declared (at load_notifications_all.js:1:1)Understand this error
?callback=jQuery331045671149505868114_1773597186820&_=1773597186821:1 Object ] **13.2** Se connecter en tant qu'**Employé** → sidebar affiche les menus employé
- [✅ ] **13.3** Se connecter en tant que **Client** → sidebar affiche les menus client
- [ ] **13.4** Se connecter en tant que **Chauffeur** → sidebar affiche les menus chauffeur
- [ ✅] **13.5** Toutes les couleurs sont cohérentes quel que soit le rôle
- [✅ ] **13.6** **WORKFLOW Admin :** Accès au tableau de bord admin avec statistiques globales
- [Je ne sais pas où cliquer pour voir le casier ce qui signifie que le workflow est encore floue ] **13.7** **WORKFLOW Client :** Accès au "Locker Virtuel" avec ses colis
- [ ] **13.8** **WORKFLOW Chauffeur :** Accès aux courses/pickups assignés

### 14. Performance et Optimisations

- [x] **14.1** **PERFORMANCE :** Les pages chargent en moins de 3 secondes (pas de spinner infini)
- [✅ ] **14.2** **PERFORMANCE :** Lucide icons ne recrée pas les icônes en boucle (console calme)
- [ ✅] **14.3** **PERFORMANCE :** Pas de fuites mémoire visibles dans la console navigateur
- [✅ ] **14.4** **PERFORMANCE :** Leaflet/Flatpickr/TomSelect ne chargent que si utilisés (réseau)
- [x Certaines pages ont un rechargement complet et d'autre s'affiche mais charge ensuite] **14.5** **CACHE :** Turbo fonctionne — navigation entre pages sans rechargement complet
- [Oui mais ce n'est pas correctement appliqué car certains endroits gardent la même couleur ] **14.6** **CACHE :** Le thème (dark/light) persiste entre les navigations

### 15. Vérification visuelle générale

- [sur le loader de la page de connexion ] **15.1** Aucune couleur teal/turquoise (`#0d9488`, `#2dd4bf`, `#14b8a6`) visible nulle part
- [ sur le loader de la page de connexion] **15.2** Aucune couleur indigo/violet (`#6366f1`, `#818cf8`) visible nulle part
- [✅ ] **15.3** Le bleu utilisé partout est bien le bleu MonResPro (pas le bleu Bootstrap par défaut)
- [ Pas dans l'admin mais dans certaines pages comme forgotpassword et autre si ] **15.4** Pas de texte "Deprixa" visible dans l'interface utilisateur
- [x] **15.5** Pas d'erreur PHP dans les logs (`error_log`)
- [ ça dépend] **15.6** Pas d'erreur JavaScript dans la console du navigateur (F12)

### 16. Workflows métier critiques

- [ ] **16.1** **WORKFLOW Expédition complète :**
  - Créer expédition → Générer tracking → Voir dans la liste → Modifier statut
- [ ] **16.2** **WORKFLOW Pré-alerte client :**
  - Client crée pré-alerte → Admin voit dans dashboard → Convertit en colis
- [ ] **16.3** **WORKFLOW Consolidation :**
  - Sélectionner plusieurs colis → Créer consolidation → Payer → Expédier
- [ ] **16.4** **WORKFLOW Paiement :**
  - Ajouter charges → Sélectionner méthode paiement → Paiement Stripe/PayPal simulé
- [ ] **16.5** **WORKFLOW Notifications :**
  - Action déclenche notification → Badge s'incrémente → Cliquer marque comme lue

---

## Fichiers modifiés (référence)

| Fichier | Modifications |
|---|---|
| `views/inc/left_sidebar_onepanel.php` | Logo, accents actifs, boutons expand/mobile, **fix expansion 72px→260px** |
| `views/inc/head_scripts.php` | **Optimisation performance** — defer Lucide, lazy-load Leaflet/Flatpickr/TomSelect |
| `ajax/load_notifications_modern.php` | Header, icônes, footer du panneau notifications |
| `assets/css/tailwind-custom.css` | Focus, boutons, pagination, checkboxes, cards, Select2 |
| `login.php` | Palette Tailwind `primary` recalibrée sur MonResPro blue, **fix top gap** |
| `views/auth/forgot-password.php` | Meta tags Deprixa → Monrespro |
| `views/auth/sign-up.php` | Meta tags Deprixa → Monrespro, **fix top gap**, **fix scroll form only** |

---

## Résultat global

- [ ] **Tous les tests ci-dessus sont passés avec succès**
- [ ] **Signature testeur :** ___________________________
- [ ] **Date de validation :** ___________________________
