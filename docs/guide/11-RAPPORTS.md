# Chapitre 11 — Rapports

> Le module Rapports offre une vue analytique complète de l'activité de l'entreprise. Les rapports sont organisés par module et peuvent être filtrés par période, exportés en Excel et imprimés en PDF.

---

## 11.1 Accès aux rapports

**URL :** `reports.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client (limité), 🟢 Chauffeur (limité)  
**Vue :** `views/reports/reports_list.php`

La page principale des rapports présente une **grille de cartes** organisées par catégorie. Chaque carte contient les liens vers les rapports disponibles.

### Visibilité par rôle

| Catégorie de rapport | Admin/Employé | Client | Chauffeur |
|---------------------|---------------|--------|-----------|
| **Packages clients** | ✅ Tous | ✅ Général uniquement | ✅ Général |
| **Expéditions** | ✅ Tous | ✅ Général uniquement | ✅ Général |
| **Collectes** | ✅ Tous | ✅ Général uniquement | ✅ Général |
| **Consolidation** | ✅ Tous | ❌ | ❌ |
| **Packages consolidés** | ✅ Tous | ❌ | ❌ |
| **Comptes à recevoir** | ✅ Tous | ❌ | ❌ |

---

## 11.2 Rapports Packages clients (Online Shopping)

### Rapport général

**URL :** `report_packages_registered.php`  
**Accès :** Tous les rôles

Affiche tous les packages clients enregistrés avec :

| Colonne | Description |
|---------|-------------|
| **N° de suivi** | Numéro de tracking |
| **Client** | Nom du client |
| **Date** | Date d'enregistrement |
| **Origine** | Bureau d'origine |
| **Poids** | Poids du colis |
| **Montant** | Total facturé |
| **Statut** | Statut actuel |

#### Filtres

- **Date de début / Date de fin** : période du rapport
- **Statut** : filtrer par statut spécifique
- **Recherche** : dans toutes les colonnes

#### Exports

| Format | URL | Description |
|--------|-----|-------------|
| **Excel** | `report_packages_registered_excel.php` | Export en fichier .xlsx |
| **Impression** | `report_packages_registered_print.php` | Version imprimable PDF |

### Rapport par employé

**URL :** `report_packages_registered_employee.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Packages enregistrés groupés par employé qui les a créés.

- Filtres : par employé, par période
- Colonnes supplémentaires : nom de l'employé créateur
- Exports : Excel (`_excel.php`), Impression (`_print.php`)

### Rapport par agence

**URL :** `report_packages_registered_agency.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Packages regroupés par agence / succursale.

- Filtres : par agence, par période
- Colonnes supplémentaires : nom de l'agence
- Exports : Excel (`_excel.php`), Impression (`_print.php`)

### Rapport par chauffeur

**URL :** `report_packages_registered_driver.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Packages regroupés par chauffeur assigné.

- Filtres : par chauffeur, par période
- Colonnes supplémentaires : nom du chauffeur
- Exports : Excel (`_excel.php`), Impression (`_print.php`)

---

## 11.3 Rapports Expéditions (Shipments)

### Rapport général

**URL :** `report_general.php`  
**Accès :** Tous les rôles

Toutes les expéditions courrier avec détails complets.

| Colonne | Description |
|---------|-------------|
| **N° de suivi** | Tracking number |
| **Expéditeur** | Nom du client expéditeur |
| **Destinataire** | Nom du destinataire |
| **Date** | Date de création |
| **Origine → Destination** | Route |
| **Poids** | Poids total |
| **Montant** | Total facturé |
| **Statut** | Statut actuel |

#### Filtres

- Par période (date début / fin)
- Par statut
- Par recherche textuelle

#### Exports

| Format | URL |
|--------|-----|
| **Excel** | `report_general_excel.php` |
| **Impression** | `report_general_print.php` |

### Rapport par client

**URL :** `report_customer.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Expéditions groupées par client expéditeur.

- Filtres : par client, par période
- Exports : Excel (`report_customer_excel.php`), Impression (`report_customer_print.php`)

### Rapport par employé

**URL :** `report_employees.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Expéditions groupées par employé créateur.

- Filtres : par employé, par période
- Exports : Excel (`report_employees_excel.php`), Impression (`report_employees_print.php`)

### Rapport par agence

**URL :** `report_agency.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Expéditions groupées par agence.

- Filtres : par agence, par période
- Exports : Excel (`report_agency_excel.php`), Impression (`report_agency_print.php`)

### Rapport par chauffeur

**URL :** `report_driver_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Expéditions groupées par chauffeur assigné.

- Filtres : par chauffeur, par période
- Exports : Excel (`report_driver_list_excel.php`), Impression (`report_driver_list_print.php`)

---

## 11.4 Rapports Collectes (Pickup)

### Rapport général

**URL :** `report_pickup_general_list.php`  
**Accès :** Tous les rôles

Toutes les collectes avec détails.

| Colonne | Description |
|---------|-------------|
| **N°** | Numéro de collecte |
| **Client** | Client demandeur |
| **Date** | Date prévue |
| **Adresse** | Lieu de collecte |
| **Chauffeur** | Chauffeur assigné |
| **Statut** | Statut actuel |

#### Exports

| Format | URL |
|--------|-----|
| **Excel** | `report_pickup_general_list_excel.php` |
| **Impression** | `report_pickup_general_list_print.php` |

### Rapport par client

**URL :** `report_pickup_customers_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

- Exports : Excel (`_excel.php`), Impression (`_print.php`)

### Rapport par employé

**URL :** `report_pickup_employees_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

- Exports : Excel (`_excel.php`), Impression (`_print.php`)

### Rapport par agence

**URL :** `report_pickup_agency_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

- Exports : Excel (`_excel.php`), Impression (`_print.php`)

### Rapport par chauffeur

**URL :** `report_pickup_driver_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

- Exports : Excel (`_excel.php`), Impression (`_print.php`)

---

## 11.5 Rapports Consolidation

### Envois consolidés

#### Rapport général

**URL :** `report_consolidate_general_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Tous les envois consolidés avec détails complets.

| Colonne | Description |
|---------|-------------|
| **N° de suivi** | Numéro du consolidé |
| **Client** | Client expéditeur |
| **Date** | Date de création |
| **Poids total** | Poids cumulé |
| **Montant** | Total |
| **Nombre d'envois** | Expéditions incluses |
| **Statut** | Statut actuel |

#### Rapport par client

**URL :** `report_consolidate_customers_list.php`

#### Rapport par employé

**URL :** `report_consolidate_employees_list.php`

#### Rapport par agence

**URL :** `report_consolidate_agency_list.php`

#### Rapport par chauffeur

**URL :** `report_consolidate_driver_list.php`

Chaque rapport dispose de ses exports Excel et impression.

### Packages consolidés

Même structure de rapports pour les packages consolidés :

| Rapport | URL |
|---------|-----|
| **Général** | `report_consolidate_packages_general_list.php` |
| **Par client** | `report_consolidate_packages_customers_list.php` |
| **Par employé** | `report_consolidate_packages_employees_list.php` |
| **Par agence** | `report_consolidate_packages_agency_list.php` |
| **Par chauffeur** | `report_consolidate_packages_driver_list.php` |

Chacun avec exports Excel (`_excel.php`) et impression (`_print.php`).

---

## 11.6 Rapports financiers (Comptes à recevoir)

### Soldes clients

**URL :** `report_customers_balance_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Liste de tous les clients avec leur solde :

| Colonne | Description |
|---------|-------------|
| **Client** | Nom du client |
| **Total facturé** | Somme de toutes les factures |
| **Total payé** | Somme de tous les paiements |
| **Solde** | Restant à payer |
| **Statut** | Payé / Partiellement payé / Impayé |

- Exports : Excel, Impression

### Détail solde client

**URL :** `report_customers_balance_detail.php?client={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Détail de toutes les transactions d'un client spécifique :
- Chaque facture (expédition, package, consolidé)
- Chaque paiement reçu
- Solde courant

### Résumé financier

**URL :** `report_summary_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Vue synthétique des finances :
- Total des revenus par période
- Total des paiements par méthode
- Total des impayés
- Graphiques de tendance

- Exports : Excel (`report_summary_list_excel.php`), Impression (`report_summary_list_print.php`)

### Paiements reçus

**URL :** `report_payments_received_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Liste de tous les paiements reçus :

| Colonne | Description |
|---------|-------------|
| **Date** | Date du paiement |
| **Client** | Nom du payeur |
| **Référence** | N° d'expédition/package |
| **Montant** | Montant payé |
| **Méthode** | Mode de paiement |
| **Validé par** | Employé qui a validé |

- Filtres : par période, par méthode, par client
- Exports : Excel (`_excel.php`), Impression (`_print.php`)

---

## 11.7 Utilisation des rapports

### Interface commune

Tous les rapports partagent une interface standard :

1. **En-tête** — titre du rapport, description
2. **Barre de filtres** — champs de filtrage (période, statut, etc.)
3. **Bouton Rechercher** — applique les filtres
4. **Tableau de données** — résultats paginés, triables
5. **Boutons d'export** — Excel et Impression
6. **Totaux** — ligne de total en bas du tableau (montants, poids, etc.)

### Filtrer un rapport

1. Sélectionnez les critères de filtre dans la barre en haut
2. Cliquez sur **Rechercher** ou appuyez sur Entrée
3. Le tableau se met à jour avec les résultats filtrés
4. Les totaux sont recalculés

### Exporter en Excel

1. Appliquez les filtres souhaités
2. Cliquez sur le bouton **Excel** (icône de tableur)
3. Le fichier `.xlsx` est automatiquement téléchargé
4. Le fichier contient les mêmes données que le tableau affiché

### Imprimer un rapport

1. Appliquez les filtres souhaités
2. Cliquez sur le bouton **Imprimer** (icône d'imprimante)
3. Une nouvelle page s'ouvre avec une mise en page optimisée pour l'impression
4. La boîte de dialogue d'impression du navigateur s'ouvre automatiquement

---

## 11.8 Bonnes pratiques

1. **Exportez régulièrement** — sauvegardez les rapports mensuels en Excel pour archivage
2. **Comparez les périodes** — utilisez les filtres de date pour comparer les performances mois par mois
3. **Identifiez les tendances** — utilisez les rapports par agence et par chauffeur pour optimiser les opérations
4. **Vérifiez les impayés** — consultez le rapport des soldes clients au moins une fois par semaine
5. **Rapports par employé** — utilisez-les pour évaluer la productivité de l'équipe
