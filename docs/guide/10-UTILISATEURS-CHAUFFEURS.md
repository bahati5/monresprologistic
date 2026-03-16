# Chapitre 10 — Utilisateurs & Chauffeurs

> Ce module couvre la gestion des comptes internes : administrateurs, employés et chauffeurs. Seuls les administrateurs ont accès à la gestion complète des utilisateurs.

---

## 10.1 Gestion des utilisateurs (Admin/Employés)

### Liste des utilisateurs

**URL :** `users_list.php`  
**Accès :** 🔴 Admin uniquement  
**Vue :** `views/tools/users/users_list.php`

#### Tableau de données

| Colonne | Description |
|---------|-------------|
| **ID** | Identifiant unique |
| **Nom complet** | Prénom + Nom |
| **Email** | Adresse email |
| **Nom d'utilisateur** | Identifiant de connexion |
| **Rôle** | Admin / Employé / Chauffeur |
| **Agence** | Agence de rattachement |
| **Statut** | Actif / Inactif |
| **Dernière connexion** | Date et heure de la dernière connexion |
| **Actions** | Modifier, Supprimer |

#### Fonctionnalités

- **Recherche** : par nom, email, nom d'utilisateur
- **Filtres** : par rôle, par statut, par agence
- **Tri** : par colonne
- **Pagination** : configurable dans les paramètres (`user_perpage`)

---

### Ajouter un utilisateur

**URL :** `users_add.php`  
**Accès :** 🔴 Admin uniquement  
**Vue :** `views/tools/users/users_add.php`

#### Champs du formulaire

##### Informations personnelles

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Prénom** | Texte | ✅ | Prénom de l'utilisateur |
| **Nom** | Texte | ✅ | Nom de famille |
| **Email** | Email | ✅ | Adresse email unique |
| **Nom d'utilisateur** | Texte | ✅ | Identifiant unique (min. 4 caractères) |
| **Mot de passe** | Mot de passe | ✅ | Mot de passe sécurisé |
| **Confirmer** | Mot de passe | ✅ | Vérification du mot de passe |
| **Téléphone** | Téléphone | ✅ | Numéro avec indicatif |

##### Rôle et permissions

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Niveau d'accès** | Liste déroulante | ✅ | Administrateur (9), Employé (2), Chauffeur (3) |
| **Agence** | Liste déroulante | Optionnel | Agence de rattachement |
| **Bureau** | Liste déroulante | Optionnel | Bureau de rattachement |
| **Actif** | Oui/Non | ✅ | Activer le compte immédiatement |

##### Photo de profil

| Champ | Type | Description |
|-------|------|-------------|
| **Avatar** | Upload image | Photo de profil (formats acceptés : JPG, PNG, GIF) |

#### Rôles disponibles

| Niveau | Rôle | Permissions |
|--------|------|------------|
| **9** | Administrateur | Accès total, configuration système, gestion utilisateurs |
| **2** | Employé | Opérations quotidiennes, pas de config système |
| **3** | Chauffeur | Livraisons et collectes assignées |

> **Note :** Les clients (niveau 1) ne sont pas créés ici. Ils sont gérés dans le module Clients (Chapitre 9) ou s'inscrivent eux-mêmes via la page d'inscription.

#### Procédure

1. Accédez à **Utilisateurs > Ajouter un utilisateur**
2. Remplissez les informations personnelles
3. Sélectionnez le **niveau d'accès** (rôle)
4. Rattachez l'utilisateur à une **agence** si nécessaire
5. Activez le compte
6. Cliquez sur **Enregistrer**
7. L'utilisateur peut immédiatement se connecter

---

### Modifier un utilisateur

**URL :** `users_edit.php?edit={id}`  
**Accès :** 🔴 Admin uniquement

- Tous les champs sont modifiables
- Le mot de passe peut être laissé vide pour ne pas le modifier
- Le changement de rôle prend effet immédiatement (à la prochaine connexion ou rafraîchissement de page)
- La désactivation du compte empêche l'utilisateur de se connecter

---

## 10.2 Gestion des chauffeurs

### Liste des chauffeurs

**URL :** `drivers_list.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/drivers/drivers_list.php`

#### Tableau

| Colonne | Description |
|---------|-------------|
| **ID** | Identifiant |
| **Nom complet** | Prénom + Nom |
| **Email** | Email |
| **Téléphone** | Numéro de téléphone |
| **Agence** | Agence de rattachement |
| **Statut** | Actif / Inactif |
| **Dernière connexion** | Dernière activité |
| **Actions** | Modifier |

#### Fonctionnalités spécifiques

- La liste affiche uniquement les utilisateurs de niveau 3 (chauffeur)
- Affichage des statistiques par chauffeur (nombre de livraisons, collectes, etc.)

---

### Ajouter un chauffeur

**URL :** `drivers_add.php`  
**Accès :** 🔴 Admin, 🟠 Employé  
**Vue :** `views/drivers/drivers_add.php`

Le formulaire d'ajout de chauffeur est similaire à celui des utilisateurs avec des champs supplémentaires spécifiques :

#### Champs supplémentaires chauffeur

| Champ | Type | Description |
|-------|------|-------------|
| **Numéro de permis** | Texte | Numéro de permis de conduire |
| **Type de véhicule** | Texte | Description du véhicule |
| **Plaque d'immatriculation** | Texte | Numéro de plaque |
| **Photo du permis** | Upload | Image du permis de conduire |
| **Documents** | Upload multiple | Autres documents (assurance véhicule, etc.) |

> **Note :** Le niveau d'accès est automatiquement défini à 3 (Chauffeur) lors de la création via ce formulaire.

---

### Modifier un chauffeur

**URL :** `drivers_edit.php?edit={id}` ou `drivers_edit.php?user={id}`  
**Accès :** 🔴 Admin, 🟠 Employé, 🟢 Chauffeur (son propre profil)

#### Profil chauffeur (auto-édition)

Le chauffeur peut modifier lui-même certaines informations :
- Informations personnelles (nom, prénom, téléphone)
- Mot de passe
- Photo de profil
- Informations du véhicule

Il ne peut **pas** modifier :
- Son email (contacter un administrateur)
- Son nom d'utilisateur
- Son rôle
- Son agence de rattachement

---

## 10.3 Assignation des chauffeurs

### Dans les expéditions

Lors de la création ou modification d'une expédition, le champ **Chauffeur** permet d'assigner un chauffeur pour la livraison :

1. La liste déroulante affiche tous les chauffeurs **actifs** (requête `cdb_users WHERE userlevel=3 AND active=1`)
2. Sélectionnez le chauffeur approprié
3. Le chauffeur est notifié de sa nouvelle assignation

### Dans les collectes

Même fonctionnement :
1. Lors de l'acceptation d'une collecte, assignez un chauffeur
2. Le chauffeur voit la collecte dans son tableau de bord

### Mise à jour en lot

**Modale :** `modal_update_driver.php`

Depuis la liste des expéditions :
1. Sélectionnez plusieurs expéditions
2. Cliquez sur « Assigner chauffeur »
3. Choisissez le chauffeur dans la modale
4. Toutes les expéditions sélectionnées sont assignées au chauffeur

**Modale :** `modal_update_driver_checked.php`

Variante avec case à cocher pour confirmer l'assignation.

---

## 10.4 Fichiers des chauffeurs

**Dossier :** `driver_files/`

Les documents des chauffeurs sont stockés dans ce dossier :
- Photos de permis de conduire
- Photos de licence
- Documents d'assurance véhicule
- Autres documents administratifs

Le nom du fichier est composé d'un timestamp + le nom original du fichier.

---

## 10.5 Sécurité et bonnes pratiques

### Gestion des mots de passe

1. **Imposez des mots de passe forts** — au moins 8 caractères, mélange de lettres/chiffres/symboles
2. **Changez les mots de passe régulièrement** — tous les 3 mois recommandé
3. **Ne réutilisez pas** les mots de passe entre différents comptes

### Gestion des comptes

1. **Désactivez les comptes** des employés/chauffeurs qui quittent l'entreprise
2. **Minimisez les administrateurs** — seuls les responsables doivent avoir le niveau 9
3. **Rattachez à l'agence** — chaque utilisateur doit être lié à une agence pour les rapports
4. **Vérifiez les connexions** — consultez régulièrement les dates de dernière connexion
5. **Sauvegardez** — utilisez la fonction de sauvegarde avant toute modification importante

### Gestion des chauffeurs

1. **Vérifiez les documents** — permis de conduire et assurance valides
2. **Équilibrez les charges** — répartissez les expéditions et collectes équitablement
3. **Suivez les performances** — consultez les rapports par chauffeur
4. **Communiquez** — assurez-vous que les chauffeurs mettent à jour les statuts en temps réel
