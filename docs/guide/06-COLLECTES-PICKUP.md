# Chapitre 6 — Collectes (Pickup)

> Le module Pickup permet de planifier et gérer la collecte de colis chez les clients. Un chauffeur est assigné pour aller chercher le colis à l'adresse indiquée et le ramener au dépôt ou directement au destinataire.

---

## 6.1 Concept

Une **collecte (pickup)** représente une demande de ramassage de colis :

1. Le client ou l'opérateur **crée une demande** de collecte avec l'adresse et la date souhaitée
2. L'opérateur **accepte** la demande et **assigne un chauffeur**
3. Le chauffeur **se rend** à l'adresse de collecte
4. Le colis est **récupéré** et ramené au dépôt
5. Le colis peut ensuite être enregistré comme expédition ou package client

### Cycle de vie d'une collecte

```
Demande créée → Acceptée → En cours de collecte → Collecté → Terminé
                                                 ↘ Annulé
```

---

## 6.2 Créer une collecte (Opérateur)

**URL :** `pickup_add_full.php`  
**Accès :** 🔴 Admin, 🟢 Chauffeur

### Formulaire complet (pickup_add_full)

Ce formulaire est la version complète destinée aux administrateurs et chauffeurs.

#### Informations de la collecte

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Date de collecte** | Date/Heure | ✅ | Date et heure souhaitées pour la collecte |
| **Client** | Select2 | ✅ | Client demandeur de la collecte |
| **Adresse de collecte** | Select2/Texte | ✅ | Adresse où récupérer le colis |
| **Téléphone de contact** | Téléphone | ✅ | Numéro pour joindre le client |

#### Informations du colis

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Description** | Texte long | ✅ | Description du colis à collecter |
| **Catégorie** | Liste déroulante | ✅ | Type de marchandise |
| **Poids estimé** | Nombre | Optionnel | Poids approximatif |
| **Nombre de pièces** | Nombre | ✅ | Quantité de colis à récupérer |

#### Assignation

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Chauffeur** | Liste déroulante | Optionnel | Chauffeur assigné (peut être assigné plus tard) |
| **Bureau** | Liste déroulante | ✅ | Bureau de rattachement |
| **Agence** | Liste déroulante | ✅ | Agence responsable |
| **Statut** | Liste déroulante | ✅ | Statut initial (ex: « En attente ») |

#### Informations destinataire (optionnel)

| Champ | Type | Description |
|-------|------|-------------|
| **Destinataire** | Select2 | Si la collecte est liée à un envoi direct |
| **Adresse de destination** | Select2 | Adresse finale de livraison |

### Procédure

1. Accédez à **Collectes > Ajouter une collecte**
2. Sélectionnez le **client** et son **adresse**
3. Indiquez la **date et l'heure** souhaitées
4. Décrivez le **colis** (contenu, poids estimé, quantité)
5. Assignez un **chauffeur** (optionnel à cette étape)
6. Cliquez sur **Enregistrer la collecte**
7. Le client et le chauffeur sont notifiés

---

## 6.3 Créer une collecte (Client)

**URL :** `pickup_add.php`  
**Accès :** 🔵 Client, 🟠 Employé

### Formulaire simplifié

Le formulaire client est une version allégée :

- Le **client** est automatiquement pré-rempli (le client connecté)
- Moins de champs techniques
- Pas d'assignation de chauffeur (fait par l'opérateur)
- Le statut est automatiquement « En attente »

#### Champs disponibles

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Date de collecte** | Date | ✅ | Date souhaitée |
| **Adresse de collecte** | Texte | ✅ | Adresse où récupérer le colis |
| **Téléphone** | Téléphone | ✅ | Numéro de contact |
| **Description** | Texte long | ✅ | Description du colis |
| **Nombre de pièces** | Nombre | ✅ | Quantité |

### Procédure client

1. Dans la sidebar, cliquez sur **Collectes > Nouvelle collecte**
2. Indiquez la **date** de collecte souhaitée
3. Vérifiez votre **adresse** et **téléphone**
4. Décrivez le **colis** à collecter
5. Cliquez sur **Demander la collecte**
6. L'administrateur est notifié de la nouvelle demande
7. Vous recevrez une notification quand la collecte sera acceptée

---

## 6.4 Liste des collectes

**URL :** `pickup_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client, 🟢 Chauffeur

### Tableau de données

| Colonne | Description |
|---------|-------------|
| **N°** | Numéro de la collecte |
| **Client** | Nom du client demandeur |
| **Date** | Date de collecte prévue |
| **Adresse** | Adresse de collecte |
| **Chauffeur** | Chauffeur assigné |
| **Statut** | Badge coloré du statut |
| **Actions** | Boutons d'action |

### Filtrage

- Par **statut** (en attente, acceptée, en cours, terminée, annulée)
- Par **période** (date début / fin)
- Par **chauffeur** (admin/employé)
- Par **agence** (admin/employé)
- **Recherche globale** dans toutes les colonnes

### Visibilité par rôle

| Rôle | Données visibles |
|------|-----------------|
| **Admin / Employé** | Toutes les collectes de toutes les agences |
| **Client** | Uniquement ses propres collectes |
| **Chauffeur** | Uniquement les collectes qui lui sont assignées |

### Actions disponibles

| Action | Description | Rôles |
|--------|-------------|-------|
| **Voir / Accepter** | Consulter et accepter la collecte | Admin, Employé |
| **Assigner chauffeur** | Attribuer un chauffeur à la collecte | Admin, Employé |
| **Mettre à jour le statut** | Changer le statut de la collecte | Admin, Employé, Chauffeur |
| **Annuler** | Annuler la collecte | Admin, Employé |
| **Supprimer** | Supprimer définitivement | Admin |

---

## 6.5 Accepter une collecte

**URL :** `pickup_accept.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

### Procédure d'acceptation

Lorsqu'un client crée une demande de collecte, un opérateur doit l'accepter :

1. Consultez la **liste des collectes** et identifiez celles en statut « En attente »
2. Cliquez sur **Voir / Accepter** pour ouvrir les détails
3. Vérifiez les informations (adresse, date, description)
4. **Assignez un chauffeur** dans la liste déroulante
5. Ajustez la **date/heure** si nécessaire
6. Complétez les informations manquantes (bureau, agence, etc.)
7. Changez le statut en **« Acceptée »**
8. Cliquez sur **Valider**
9. Le client est notifié que sa collecte est acceptée
10. Le chauffeur est notifié de sa nouvelle assignation

### Informations affichées

La page d'acceptation affiche toutes les informations de la collecte avec la possibilité de :
- Modifier les détails
- Assigner un chauffeur
- Ajouter des notes internes
- Mettre à jour le statut

---

## 6.6 Mise à jour du statut

### Statuts disponibles

Les statuts de collecte sont les mêmes que ceux configurés dans **Configuration > Statuts** (`cdb_styles`), à l'exception du statut « Retenu en douane » (id 14) qui est exclu des collectes.

Statuts typiques pour une collecte :

| Statut | Description | Couleur |
|--------|-------------|---------|
| **En attente** | Demande créée, pas encore traitée | Jaune |
| **Acceptée** | Collecte confirmée par l'opérateur | Bleu |
| **En cours** | Chauffeur en route vers l'adresse | Orange |
| **Collecté** | Colis récupéré | Vert clair |
| **Au dépôt** | Colis arrivé au dépôt | Vert |
| **Annulé** | Collecte annulée | Rouge |

### Workflow de mise à jour

1. Depuis la liste ou la page de détails, changez le **statut**
2. La mise à jour est enregistrée avec un **horodatage**
3. Des **notifications** sont envoyées selon la configuration :
   - Client informé du changement de statut
   - Chauffeur informé si nécessaire

---

## 6.7 Annulation d'une collecte

### Fenêtre modale d'annulation

Une fenêtre modale (`modal_cancel_pickup.php`) s'affiche pour confirmer l'annulation :

1. Cliquez sur le bouton **Annuler** dans la liste
2. La modale s'ouvre avec un message de confirmation
3. Vous pouvez ajouter un **motif d'annulation**
4. Cliquez sur **Confirmer l'annulation**
5. Le statut passe à « Annulé »
6. Le client est notifié

### Suppression

La suppression définitive (`modal_delete_pickup.php`) est réservée aux administrateurs :

1. Cliquez sur le bouton **Supprimer**
2. Confirmez dans la modale de confirmation
3. La collecte est définitivement supprimée de la base de données

> **Attention :** La suppression est irréversible. Préférez l'annulation à la suppression.

---

## 6.8 Dashboard Collectes

**URL :** `dashboard_admin_pickup.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Le tableau de bord des collectes offre une vue synthétique :

- **Compteurs par statut** : nombre de collectes par statut
- **Graphiques** : répartition visuelle
- **Liste récente** : dernières collectes avec accès rapide aux actions
- **Filtres** : par période, agence, chauffeur

---

## 6.9 Bonnes pratiques

### Pour les opérateurs

1. **Traitez les demandes rapidement** — les collectes en attente doivent être acceptées dans les 24h
2. **Assignez un chauffeur disponible** — vérifiez la charge de travail du chauffeur avant l'assignation
3. **Confirmez la date** avec le client si la date demandée n'est pas disponible
4. **Mettez à jour les statuts** en temps réel pour que le client puisse suivre

### Pour les clients

1. **Créez la demande à l'avance** — idéalement 24-48h avant la date souhaitée
2. **Soyez précis dans l'adresse** — incluez les détails (étage, code d'accès, etc.)
3. **Décrivez le colis** — poids approximatif, fragilité, dimensions
4. **Soyez disponible** — assurez-vous d'être présent à l'adresse le jour de la collecte

### Pour les chauffeurs

1. **Consultez votre dashboard** chaque matin pour voir les collectes du jour
2. **Appelez le client** avant de vous déplacer pour confirmer sa disponibilité
3. **Mettez à jour le statut** dès que vous prenez en charge ou terminez une collecte
4. **Signalez tout problème** (adresse introuvable, client absent) à l'opérateur
