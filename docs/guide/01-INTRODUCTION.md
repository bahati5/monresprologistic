# Chapitre 1 — Introduction & Architecture

> **MonResPro** est un système intégré de logistique, d'expédition et de gestion de colis conçu pour les entreprises de transport, de fret et de courrier express opérant à l'échelle nationale et internationale.

---

## 1.1 Présentation générale

MonResPro permet de gérer l'intégralité du cycle de vie d'une expédition :

1. **Réception** — Le client crée une pré-alerte ou un employé enregistre un colis entrant
2. **Traitement** — L'opérateur crée l'expédition, assigne un chauffeur, calcule les frais
3. **Suivi** — Chaque étape est tracée avec des statuts personnalisables et des notifications automatiques
4. **Livraison** — Le chauffeur confirme la livraison avec signature électronique
5. **Facturation** — Génération de factures, gestion des paiements et comptes à recevoir

### Modules principaux

| Module | Description |
|--------|-------------|
| **Packages clients** | Gestion des colis pour le commerce en ligne (casier virtuel, pré-alertes) |
| **Expéditions Courier** | Envois courrier point-à-point avec calcul de tarifs |
| **Collectes (Pickup)** | Planification de la collecte de colis chez le client |
| **Consolidation** | Regroupement de plusieurs envois en un seul conteneur |
| **Comptabilité** | Comptes à recevoir, passerelles de paiement, soldes clients |
| **Rapports** | Rapports détaillés par module, par période, exportables en Excel/PDF |
| **Configuration** | Paramètres système, tarifs, taxes, localisations, notifications |

---

## 1.2 Architecture technique

### Stack technologique

| Composant | Technologie |
|-----------|------------|
| **Backend** | PHP 7.4+ (architecture MVC simplifiée) |
| **Base de données** | MySQL / MariaDB |
| **Serveur** | Apache (XAMPP / hébergement partagé) |
| **Frontend** | Tailwind CSS (préfixe `tw-`), Alpine.js, Lucide Icons |
| **UI Framework** | DaisyUI 5 (pages publiques et login), Bootstrap 4 (pages internes legacy) |
| **Thème** | Mode clair / mode sombre avec basculement automatique |
| **PDF** | TCPDF + HTML2PDF pour la génération de documents |
| **Notifications** | PHPMailer (email SMTP), Twilio (SMS), API WhatsApp |
| **Paiements** | PayPal, Stripe, Paystack, virement bancaire |

### Structure des dossiers

```
logistics.monrespro.com/
├── ajax/                    # Contrôleurs AJAX (traitement des formulaires)
│   ├── courier/             # Actions sur les expéditions
│   ├── consolidate/         # Actions sur les consolidations
│   ├── consolidate_packages/# Actions sur les packages consolidés
│   ├── customers_packages/  # Actions sur les packages clients
│   ├── pre_alerts/          # Actions sur les pré-alertes
│   ├── accounts_receivable/ # Actions comptabilité
│   ├── reports/             # Génération des rapports
│   └── ...                  # Autres contrôleurs AJAX
├── assets/                  # Ressources statiques
│   ├── css/                 # Feuilles de style
│   ├── template/            # Template admin (Bootstrap)
│   ├── uploads/             # Fichiers uploadés (logos, avatars)
│   └── images/              # Images statiques
├── config/                  # Configuration base de données
│   └── config.php           # Paramètres de connexion BDD
├── dataJs/                  # Scripts JavaScript par page
│   ├── courier_add.js       # JS pour le formulaire d'expédition
│   ├── pre_alert_add.js     # JS pour les pré-alertes
│   ├── dashboard_index.js   # JS pour le tableau de bord admin
│   └── ...                  # ~145 fichiers JS
├── docs/                    # Documentation
│   └── guide/               # Ce guide d'utilisation
├── helpers/                 # Utilitaires et bibliothèques
│   ├── languages/           # Fichiers de traduction (fr.php, en.php, es.php, ar.php)
│   ├── phpmailer/           # Bibliothèque PHPMailer
│   ├── stripe/              # SDK Stripe
│   ├── vendor/              # Dépendances (ClickSend, Guzzle)
│   ├── querys.php           # Requêtes SQL réutilisables
│   └── function_exist.php   # Fonctions utilitaires
├── lib/                     # Classes principales
│   ├── Conexion.php         # Classe de connexion PDO
│   ├── Core.php             # Paramètres système et méthodes utilitaires
│   └── User.php             # Authentification et gestion utilisateur
├── pdf/                     # Génération de PDF (TCPDF)
├── views/                   # Vues (templates PHP)
│   ├── auth/                # Pages d'authentification
│   ├── components/          # Composants réutilisables
│   ├── consolidate/         # Vues consolidation
│   ├── consolidate_packages/# Vues packages consolidés
│   ├── courier/             # Vues expéditions
│   ├── customer_packages/   # Vues packages clients
│   ├── customers/           # Vues gestion clients
│   ├── dashboard/           # Tableaux de bord
│   ├── drivers/             # Vues chauffeurs
│   ├── inc/                 # Includes partagés (sidebar, topbar, scripts)
│   ├── locations/           # Pays, états, villes
│   ├── modals/              # Fenêtres modales
│   ├── pickup/              # Vues collectes
│   ├── prealert/            # Vues pré-alertes
│   ├── print/               # Vues d'impression
│   ├── recipients/          # Vues destinataires
│   ├── reports/             # Vues rapports
│   └── tools/               # Vues configuration
├── vendor/                  # Dépendances Composer (TCPDF, HTML2PDF)
├── index.php                # Point d'entrée (dashboard)
├── login.php                # Page de connexion
├── loader.php               # Autoloader et initialisation
└── composer.json             # Dépendances PHP
```

### Base de données — Tables principales

| Table | Description |
|-------|-------------|
| `cdb_settings` | Configuration générale du système |
| `cdb_users` | Utilisateurs (admin, employés, clients, chauffeurs) |
| `cdb_add_order` | Expéditions courrier |
| `cdb_customers_packages` | Packages clients (online shopping) |
| `cdb_consolidate` | Envois consolidés |
| `cdb_pre_alerts` | Pré-alertes de colis |
| `cdb_pickup` | Collectes planifiées |
| `cdb_recipients` | Destinataires |
| `cdb_virtual_locker` | Casiers virtuels clients |
| `cdb_accounts_receivable` | Comptes à recevoir |
| `cdb_styles` | Statuts d'expédition (avec couleurs) |
| `cdb_offices` | Bureaux |
| `cdb_branchoffices` | Agences / succursales |
| `cdb_courier_com` | Entreprises de transport partenaires |
| `cdb_category` | Catégories de marchandises |
| `cdb_packaging` | Types d'emballage |
| `cdb_shipping_mode` | Modes d'expédition (aérien, maritime, terrestre) |
| `cdb_delivery_time` | Délais de livraison |
| `cdb_met_payment` | Modes de paiement |
| `cdb_payment_methods` | Méthodes de paiement |
| `cdb_countries` | Pays |
| `cdb_states` | États / régions |
| `cdb_cities` | Villes |
| `cdb_tariffs` | Tarifs d'expédition |
| `cdb_info_ship_default` | Valeurs par défaut des formulaires d'expédition |
| `cdb_zone` | Zones géographiques |
| `cdb_notifications` | Notifications système |

---

## 1.3 Rôles utilisateurs

MonResPro utilise un système de rôles à 4 niveaux :

### 🔴 Administrateur (niveau 9)

L'administrateur a un accès **complet** à toutes les fonctionnalités :

- **Opérations** : Créer/modifier/supprimer des expéditions, packages, collectes, consolidations
- **Gestion** : Clients, destinataires, utilisateurs, chauffeurs
- **Comptabilité** : Comptes à recevoir, paiements, passerelles
- **Rapports** : Tous les rapports (général, par client, par employé, par agence, par chauffeur)
- **Configuration** : Paramètres système, entreprise, logo, email SMTP, WhatsApp, SMS, tarifs, taxes, localisations, statuts, catégories, emballages, modes d'expédition, délais de livraison, modèles de notification, sauvegardes

### 🟠 Employé (niveau 2)

L'employé a accès à toutes les **opérations quotidiennes** mais pas à la configuration système :

- **Opérations** : Identiques à l'administrateur (créer/modifier expéditions, packages, etc.)
- **Gestion** : Clients et destinataires
- **Comptabilité** : Comptes à recevoir, paiements
- **Rapports** : Tous les rapports
- **Restrictions** : Pas d'accès aux paramètres système, pas de gestion des utilisateurs

### 🔵 Client (niveau 1)

Le client accède uniquement à **ses propres données** :

- **Pré-alertes** : Créer et consulter ses pré-alertes de colis
- **Packages** : Consulter ses colis, leur statut et les paiements associés
- **Expéditions** : Créer des expéditions (formulaire simplifié), consulter sa liste
- **Collectes** : Demander une collecte, consulter ses collectes
- **Consolidation** : Consulter ses envois consolidés
- **Profil** : Modifier son profil, gérer ses destinataires
- **Casier virtuel** : Numéro de casier unique pour la réception de colis

### 🟢 Chauffeur (niveau 3)

Le chauffeur a un accès **opérationnel limité** :

- **Expéditions** : Créer et consulter les expéditions qui lui sont assignées
- **Collectes** : Créer et consulter ses collectes
- **Packages** : Consulter la liste des packages
- **Consolidation** : Consulter les envois consolidés
- **Rapports** : Accès aux rapports généraux
- **Profil** : Modifier son profil chauffeur

---

## 1.4 Navigation dans l'application

### Barre latérale (Sidebar)

La navigation principale se fait via une **barre latérale fixe** sur le côté gauche de l'écran :

- **Logo** en haut à gauche — cliquer pour revenir au tableau de bord
- **Barre de recherche** — raccourci `Ctrl+K` pour recherche rapide
- **Groupes de menu** — cliquez sur un groupe pour le déplier/replier
- **Sous-menus** — certains groupes contiennent des sous-groupes imbriqués
- **Section Paramètres** — visible uniquement pour les administrateurs
- **Pied de sidebar** — notifications, aide, déconnexion, carte utilisateur

### Réduire la sidebar

- Cliquez sur l'icône **⟪** (panel-left-close) à côté du logo pour réduire la sidebar
- En mode réduit, seules les **icônes** sont visibles (largeur 72px)
- Cliquez sur l'icône **⟫** (panel-left-open) pour rouvrir la sidebar
- L'état est **mémorisé** dans le navigateur (localStorage)

### Mode sombre

- Un **bouton de basculement** dans la sidebar permet de passer du mode clair au mode sombre
- Le thème est mémorisé dans le navigateur
- Toutes les pages authentifiées supportent le mode sombre
- Les pages publiques (tracking, etc.) restent en mode clair

### Notifications

- L'icône de **cloche** dans le pied de la sidebar affiche les notifications récentes
- Un **badge rouge** indique le nombre de notifications non lues
- Cliquez sur une notification pour voir le détail
- Lien « Voir toutes » pour accéder à la liste complète (`notifications_list.php`)

### Menu utilisateur

- La **carte utilisateur** en bas de la sidebar affiche le nom et le rôle
- Cliquez pour accéder au menu : profil, paramètres, déconnexion

---

## 1.5 Multilingue

MonResPro supporte plusieurs langues :

| Code | Langue |
|------|--------|
| `fr` | Français (par défaut) |
| `en` | Anglais |
| `es` | Espagnol |
| `ar` | Arabe (avec support RTL) |
| `pt` | Portugais |

Le changement de langue se fait dans **Configuration > Paramètres généraux > Langue**.

Les fichiers de traduction sont situés dans `helpers/languages/` et contiennent plus de 3 400 chaînes traduites.

---

## 1.6 Prérequis système

### Pour l'hébergement

| Composant | Version minimale |
|-----------|-----------------|
| PHP | 7.4 ou supérieur |
| MySQL | 5.7 ou MariaDB 10.3+ |
| Apache | 2.4+ avec mod_rewrite |
| Extensions PHP | PDO, PDO_MySQL, mbstring, curl, gd, json, openssl |

### Pour le navigateur

- Google Chrome 90+ (recommandé)
- Mozilla Firefox 90+
- Microsoft Edge 90+
- Safari 14+

> **Note :** JavaScript doit être activé. L'application utilise intensivement AJAX pour les interactions sans rechargement de page.
