# Chapitre 7 — Consolidation

> Le module de consolidation permet de regrouper plusieurs envois en un seul conteneur ou expédition groupée. Il existe deux sous-modules : les **envois consolidés** et les **packages consolidés**.

---

## 7.1 Concept de la consolidation

### Pourquoi consolider ?

La consolidation est une pratique courante en logistique internationale qui consiste à :

1. **Regrouper** plusieurs colis de différents clients dans un seul conteneur
2. **Réduire les coûts** de transport en partageant les frais
3. **Optimiser les volumes** en remplissant au maximum les conteneurs
4. **Simplifier les formalités** douanières avec un seul bordereau

### Deux types de consolidation

| Type | Description | URL |
|------|-------------|-----|
| **Envoi consolidé** | Regroupement d'expéditions courrier existantes | `consolidate_*.php` |
| **Package consolidé** | Regroupement de packages clients existants | `consolidate_package_*.php` |

### Cycle de vie d'une consolidation

```
Création → Ajout d'envois → Validation → En transit → Livré
                                        ↘ Annulé
```

---

## 7.2 Envois consolidés (Consolidate)

### Créer un envoi consolidé

**URL :** `consolidate_add.php`  
**Accès :** 🔴 Admin, 🟠 Employé

#### Informations de l'envoi consolidé

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **N° de suivi** | Auto-généré | ✅ | Préfixe consolidé + numéro séquentiel |
| **Date** | Date/Heure | ✅ | Date de création |
| **Expéditeur** | Select2 | ✅ | Client ou entreprise expéditrice |
| **Adresse expéditeur** | Select2 | ✅ | Adresse d'enlèvement |
| **Destinataire** | Select2 | ✅ | Client ou entreprise destinataire |
| **Adresse destinataire** | Select2 | ✅ | Adresse de livraison |

#### Détails logistiques

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Bureau d'origine** | Liste déroulante | ✅ | Bureau d'envoi |
| **Agence** | Liste déroulante | ✅ | Agence de rattachement |
| **Catégorie** | Liste déroulante | ✅ | Type de marchandise |
| **Emballage** | Liste déroulante | ✅ | Type de conteneur |
| **Mode d'expédition** | Liste déroulante | ✅ | Aérien, maritime, terrestre |
| **Transporteur** | Liste déroulante | ✅ | Entreprise de transport |
| **Délai de livraison** | Liste déroulante | ✅ | Délai estimé |
| **Chauffeur** | Liste déroulante | Optionnel | Chauffeur assigné |
| **Statut** | Liste déroulante | ✅ | Statut initial |

#### Dimensions, poids et tarification

Identiques à une expédition courrier classique (voir Chapitre 5, sections 5.2).

#### Ajout d'envois au consolidé

Une fois le conteneur créé, vous pouvez y **ajouter des expéditions existantes** :

1. Dans la page de détails du consolidé, cliquez sur **Ajouter un envoi**
2. La fenêtre modale (`modal_add_ship_consolidate.php`) s'ouvre
3. **Recherchez** les expéditions à ajouter (par numéro de suivi, client, etc.)
4. **Sélectionnez** les expéditions à consolider (minimum 2)
5. Cliquez sur **Ajouter au consolidé**
6. Les expéditions sont rattachées au conteneur consolidé

#### Procédure complète

1. Accédez à **Consolidation > Envois consolidés > Ajouter**
2. Remplissez les informations du conteneur
3. Enregistrez le conteneur
4. Ajoutez les expéditions individuelles au conteneur
5. Vérifiez le total (poids, dimensions, frais)
6. Validez et mettez à jour le statut

### Numérotation

- **Préfixe** : configurable dans les paramètres (`prefix_consolidate`, ex: `COL`)
- **Numéro** : séquentiel, basé sur le compteur `c_no` dans `cdb_consolidate`
- **Format** : `COL00001`, `COL00002`, etc.

---

### Liste des envois consolidés

**URL :** `consolidate_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client, 🟢 Chauffeur

#### Tableau

| Colonne | Description |
|---------|-------------|
| **N° de suivi** | Numéro du consolidé |
| **Expéditeur** | Client expéditeur |
| **Destinataire** | Destinataire |
| **Date** | Date de création |
| **Poids total** | Poids cumulé |
| **Montant** | Total des frais |
| **Statut** | Badge coloré |
| **Actions** | Boutons |

#### Visibilité

| Rôle | Données visibles |
|------|-----------------|
| **Admin / Employé** | Tous les consolidés |
| **Client** | Ses propres consolidés uniquement |
| **Chauffeur** | Consolidés qui lui sont assignés |

#### Actions

| Action | Description | Rôles |
|--------|-------------|-------|
| **Voir** | Détails complets + liste des envois inclus | Tous |
| **Modifier** | Éditer le consolidé | Admin, Employé |
| **Suivi** | Mettre à jour le tracking | Admin, Employé |
| **Livraison** | Confirmer la livraison | Admin, Employé |
| **Imprimer** | Étiquette et bordereau PDF | Admin, Employé |
| **Email** | Envoyer par email | Admin, Employé |
| **Supprimer** | Supprimer le consolidé | Admin |

---

### Détails d'un envoi consolidé

**URL :** `consolidate_view.php?view={id}`  
**Accès :** Tous les rôles

Affiche :
- Toutes les informations du conteneur
- **Liste des expéditions incluses** avec détails de chacune
- Timeline de suivi
- Documents joints
- Signature de livraison

---

### Suivi d'un envoi consolidé

**URL :** `consolidate_shipment_tracking.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Fonctionnement identique au suivi des expéditions courrier :
- Changement de statut
- Ajout de localisation et commentaire
- Notifications automatiques à tous les clients concernés

---

### Livraison d'un envoi consolidé

**URL :** `consolidate_deliver_shipment.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

- Signature électronique du destinataire
- Le statut de toutes les expéditions incluses peut être mis à jour simultanément
- Signature stockée dans `doc_signs/consolidate/`

---

## 7.3 Packages consolidés (Consolidate Packages)

### Concept

Les packages consolidés fonctionnent de la même manière que les envois consolidés, mais pour les **packages clients** (online shopping) au lieu des expéditions courrier.

Cela permet de regrouper plusieurs colis de différents clients qui arrivent d'un même entrepôt ou qui partent vers la même destination.

### Créer un package consolidé

**URL :** `consolidate_package_add.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Le formulaire est identique en structure à celui des envois consolidés, avec les mêmes champs et sections. La différence est que les éléments ajoutés sont des **packages clients** et non des expéditions courrier.

### Liste des packages consolidés

**URL :** `consolidate_package_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client, 🟢 Chauffeur

Même structure que la liste des envois consolidés.

### Détails, suivi et livraison

| Fonction | URL |
|----------|-----|
| **Voir** | `consolidate_package_view.php?view={id}` |
| **Modifier** | `consolidate_package_edit.php?edit={id}` |
| **Suivi** | `consolidate_package_shipment_tracking.php?edit={id}` |
| **Livraison** | `consolidate_package_deliver_shipment.php?edit={id}` |

---

## 7.4 Passerelles de paiement

### Pour les envois consolidés

**URL :** `payments_gateways_consolidate_list.php`  
**Ajouter :** `add_payment_gateways_consolidate.php?edit={id}`

### Pour les packages consolidés

**URL :** `payments_gateways_package_consolidate_list.php`  
**Ajouter :** `add_payment_gateways_consolidate_package.php?edit={id}`

Mêmes passerelles disponibles : PayPal, Stripe, Paystack, virement bancaire.

---

## 7.5 Impression

### Envois consolidés

| Document | URL |
|----------|-----|
| **Bordereau** | `print_consolidate.php?print={id}` |
| **Étiquette** | `print_label_consolidate.php?print={id}` |
| **Étiquettes multiples** | `print_label_consolidate_multiple.php` |
| **Email** | `send_email_pdf_consolidate.php` |

### Packages consolidés

| Document | URL |
|----------|-----|
| **Étiquette** | `print_label_consolidate_package.php?print={id}` |
| **Étiquettes multiples** | `print_label_consolidate_multiple_package.php` |
| **Email** | `send_email_pdf_consolidate_packages.php` |

---

## 7.6 Dashboard Consolidation

### Envois consolidés
**URL :** `dashboard_admin_consolidated.php`

### Packages consolidés
**URL :** `dashboard_admin_package_consolidated.php`

Ces tableaux de bord offrent :
- Compteurs par statut
- Graphiques de répartition
- Liste des derniers consolidés
- Accès rapide aux actions

---

## 7.7 Bonnes pratiques

1. **Regroupez par destination** — consolidez les envois allant vers la même zone géographique
2. **Respectez les limites de poids** — vérifiez la capacité maximale du conteneur/véhicule
3. **Documentez le contenu** — listez tous les envois inclus pour faciliter le dédouanement
4. **Mettez à jour le suivi** — chaque étape du consolidé doit être tracée, ce qui met à jour automatiquement tous les envois inclus
5. **Minimum 2 envois** — une consolidation nécessite au minimum 2 expéditions/packages
