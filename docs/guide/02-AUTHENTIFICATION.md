# Chapitre 2 — Authentification

> Ce chapitre couvre la connexion, l'inscription, la récupération de mot de passe et la sécurité des sessions.

---

## 2.1 Page de connexion

**URL :** `login.php`  
**Accès :** Public (non authentifié)

### Description

La page de connexion est le point d'entrée principal de l'application. Elle présente un formulaire moderne avec le logo MonResPro et une illustration de logistique.

### Champs du formulaire

| Champ | Type | Obligatoire | Description |
|-------|------|-------------|-------------|
| **Nom d'utilisateur / Email** | Texte | ✅ | Le nom d'utilisateur ou l'adresse email du compte |
| **Mot de passe** | Mot de passe | ✅ | Le mot de passe du compte |

### Procédure de connexion

1. Accédez à l'URL de l'application (ex: `https://logistics.monrespro.com/login.php`)
2. Saisissez votre **nom d'utilisateur** ou **adresse email**
3. Saisissez votre **mot de passe**
4. Cliquez sur le bouton **Se connecter**
5. En cas de succès, vous êtes redirigé vers le **tableau de bord** correspondant à votre rôle
6. En cas d'échec, un message d'erreur s'affiche :
   - « Les identifiants ne correspondent pas à la base de données » — identifiants incorrects
   - « Votre compte n'est pas activé » — le compte existe mais est désactivé

### Fonctionnalités supplémentaires

- **Lien « Mot de passe oublié ? »** — redirige vers la page de récupération
- **Lien « Créer un compte »** — redirige vers la page d'inscription (si l'inscription publique est activée)
- **Mode sombre/clair** — basculement via le bouton en haut à droite
- **Redirection automatique** — si vous êtes déjà connecté, vous êtes automatiquement redirigé vers `index.php`

### Sécurité

- Les mots de passe sont hachés avec **`password_hash()`** (bcrypt)
- La vérification utilise **`password_verify()`**
- La connexion peut se faire par **nom d'utilisateur** ou **email**
- L'adresse IP et la date de dernière connexion sont enregistrées

---

## 2.2 Inscription

**URL :** `sign-up.php` → `views/auth/sign-up.php`  
**Accès :** Public (si l'inscription est autorisée dans les paramètres)

### Prérequis

L'inscription publique doit être activée dans **Configuration > Paramètres généraux** :
- Le paramètre `reg_allowed` doit être activé

### Champs du formulaire

| Champ | Type | Obligatoire | Validation |
|-------|------|-------------|------------|
| **Prénom** | Texte | ✅ | Minimum 2 caractères |
| **Nom** | Texte | ✅ | Minimum 2 caractères |
| **Email** | Email | ✅ | Format email valide, unicité vérifiée |
| **Nom d'utilisateur** | Texte | ✅ | Minimum 4 caractères, unicité vérifiée |
| **Mot de passe** | Mot de passe | ✅ | Minimum requis selon configuration |
| **Confirmer le mot de passe** | Mot de passe | ✅ | Doit correspondre au mot de passe |
| **Téléphone** | Téléphone | ✅ | Format international |
| **Numéro de document** | Texte | Optionnel | Numéro d'identité ou passeport |

### Procédure d'inscription

1. Accédez à `sign-up.php`
2. Remplissez tous les champs obligatoires
3. Cliquez sur **Créer un compte**
4. Selon la configuration :
   - **Vérification automatique activée** (`auto_verify`) : le compte est immédiatement actif
   - **Vérification manuelle** (`reg_verify`) : le compte est créé mais inactif — un administrateur doit l'activer
5. Un **casier virtuel** est automatiquement créé pour le nouveau client avec un numéro unique (préfixe + numéro séquentiel)

### Après l'inscription

- Le client reçoit un **numéro de casier virtuel** unique (ex: `LOC00001`)
- Ce numéro sert d'adresse de réception pour les achats en ligne
- L'administrateur est notifié de la nouvelle inscription (si `notify_admin` est activé)

---

## 2.3 Récupération de mot de passe

**URL :** `forgot-password.php` → `views/auth/forgot-password.php`  
**Accès :** Public

### Procédure

1. Depuis la page de connexion, cliquez sur **« Mot de passe oublié ? »**
2. Saisissez votre **adresse email** enregistrée
3. Cliquez sur **Envoyer le lien de réinitialisation**
4. Un email contenant les instructions de réinitialisation est envoyé
5. Suivez le lien dans l'email pour définir un nouveau mot de passe

### Prérequis

- L'email SMTP doit être correctement configuré dans **Configuration > Email SMTP**
- L'adresse email doit correspondre à un compte existant

---

## 2.4 Gestion des sessions

### Durée de session

- La session a une durée d'inactivité maximale de **1 440 secondes** (24 minutes) pour les clients (niveau 1)
- Après cette période d'inactivité, le client est automatiquement déconnecté
- Les administrateurs et employés ne sont pas soumis à cette limite d'inactivité automatique

### Données de session

Les informations suivantes sont stockées dans la session PHP :

| Variable | Description |
|----------|-------------|
| `$_SESSION['userid']` | ID unique de l'utilisateur |
| `$_SESSION['username']` | Nom d'utilisateur |
| `$_SESSION['email']` | Adresse email |
| `$_SESSION['name']` | Nom complet (prénom + nom) |
| `$_SESSION['userlevel']` | Niveau d'accès (1, 2, 3, 9) |
| `$_SESSION['last']` | Date de dernière connexion |
| `$_SESSION['name_off']` | Nom du bureau/agence |
| `$_SESSION['LAST_ACTIVITY']` | Timestamp de la dernière activité |

### Déconnexion

**URL :** `logout.php`

La déconnexion :
1. Efface toutes les variables de session
2. Supprime le cookie de session
3. Détruit la session PHP
4. Vide le cache navigateur (en-têtes HTTP)
5. Ferme la connexion à la base de données
6. Redirige vers la page de connexion

### Protection des pages

Chaque page protégée vérifie l'authentification au chargement :

- **Pages Admin/Employé** : vérifient `$user->cdp_is_Admin()` (niveaux 9 et 2) — redirigent vers `login.php` si non autorisé
- **Pages Chauffeur** : vérifient `$user->userlevel === 3` en plus du statut Admin
- **Pages Client** : vérifient que l'utilisateur est connecté (pas de niveau spécifique requis pour les pages partagées)

---

## 2.5 Bonnes pratiques de sécurité

### Pour les administrateurs

1. **Changez le mot de passe par défaut** immédiatement après l'installation
2. **Désactivez l'inscription publique** (`reg_allowed`) si vous n'en avez pas besoin
3. **Activez la vérification manuelle** (`reg_verify`) pour contrôler les nouveaux comptes
4. **Vérifiez régulièrement** les comptes inactifs dans la liste des utilisateurs
5. **Désactivez les comptes** des employés/chauffeurs qui ne travaillent plus

### Pour les utilisateurs

1. Utilisez un **mot de passe fort** (minimum 8 caractères, mélange de lettres, chiffres et symboles)
2. Ne partagez **jamais** vos identifiants
3. **Déconnectez-vous** après chaque session, surtout sur un ordinateur partagé
4. Signalez immédiatement tout **accès suspect** à l'administrateur
