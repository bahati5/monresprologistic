# REFONTE FRONTEND — Monrespro Logistics

**Version :** 1.0  
**Date :** 13 mars 2026  
**Projet :** Refonte UI/UX et modernisation du frontend  
**Identifiants de test :** admin / admin123  

---

## TABLE DES MATIÈRES

1. [Pertinence de la refonte](#1-pertinence-de-la-refonte)
2. [État des lieux du frontend actuel](#2-état-des-lieux-du-frontend-actuel)
3. [Objectifs et principes de la refonte](#3-objectifs-et-principes-de-la-refonte)
4. [Stack technique cible](#4-stack-technique-cible)
5. [Système de workflow par fonctionnalité](#5-système-de-workflow-par-fonctionnalité)
6. [Interfaces détaillées par rôle](#6-interfaces-détaillées-par-rôle)
7. [Plan de mise en œuvre](#7-plan-de-mise-en-œuvre)
8. [Annexes](#8-annexes)

---

## 1. PERTINENCE DE LA REFONTE

### 1.1 Pourquoi une refonte est pertinente

| Problème actuel | Impact | Solution apportée par la refonte |
|-----------------|--------|-----------------------------------|
| **Bibliothèques anciennes** (Bootstrap 4.1, jQuery 3.3.1, Chart.js 2.x) | Risques de sécurité, maintenance difficile, performances sous-optimales | Tailwind CSS, JS moderne (ou Alpine.js), Chart.js 4 ou alternative légère |
| **UI peu explicite** | Les exécutants, admin et clients se perdent dans les écrans | Hiérarchie visuelle claire, libellés explicites, états de workflow visibles |
| **Expérience fragmentée** | Login (Landrick) ≠ Dashboard (template DEPRIXA) ; jQuery différent selon les pages | Une seule stack cohérente sur tout le parcours |
| **Workflow peu visible** | Les statuts existent en BDD mais ne guident pas l’utilisateur | Indicateurs d’étape, parcours guidés, actions contextuelles |
| **Code difficile à maintenir** | Sidebar 1300+ lignes, duplications, HTML mal formé | Composants réutilisables, structure claire, design system |
| **Mobile / UX** | Responsive basique, pas de vraie approche mobile-first | Tailwind responsive, touch-friendly, feedback immédiat |

**Conclusion :** Une refonte frontend est **pertinente et recommandée** pour aligner l’outil sur les usages réels (exécutants, admin, clients), sécuriser et simplifier la maintenance, et améliorer l’adoption sur le terrain.

### 1.2 Ce que la refonte ne change pas

- **Backend PHP** : Les fichiers `ajax/`, `helpers/`, la logique métier et l’authentification restent inchangés dans un premier temps.
- **Base de données** : Aucune modification de schéma requise pour la refonte UI.
- **Fichiers ionCube** : `loader.php` et les fichiers protégés ne sont pas modifiés ; on adapte uniquement les vues et les assets.

---

## 2. ÉTAT DES LIEUX DU FRONTEND ACTUEL

### 2.1 Stack et versions

| Composant | Version actuelle | Problème |
|-----------|------------------|----------|
| Bootstrap | 4.1.0 (2018) | Obsolète ; Bootstrap 5 utilise `data-bs-*` |
| jQuery | 3.3.1 (dashboard) / 3.6.0 (login) | Versions différentes, 3.3.1 sans correctifs récents |
| Chart.js | 2.7 / 2.8 | Ligne 4.x avec meilleures perfs et API |
| DataTables | 1.13.7 (CDN) | OK, mais chargé partout |
| SweetAlert2 | Non versionné | À conserver ou remplacer par modales cohérentes |
| Select2, intlTelInput, Summernote, etc. | Multiples | Beaucoup de JS legacy |
| CSS | `style.min.css` (~493k), Landrick (login) | Deux systèmes, peu de variables, difficile à thème |

### 2.2 Structure des vues

- **Layout** : `views/inc/head_scripts.php`, `footer.php`, `topbar.php`, `left_sidebar.php`, `preloader.php`.
- **Sidebar** : Un fichier unique avec des branches `userlevel == 9`, `== 2`, `== 1`, `== 3` ; répétitions, chaînes en dur, bug HTML (lignes 308–322).
- **Pages** : Chaque écran = un fichier PHP qui inclut le layout et du HTML + requêtes SQL parfois dans la vue (ex. `dashboard_client.php`).

### 2.3 Parcours par rôle (résumé)

| Rôle | Dashboard | Écrans principaux |
|------|-----------|-------------------|
| **Admin (9)** | `views/dashboard/index.php` | Tous les modules (courier, pickup, consolidate, packages, rapports, config) |
| **Employé (2)** | Idem | Même que admin mais filtré par agence, pas de config système |
| **Client (1)** | `dashboard_client.php` | Casier virtuel, pré-alertes, colis, expéditions, ramassages, destinataires |
| **Chauffeur (3)** | `dashboard_driver.php` | Expéditions assignées, ramassages, rapports |

### 2.4 Problèmes UX identifiés

- **Login** : Typo « otre » → « autre », CTA secondaire (Suivi) qui concurrence la connexion.
- **Dashboard** : Trop de cartes et d’onglets sans priorisation ; pas de « prochaine action » claire.
- **Listes** : Filtres + tableau chargé en AJAX ; pas de feedback de chargement standardisé ; actions groupées dans des modales génériques.
- **Formulaires** : Longs (ex. `courier_add.php`), Select2 partout ; pas de sauvegarde brouillon ni de rappel d’étape.
- **Workflow** : Statuts en BDD (`cdb_styles`) et en couleurs, mais pas de timeline ni d’étapes explicites pour l’utilisateur.

---

## 3. OBJECTIFS ET PRINCIPES DE LA REFONTE

### 3.1 Objectifs

1. **Une seule stack frontend** : Tailwind CSS + JS modulaire (ou Alpine.js pour l’interactivité), cohérente de la login à toutes les interfaces.
2. **UI/UX explicite** : Chaque écran indique clairement « où je suis », « ce que je peux faire », « quelle est la prochaine étape ».
3. **Workflow intégré** : Pour chaque entité (colis, expédition, ramassage, consolidation, preuve de paiement), afficher un parcours en étapes et des actions contextuelles.
4. **Design system** : Couleurs, typo, espacements, composants (boutons, cartes, badges, formulaires) définis une fois et réutilisés.
5. **Performance et maintenabilité** : Moins de CSS/JS globaux, chargement conditionnel des scripts par page, HTML valide et sémantique.

### 3.2 Principes UI/UX

- **Mobile-first** : Conception d’abord pour petit écran, puis élargissement.
- **Hiérarchie claire** : Un titre de page, des sous-titres de section, des libellés explicites (pas seulement des icônes).
- **Feedback immédiat** : Loaders, toasts ou messages après chaque action (création, mise à jour statut, etc.).
- **Accessibilité** : Contraste suffisant, champs labellisés, focus visible, boutons et liens explicites.
- **Cohérence** : Même pattern pour « liste → détail → action » sur tous les modules.

---

## 4. STACK TECHNIQUE CIBLE

### 4.1 Proposition

| Couche | Technologie | Rôle |
|--------|-------------|------|
| **CSS** | **Tailwind CSS 3.x** | Utility-first, design tokens (couleurs, espacements), composants réutilisables via @apply si besoin |
| **JS** | **Alpine.js 3.x** (ou Vanilla JS modulaire) | Interactivité légère (modales, onglets, filtres, chargement AJAX) sans tout réécrire en framework |
| **Icônes** | **Heroicons** ou **Lucide** (SVG) | Une seule librairie, cohérente |
| **Graphiques** | **Chart.js 4** ou **ApexCharts** | Dashboards et rapports |
| **Tables** | **DataTables** (conservé) ou **TanStack Table** côté client | Listes avec tri, filtre, pagination |
| **Formulaires** | Champs natifs + Tailwind + Alpine pour validation côté client | Select2 remplacé par un composant « select searchable » léger ou Alpine + API existante |
| **HTTP** | `fetch` + endpoints PHP existants (`ajax/*.php`) | Pas de changement côté backend |
| **Build (optionnel)** | Vite ou Laravel Mix | Compilation Tailwind, purge, minification |

### 4.2 Compatibilité avec l’existant

- Les vues PHP continuent de rendre du HTML ; on remplace les classes Bootstrap par des classes Tailwind et on introduit des balises `x-data` (Alpine) où nécessaire.
- Les handlers AJAX restent en PHP ; seuls l’appel (fetch) et le rendu du résultat changent côté frontend.
- Pas d’obligation de tout migrer d’un coup : migration par zone (login → layout → dashboard → modules) possible.

---

## 5. SYSTÈME DE WORKFLOW PAR FONCTIONNALITÉ

L’idée est d’afficher, pour chaque type d’entité, un **parcours en étapes** et des **actions possibles selon le statut**, afin que l’exécutant ou l’admin sache toujours quoi faire ensuite.

### 5.1 Workflow « Colis client » (Online Shopping)

| Étape | Statuts concernés | Affichage proposé | Actions possibles |
|-------|-------------------|-------------------|-------------------|
| 1. Pré-alerte | Pré-alerte créée | Badge « Pré-alerte » | Voir détail, modifier |
| 2. Réception | Colis enregistré, en attente | Badge « Reçu » | Pesée, calcul frais, notifier client |
| 3. Paiement | En attente paiement / Preuve envoyée | Badge « Paiement en attente » ou « Preuve à valider » | Valider preuve, enregistrer paiement |
| 4. Consolidation (optionnel) | Inclus dans un lot | Badge « Consolidé » | Voir le lot |
| 5. Expédition | En transit | Badge « En transit » + timeline | Mettre à jour suivi |
| 6. Arrivée destination | Arrivé au hub | Badge « Arrivé » | Notifier client |
| 7. Livraison | Livré | Badge « Livré » | Clôturer |

**Interface :** Sur la liste des colis, une colonne « Étape » avec un indicateur visuel (stepper ou badges). Sur la fiche colis, une **timeline verticale** avec les dates et statuts, et un bloc « Prochaine action » (ex. « Valider la preuve de paiement »).

### 5.2 Workflow « Expédition » (Courier)

| Étape | Statuts (ex. cdb_styles) | Affichage | Actions |
|-------|---------------------------|-----------|--------|
| Création | Pending_Collection, Quotation | « Créée » | Modifier, assigner chauffeur |
| Prise en charge | Received Office, Pick_up, Picked up | « Prise en charge » | Mettre à jour statut |
| Transit | In_Transit, In_Warehouse, Distribution | « En transit » | Suivi, changement bureau |
| Livraison | On Route, Available | « En cours de livraison » | Assigner chauffeur |
| Clôture | Delivered | « Livrée » | Facture, archive |
| Annulation | Cancelled | « Annulée » | — |

**Interface :** Même principe : liste avec indicateur d’étape, fiche avec timeline et boutons d’action contextuels (Changer statut, Assigner chauffeur, Imprimer étiquette, etc.).

### 5.3 Workflow « Ramassage » (Pickup)

| Étape | Affichage | Actions |
|-------|-----------|--------|
| Demande créée | « En attente » | Assigner chauffeur |
| Chauffeur assigné | « Assigné » | Accepter (chauffeur) / Refuser |
| Accepté | « Accepté » | Marquer « Ramassé » |
| Ramassé | « Ramassé » | Lier à une expédition |
| Annulé / Refusé | « Annulé » | — |

**Interface :** Liste avec statut lisible ; fiche avec étapes et boutons « Accepter », « Refuser », « Marquer ramassé ».

### 5.4 Workflow « Preuve de paiement »

| Étape | Affichage | Actions (admin) |
|-------|-----------|------------------|
| Preuve déposée | « En attente de validation » | Ouvrir, voir pièces, Approuver / Rejeter |
| Approuvée | « Validée » | — |
| Rejetée | « Rejetée » + motif | Demander nouvelle preuve (workflow métier) |

**Interface :** Page « Preuves en attente » avec cartes par preuve (client, montant, date, pièces) et boutons « Approuver » / « Rejeter » avec motif obligatoire.

### 5.5 Règles d’affichage communes

- **Couleurs** : Réutiliser les couleurs de `cdb_styles` pour les badges de statut, avec une palette Tailwind cohérente (primary, success, warning, danger, neutral).
- **Timeline** : Composant réutilisable (Alpine ou HTML+Tailwind) affichant la liste des statuts/suivis avec date et libellé.
- **Prochaine action** : Bloc mis en évidence en haut de la fiche (ex. bandeau « Action requise : valider la preuve de paiement »).

---

## 6. INTERFACES DÉTAILLÉES PAR RÔLE

### 6.1 Login (tous)

- **Objectif** : Connexion rapide et claire, sans distraction.
- **Layout** : Fond sobre (dégradé ou image légère), formulaire centré (ou split conservé mais simplifié).
- **Champs** : Utilisateur, Mot de passe ; case « Se souvenir de moi » ; lien « Mot de passe oublié » ; bouton « Se connecter ».
- **Liens secondaires** : « S’inscrire », « Suivre une expédition » en bas ou en petit, sans concurrence avec le CTA principal.
- **Erreur** : Message sous le formulaire (ou toast), libellé explicite (« Identifiant ou mot de passe incorrect »).
- **Correction** : Corriger la typo « otre » → « autre » sur le panneau droit si conservé.

### 6.2 Dashboard Admin / Employé

- **Objectif** : Vue d’ensemble et accès rapide aux tâches du jour.
- **Bloc 1 – KPIs** : 4 à 6 cartes (Colis en attente, Expéditions du jour, Preuves à valider, etc.) avec chiffres et lien « Voir ».
- **Bloc 2 – Actions prioritaires** : Liste courte « À faire » (ex. « 3 preuves de paiement à valider », « 5 ramassages non assignés ») avec boutons directs.
- **Bloc 3 – Résumé par module** : Onglets ou cartes (Expéditions, Ramassages, Colis, Pré-alertes) avec tableau récapitulatif (optionnel, chargé en AJAX comme aujourd’hui).
- **Navigation** : Sidebar claire avec icônes + libellés ; regroupement par domaine (Achats en ligne, Expéditions, Ramassage, Consolidation, Rapports, Comptabilité, Utilisateurs, Configuration).
- **Header** : Logo, recherche globale (optionnel), notifications, profil utilisateur.

### 6.3 Dashboard Client

- **Objectif** : Casier virtuel visible, suivi des colis et des expéditions.
- **Bloc 1 – Mon casier virtuel** : Adresse Belgique + numéro de casier bien mis en avant (copier l’adresse en un clic).
- **Bloc 2 – Résumé** : Nombre de colis en attente, en transit, livrés ; montant à payer si pertinent.
- **Bloc 3 – Dernières activités** : Liste courte (derniers colis / expéditions) avec statut et lien vers le détail.
- **Actions rapides** : « Nouvelle pré-alerte », « Nouveau colis », « Suivre une expédition ».

### 6.4 Dashboard Chauffeur

- **Objectif** : Voir les ramassages et expéditions assignés, accepter / refuser, mettre à jour.
- **Bloc 1 – Ramassages du jour** : Liste des ramassages assignés avec boutons « Accepter » / « Refuser » et « Marquer ramassé ».
- **Bloc 2 – Expéditions à livrer** : Liste des expéditions assignées avec statut et « Marquer livré ».
- **Bloc 3 – Résumé** : Nombre de ramassages/expéditions par statut.

### 6.5 Listes (expéditions, colis, ramassages, consolidations, clients…)

- **Structure commune** :
  - Titre de page + fil d’Ariane.
  - Filtres en barre (recherche, statut, dates) avec bouton « Appliquer » / « Réinitialiser ».
  - Tableau responsive : colonnes pertinentes (numéro, date, statut, client, montant, actions).
  - Colonne « Statut / Étape » avec badge coloré et optionnellement mini-stepper.
  - Colonne « Actions » : Voir, Modifier, (autres selon contexte).
  - Pagination et choix du nombre de lignes par page.
- **Chargement** : Skeleton ou spinner pendant l’AJAX ; message « Aucun résultat » si vide.
- **Actions groupées** : Si sélection multiple (cases à cocher), barre d’actions (Changer statut, Assigner chauffeur, Imprimer étiquettes) avec confirmation.

### 6.6 Fiches détail (expédition, colis, ramassage, consolidation)

- **En-tête** : Numéro de tracking / référence, statut actuel (badge), boutons d’action (Modifier, Imprimer étiquette, etc.).
- **Bloc « Workflow / Timeline »** : Historique des statuts et événements avec dates.
- **Bloc « Prochaine action »** : Si applicable, bandeau ou encadré avec un seul CTA principal.
- **Sections** : Infos générales, Expéditeur / Destinataire, Contenu / Poids, Paiements, Documents (preuves, factures).
- **Design** : Cartes (Tailwind) avec titres de section ; mise en page en grille sur desktop, empilée sur mobile.

### 6.7 Formulaires (création / édition)

- **Structure** : Étapes si le formulaire est long (ex. création d’expédition : 1. Parties, 2. Contenu, 3. Options, 4. Récap).
- **Champs** : Labels au-dessus, placeholders optionnels ; messages d’erreur sous le champ (validation côté client + retour AJAX).
- **Selects lourds** : Remplacer Select2 par un composant « select searchable » (Alpine + fetch vers les endpoints existants type `select2_sender.php`).
- **Boutons** : « Enregistrer » (primary), « Enregistrer brouillon » si métier pertinent, « Annuler » (lien ou secondaire).
- **Feedback** : Après soumission, message de succès et redirection ou mise à jour de la fiche.

### 6.8 Preuves de paiement (admin)

- **Liste** : Cartes ou tableau avec colonnes : Client, Commande/Colis, Montant, Date dépôt, Pièces jointes, Actions.
- **Détail** : Visualisation des pièces (images/PDF), montant attendu, boutons « Approuver » / « Rejeter ».
- **Rejet** : Modal avec champ « Motif » obligatoire avant envoi.

### 6.9 Rapports

- **Page** : Filtres (dates, agence, type de rapport) en haut.
- **Contenu** : Tableaux de données + graphiques (Chart.js 4 ou ApexCharts) selon le type (ventes, volumes, par agence, etc.).
- **Export** : Boutons CSV / PDF si déjà présents côté backend, exposés clairement.

### 6.10 Configuration / Paramètres

- **Organisation** : Menu ou onglets par domaine (Général, Bureaux, Paiements, Tarifs, Templates, etc.).
- **Formulaires** : Même principe que 6.7 ; listes d’entités (offices, agences, statuts, etc.) avec boutons Ajouter / Modifier / Supprimer et modales ou pages dédiées.

---

## 7. PLAN DE MISE EN ŒUVRE

### Phase 1 – Fondations (2–3 semaines)

1. Introduire Tailwind CSS dans le projet (fichier de config, build ou CDN pour prototypage).
2. Définir le design system : couleurs (dont statuts), typographie, espacements, composants de base (bouton, carte, badge, input, select).
3. Refaire le **layout global** : header, sidebar, footer en Tailwind ; garder la structure PHP des includes, remplacer les classes.
4. Refaire la **page de login** en Tailwind ; corriger la typo et simplifier les CTA.
5. Tester la navigation (sidebar) pour tous les rôles sur une base de données de test.

### Phase 2 – Dashboards (2–3 semaines)

1. Dashboard admin : cartes KPI, bloc « Actions prioritaires », onglets de résumé.
2. Dashboard client : casier virtuel, résumé, dernières activités.
3. Dashboard chauffeur : ramassages et expéditions du jour.
4. Intégrer les graphiques (Chart.js 4 ou autre) sur les dashboards existants qui en ont besoin.

### Phase 3 – Workflow et listes (3–4 semaines)

1. Composant **Timeline** réutilisable (statuts + dates).
2. Composant **Badge / Stepper** d’étape pour les listes.
3. Refonte des listes principales : Expéditions, Colis clients, Ramassages, Consolidations (filtres, tableau, pagination, chargement).
4. Refonte des fiches détail avec timeline et bloc « Prochaine action ».

### Phase 4 – Formulaires et actions (2–3 semaines)

1. Formulaires de création/édition : Expédition, Colis, Ramassage, Pré-alerte (étapes + champs en Tailwind).
2. Remplacement progressif de Select2 par un composant searchable (Alpine + API existante).
3. Modales (changement de statut, assignation chauffeur, validation preuve) en Tailwind + Alpine.
4. Page dédiée Preuves de paiement avec approbation/rejet.

### Phase 5 – Rapports, config et polish (2 semaines)

1. Pages Rapports avec filtres et graphiques.
2. Pages Configuration en Tailwind (listes + formulaires).
3. Revue accessibilité (contraste, focus, labels).
4. Tests manuels complets (parcours Admin, Employé, Client, Chauffeur) avec les identifiants **admin / admin123**.

### Livrables par phase

- Code (vues PHP, CSS, JS) dans le dépôt.
- Documentation courte des composants (design system) et des conventions (nommage des classes, structure des vues).
- Liste des URLs / écrans modifiés pour recette.

---

## 8. ANNEXES

### A. Identifiants de test

- **Admin** : `admin` / `admin123`
- À configurer en base si besoin pour Employé, Client, Chauffeur (ex. `employee`, `customer`, `driver` avec mot de passe de test).

### B. Fichiers clés à modifier en priorité

| Fichier | Rôle |
|---------|------|
| `views/inc/head_scripts.php` | Remplacer les liens CSS par Tailwind (et un fichier de composants si besoin). |
| `views/inc/footer.php` | Remplacer/ajouter Alpine.js, supprimer ou conditionner les anciens scripts. |
| `views/inc/left_sidebar.php` | Réécrire en Tailwind, corriger le HTML, factoriser les branches par rôle. |
| `views/inc/topbar.php` | Tailwind + structure notifications/profil. |
| `login.php` | Nouveau layout Tailwind, correction typo. |
| `views/dashboard/index.php` | Nouveau dashboard admin. |
| `views/dashboard/dashboard_client.php` | Nouveau dashboard client. |
| `views/dashboard/dashboard_driver.php` | Nouveau dashboard chauffeur. |
| `views/courier/courier_list.php`, `courier_view.php`, `courier_add.php` | Listes, fiche, formulaire. |
| `views/customer_packages/*.php` | Idem pour colis clients. |
| `views/pickup/*.php` | Idem pour ramassages. |
| `views/consolidate/*.php`, `views/consolidate_packages/*.php` | Consolidations. |
| `payment_proofs_pending.php` + vues associées | Preuves de paiement. |

### C. Référence des statuts (cdb_styles)

À conserver pour les couleurs et libellés des badges ; les mapper vers des classes Tailwind (ex. `bg-green-600` pour Livré, `bg-red-600` pour Annulé, etc.) dans un fichier de configuration ou un partial PHP.

### D. Glossaire

- **Exécutant** : Employé (userlevel 2) ou Admin (userlevel 9) qui traite les colis, expéditions, ramassages au quotidien.
- **Workflow** : Enchaînement d’étapes et de statuts pour une entité (colis, expédition, etc.) avec actions possibles à chaque étape.
- **Design system** : Ensemble de couleurs, typographies, composants et règles d’usage pour garder l’UI cohérente.

---

*Document rédigé le 13 mars 2026 — Monrespro Logistics. Identifiants de test : admin / admin123.*
