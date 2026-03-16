# MonResPro — Guide d'utilisation complet

> **Version :** 8.4  
> **Dernière mise à jour :** Mars 2026  
> **Application :** MonResPro — Système intégré de logistique et d'expédition

---

## Table des matières

| # | Chapitre | Fichier | Description |
|---|----------|---------|-------------|
| 1 | [Introduction & Architecture](01-INTRODUCTION.md) | `01-INTRODUCTION.md` | Présentation générale, architecture technique, rôles utilisateurs, navigation |
| 2 | [Authentification](02-AUTHENTIFICATION.md) | `02-AUTHENTIFICATION.md` | Connexion, inscription, récupération de mot de passe, sécurité de session |
| 3 | [Tableaux de bord](03-TABLEAU-DE-BORD.md) | `03-TABLEAU-DE-BORD.md` | Dashboard administrateur, client et chauffeur |
| 4 | [Packages clients (Online Shopping)](04-PACKAGES-CLIENTS.md) | `04-PACKAGES-CLIENTS.md` | Pré-alertes, enregistrement de colis, suivi, livraison, paiements |
| 5 | [Expéditions Courier](05-EXPEDITIONS-COURIER.md) | `05-EXPEDITIONS-COURIER.md` | Création, édition, suivi, livraison d'expéditions courrier |
| 6 | [Collectes (Pickup)](06-COLLECTES-PICKUP.md) | `06-COLLECTES-PICKUP.md` | Planification et gestion des collectes de colis |
| 7 | [Consolidation](07-CONSOLIDATION.md) | `07-CONSOLIDATION.md` | Envois consolidés et packages consolidés |
| 8 | [Comptabilité & Paiements](08-COMPTABILITE.md) | `08-COMPTABILITE.md` | Comptes à recevoir, passerelles de paiement, preuves de paiement |
| 9 | [Clients & Destinataires](09-CLIENTS-DESTINATAIRES.md) | `09-CLIENTS-DESTINATAIRES.md` | Gestion des clients, profils, adresses, destinataires |
| 10 | [Utilisateurs & Chauffeurs](10-UTILISATEURS-CHAUFFEURS.md) | `10-UTILISATEURS-CHAUFFEURS.md` | Gestion des employés, administrateurs, chauffeurs |
| 11 | [Rapports](11-RAPPORTS.md) | `11-RAPPORTS.md` | Tous les rapports disponibles par module |
| 12 | [Configuration & Paramètres](12-CONFIGURATION.md) | `12-CONFIGURATION.md` | Paramètres généraux, entreprise, logo, email, tarifs, taxes, localisations |
| 13 | [Notifications & Communications](13-NOTIFICATIONS.md) | `13-NOTIFICATIONS.md` | Email SMTP, WhatsApp API, SMS Twilio, modèles de notification |
| 14 | [Impression & PDF](14-IMPRESSION-PDF.md) | `14-IMPRESSION-PDF.md` | Étiquettes, factures, bordereaux d'expédition |
| 15 | [Pages publiques](15-PAGES-PUBLIQUES.md) | `15-PAGES-PUBLIQUES.md` | Suivi en ligne, page d'accueil, services, pays desservis |

---

## Légende des rôles

Chaque fonctionnalité est annotée avec les rôles qui y ont accès :

| Icône | Rôle | Niveau | Description |
|-------|------|--------|-------------|
| 🔴 | **Admin** | 9 | Accès total à toutes les fonctionnalités |
| 🟠 | **Employé** | 2 | Accès opérationnel (pas de configuration système) |
| 🔵 | **Client** | 1 | Accès à ses propres colis, expéditions et profil |
| 🟢 | **Chauffeur** | 3 | Accès aux livraisons, collectes et expéditions assignées |

---

## Accès rapide par rôle

### Administrateur / Employé
- Tableau de bord → `index.php`
- Rapports → `reports.php`
- Packages clients → `customer_packages_list.php`
- Expéditions → `courier_list.php`
- Collectes → `pickup_list.php`
- Consolidation → `consolidate_list.php`
- Comptabilité → `accounts_receivable.php`
- Clients → `customers_list.php`
- Utilisateurs → `users_list.php`
- Configuration → `tools.php`

### Client
- Mon espace → `index.php`
- Créer pré-alerte → `prealert_add.php`
- Mes colis → `customer_packages_list.php`
- Mes expéditions → `courier_list.php`
- Mes collectes → `pickup_list.php`
- Mon profil → `customers_profile_edit.php`
- Mes destinataires → `recipients_list.php`

### Chauffeur
- Mon espace → `index.php`
- Expéditions → `courier_list.php`
- Collectes → `pickup_list.php`
- Mon profil → `drivers_edit.php`
