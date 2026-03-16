# Chapitre 9 — Clients & Destinataires

> Ce module couvre la gestion complète des clients (expéditeurs) et des destinataires (récepteurs) de colis. Les clients sont des utilisateurs du système avec un compte, tandis que les destinataires sont des contacts associés aux clients.

---

## 9.1 Gestion des clients

### Liste des clients

**URL :** `customers_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/customers/customers_list.php`

#### Tableau de données

| Colonne | Description |
|---------|-------------|
| **ID** | Identifiant unique |
| **Nom complet** | Prénom + Nom |
| **Email** | Adresse email |
| **Téléphone** | Numéro de téléphone |
| **Casier virtuel** | Numéro de casier attribué |
| **Agence** | Agence de rattachement |
| **Statut** | Actif / Inactif |
| **Date d'inscription** | Date de création du compte |
| **Actions** | Boutons d'action |

#### Fonctionnalités

- **Recherche** : par nom, email, téléphone ou numéro de casier
- **Filtres** : par statut (actif/inactif), par agence
- **Tri** : par colonne (cliquer sur l'en-tête)
- **Pagination** : navigation entre les pages

#### Actions disponibles

| Action | Description |
|--------|-------------|
| **Voir** | Fiche complète du client |
| **Modifier** | Éditer les informations |
| **Activer/Désactiver** | Changer le statut du compte |
| **Supprimer** | Supprimer le client (si aucune expédition associée) |

---

### Ajouter un client

**URL :** `customers_add.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/customers/customers_add.php`

#### Champs du formulaire

##### Informations personnelles

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Prénom** | Texte | ✅ | Prénom du client |
| **Nom** | Texte | ✅ | Nom de famille |
| **Email** | Email | ✅ | Adresse email (unique, sert de login) |
| **Nom d'utilisateur** | Texte | ✅ | Identifiant de connexion (min. 4 caractères, unique) |
| **Mot de passe** | Mot de passe | ✅ | Mot de passe du compte |
| **Confirmer le mot de passe** | Mot de passe | ✅ | Vérification |
| **Téléphone** | Téléphone | ✅ | Numéro avec indicatif international |
| **Numéro de document** | Texte | Optionnel | CNI, passeport ou autre pièce d'identité |

##### Informations de rattachement

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Agence** | Liste déroulante | Optionnel | Agence de rattachement du client |
| **Bureau** | Liste déroulante | Optionnel | Bureau de rattachement |

##### Adresse

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Adresse** | Texte | Optionnel | Adresse postale |
| **Ville** | Texte | Optionnel | Ville |
| **État/Région** | Texte | Optionnel | État ou région |
| **Pays** | Liste déroulante | Optionnel | Pays |
| **Code postal** | Texte | Optionnel | Code postal |

##### Paramètres du compte

| Champ | Type | Description |
|-------|------|-------------|
| **Actif** | Oui/Non | Si le compte est immédiatement actif |
| **Avatar** | Upload image | Photo de profil du client |

#### Procédure

1. Accédez à **Clients > Ajouter un client**
2. Remplissez les informations personnelles (nom, email, téléphone)
3. Créez un **nom d'utilisateur** et un **mot de passe** pour le client
4. Sélectionnez l'**agence** de rattachement (si applicable)
5. Renseignez l'**adresse** du client
6. Choisissez si le compte est **actif** immédiatement
7. Cliquez sur **Enregistrer**
8. Un **casier virtuel** est automatiquement créé avec un numéro unique
9. Le client peut maintenant se connecter avec ses identifiants

#### Validations

- L'**email** doit être unique (non utilisé par un autre compte)
- Le **nom d'utilisateur** doit être unique et avoir au minimum 4 caractères
- Le **numéro de document** est vérifié pour unicité (s'il est renseigné)
- Le **mot de passe** est haché avec bcrypt avant stockage

---

### Fiche client

**URL :** `customers_view.php?view={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

La fiche client affiche toutes les informations du client ainsi que ses statistiques :

#### Informations affichées

1. **Profil** — photo, nom, email, téléphone, date d'inscription
2. **Casier virtuel** — numéro de casier et adresse du dépôt
3. **Statistiques** :
   - Nombre total de packages
   - Nombre total d'expéditions
   - Nombre total de collectes
   - Montant total facturé
   - Montant total payé
   - Solde restant
4. **Historique** — dernières activités (packages, expéditions, paiements)

---

### Modifier un client

**URL :** `customers_edit.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Formulaire identique à l'ajout, pré-rempli avec les données existantes. Le mot de passe peut être laissé vide s'il ne doit pas être modifié.

---

### Profil client (côté client)

**URL :** `customers_profile_edit.php?user={id}`  
**Accès :** 🔵 Client

Le client peut modifier lui-même son profil :

- Modifier ses informations personnelles (nom, prénom, téléphone)
- Changer son mot de passe
- Mettre à jour son adresse
- Changer sa photo de profil (avatar)

> **Restriction :** Le client ne peut pas modifier son email ni son nom d'utilisateur (contacter un administrateur pour cela).

---

## 9.2 Gestion des destinataires

### Concept

Un **destinataire** est un contact de livraison associé à un client. Un client peut avoir plusieurs destinataires (ex: sa maison, son bureau, un proche, etc.).

Les destinataires sont utilisés lors de la création d'expéditions courrier pour renseigner rapidement l'adresse de livraison.

### Liste des destinataires (Admin)

**URL :** `recipients_admin_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/recipients/recipients_admin_list.php`

Affiche **tous** les destinataires de **tous** les clients.

| Colonne | Description |
|---------|-------------|
| **Nom** | Nom du destinataire |
| **Email** | Email du destinataire |
| **Téléphone** | Numéro de téléphone |
| **Client associé** | Nom du client propriétaire |
| **Adresse** | Adresse de livraison |
| **Actions** | Modifier, Supprimer |

### Liste des destinataires (Client)

**URL :** `recipients_list.php`  
**Accès :** 🔵 Client  
**Vue :** `views/recipients/recipients_list.php`

Le client ne voit que **ses propres** destinataires. Il peut :
- Ajouter de nouveaux destinataires
- Modifier les destinataires existants
- Supprimer des destinataires

### Ajouter un destinataire

**URL :** `recipients_add.php`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client  
**Vue :** `views/recipients/recipients_add.php`

#### Champs du formulaire

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Prénom** | Texte | ✅ | Prénom du destinataire |
| **Nom** | Texte | ✅ | Nom de famille |
| **Email** | Email | ✅ | Email (vérifié pour unicité dans la table destinataires) |
| **Téléphone** | Téléphone | ✅ | Numéro avec indicatif |
| **Adresse** | Texte | ✅ | Adresse complète de livraison |
| **Ville** | Texte | ✅ | Ville |
| **État/Région** | Texte | Optionnel | État ou région |
| **Pays** | Liste déroulante | ✅ | Pays |
| **Code postal** | Texte | Optionnel | Code postal |

#### Procédure

1. Accédez à **Profil > Mes destinataires > Ajouter** (client) ou **Clients > Destinataires > Ajouter** (admin)
2. Remplissez les informations du destinataire
3. L'email est vérifié pour s'assurer qu'il n'est pas déjà utilisé par un autre destinataire
4. Cliquez sur **Enregistrer**

### Modifier un destinataire

**URL :** `recipients_edit.php?edit={id}`  
**Accès :** 🔴 Admin, 🟠 Employé, 🔵 Client

Formulaire pré-rempli pour éditer les informations du destinataire.

---

## 9.3 Adresses des clients et destinataires

### Adresses multiples

Un client et chaque destinataire peuvent avoir **plusieurs adresses** enregistrées. Cela permet de sélectionner rapidement l'adresse correcte lors de la création d'une expédition.

### Ajouter une adresse (dans le formulaire d'expédition)

Lors de la création d'une expédition courrier, deux fenêtres modales permettent d'ajouter des adresses à la volée :

#### Pour l'expéditeur

**Modale :** `modal_add_addresses_user.php`

| Champ | Description |
|-------|-------------|
| **Adresse** | Rue et numéro |
| **Ville** | Ville |
| **État** | État ou région |
| **Pays** | Pays |
| **Code postal** | Code postal |

#### Pour le destinataire

**Modale :** `modal_add_addresses_recipient.php`

Mêmes champs que pour l'expéditeur.

### Ajouter un client dans le formulaire d'expédition

**Modale :** `modal_add_user_shipment.php`

Si l'expéditeur n'existe pas encore, cette modale permet de créer un nouveau client directement depuis le formulaire d'expédition :

| Champ | Description |
|-------|-------------|
| **Prénom** | Prénom |
| **Nom** | Nom |
| **Email** | Email (vérifié pour unicité) |
| **Téléphone** | Numéro |
| **Adresse** | Adresse complète |
| **Pays** | Pays |

### Ajouter un destinataire dans le formulaire d'expédition

**Modale :** `modal_add_recipient_shipment.php`

Même principe pour créer un nouveau destinataire à la volée.

---

## 9.4 Casier virtuel (Virtual Locker)

### Attribution

- Chaque client inscrit reçoit **automatiquement** un numéro de casier virtuel unique
- Le numéro est généré à partir du **préfixe** (`prefix_locker`) et du **compteur séquentiel** (`digit_random_locker`)
- Exemple : `LOC00042`

### Utilisation

1. Le client communique son numéro de casier au vendeur en ligne
2. Le vendeur livre le colis à l'adresse du dépôt MonResPro + numéro de casier
3. À la réception, l'opérateur identifie le client grâce au numéro de casier
4. Le colis est enregistré comme package client et le client est notifié

### Configuration

La configuration du casier virtuel se fait dans **Configuration > Paramètres généraux** :

| Paramètre | Description |
|-----------|-------------|
| `prefix_locker` | Préfixe du numéro de casier (ex: `LOC`) |
| `digit_random_locker` | Nombre de chiffres (ex: 5 → `00042`) |
| `code_number_locker` | Compteur actuel |
| `locker_address` | Adresse physique du dépôt |

---

## 9.5 Bonnes pratiques

### Pour la gestion des clients

1. **Vérifiez les doublons** avant de créer un nouveau client — recherchez d'abord par email ou téléphone
2. **Complétez les profils** — plus les informations sont complètes, plus les formulaires d'expédition seront rapides
3. **Désactivez plutôt que supprimer** — désactivez les comptes inactifs au lieu de les supprimer pour conserver l'historique
4. **Rattachez à l'agence** — associez chaque client à son agence pour les rapports par agence

### Pour les destinataires

1. **Adresses précises** — incluez tous les détails (numéro de rue, étage, code d'accès)
2. **Téléphone valide** — le chauffeur doit pouvoir contacter le destinataire
3. **Évitez les doublons** — vérifiez si le destinataire existe déjà avant d'en créer un nouveau
