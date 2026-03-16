# Chapitre 8 — Comptabilité & Paiements

> Ce module gère les aspects financiers de l'application : comptes à recevoir, passerelles de paiement en ligne, preuves de paiement, coordonnées bancaires par agence et soldes clients.

---

## 8.1 Vue d'ensemble financière

### Dashboard Comptabilité

**URL :** `dashboard_admin_account.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Le tableau de bord comptable présente :

- **Revenus totaux** : somme de tous les paiements reçus
- **Montants en attente** : somme des factures non réglées
- **Solde global** : différence entre le total facturé et le total payé
- **Graphiques** : évolution des revenus et des paiements sur la période
- **Top clients** : clients avec les montants les plus élevés (payés et en attente)

---

## 8.2 Comptes à recevoir

**URL :** `accounts_receivable.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/accounts_receivable/accounts_receivable.php`

### Concept

Les **comptes à recevoir** (accounts receivable) représentent les montants que les clients doivent encore payer. Chaque expédition, package ou consolidation génère une ligne de compte à recevoir.

### Tableau principal

| Colonne | Description |
|---------|-------------|
| **Client** | Nom du client |
| **N° de référence** | Numéro de l'expédition/package associé |
| **Type** | Expédition, Package, Consolidé |
| **Date** | Date de création de la facture |
| **Montant total** | Total facturé |
| **Montant payé** | Somme des paiements reçus |
| **Solde** | Restant à payer |
| **Statut** | Payé / Partiellement payé / Impayé |
| **Actions** | Boutons d'action |

### Filtres

- **Par client** : recherche par nom ou email
- **Par période** : date de début / date de fin
- **Par statut** : payé, partiellement payé, impayé
- **Par type** : expédition, package, consolidé

### Actions

| Action | Description |
|--------|-------------|
| **Voir les détails** | Détail complet des charges et paiements |
| **Ajouter une charge** | Ajouter un frais supplémentaire au compte |
| **Modifier une charge** | Éditer un frais existant |
| **Supprimer une charge** | Retirer un frais |
| **Enregistrer un paiement** | Marquer un paiement reçu |
| **Imprimer** | Générer un relevé PDF |

---

## 8.3 Gestion des charges

### Ajouter une charge

**Modale :** `modal_charges_add.php`

Permet d'ajouter des frais supplémentaires au compte d'un client :

| Champ | Type | Description |
|-------|------|-------------|
| **Description** | Texte | Libellé de la charge (ex: « Frais de stockage ») |
| **Montant** | Nombre | Montant de la charge |
| **Date** | Date | Date de la charge |

### Modifier une charge

**Modale :** `modal_charges_edit.php`

Permet de modifier le libellé, le montant ou la date d'une charge existante.

### Supprimer une charge

**Modale :** `modal_charges_list.php`

Affiche la liste des charges avec possibilité de suppression individuelle.

### Impression des charges

**URL :** `print_charge.php?print={id}`

Génère un relevé PDF avec le détail de toutes les charges d'un client.

---

## 8.4 Passerelles de paiement

### Configuration globale

**URL :** `global_payments_gateways.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/global_payments_gateways.php`

Cette page centralise la gestion des **passerelles de paiement en ligne** disponibles dans l'application.

### Passerelles disponibles

#### PayPal

| Paramètre | Description |
|-----------|-------------|
| **Client ID** | Identifiant de l'application PayPal |
| **Secret** | Clé secrète PayPal |
| **Mode** | Sandbox (test) ou Live (production) |
| **Actif** | Oui / Non |

**Flux de paiement PayPal :**
1. Le client clique sur « Payer avec PayPal »
2. Redirection vers la page de paiement PayPal
3. Le client se connecte et valide le paiement
4. Retour automatique vers MonResPro
5. Le paiement est enregistré et le solde mis à jour

#### Stripe

| Paramètre | Description |
|-----------|-------------|
| **Publishable Key** | Clé publique Stripe |
| **Secret Key** | Clé secrète Stripe |
| **Actif** | Oui / Non |

**Flux de paiement Stripe :**
1. Le client clique sur « Payer par carte »
2. Un formulaire sécurisé Stripe s'affiche
3. Le client saisit les informations de sa carte
4. Le paiement est traité directement
5. Confirmation et mise à jour du solde

#### Paystack

| Paramètre | Description |
|-----------|-------------|
| **Public Key** | Clé publique Paystack |
| **Secret Key** | Clé secrète Paystack |
| **Actif** | Oui / Non |

**Flux de paiement Paystack :**
1. Le client clique sur « Payer avec Paystack »
2. Le widget Paystack s'affiche
3. Le client choisit sa méthode (carte, mobile money, etc.)
4. Paiement traité
5. Confirmation et mise à jour

#### Virement bancaire

| Paramètre | Description |
|-----------|-------------|
| **Coordonnées bancaires** | IBAN, BIC, nom du bénéficiaire |
| **Instructions** | Instructions de paiement affichées au client |
| **Actif** | Oui / Non |

**Flux de paiement par virement :**
1. Le client choisit « Virement bancaire »
2. Les coordonnées bancaires s'affichent
3. Le client effectue le virement depuis sa banque
4. Le client upload une **preuve de paiement** (capture d'écran, reçu)
5. L'opérateur vérifie et valide manuellement le paiement

---

## 8.5 Passerelles par module

Chaque module dispose de sa propre section de paiements :

| Module | Liste des paiements | Ajouter un paiement |
|--------|-------------------|---------------------|
| **Packages clients** | `payments_gateways_list.php` | `add_payment_gateways_package.php` |
| **Expéditions courier** | `payments_gateways_courier_list.php` | `add_payment_gateways_courier.php` |
| **Envois consolidés** | `payments_gateways_consolidate_list.php` | `add_payment_gateways_consolidate.php` |
| **Packages consolidés** | `payments_gateways_package_consolidate_list.php` | `add_payment_gateways_consolidate_package.php` |

### Tableau des paiements

| Colonne | Description |
|---------|-------------|
| **N° de référence** | Numéro de l'expédition/package |
| **Client** | Nom du client |
| **Montant** | Montant du paiement |
| **Méthode** | PayPal, Stripe, Paystack, Virement |
| **Date** | Date du paiement |
| **Statut** | Validé, En attente, Rejeté |
| **Actions** | Voir les détails |

---

## 8.6 Preuves de paiement en attente

**URL :** `payment_proofs_pending.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/tools/payment_proofs_pending.php`

### Description

Cette page liste toutes les preuves de paiement uploadées par les clients (pour les virements bancaires) qui n'ont pas encore été vérifiées.

### Procédure de vérification

1. Consultez la liste des preuves en attente
2. Cliquez sur une preuve pour la **visualiser** (image ou PDF)
3. **Vérifiez** les informations :
   - Le montant correspond-il à la facture ?
   - Le bénéficiaire est-il correct ?
   - La date du virement est-elle cohérente ?
4. **Validez** le paiement → le solde du client est mis à jour
5. Ou **rejetez** le paiement → le client est notifié du rejet avec un motif

### Fenêtre modale de vérification

**Modale :** `modal_verify_payment_packages.php`

Affiche :
- Image/PDF de la preuve de paiement
- Informations de la facture associée
- Boutons « Valider » et « Rejeter »

---

## 8.7 Coordonnées de paiement par agence

**URL :** `agency_payment_coordinates_list.php`  
**Accès :** 🔴 Admin  
**Vue :** `views/tools/agency_payment_coordinates_list.php`

### Description

Permet de configurer les **coordonnées bancaires** spécifiques à chaque agence / succursale. Cela est utile lorsque différentes agences ont des comptes bancaires différents.

### Informations configurables par agence

| Champ | Description |
|-------|-------------|
| **Agence** | Nom de l'agence |
| **Banque** | Nom de la banque |
| **IBAN** | Numéro de compte international |
| **BIC/SWIFT** | Code d'identification bancaire |
| **Bénéficiaire** | Nom du titulaire du compte |
| **Instructions** | Instructions spéciales de paiement |
| **Numéro Mobile Money** | Numéro pour les paiements mobile (Afrique) |

---

## 8.8 Modes et méthodes de paiement

### Modes de paiement

**URL :** `payment_mode_list.php`  
**Accès :** 🔴 Admin

Les modes de paiement définissent **quand** le paiement est effectué :

| Mode | Description |
|------|-------------|
| **Prépayé** | Paiement avant l'envoi |
| **À la livraison** | Paiement à la réception du colis (COD) |
| **À crédit** | Paiement différé (compte client) |
| **Tiers payant** | Un tiers paie l'expédition |

Configuration : `payment_mode_edit.php`

### Méthodes de paiement

**URL :** `payment_methods_list.php`  
**Accès :** 🔴 Admin

Les méthodes de paiement définissent **comment** le paiement est effectué :

| Méthode | Description |
|---------|-------------|
| **Espèces** | Paiement en cash |
| **Carte bancaire** | Paiement par carte (Visa, Mastercard) |
| **Virement** | Virement bancaire |
| **Chèque** | Paiement par chèque |
| **Mobile Money** | Paiement mobile (Orange Money, MTN MoMo, etc.) |
| **PayPal** | Paiement en ligne PayPal |

Gestion : `payment_methods_add.php`, `payment_methods_edit.php`

---

## 8.9 Rapports financiers

Les rapports financiers sont détaillés dans le Chapitre 11, mais voici un résumé :

| Rapport | URL | Description |
|---------|-----|-------------|
| **Soldes clients** | `report_customers_balance_list.php` | Liste des soldes de tous les clients |
| **Détail solde** | `report_customers_balance_detail.php` | Détail du solde d'un client spécifique |
| **Résumé** | `report_summary_list.php` | Résumé global des finances |
| **Paiements reçus** | `report_payments_received_list.php` | Liste de tous les paiements reçus |

Chaque rapport est disponible en :
- **Vue web** (tableau interactif)
- **Export Excel** (`_excel.php`)
- **Impression PDF** (`_print.php`)

---

## 8.10 Bonnes pratiques

### Gestion quotidienne

1. **Vérifiez les preuves de paiement** chaque jour — ne laissez pas les preuves s'accumuler
2. **Rapprochez les paiements** — assurez-vous que chaque paiement correspond à une facture
3. **Suivez les impayés** — contactez les clients avec des soldes en retard
4. **Exportez régulièrement** — sauvegardez les rapports financiers en Excel

### Sécurité

1. **Ne partagez jamais** les clés API des passerelles de paiement
2. **Utilisez le mode Sandbox** pour les tests avant de passer en production
3. **Vérifiez les montants** des paiements automatiques (PayPal, Stripe) dans le dashboard de la passerelle
4. **Gardez une trace** de toutes les preuves de paiement validées ou rejetées
