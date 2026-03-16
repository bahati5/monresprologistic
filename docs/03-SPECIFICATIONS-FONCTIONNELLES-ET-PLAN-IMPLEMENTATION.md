# CAHIER DES CHARGES — Plateforme Monrespro Logistics

**Version :** 1.0  
**Date :** 12 mars 2026  
**Projet :** Adaptation de DEPRIXA PRO pour le marché africain  
**Client :** Monrespro SARL  
**Implantations :** Belgique (Hub Europe) — Kinshasa, RDC — Libreville, Gabon

---

## TABLE DES MATIERES

1. [Présentation générale](#1-présentation-générale)
2. [Architecture technique existante](#2-architecture-technique-existante)
3. [Rôles et permissions utilisateurs](#3-rôles-et-permissions-utilisateurs)
4. [Modules fonctionnels existants](#4-modules-fonctionnels-existants)
5. [Flux d'activité détaillés](#5-flux-dactivité-détaillés)
6. [Base de données](#6-base-de-données)
7. [Intégrations tierces](#7-intégrations-tierces)
8. [Contraintes et limitations](#8-contraintes-et-limitations)

---

## 1. PRESENTATION GENERALE

### 1.1 Le produit

La plateforme Monrespro Logistics repose sur **DEPRIXA PRO**, un système intégré de gestion d'expéditions et de logistique web, acquis sous licence CodeCanyon (JAOMWEB). Il couvre l'ensemble du cycle de vie d'un colis : de la réception ou de l'achat jusqu'à la livraison au destinataire final.

### 1.2 Objectif métier

Monrespro Logistics est un service de **courrier international et de forwarding** qui permet à des clients basés principalement en Afrique centrale (RDC, Gabon) de :

- **Recevoir des achats en ligne** effectués sur des plateformes internationales (Shein, Zara, AliExpress, Amazon, etc.) via un système de casier virtuel basé en Europe (Belgique).
- **Expédier des colis** depuis l'Afrique (Congo, Gabon) vers le reste du monde.
- **Suivre en temps réel** l'acheminement de leurs colis.
- **Payer** via des moyens de paiement adaptés au marché local.

### 1.3 Périmètre fonctionnel global

| Domaine                           | Description                                          |
| --------------------------------- | ---------------------------------------------------- |
| Achats en ligne (Online Shopping) | Casier virtuel, pré-alertes, enregistrement de colis |
| Expéditions (Shipments)           | Création, gestion, suivi d'envois courrier           |
| Ramassage (Pickup)                | Demandes de collecte de colis chez le client         |
| Consolidation                     | Regroupement de plusieurs colis en un seul envoi     |
| Suivi (Tracking)                  | Suivi public et privé par numéro de tracking         |
| Paiements                         | Passerelles en ligne et paiement en espèces          |
| Rapports                          | Rapports par agence, client, chauffeur, employé      |
| Notifications                     | Email, SMS (Twilio/ClickSend), WhatsApp              |
| Administration                    | Paramétrage complet du système                       |

---

## 2. ARCHITECTURE TECHNIQUE EXISTANTE

### 2.1 Stack technologique

| Composant       | Technologie                                        |
| --------------- | -------------------------------------------------- |
| Backend         | PHP 8.2 (pur, sans framework)                      |
| Base de données | MariaDB 10.4.28 (MySQL compatible)                 |
| Frontend        | Bootstrap 4, jQuery 3.6.0                          |
| Serveur web     | Apache (XAMPP)                                     |
| PDF             | TCPDF 6.6.5, html2pdf 5.2.8                        |
| Email           | PHPMailer (SMTP)                                   |
| SMS             | Twilio, ClickSend                                  |
| Paiement        | Stripe SDK PHP, PayPal JS SDK, Paystack            |
| Protection      | ionCube Loader (6 fichiers critiques)              |
| Icônes          | Material Design Icons, Font Awesome, Feather Icons |
| Alertes         | SweetAlert2                                        |

### 2.2 Structure du projet

```
logistics.monrespro.com/
├── index.php                    # Point d'entrée principal (routage par rôle)
├── login.php                    # Authentification
├── loader.php                   # Bootstrap (ionCube protégé)
├── config/
│   ├── config.php               # Configuration BDD + URL
│   └── example-config.php       # Template de configuration
├── lib/
│   ├── Conexion.php             # Wrapper PDO
│   ├── User.php                 # Gestion utilisateurs/sessions
│   └── Core.php                 # Paramètres et données de référence
├── helpers/
│   ├── querys.php               # Couche d'accès données (~6 400 lignes)
│   ├── config.lang.php          # Système de traduction
│   ├── phpmailer/               # Librairie PHPMailer
│   ├── stripe/                  # SDK Stripe
│   └── vendor/                  # Guzzle, ClickSend
├── views/
│   ├── dashboard/               # Tableaux de bord (admin, client, driver)
│   ├── customer_packages/       # Vues colis clients
│   ├── consolidate/             # Vues consolidation
│   ├── consolidate_packages/    # Vues consolidation paquets
│   ├── pickup/                  # Vues ramassage
│   ├── accounts_receivable/     # Comptes à recevoir
│   ├── prealert/                # Pré-alertes
│   ├── print/                   # Templates d'impression (factures, étiquettes)
│   ├── reports/                 # Rapports
│   ├── modals/                  # Fenêtres modales
│   ├── tools/                   # Configuration système
│   ├── auth/                    # Inscription, mot de passe oublié
│   ├── inc/                     # Composants (header, sidebar, footer)
│   └── locations/               # Pays, provinces, villes
├── ajax/                        # Handlers AJAX (27+ fichiers)
├── dataJs/                      # JavaScript métier (40+ fichiers)
├── assets/                      # CSS, images, thèmes
├── pdf/                         # Librairie TCPDF
├── install/
│   └── deprixapro_database.sql  # Schéma initial BDD (41 tables)
└── vendor/                      # Dépendances Composer
```

### 2.3 Modèle de routage

Le système utilise un routage par **fichiers PHP directs** (pas de routeur centralisé) :

1. L'utilisateur accède à une URL (ex: `courier_add.php`)
2. Le fichier charge `loader.php` (authentification, sessions, langue)
3. Le fichier inclut la vue correspondante depuis `views/`
4. Les interactions dynamiques passent par les handlers dans `ajax/`
5. Le JavaScript métier est dans `dataJs/`

### 2.4 Fichiers protégés (ionCube)

Ces 6 fichiers sont chiffrés et **non modifiables** :

| Fichier                       | Rôle                                  | Impact                                              |
| ----------------------------- | ------------------------------------- | --------------------------------------------------- |
| `loader.php`                  | Bootstrapping, auth, sessions, langue | Coeur du système — non bloquant car on peut étendre |
| `helpers/function_exist.php`  | Vérification de fonctions             | Mineur                                              |
| `helpers/functions_money.php` | Formatage monétaire, devises          | Impactant — nécessite un wrapper                    |
| `install/index.php`           | Installation initiale                 | Non impactant en production                         |
| `views/verify_purchase.php`   | Vérification de licence               | Non impactant                                       |
| `views/all_update.php`        | Mises à jour                          | Non impactant                                       |

**Conclusion : ~95% du code est en clair et modifiable.**

---

## 3. ROLES ET PERMISSIONS UTILISATEURS

### 3.1 Matrice des rôles

| Fonctionnalité                |  Admin (9)  | Employé (2) |  Client (1)   | Chauffeur (3) |
| ----------------------------- | :---------: | :---------: | :-----------: | :-----------: |
| **Tableau de bord complet**   |      X      |      X      |       —       |       —       |
| **Tableau de bord client**    |      —      |      —      |       X       |       —       |
| **Tableau de bord chauffeur** |      —      |      —      |       —       |       X       |
| **Créer expédition**          |      X      |      X      |  X (limité)   |       X       |
| **Créer expédition multiple** |      X      |      X      |       —       |       —       |
| **Lister expéditions**        |   Toutes    | Par agence  |  Les siennes  |  Les siennes  |
| **Pré-alertes : créer**       |      X      |      X      |       X       |       —       |
| **Pré-alertes : lister**      |   Toutes    | Par agence  |  Les siennes  |       —       |
| **Enregistrer colis client**  |      X      |      X      |       —       |       —       |
| **Voir ses colis**            |      —      |      —      |       X       |       X       |
| **Créer ramassage (pickup)**  | X (complet) | X (simple)  |  X (simple)   |  X (complet)  |
| **Consolidation**             |      X      |      X      |   Voir seul   |   Voir seul   |
| **Rapports**                  |    Tous     |    Tous     |       —       |   Les siens   |
| **Transactions / Paiements**  |      X      |      —      |       —       |       —       |
| **Comptes à recevoir**        |      X      |      —      |       —       |       —       |
| **Gestion clients**           |      X      |      X      |       —       |       —       |
| **Gestion destinataires**     |  X (admin)  |      —      | X (les siens) |       —       |
| **Gestion utilisateurs**      |      X      |      —      |       —       |       —       |
| **Gestion chauffeurs**        |      X      |      —      |       —       |       —       |
| **Paramètres système**        |      X      |      —      |       —       |       —       |
| **Configuration logistique**  |      X      |      —      |       —       |       —       |
| **Configuration paiements**   |      X      |      —      |       —       |       —       |
| **Géolocalisation**           |      X      |      —      |       —       |       —       |
| **Templates (email/SMS/WA)**  |      X      |      —      |       —       |       —       |
| **Profil personnel**          |      X      |      X      |       X       |       X       |

### 3.2 Détail par rôle

**Admin (userlevel = 9)**
Accès total à toutes les fonctionnalités. Peut configurer le système, gérer les utilisateurs, voir tous les rapports, gérer toutes les agences.

**Employé/Manager (userlevel = 2)**
Accès opérationnel : créer et gérer des expéditions, colis, ramassages. Rattaché à une agence (`name_off`). Ne peut pas accéder aux paramètres système ni à la gestion des utilisateurs.

**Client (userlevel = 1)**
Reçoit un **casier virtuel (Virtual Locker)** à l'inscription. Peut créer des pré-alertes, voir ses colis, créer des expéditions et des demandes de ramassage. Peut gérer ses destinataires.

**Chauffeur (userlevel = 3)**
Peut voir les colis/expéditions qui lui sont assignés, créer des expéditions, gérer des ramassages (version complète), voir ses rapports.

---

## 4. MODULES FONCTIONNELS EXISTANTS

### 4.1 Module Online Shopping (Achats en ligne)

**Objectif :** Permettre aux clients de recevoir leurs achats en ligne internationaux via un casier virtuel.

**Flux :**

1. Le client s'inscrit et reçoit un numéro de casier virtuel
2. Le client utilise l'adresse du casier pour ses achats en ligne
3. Le client crée une **pré-alerte** pour déclarer un colis en attente
4. Le colis arrive à l'entrepôt (hub Belgique)
5. Un employé **enregistre le colis** dans le système
6. Le colis est pesé, mesuré, et les frais sont calculés
7. Le client est **notifié** (email/SMS/WhatsApp)
8. Le colis est éventuellement **consolidé** avec d'autres
9. Le colis est **expédié** vers la destination
10. Le client **paie** et **reçoit** le colis

**Sous-fonctionnalités :**

- Tableau de bord Online Shopping (`dashboard_admin_packages_customers.php`)
- Liste des pré-alertes (`prealert_list.php`)
- Création de pré-alerte (`prealert_add.php`)
- Enregistrement de colis simple (`customer_packages_add.php`)
- Enregistrement de colis multiple (`customer_packages_multiple.php`)
- Enregistrement depuis pré-alerte (`customer_packages_add_from_prealert.php`)
- Liste de colis (`customer_packages_list.php`)
- Vue détaillée d'un colis (`customer_packages_view.php`)
- Modification d'un colis (`customer_package_edit.php`)
- Suivi d'un colis (`customer_package_tracking.php`)
- Livraison d'un colis (`customer_package_deliver.php`)
- Paiements des colis (`payments_gateways_list.php`)
- Ajout paiement (`add_payment_gateways_package.php`)
- Impression facture (`print_invoice_package.php`)
- Impression étiquette (`print_label_package.php`)
- Impression étiquettes multiples (`print_label_package_multiple.php`)
- Impression suivi (`print_customer_package_track.php`)
- Envoi facture par email (`send_email_pdf_packages.php`)

### 4.2 Module Expéditions (Shipments / Courier)

**Objectif :** Gérer les envois de colis point à point.

**Flux :**

1. Un admin/employé/client crée une expédition
2. Renseigne expéditeur, destinataire, articles, poids, dimensions
3. Le système calcule les frais (tarifs + taxes)
4. Un numéro de tracking est généré
5. L'expédition est assignée à un chauffeur (optionnel)
6. Le statut évolue (créé → en transit → livré)
7. Des notifications sont envoyées à chaque changement de statut
8. Le paiement est enregistré

**Sous-fonctionnalités :**

- Tableau de bord Expéditions (`dashboard_admin_shipments.php`)
- Création expédition simple (`courier_add.php`)
- Création expédition multiple (`courier_add_multiple.php`)
- Création expédition client (`courier_add_client.php`)
- Liste des expéditions (`courier_list.php`)
- Vue détaillée (`courier_view.php`)
- Modification (`courier_edit.php`)
- Suivi (`courier_shipment_tracking.php`)
- Livraison (`courier_deliver_shipment.php`)
- Acceptation (`courier_accept.php`)
- Paiements (`payments_gateways_courier_list.php`, `add_payment_gateways_courier.php`)
- Impression facture (`print_inv_ship.php`)
- Impression étiquette (`print_label_ship.php`)
- Impression étiquettes multiples (`print_label_ship_multiple.php`)
- Impression suivi (`print_inv_ship_track.php`)
- Envoi facture email (`send_email_pdf.php`)

### 4.3 Module Ramassage (Pickup)

**Objectif :** Permettre aux clients de demander qu'un chauffeur vienne chercher un colis chez eux.

**Flux :**

1. Le client/admin crée une demande de ramassage
2. Un chauffeur est assigné
3. Le chauffeur accepte le ramassage
4. Le ramassage est effectué
5. Le colis entre dans le circuit d'expédition

**Sous-fonctionnalités :**

- Tableau de bord Pickup (`dashboard_admin_pickup.php`)
- Création simple (`pickup_add.php`)
- Création complète — admin/chauffeur (`pickup_add_full.php`)
- Liste (`pickup_list.php`)
- Acceptation (`pickup_accept.php`)

### 4.4 Module Consolidation

**Objectif :** Regrouper plusieurs envois ou colis dans un seul conteneur/envoi pour optimiser les coûts de transport.

**Deux sous-types :**

**A. Consolidation d'expéditions**

- Tableau de bord (`dashboard_admin_consolidated.php`)
- Création (`consolidate_add.php`)
- Liste (`consolidate_list.php`)
- Vue détaillée (`consolidate_view.php`)
- Modification (`consolidate_edit.php`)
- Suivi (`consolidate_shipment_tracking.php`)
- Livraison (`consolidate_deliver_shipment.php`)
- Paiements (`payments_gateways_consolidate_list.php`)

**B. Consolidation de colis (paquets)**

- Tableau de bord (`dashboard_admin_package_consolidated.php`)
- Création (`consolidate_package_add.php`)
- Liste (`consolidate_package_list.php`)
- Vue détaillée (`consolidate_package_view.php`)
- Modification (`consolidate_package_edit.php`)
- Suivi (`consolidate_package_shipment_tracking.php`)
- Livraison (`consolidate_package_deliver_shipment.php`)
- Paiements (`payments_gateways_package_consolidate_list.php`)

### 4.5 Module Suivi (Tracking)

**Objectif :** Permettre à quiconque (même sans compte) de suivre un colis.

**Fonctionnalités :**

- Page de suivi publique (`tracking.php`) — accessible sans login
- Suivi d'expédition (`track.php`)
- Suivi d'achat en ligne (`track_online_shopping.php`)
- Mise à jour du suivi (admin/employé) avec :
  - Pays actuel
  - Adresse actuelle
  - Bureau/office actuel
  - Statut
  - Date
  - Option notification WhatsApp/SMS

### 4.6 Module Paiements

**Passerelles supportées (existantes dans DEPRIXA PRO) :**

| ID  | Passerelle        | Type           |
| --- | ----------------- | -------------- |
| 1   | Espèces (Cash)    | Sur place      |
| 2   | PayPal            | En ligne       |
| 3   | Stripe            | En ligne       |
| 4   | Paystack          | En ligne       |
| 5   | Virement bancaire | Upload de reçu |

**Passerelle à ajouter (adaptation marché africain) :**

| ID  | Passerelle                                         | Type                         | Phase                |
| --- | -------------------------------------------------- | ---------------------------- | -------------------- |
| 6   | **Preuve de paiement**                             | Manuel avec validation admin | Phase A (immédiate)  |
| 7+  | **Agrégateur** (Flutterwave / MaxiCash / CinetPay) | Automatisé                   | Phase B (ultérieure) |

**Principe de la preuve de paiement (Phase A) :**  
Le client paie via le moyen de son choix (Mobile Money, virement, Western Union, etc.) vers les coordonnées de l'agence Monrespro, puis charge sur la plateforme la preuve de son paiement (screenshot du transfert, photo du reçu, scan du bordereau). L'admin vérifie et valide ou rejette. Ce système permet de lancer l'activité immédiatement sans attendre l'intégration d'un agrégateur.

**Fonctionnalités :**

- Configuration des passerelles (clés API, activation/désactivation)
- **Coordonnées de paiement par agence** (numéros Mobile Money, comptes bancaires)
- **Upload de preuves de paiement** (JPG, PNG, PDF — jusqu'à 3 fichiers)
- **Validation/rejet des preuves par l'admin** avec motif
- Paiement par expédition, par colis, par consolidation
- Historique des transactions
- Soldes clients
- Comptes à recevoir
- Paiements globaux
- **Base technique préparée pour l'intégration future d'un agrégateur automatisé**

### 4.7 Module Rapports

**Types de rapports disponibles :**

| Catégorie                   | Rapports                                                    |
| --------------------------- | ----------------------------------------------------------- |
| Expéditions                 | Général, par agence, par client, par chauffeur, par employé |
| Consolidation (expéditions) | Général, par agence, par client, par chauffeur, par employé |
| Consolidation (colis)       | Général, par agence, par client, par chauffeur, par employé |
| Ramassage (Pickup)          | Général, par agence, par client, par chauffeur, par employé |
| Colis enregistrés           | Général, par agence, par employé, par chauffeur             |
| Comptabilité                | Résumé, paiements reçus, soldes clients                     |

### 4.8 Module Notifications

**Canaux :**

- **Email** : via PHPMailer + SMTP, templates personnalisables
- **SMS** : via Twilio ou ClickSend, templates personnalisables
- **WhatsApp** : templates personnalisables, envoi à chaque mise à jour de statut
- **In-app** : notifications dans la plateforme

**Evénements déclencheurs :**

- Création de colis/expédition
- Changement de statut
- Arrivée à un hub
- Prêt pour livraison
- Livré
- Paiement reçu

### 4.9 Module Administration / Configuration

**Paramètres généraux :**

- Nom du site, logo, favicon
- Langue (fr, en, es, ar, br)
- Fuseau horaire
- Mode démo
- Configuration email SMTP
- Configuration SMS/WhatsApp

**Configuration logistique :**

- Bureaux / Offices
- Agences / Branch Offices
- Sociétés de transport (Courier Companies)
- Types d'emballage (Packaging)
- Modes d'expédition (Shipping Modes)
- Délais de livraison (Delivery Time)
- Styles de statuts (couleurs, labels)
- Catégories d'articles
- Lignes d'expédition (Shipping Lines)
- Incoterms

**Configuration tarification :**

- Taxes et frais
- Tarifs d'expédition (par poids, zone, etc.)
- Numérotation tracking / factures
- Informations d'expédition par défaut

**Configuration paiements :**

- Activation/désactivation des passerelles
- Clés API (PayPal, Stripe, Paystack)
- Méthodes de paiement (Prepaid, Postpaid 15/30 jours)

**Géolocalisation :**

- Pays (avec codes ISO, indicatifs téléphoniques, devises)
- Provinces / États
- Villes

---

## 5. FLUX D'ACTIVITE DETAILLES

### 5.1 Flux principal — Achat en ligne et livraison en Afrique

```
┌─────────────────────────────────────────────────────────────────────┐
│                        PARCOURS CLIENT                              │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  1. INSCRIPTION                                                     │
│     └─► Le client crée un compte sur la plateforme                  │
│     └─► Il reçoit un numéro de CASIER VIRTUEL (ex: MRP-1042)       │
│     └─► Il reçoit une ADRESSE en Belgique liée à son casier        │
│                                                                     │
│  2. ACHAT EN LIGNE                                                  │
│     └─► Le client achète sur Shein / Zara / AliExpress / Amazon    │
│     └─► Il utilise l'adresse de son casier virtuel Belgique         │
│         comme adresse de livraison                                  │
│                                                                     │
│  3. PRE-ALERTE                                                      │
│     └─► Le client déclare son achat sur la plateforme               │
│     └─► Il fournit : numéro de suivi du vendeur, description,      │
│         valeur estimée, plateforme d'achat                          │
│                                                                     │
│  4. RECEPTION AU HUB BELGIQUE                                       │
│     └─► L'employé reçoit le colis physiquement                      │
│     └─► Il le rattache à la pré-alerte du client                    │
│     └─► Il pèse et mesure le colis                                  │
│     └─► Le système calcule les frais                                │
│     └─► Le client est notifié (WhatsApp/SMS/Email)                  │
│                                                                     │
│  5. CONSOLIDATION (optionnelle)                                     │
│     └─► Si le client a plusieurs colis en attente                   │
│     └─► L'employé les regroupe dans un seul envoi                   │
│     └─► Réduction des frais de transport                            │
│                                                                     │
│  6. EXPEDITION                                                      │
│     └─► Le colis (ou lot consolidé) est expédié                     │
│         Belgique ──► Kinshasa (ou Gabon)                            │
│     └─► Le tracking est mis à jour à chaque étape                   │
│     └─► Notifications automatiques à chaque changement              │
│                                                                     │
│  7. ARRIVEE AU HUB DESTINATION                                      │
│     └─► Le colis arrive au hub Kinshasa (ou Libreville)             │
│     └─► L'employé met à jour le statut                              │
│     └─► Le client est notifié : "Votre colis est arrivé"            │
│                                                                     │
│  8. PAIEMENT                                                        │
│     └─► Le client paie les frais                                    │
│     └─► Via : Mobile Money / Espèces / Virement / Carte             │
│                                                                     │
│  9. LIVRAISON LOCALE                                                │
│     └─► Un chauffeur est assigné                                    │
│     └─► Le colis est livré au domicile du client                    │
│     └─► Le statut passe à "Livré"                                   │
│     └─► Le client est notifié                                       │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

### 5.2 Flux — Envoi de colis depuis l'Afrique vers le monde

```
┌─────────────────────────────────────────────────────────────────────┐
│                   ENVOI DEPUIS L'AFRIQUE                            │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  1. Le client se connecte à la plateforme                           │
│                                                                     │
│  2. OPTION A : Le client dépose au bureau                           │
│     └─► Il crée une EXPEDITION sur la plateforme                    │
│     └─► Il renseigne expéditeur, destinataire, contenu              │
│     └─► Il dépose le colis au bureau Monrespro (Kinshasa/Gabon)     │
│                                                                     │
│  2. OPTION B : Demande de ramassage                                 │
│     └─► Le client crée une demande de PICKUP                        │
│     └─► Un chauffeur est assigné et va chercher le colis            │
│                                                                     │
│  3. RECEPTION ET TRAITEMENT                                         │
│     └─► L'employé vérifie, pèse, mesure le colis                   │
│     └─► Les frais sont calculés (poids, destination, mode)          │
│     └─► Le client valide et paie                                    │
│                                                                     │
│  4. EXPEDITION                                                      │
│     └─► Kinshasa/Gabon ──► Hub Belgique (si Europe)                 │
│     └─► Kinshasa/Gabon ──► Destination directe (si autre)           │
│     └─► Tracking mis à jour en temps réel                           │
│                                                                     │
│  5. TRANSIT ET LIVRAISON                                            │
│     └─► Si transit par la Belgique : redistribution Europe          │
│     └─► Livraison au destinataire final                             │
│     └─► Statut "Livré" — notifications envoyées                     │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

### 5.3 Flux — Gestion administrative quotidienne

```
┌─────────────────────────────────────────────────────────────────────┐
│                   OPERATIONS QUOTIDIENNES                           │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  MATIN                                                              │
│  ├─► Consultation du tableau de bord                                │
│  ├─► Vérification des nouvelles pré-alertes                         │
│  ├─► Traitement des colis reçus pendant la nuit                     │
│  └─► Attribution des ramassages aux chauffeurs                      │
│                                                                     │
│  JOURNEE                                                            │
│  ├─► Enregistrement des colis reçus (scan, pesée)                   │
│  ├─► Mise à jour des statuts de tracking                            │
│  ├─► Consolidation des colis pour envoi groupé                      │
│  ├─► Traitement des paiements                                       │
│  └─► Réponse aux clients (notifications)                            │
│                                                                     │
│  FIN DE JOURNEE                                                     │
│  ├─► Consultation des rapports                                      │
│  ├─► Vérification des comptes à recevoir                            │
│  └─► Préparation des envois du lendemain                            │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 6. BASE DE DONNEES

### 6.1 Schéma des tables principales

**41 tables au total** — moteur InnoDB (principalement), charset UTF-8.

#### Tables métier principales

| Table                             | Colonnes clés                                                                                  | Rôle                                                      |
| --------------------------------- | ---------------------------------------------------------------------------------------------- | --------------------------------------------------------- |
| `cdb_users`                       | id, username, password, userlevel, email, fname, lname, locker, phone, active, name_off        | Tous les utilisateurs (admin, employé, client, chauffeur) |
| `cdb_add_order`                   | order_id, order_no, sender_id, receiver_id, total_order, status_courier, driver_id, courier_id | Expéditions / commandes                                   |
| `cdb_add_order_item`              | id, order_id, item_description, weight, qty, price                                             | Articles d'une commande                                   |
| `cdb_customers_packages`          | id, user_id, tracking, weight, status, total                                                   | Colis clients (online shopping)                           |
| `cdb_customers_packages_detail`   | id, package_id, item_description, qty, price                                                   | Détails colis client                                      |
| `cdb_consolidate`                 | id, tracking, status, total                                                                    | Consolidation d'expéditions                               |
| `cdb_consolidate_detail`          | id, consolidate_id, order_id                                                                   | Liens consolidation-expéditions                           |
| `cdb_consolidate_packages`        | id, tracking, status, total                                                                    | Consolidation de colis                                    |
| `cdb_consolidate_packages_detail` | id, consolidate_id, package_id                                                                 | Liens consolidation-colis                                 |
| `cdb_pre_alert`                   | id, user_id, tracking_vendor, description, status                                              | Pré-alertes clients                                       |
| `cdb_virtual_locker`              | id, locker_number, address, city, postal                                                       | Casiers virtuels                                          |
| `cdb_courier_track`               | id, order_id, status, location, date                                                           | Historique de suivi                                       |

#### Tables de paiement

| Table                  | Rôle                                                  |
| ---------------------- | ----------------------------------------------------- |
| `cdb_payments_gateway` | Transactions (montant, passerelle, statut, référence) |
| `cdb_met_payment`      | Passerelles configurées (PayPal, Stripe, etc.)        |
| `cdb_payment_methods`  | Méthodes de paiement (Prepaid, Postpaid)              |
| `cdb_charges_order`    | Frais facturés par commande                           |

#### Tables de référence

| Table               | Rôle                                   |
| ------------------- | -------------------------------------- |
| `cdb_countries`     | Pays (249 entrées, codes ISO, devises) |
| `cdb_states`        | Provinces / États                      |
| `cdb_cities`        | Villes                                 |
| `cdb_offices`       | Bureaux                                |
| `cdb_branchoffices` | Agences                                |
| `cdb_courier_com`   | Sociétés de transport                  |
| `cdb_packaging`     | Types d'emballage                      |
| `cdb_shipping_mode` | Modes d'expédition                     |
| `cdb_delivery_time` | Délais de livraison                    |
| `cdb_shipping_fees` | Tarifs d'expédition                    |
| `cdb_shipping_line` | Lignes d'expédition                    |
| `cdb_incoterm`      | Incoterms                              |
| `cdb_category`      | Catégories d'articles                  |
| `cdb_styles`        | Styles de statuts (couleurs, labels)   |
| `cdb_zone`          | Fuseaux horaires                       |

#### Tables de communication

| Table                            | Rôle                          |
| -------------------------------- | ----------------------------- |
| `cdb_email_templates`            | Templates email               |
| `cdb_sms_templates`              | Templates SMS                 |
| `whatsapp_templates`             | Templates WhatsApp            |
| `default_notification_templates` | Templates par défaut          |
| `cdb_notifications`              | Notifications système         |
| `cdb_notifications_users`        | Notifications par utilisateur |
| `cdb_news`                       | Actualités                    |

#### Tables de configuration

| Table                   | Rôle                                 |
| ----------------------- | ------------------------------------ |
| `cdb_settings`          | Paramètres généraux (clé-valeur)     |
| `cdb_info_ship_default` | Informations d'expédition par défaut |

#### Autres tables

| Table                        | Rôle                          |
| ---------------------------- | ----------------------------- |
| `cdb_recipients`             | Destinataires                 |
| `cdb_recipients_addresses`   | Adresses destinataires        |
| `cdb_senders_addresses`      | Adresses expéditeurs          |
| `cdb_address_locker`         | Adresses casiers              |
| `cdb_address_shipments`      | Adresses d'expédition         |
| `cdb_order_files`            | Fichiers joints aux commandes |
| `cdb_customer_package_files` | Fichiers joints aux colis     |
| `cdb_driver_files`           | Documents chauffeurs          |
| `cdb_order_user_history`     | Historique utilisateur        |

---

## 7. INTEGRATIONS TIERCES

| Service         | Usage                        | Fichiers concernés                                 |
| --------------- | ---------------------------- | -------------------------------------------------- |
| **Stripe**      | Paiement carte bancaire      | `helpers/stripe/`, `dataJs/config_payment.js`      |
| **PayPal**      | Paiement en ligne            | JS SDK (`paypal.com/sdk/js`)                       |
| **Paystack**    | Paiement en ligne (Afrique)  | JS SDK (`js.paystack.co`)                          |
| **PHPMailer**   | Envoi d'emails SMTP          | `helpers/phpmailer/`                               |
| **Twilio**      | SMS                          | `config_twilio.php`, `dataJs/config_twilio*.js`    |
| **ClickSend**   | SMS/Email API                | `helpers/vendor/clicksend/`                        |
| **WhatsApp**    | Notifications                | `config_whatsapp.php`, `dataJs/whatssap_config.js` |
| **Google API**  | Géolocalisation/cartes       | `dataJs/config_api_google.js`                      |
| **TCPDF**       | Génération PDF               | `pdf/`, `vendor/tecnickcom/tcpdf/`                 |
| **html2pdf**    | Génération PDF               | `vendor/spipu/html2pdf/`                           |
| **SweetAlert2** | Alertes UI                   | Assets frontend                                    |
| **Select2**     | Listes déroulantes enrichies | Assets frontend                                    |
| **Chart.js**    | Graphiques dashboard         | Assets frontend                                    |

---

## 8. CONTRAINTES ET LIMITATIONS

### 8.1 Contraintes techniques

- **ionCube** : Le `loader.php` et les fonctions monétaires sont chiffrés. Toute modification du bootstrapping ou du formatage monétaire nécessite un wrapper/contournement.
- **Pas de framework** : PHP pur sans architecture MVC stricte. Les modifications sont possibles mais doivent être faites avec rigueur pour maintenir la cohérence.
- **Pas d'API REST** : Le système n'expose pas d'API. Toute intégration mobile nécessitera d'en créer une.
- **Base de données non normalisée par endroits** : Certaines tables utilisent MyISAM au lieu d'InnoDB.
- **Pas de tests automatisés** : Aucun test unitaire ou d'intégration.
- **Pas de gestion de versions** : Pas de Git initialisé.

### 8.2 Contraintes de licence

- Licence CodeCanyon Standard : modification autorisée, redistribution interdite.
- Le script ne peut pas être revendu en tant que tel.
- Utilisation autorisée pour un seul projet/produit final.

### 8.3 Contraintes marché africain

- Connectivité internet variable — nécessité d'une interface légère et résiliente.
- Dominance du mobile — le responsive design existant (Bootstrap) est un bon point de départ.
- Paiement mobile dominant (Mobile Money) — non intégré actuellement.
- Adressage postal approximatif — le système d'adresses actuel est trop structuré pour l'Afrique.
- Réglementation douanière spécifique — pas de module douane.

---

_Document généré le 12 mars 2026 — Monrespro Logistics_
