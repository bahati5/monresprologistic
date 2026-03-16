# Chapitre 4 — Packages clients (Online Shopping)

> Ce module gère l'ensemble du cycle de vie des colis clients : de la pré-alerte à la livraison finale, en passant par l'enregistrement, le suivi et le paiement. Il est au coeur du service de casier virtuel (virtual locker) proposé aux clients.

---

## 4.1 Concept du casier virtuel

### Principe

Le **casier virtuel** est une adresse de réception unique attribuée à chaque client inscrit. Ce système fonctionne comme une boîte postale :

1. Le client s'inscrit sur MonResPro et reçoit un **numéro de casier** (ex: `LOC00042`)
2. Lors d'achats en ligne, le client utilise l'**adresse du dépôt MonResPro** comme adresse de livraison, en ajoutant son numéro de casier
3. Quand le colis arrive au dépôt, l'opérateur l'enregistre dans le système en utilisant le numéro de casier pour identifier le client
4. Le client est notifié et peut suivre son colis jusqu'à la livraison finale

### Numérotation

- **Préfixe** : configurable dans les paramètres (ex: `LOC`)
- **Chiffres** : nombre de chiffres configurable (ex: 5 → `00042`)
- **Format final** : `{préfixe}{numéro}` → `LOC00042`
- Le numéro est **incrémental** et unique pour chaque client

---

## 4.2 Pré-alertes

### Qu'est-ce qu'une pré-alerte ?

Une pré-alerte est une **notification anticipée** qu'un client envoie pour signaler qu'un colis est en route vers le dépôt. Cela permet à l'opérateur de :
- Anticiper la réception du colis
- Associer rapidement le colis au bon client à l'arrivée
- Préparer la facturation

### Créer une pré-alerte

**URL :** `prealert_add.php`  
**Accès :** 🔵 Client

#### Champs du formulaire

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Date** | Date | ✅ | Date de la pré-alerte (pré-remplie avec la date du jour) |
| **Entreprise de transport** | Liste déroulante | ✅ | L'entreprise qui achemine le colis (ex: DHL, FedEx, UPS) |
| **Numéro de suivi** | Texte | ✅ | Le tracking number du transporteur d'origine |
| **Fournisseur** | Texte | ✅ | Le nom du vendeur / magasin en ligne (ex: Amazon, eBay) |
| **Prix** | Nombre | ✅ | La valeur déclarée du colis (en devise du système) |
| **Description** | Texte long | Optionnel | Description du contenu du colis |
| **Fichier facture** | Fichier | Optionnel | Photo ou PDF de la facture d'achat |

#### Procédure

1. Dans la sidebar, cliquez sur **Packages clients > Créer pré-alerte**
2. La date est automatiquement remplie avec la date du jour
3. Sélectionnez l'**entreprise de transport** dans la liste déroulante
4. Saisissez le **numéro de suivi** fourni par le transporteur
5. Indiquez le **fournisseur** (nom du vendeur en ligne)
6. Saisissez le **prix déclaré** du colis
7. Ajoutez une **description** du contenu (facultatif mais recommandé)
8. Joignez la **facture d'achat** si disponible (image ou PDF)
9. Cliquez sur **Créer la pré-alerte**

#### Validation

- Le numéro de suivi est vérifié pour s'assurer qu'il n'est pas déjà utilisé
- Le fichier joint est limité en taille (validation côté client)
- Tous les champs marqués comme obligatoires doivent être remplis

### Liste des pré-alertes

**URL :** `prealert_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client

#### Fonctionnalités de la liste

- **Tableau paginé** avec toutes les pré-alertes
- **Colonnes** : Date, N° de suivi, Fournisseur, Transporteur, Prix, Statut, Actions
- **Filtres** : par date, par statut, par client (admin/employé uniquement)
- **Recherche** : par numéro de suivi ou nom de fournisseur
- **Export** : possibilité d'exporter la liste

#### Statuts des pré-alertes

| Statut | Description |
|--------|-------------|
| **En attente** | Pré-alerte créée, colis pas encore reçu |
| **Reçu** | Colis arrivé au dépôt |
| **Enregistré** | Colis enregistré comme package client |

#### Actions disponibles

- **Voir** — consulter les détails de la pré-alerte
- **Créer un package à partir de la pré-alerte** — convertir la pré-alerte en package client (Admin/Employé)
- **Supprimer** — supprimer la pré-alerte (sous conditions)

---

## 4.3 Enregistrement de packages clients

### Créer un package client

**URL :** `customer_packages_add.php`  
**Accès :** 🔴 Admin, 🟠 Employé

#### Champs du formulaire

Le formulaire de création d'un package client est complet et couvre toutes les informations nécessaires :

##### Informations de base

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **N° de suivi** | Texte | ✅ | Numéro de suivi auto-généré ou saisi manuellement |
| **Préfixe** | Texte | Auto | Préfixe configuré dans les paramètres |
| **Date** | Date | ✅ | Date d'enregistrement |

##### Informations client

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Client** | Select2 (recherche) | ✅ | Sélection du client destinataire via recherche |
| **Casier virtuel** | Auto | Auto | Numéro de casier du client sélectionné |

##### Informations de l'expédition

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Bureau d'origine** | Liste déroulante | ✅ | Bureau ou agence d'où le colis est envoyé |
| **Agence** | Liste déroulante | ✅ | Agence de rattachement |
| **Catégorie** | Liste déroulante | ✅ | Type de marchandise (électronique, vêtements, etc.) |
| **Emballage** | Liste déroulante | ✅ | Type d'emballage (carton, enveloppe, etc.) |
| **Mode d'expédition** | Liste déroulante | ✅ | Aérien, maritime, terrestre, etc. |
| **Entreprise de transport** | Liste déroulante | ✅ | Transporteur utilisé |
| **Délai de livraison** | Liste déroulante | ✅ | Délai estimé |
| **Chauffeur** | Liste déroulante | Optionnel | Chauffeur assigné pour la livraison |

##### Dimensions et poids

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Poids** | Nombre | ✅ | Poids en kg ou lbs (selon configuration) |
| **Longueur** | Nombre | Optionnel | Longueur en cm ou inches |
| **Largeur** | Nombre | Optionnel | Largeur en cm ou inches |
| **Hauteur** | Nombre | Optionnel | Hauteur en cm ou inches |
| **Nombre de pièces** | Nombre | ✅ | Quantité de pièces dans le colis |

##### Tarification

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Valeur déclarée** | Nombre | Optionnel | Valeur déclarée de la marchandise |
| **Frais d'expédition** | Nombre | ✅ | Coût de l'expédition |
| **Taxes** | Auto-calculé | Auto | Taxes applicables selon configuration |
| **Assurance** | Auto-calculé | Auto | Prime d'assurance si applicable |
| **Frais supplémentaires** | Nombre | Optionnel | Frais additionnels |
| **Total** | Auto-calculé | Auto | Somme de tous les frais |

##### Paiement et statut

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Mode de paiement** | Liste déroulante | ✅ | Espèces, carte, virement, etc. |
| **Méthode de paiement** | Liste déroulante | ✅ | Détail de la méthode |
| **Statut** | Liste déroulante | ✅ | Statut initial du colis |
| **Description** | Texte long | Optionnel | Notes ou description du colis |

##### Fichiers joints

| Champ | Type | Description |
|-------|------|-------------|
| **Photos/Documents** | Upload multiple | Photos du colis, facture, documents douaniers |

#### Procédure de création

1. Accédez à **Packages clients > Ajouter un package**
2. Le numéro de suivi est **auto-généré** (préfixe + numéro séquentiel)
3. **Sélectionnez le client** via le champ de recherche Select2 (tapez le nom ou email)
4. Les informations par défaut sont pré-remplies selon la configuration (`cdb_info_ship_default`)
5. Complétez les informations d'expédition
6. Saisissez les dimensions et le poids
7. Les frais sont calculés automatiquement ou saisis manuellement
8. Sélectionnez le mode de paiement et le statut
9. Ajoutez des fichiers joints si nécessaire
10. Cliquez sur **Enregistrer**
11. Le client est **automatiquement notifié** (email / WhatsApp / SMS selon configuration)

### Créer un package à partir d'une pré-alerte

**URL :** `customer_packages_add_from_prealert.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Cette variante du formulaire est pré-remplie avec les informations de la pré-alerte :
- Le numéro de suivi original est conservé
- Le client est automatiquement identifié
- Le fournisseur et la valeur déclarée sont pré-remplis
- La facture jointe à la pré-alerte est reprise

### Enregistrement multiple

**URL :** `customer_packages_multiple.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Permet de créer **plusieurs packages en une seule opération** :
- Formulaire identique mais avec possibilité d'ajouter plusieurs lignes
- Idéal pour l'enregistrement en lot de colis reçus

---

## 4.4 Liste des packages clients

**URL :** `customer_packages_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client, 🟢 Chauffeur

### Tableau de données

Le tableau affiche tous les packages clients avec les colonnes suivantes :

| Colonne | Description |
|---------|-------------|
| **N° de suivi** | Numéro de tracking unique |
| **Client** | Nom du client destinataire |
| **Date** | Date d'enregistrement |
| **Origine** | Bureau / agence d'origine |
| **Poids** | Poids du colis |
| **Montant** | Total des frais |
| **Statut** | Statut actuel (avec badge coloré) |
| **Actions** | Boutons d'action |

### Filtrage et recherche

- **Barre de recherche** : recherche globale dans toutes les colonnes
- **Filtres avancés** :
  - Par période (date début / date fin)
  - Par statut
  - Par client
  - Par agence
- **Tri** : cliquez sur l'en-tête de colonne pour trier
- **Pagination** : navigation entre les pages de résultats

### Actions disponibles par ligne

| Action | Icône | Description | Rôles |
|--------|-------|-------------|-------|
| **Voir** | 👁 | Consulter tous les détails du package | Tous |
| **Modifier** | ✏️ | Éditer les informations du package | Admin, Employé |
| **Suivi** | 📍 | Voir/mettre à jour l'historique de suivi | Admin, Employé |
| **Livraison** | 🚚 | Marquer comme livré avec signature | Admin, Employé |
| **Imprimer étiquette** | 🏷 | Générer l'étiquette du colis (PDF) | Admin, Employé |
| **Imprimer facture** | 📄 | Générer la facture (PDF) | Admin, Employé |
| **Envoyer email** | ✉️ | Envoyer la facture par email au client | Admin, Employé |
| **Supprimer** | 🗑 | Supprimer le package | Admin |

### Actions en lot

- **Sélection multiple** : cochez plusieurs packages
- **Changement de statut en lot** : modifier le statut de plusieurs packages simultanément
- **Impression d'étiquettes multiples** : générer un PDF avec toutes les étiquettes sélectionnées
- **Assignation de chauffeur en lot** : assigner un chauffeur à plusieurs packages

---

## 4.5 Consulter un package

**URL :** `customer_packages_view.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client (ses propres packages)

### Informations affichées

La page de détail affiche toutes les informations du package :

1. **En-tête** : numéro de suivi, statut actuel avec badge coloré, date
2. **Informations client** : nom, email, téléphone, casier virtuel
3. **Détails de l'expédition** : origine, destination, catégorie, emballage, mode, transporteur
4. **Dimensions et poids** : poids, dimensions, nombre de pièces
5. **Tarification complète** : détail de tous les frais, taxes, assurance, total
6. **Informations de paiement** : mode, méthode, statut du paiement
7. **Historique de suivi** : timeline de tous les changements de statut
8. **Documents joints** : photos et fichiers associés
9. **Signature de livraison** : si le colis a été livré, la signature est affichée

---

## 4.6 Modifier un package

**URL :** `customer_package_edit.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Le formulaire d'édition reprend tous les champs du formulaire de création, pré-remplis avec les données existantes. Vous pouvez modifier :

- Les informations d'expédition
- Les dimensions et le poids
- La tarification
- Le statut
- Le chauffeur assigné
- Les fichiers joints

> **Attention :** La modification d'un package peut déclencher une nouvelle notification au client si le statut change.

---

## 4.7 Suivi d'un package

**URL :** `customer_package_tracking.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

### Mettre à jour le suivi

La page de suivi permet d'ajouter des étapes au parcours du colis :

1. **Sélectionnez le nouveau statut** dans la liste déroulante
2. Ajoutez une **note/commentaire** optionnel (ex: « Colis arrivé à l'entrepôt de Douala »)
3. Sélectionnez la **localisation** (ville, pays)
4. Cliquez sur **Mettre à jour**

### Historique de suivi (Timeline)

L'historique affiche chronologiquement toutes les étapes du colis :
- **Date et heure** de chaque mise à jour
- **Statut** avec badge coloré
- **Localisation** si renseignée
- **Commentaire** de l'opérateur
- **Utilisateur** qui a effectué la mise à jour

### Notifications automatiques

À chaque mise à jour de statut, le client peut recevoir une notification :
- **Email** — si l'email SMTP est configuré et le modèle de notification activé
- **WhatsApp** — si l'API WhatsApp est configurée
- **SMS** — si Twilio SMS est configuré

---

## 4.8 Livraison d'un package

**URL :** `customer_package_deliver.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

### Procédure de livraison

1. Accédez à la page de livraison du package
2. Vérifiez les **informations du colis** affichées
3. Le destinataire **signe** directement sur l'écran (signature électronique)
4. Ajoutez des **notes de livraison** si nécessaire
5. Cliquez sur **Confirmer la livraison**
6. Le statut passe automatiquement à **« Livré »**
7. La signature est enregistrée et associée au colis
8. Le client est notifié de la livraison

### Signature électronique

- Un **canvas de signature** est affiché à l'écran
- Le destinataire signe avec le doigt (tablette/mobile) ou la souris (PC)
- La signature est enregistrée comme image et stockée dans le dossier `doc_signs/customer_packages/`

---

## 4.9 Paiements des packages

### Passerelles de paiement

**URL :** `payments_gateways_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client

Les clients peuvent payer leurs packages via plusieurs passerelles :

| Passerelle | Description |
|------------|-------------|
| **PayPal** | Paiement par compte PayPal |
| **Stripe** | Paiement par carte bancaire |
| **Paystack** | Paiement mobile (Afrique) |
| **Virement bancaire** | Preuve de paiement à valider manuellement |
| **Paiement en agence** | Paiement en espèces ou par carte au bureau |

### Ajouter un paiement

**URL :** `add_payment_gateways_package.php?edit={id}`

1. Sélectionnez le **package** à payer
2. Choisissez la **passerelle de paiement**
3. Saisissez le **montant**
4. Selon la passerelle :
   - **PayPal** : redirection vers PayPal pour validation
   - **Stripe** : formulaire de carte bancaire sécurisé
   - **Paystack** : redirection vers le widget Paystack
   - **Virement** : upload de la preuve de paiement
5. Le paiement est enregistré et le solde du client est mis à jour

### Vérification des preuves de paiement

**URL :** `payment_proofs_pending.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Pour les paiements par virement bancaire, l'administrateur doit :
1. Consulter la liste des **preuves de paiement en attente**
2. **Vérifier** la preuve (capture d'écran ou document)
3. **Valider** ou **rejeter** le paiement

---

## 4.10 Impression

### Étiquette de colis

**URL :** `print_label_package.php?print={id}`

Génère un PDF contenant :
- Numéro de suivi avec code-barres
- Informations expéditeur et destinataire
- Poids et dimensions
- Description du contenu

### Étiquettes multiples

**URL :** `print_label_package_multiple.php`

Génère un PDF avec plusieurs étiquettes sur une même page pour l'impression en lot.

### Facture

**URL :** `print_invoice_package.php?print={id}`

Génère une facture PDF contenant :
- Coordonnées de l'entreprise
- Informations du client
- Détail des frais (expédition, taxes, assurance, suppléments)
- Total à payer
- Conditions de paiement

### Envoi par email

**URL :** `send_email_pdf_packages.php`

Envoie automatiquement la facture PDF par email au client.
