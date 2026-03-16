# Chapitre 3 — Tableaux de bord

> Les tableaux de bord offrent une vue synthétique de l'activité selon le rôle de l'utilisateur connecté. Chaque rôle dispose de son propre tableau de bord avec des indicateurs adaptés.

---

## 3.1 Tableau de bord Administrateur / Employé

**URL :** `index.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/dashboard/index.php`

### Vue d'ensemble

Le tableau de bord administrateur est la page d'accueil principale. Il présente une synthèse complète de l'activité de l'entreprise sur le mois en cours.

### Composants affichés

#### 1. Carte de revenus principale

- **Revenus mensuels** : montant total des expéditions du mois en cours
- Affichage en devise configurée (symbole + format)
- Comparaison visuelle avec les mois précédents

#### 2. Mini-cartes mensuelles (3 cartes)

| Carte | Donnée | Description |
|-------|--------|-------------|
| **Expéditions** | Nombre | Total des expéditions courrier créées ce mois |
| **Packages** | Nombre | Total des packages clients enregistrés ce mois |
| **Collectes** | Nombre | Total des collectes planifiées ce mois |

#### 3. Rapport de revenus

- **Barres de progression** montrant la répartition des revenus par catégorie :
  - Expéditions courrier
  - Packages clients
  - Consolidation
  - Collectes
- Chaque barre affiche le montant et le pourcentage du total

#### 4. Compteurs d'activité (grille 2×3)

Six compteurs affichant les totaux actuels :

| Compteur | Description |
|----------|-------------|
| **Total Expéditions** | Nombre total d'expéditions courrier |
| **Total Packages** | Nombre total de packages clients |
| **Total Consolidés** | Nombre total d'envois consolidés |
| **Total Collectes** | Nombre total de collectes |
| **Expéditions en transit** | Expéditions actuellement en cours de livraison |
| **Packages en attente** | Packages non encore livrés |

#### 5. Compteurs utilisateurs

- **Total clients** enregistrés
- **Total employés** actifs
- **Total chauffeurs** actifs

#### 6. Recherche d'expéditions par onglets

Un système à onglets permet de rechercher rapidement :
- **Par numéro de suivi** — saisir le tracking number
- **Par client** — recherche par nom du client
- **Par statut** — filtrer par statut d'expédition

### Interactions

- Cliquer sur un compteur redirige vers la liste correspondante
- Les graphiques sont interactifs (Chart.js)
- Le tableau de bord se rafraîchit au chargement de la page

---

## 3.2 Tableau de bord Client

**URL :** `index.php` (redirection automatique selon le rôle)  
**Accès :** 🔵 Client  
**Vue :** `views/dashboard/dashboard_client.php`

### Vue d'ensemble

Le tableau de bord client offre une vue personnalisée des colis et expéditions du client connecté.

### Composants affichés

#### 1. Bannière de bienvenue

- Message d'accueil personnalisé avec le nom du client
- Message contextuel selon l'heure (Bonjour / Bon après-midi / Bonsoir)

#### 2. Carte du casier virtuel

- **Numéro de casier** unique du client (ex: `LOC00042`)
- **Adresse du casier** — adresse physique du dépôt pour la réception de colis
- Cette carte est essentielle pour les clients qui font des achats en ligne : ils utilisent ce numéro comme adresse de livraison

#### 3. Résumé financier

Trois indicateurs financiers :

| Indicateur | Description |
|------------|-------------|
| **Total payé** | Somme des paiements effectués |
| **Total en attente** | Montant restant à payer |
| **Total général** | Somme totale de tous les frais |

#### 4. Compteurs d'activité (6 cartes)

| Compteur | Description |
|----------|-------------|
| **Mes packages** | Nombre total de packages enregistrés |
| **Mes expéditions** | Nombre total d'expéditions courrier |
| **Mes consolidés** | Nombre d'envois consolidés |
| **Mes collectes** | Nombre de collectes demandées |
| **Mes pré-alertes** | Nombre de pré-alertes créées |
| **Packages livrés** | Nombre de packages déjà livrés |

#### 5. Statuts des collectes (4 cartes)

| Statut | Description |
|--------|-------------|
| **En attente** | Collectes demandées mais pas encore traitées |
| **Acceptées** | Collectes confirmées par l'entreprise |
| **En cours** | Collectes en cours de ramassage |
| **Terminées** | Collectes effectuées avec succès |

#### 6. Liste des expéditions récentes

- Tableau avec les dernières expéditions du client
- Colonnes : tracking, date, origine, destination, statut
- Possibilité de recherche par onglets (tracking, statut)

---

## 3.3 Tableau de bord Chauffeur

**URL :** `index.php` (redirection automatique selon le rôle)  
**Accès :** 🟢 Chauffeur  
**Vue :** `views/dashboard/dashboard_driver.php`

### Vue d'ensemble

Le tableau de bord chauffeur est centré sur les livraisons et collectes assignées.

### Composants affichés

#### 1. Compteurs d'expéditions (3 cartes)

| Compteur | Description |
|----------|-------------|
| **Expéditions assignées** | Total des expéditions attribuées au chauffeur |
| **Expéditions en transit** | Expéditions actuellement en cours de livraison |
| **Expéditions livrées** | Expéditions marquées comme livrées |

#### 2. Statuts des collectes (4 cartes)

Même structure que le dashboard client mais filtré par les collectes assignées au chauffeur :

| Statut | Description |
|--------|-------------|
| **En attente** | Collectes assignées non encore prises en charge |
| **Acceptées** | Collectes que le chauffeur a acceptées |
| **En cours** | Collectes en cours de ramassage |
| **Terminées** | Collectes terminées |

#### 3. Liste des expéditions récentes

- Tableau des dernières expéditions assignées au chauffeur
- Vue simplifiée avec les informations essentielles de livraison

---

## 3.4 Sous-tableaux de bord spécialisés (Admin/Employé)

En plus du tableau de bord principal, l'administrateur et l'employé ont accès à des tableaux de bord spécialisés par module :

### Dashboard Expéditions

**URL :** `dashboard_admin_shipments.php`

- Vue détaillée de toutes les expéditions courrier
- Statistiques par statut (en attente, en transit, livré, annulé, etc.)
- Graphiques de tendance
- Filtres par période, agence, chauffeur

### Dashboard Packages Clients

**URL :** `dashboard_admin_packages_customers.php`

- Vue détaillée de tous les packages clients (online shopping)
- Statistiques par statut
- Compteurs par agence et par période

### Dashboard Collectes

**URL :** `dashboard_admin_pickup.php`

- Vue détaillée de toutes les collectes
- Répartition par statut
- Statistiques par chauffeur et par agence

### Dashboard Consolidation

**URL :** `dashboard_admin_consolidated.php`

- Vue détaillée des envois consolidés (consolidate)
- Statistiques et compteurs

### Dashboard Packages Consolidés

**URL :** `dashboard_admin_package_consolidated.php`

- Vue détaillée des packages dans les consolidations
- Statistiques et compteurs

### Dashboard Comptabilité

**URL :** `dashboard_admin_account.php`

- Vue synthétique des comptes à recevoir
- Soldes clients
- Paiements reçus vs en attente
- Graphiques financiers

---

## 3.5 Navigation depuis le tableau de bord

### Raccourcis d'action

Depuis chaque tableau de bord, vous pouvez accéder rapidement aux actions principales via :

1. **La sidebar** — navigation principale à gauche
2. **Les cartes cliquables** — chaque compteur est un lien vers la liste correspondante
3. **La barre de recherche** — `Ctrl+K` pour rechercher un élément

### Rafraîchissement des données

- Les données du tableau de bord sont calculées en **temps réel** à chaque chargement de page
- Les requêtes SQL interrogent directement la base de données pour le mois en cours
- Les graphiques Chart.js se mettent à jour au chargement

> **Conseil :** Pour une vue plus détaillée d'un module spécifique, utilisez les sous-tableaux de bord accessibles depuis le menu de la sidebar.
