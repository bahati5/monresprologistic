# Chapitre 5 — Expéditions Courier

> Le module Courier gère les envois point-à-point : de l'expéditeur au destinataire, avec calcul de tarifs, suivi en temps réel, assignation de chauffeur et confirmation de livraison avec signature.

---

## 5.1 Concept

Une **expédition courrier** représente un envoi physique d'un point A (expéditeur) vers un point B (destinataire). Contrairement aux packages clients qui transitent par un casier virtuel, les expéditions courrier sont des envois directs.

### Cycle de vie d'une expédition

```
Création → Acceptation → En transit → En cours de livraison → Livré
                                    ↘ Retourné / Annulé
```

1. **Création** — L'opérateur ou le client crée l'expédition avec toutes les informations
2. **Acceptation** — L'opérateur valide l'expédition et assigne un chauffeur
3. **En transit** — Le colis est en route vers la destination
4. **En cours de livraison** — Le chauffeur est en train de livrer
5. **Livré** — Livraison confirmée avec signature électronique
6. **Retourné / Annulé** — En cas de problème (adresse introuvable, refus, etc.)

---

## 5.2 Créer une expédition

**URL :** `courier_add.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🟢 Chauffeur

### Le formulaire complet

Le formulaire de création d'une expédition est l'un des plus complets de l'application. Il est organisé en sections.

#### Section 1 — Numéro de suivi

| Champ | Type | Description |
|-------|------|-------------|
| **Préfixe** | Auto | Préfixe configuré dans les paramètres (ex: `AWB`) |
| **Numéro de suivi** | Auto-généré | Numéro séquentiel auto-généré (`prefix` + `order_no`) |
| **Date** | Date/Heure | Date et heure de création |

Le numéro de suivi est automatiquement généré à partir du préfixe et du compteur séquentiel configurés dans **Configuration > Suivi et facturation**.

#### Section 2 — Expéditeur

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Client expéditeur** | Select2 | ✅ | Recherche et sélection du client expéditeur |
| **Adresse expéditeur** | Select2 | ✅ | Sélection parmi les adresses enregistrées du client |
| **Téléphone** | Auto | Auto | Rempli automatiquement à la sélection du client |
| **Email** | Auto | Auto | Rempli automatiquement |

> **Astuce :** Si l'expéditeur n'est pas encore dans le système, vous pouvez le créer directement via le bouton **« + Nouveau client »** qui ouvre une fenêtre modale sans quitter le formulaire.

#### Section 3 — Destinataire

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Destinataire** | Select2 | ✅ | Recherche et sélection du destinataire |
| **Adresse destinataire** | Select2 | ✅ | Sélection parmi les adresses du destinataire |
| **Téléphone** | Auto | Auto | Rempli automatiquement |
| **Email** | Auto | Auto | Rempli automatiquement |

> **Astuce :** Comme pour l'expéditeur, un bouton **« + Nouveau destinataire »** permet de créer un destinataire à la volée via une fenêtre modale.

#### Section 4 — Détails de l'expédition

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Bureau d'origine** | Liste déroulante | ✅ | Bureau d'envoi |
| **Agence** | Liste déroulante | ✅ | Agence de rattachement |
| **Catégorie** | Liste déroulante | ✅ | Type de marchandise (documents, électronique, fragile, etc.) |
| **Emballage** | Liste déroulante | ✅ | Type d'emballage (enveloppe, carton petit/moyen/grand, palette) |
| **Mode d'expédition** | Liste déroulante | ✅ | Aérien, maritime, terrestre, express |
| **Entreprise de transport** | Liste déroulante | ✅ | Transporteur partenaire |
| **Délai de livraison** | Liste déroulante | ✅ | Délai estimé (24h, 48h, 3-5 jours, etc.) |
| **Chauffeur** | Liste déroulante | Optionnel | Chauffeur assigné |
| **Statut** | Liste déroulante | ✅ | Statut initial |
| **Incoterms** | Liste déroulante | Optionnel | Conditions de commerce international |

> **Valeurs par défaut :** Les champs catégorie, emballage, mode, transporteur, délai, mode de paiement et statut sont pré-remplis avec les valeurs par défaut configurées dans **Configuration > Valeurs par défaut des expéditions** (`info_ship_default.php`).

#### Section 5 — Dimensions et poids

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Poids** | Nombre | ✅ | Poids réel en kg ou lbs |
| **Longueur** | Nombre | Optionnel | En cm ou inches |
| **Largeur** | Nombre | Optionnel | En cm ou inches |
| **Hauteur** | Nombre | Optionnel | En cm ou inches |
| **Poids volumétrique** | Auto-calculé | Auto | Calculé à partir des dimensions (L×l×H / facteur) |
| **Nombre de pièces** | Nombre | ✅ | Quantité de colis |

Le système utilise le **poids le plus élevé** entre le poids réel et le poids volumétrique pour le calcul des frais.

#### Section 6 — Tarification

| Champ | Type | Description |
|-------|------|-------------|
| **Tarif de base** | Auto/Manuel | Calculé automatiquement à partir des tarifs configurés ou saisi manuellement |
| **Valeur déclarée** | Nombre | Valeur de la marchandise (pour l'assurance) |
| **Taxe 1 à 7** | Auto-calculé | Taxes applicables (activées/désactivées dans la configuration) |
| **Assurance** | Auto-calculé | Prime d'assurance basée sur la valeur déclarée |
| **Frais supplémentaires** | Nombre | Frais additionnels |
| **Remise** | Nombre | Remise éventuelle |
| **Total** | Auto-calculé | Somme de tous les frais |

##### Calcul automatique des tarifs

Si le **tarif automatique** est activé (`c_tariffs`), le système calcule le tarif à partir de :
- Le **pays d'origine** et le **pays de destination**
- Le **poids** (le plus élevé entre réel et volumétrique)
- La **grille tarifaire** configurée dans **Configuration > Tarifs d'expédition**

Le tarif est recherché dans la table `cdb_tariffs` en fonction de la plage de poids et de la route origine/destination.

#### Section 7 — Paiement

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Mode de paiement** | Liste déroulante | ✅ | Prépayé, à la livraison, crédit |
| **Méthode de paiement** | Liste déroulante | ✅ | Espèces, carte, virement, mobile money |

#### Section 8 — Fichiers et notes

| Champ | Type | Description |
|-------|------|-------------|
| **Description** | Texte long | Détail du contenu, instructions spéciales |
| **Fichiers joints** | Upload multiple | Photos du colis, documents douaniers, facture |

### Procédure complète

1. Accédez à **Expéditions > Ajouter une expédition**
2. Le numéro de suivi et la date sont automatiquement remplis
3. Sélectionnez l'**expéditeur** (ou créez-en un nouveau)
4. Sélectionnez son **adresse** (ou créez-en une nouvelle)
5. Sélectionnez le **destinataire** (ou créez-en un nouveau)
6. Sélectionnez son **adresse**
7. Remplissez les détails d'expédition (les valeurs par défaut sont pré-remplies)
8. Saisissez les dimensions et le poids
9. Vérifiez la tarification (automatique ou manuelle)
10. Choisissez le mode et la méthode de paiement
11. Ajoutez une description et des fichiers si nécessaire
12. Cliquez sur **Enregistrer l'expédition**
13. Les notifications sont envoyées automatiquement au client

---

## 5.3 Créer une expédition (Client)

**URL :** `courier_add_client.php`  
**Accès :** 🔵 Client

Le formulaire client est une **version simplifiée** du formulaire opérateur :

- L'**expéditeur** est automatiquement le client connecté
- Moins de champs techniques visibles
- Le tarif est calculé automatiquement
- Certains champs sont en lecture seule

---

## 5.4 Enregistrement multiple

**URL :** `courier_add_multiple.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Permet de créer **plusieurs expéditions simultanément** :
- Un formulaire avec les informations communes (même expéditeur, même destination)
- Ajout de plusieurs lignes pour chaque colis
- Chaque colis reçoit un numéro de suivi unique
- Idéal pour les envois en lot

---

## 5.5 Liste des expéditions

**URL :** `courier_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client, 🟢 Chauffeur

### Tableau de données

| Colonne | Description |
|---------|-------------|
| **☐** | Case à cocher pour sélection multiple |
| **N° de suivi** | Numéro de tracking (lien vers les détails) |
| **Expéditeur** | Nom du client expéditeur |
| **Destinataire** | Nom du destinataire |
| **Date** | Date de création |
| **Origine → Destination** | Route de l'expédition |
| **Poids** | Poids du colis |
| **Total** | Montant total des frais |
| **Statut** | Badge coloré avec le statut actuel |
| **Actions** | Boutons d'action |

### Filtres disponibles

- **Recherche globale** : dans toutes les colonnes
- **Par statut** : filtrer par un statut spécifique
- **Par période** : date de début et date de fin
- **Par agence** : filtrer par agence (admin/employé)
- **Par chauffeur** : filtrer par chauffeur assigné

### Actions par ligne

| Action | Description | Rôles |
|--------|-------------|-------|
| **Voir** | Détails complets de l'expédition | Tous |
| **Modifier** | Éditer l'expédition | Admin, Employé |
| **Suivi** | Mettre à jour le statut/tracking | Admin, Employé |
| **Livraison** | Confirmer la livraison | Admin, Employé |
| **Imprimer étiquette** | Générer l'étiquette PDF | Admin, Employé |
| **Imprimer facture** | Générer la facture PDF | Admin, Employé |
| **Envoyer email** | Envoyer la facture par email | Admin, Employé |
| **Supprimer** | Supprimer l'expédition | Admin |

### Actions en lot

- **Changement de statut** : sélectionnez plusieurs expéditions → changez le statut en une fois
- **Assignation chauffeur** : sélectionnez → assignez un chauffeur
- **Impression** : sélectionnez → impression d'étiquettes multiples
- **Mise à jour en lot** : mise à jour via fichier ou sélection multiple

---

## 5.6 Détails d'une expédition

**URL :** `courier_view.php?view={id}`  
**Accès :** Tous les rôles

La page de détails affiche l'intégralité des informations :

1. **En-tête** — Numéro de suivi, statut, dates
2. **Expéditeur** — Nom, adresse, téléphone, email
3. **Destinataire** — Nom, adresse, téléphone, email
4. **Détails logistiques** — Bureau, agence, catégorie, emballage, mode, transporteur
5. **Dimensions** — Poids, dimensions, poids volumétrique, pièces
6. **Tarification** — Détail complet des frais
7. **Paiement** — Mode, méthode, statut
8. **Timeline de suivi** — Historique chronologique de tous les statuts
9. **Documents** — Fichiers joints, photos
10. **Signature** — Signature de livraison si applicable

### Boutons d'action rapide

- **Modifier** — accès au formulaire d'édition
- **Imprimer** — étiquette ou facture
- **Email** — envoyer par email
- **Suivi** — mettre à jour le tracking

---

## 5.7 Modifier une expédition

**URL :** `courier_edit.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Formulaire identique à la création, pré-rempli avec les données existantes. Tous les champs sont modifiables.

---

## 5.8 Accepter une expédition

**URL :** `courier_accept.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Page spécialisée pour l'**acceptation** d'une expédition créée par un client :

1. Vérification des informations saisies par le client
2. Complétion des champs manquants (tarification, assignation chauffeur)
3. Validation et changement de statut
4. Notification au client que son expédition est acceptée

---

## 5.9 Suivi d'une expédition

**URL :** `courier_shipment_tracking.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

### Mettre à jour le suivi

1. Sélectionnez le **nouveau statut** dans la liste
2. Ajoutez une **localisation** (optionnel)
3. Ajoutez un **commentaire** (optionnel)
4. Cliquez sur **Mettre à jour le suivi**

### Timeline interactive

L'historique de suivi est affiché sous forme de **timeline verticale** avec :
- Icône de statut colorée
- Date et heure
- Statut
- Localisation
- Commentaire
- Opérateur qui a effectué la mise à jour

### Notifications automatiques

Chaque mise à jour déclenche potentiellement :
- **Email** au client (si configuré)
- **WhatsApp** au client (si configuré)
- **SMS** au client (si configuré)

Le contenu de la notification utilise les **modèles de notification** configurés dans les paramètres.

---

## 5.10 Livraison d'une expédition

**URL :** `courier_deliver_shipment.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

### Procédure

1. Vérifiez les informations affichées (destinataire, colis)
2. Le destinataire signe sur le **canvas de signature** (tactile ou souris)
3. Ajoutez des **notes de livraison** (optionnel)
4. Cliquez sur **Confirmer la livraison**
5. Le statut passe à **« Livré »**
6. La signature est sauvegardée dans `doc_signs/shipments_courier/`
7. Le client est notifié

---

## 5.11 Passerelles de paiement (Courier)

**URL :** `payments_gateways_courier_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client

Liste et gestion des paiements spécifiques aux expéditions courrier :
- Mêmes passerelles disponibles que pour les packages clients (PayPal, Stripe, Paystack, virement)
- Ajout de paiement via `add_payment_gateways_courier.php`

---

## 5.12 Impression

### Étiquette d'expédition

**URL :** `print_label_ship.php?print={id}`

PDF avec :
- Code-barres du numéro de suivi
- Adresse expéditeur et destinataire
- Poids, dimensions, nombre de pièces
- Catégorie et description
- Instructions spéciales

### Étiquettes multiples

**URL :** `print_label_ship_multiple.php`

Impression en lot de plusieurs étiquettes sur une même page.

### Facture / Bordereau

**URL :** `print_inv_ship.php?print={id}`

Facture détaillée avec tous les frais.

### Bordereau de suivi

**URL :** `print_inv_ship_track.php?print={id}`

Document avec le QR code / code-barres pour le suivi.

### Envoi par email

**URL :** `send_email_pdf.php`

Envoi automatique de la facture PDF par email au client.
