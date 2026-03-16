# Chapitre 13 — Notifications & Communications

> MonResPro dispose de trois canaux de notification pour informer les clients à chaque étape du processus : **Email SMTP**, **WhatsApp API** et **SMS Twilio**. Ce chapitre couvre la configuration de chaque canal et la gestion des modèles de notification.

---

## 13.1 Vue d'ensemble

### Événements déclencheurs

Les notifications sont envoyées automatiquement lors des événements suivants :

| Événement | Description | Canaux |
|-----------|-------------|--------|
| **Création d'expédition** | Nouvelle expédition créée | Email, WhatsApp, SMS |
| **Mise à jour de statut** | Changement de statut d'un envoi | Email, WhatsApp, SMS |
| **Livraison confirmée** | Colis marqué comme livré | Email, WhatsApp, SMS |
| **Création de package** | Nouveau package client enregistré | Email, WhatsApp, SMS |
| **Création de collecte** | Nouvelle collecte planifiée | Email, WhatsApp, SMS |
| **Acceptation de collecte** | Collecte acceptée par l'opérateur | Email, WhatsApp, SMS |
| **Création de pré-alerte** | Pré-alerte client enregistrée | Email |
| **Inscription client** | Nouveau compte créé | Email |
| **Paiement reçu** | Paiement validé | Email |
| **Paiement rejeté** | Preuve de paiement rejetée | Email |

### Priorité des canaux

L'application vérifie la configuration de chaque canal dans l'ordre suivant :
1. **Email** — si le SMTP est configuré et le modèle existe
2. **WhatsApp** — si l'API WhatsApp est active et le numéro du client est renseigné
3. **SMS** — si Twilio est configuré et le numéro du client est renseigné

Chaque canal est **indépendant** : vous pouvez activer un, deux ou les trois canaux simultanément.

---

## 13.2 Configuration Email SMTP

**URL :** `tools.php?list=config_email`  
**Accès :** 🔴 Admin uniquement  
**Vue :** `views/tools/config_email.php`

### Paramètres SMTP

| Paramètre | Description | Exemple |
|-----------|-------------|---------|
| **Activer l'envoi d'emails** | Active/désactive les emails | Oui / Non |
| **Hôte SMTP** | Serveur de messagerie | `smtp.gmail.com` |
| **Port SMTP** | Port du serveur | `587` (TLS) ou `465` (SSL) |
| **Chiffrement** | Type de sécurité | `tls` ou `ssl` |
| **Nom d'utilisateur SMTP** | Identifiant de connexion | `contact@monrespro.com` |
| **Mot de passe SMTP** | Mot de passe ou App Password | `********` |
| **Email expéditeur** | Adresse « De » des emails | `noreply@monrespro.com` |
| **Nom expéditeur** | Nom affiché comme expéditeur | `MonResPro Logistics` |

### Procédure de configuration

1. Accédez à **Paramètres > Email SMTP**
2. Activez l'envoi d'emails
3. Renseignez les paramètres de votre serveur SMTP :
   - Pour **Gmail** : hôte `smtp.gmail.com`, port `587`, chiffrement `tls`
   - Pour **Outlook** : hôte `smtp.office365.com`, port `587`, chiffrement `tls`
   - Pour un **serveur dédié** : paramètres fournis par votre hébergeur
4. Saisissez les identifiants de connexion
5. Définissez l'email et le nom de l'expéditeur
6. Cliquez sur **Enregistrer**
7. **Testez** l'envoi avec le bouton « Envoyer un email de test »

### Résolution de problèmes

| Problème | Solution |
|----------|---------|
| **Emails non envoyés** | Vérifiez les identifiants SMTP et le port |
| **Emails en spam** | Configurez SPF, DKIM et DMARC sur votre domaine |
| **Gmail bloqué** | Utilisez un « App Password » au lieu du mot de passe principal |
| **Timeout** | Vérifiez que le port n'est pas bloqué par le pare-feu du serveur |

### Bibliothèque utilisée

MonResPro utilise **PHPMailer** (`helpers/phpmailer/`) pour l'envoi d'emails.

---

## 13.3 Configuration WhatsApp

**URL :** `config_whatsapp.php`  
**Accès :** 🔴 Admin uniquement  
**Vue :** `views/tools/config_whatsapp.php`

### Prérequis

- Un compte **WhatsApp Business API** ou un fournisseur de service WhatsApp
- Un **numéro de téléphone** vérifié pour l'envoi
- Une **clé API** du fournisseur

### Paramètres

| Paramètre | Description |
|-----------|-------------|
| **Activer WhatsApp** | Active/désactive les notifications WhatsApp |
| **URL de l'API** | Endpoint de l'API WhatsApp |
| **Clé API** | Token d'authentification |
| **Numéro expéditeur** | Numéro WhatsApp de l'entreprise |
| **Instance ID** | Identifiant de l'instance (selon le fournisseur) |

### Activation

**URL :** `activate_whatsapp.php`  
**Accès :** 🔴 Admin

Page dédiée pour activer/désactiver le service WhatsApp et vérifier la connexion.

### Procédure

1. Accédez à **Paramètres > WhatsApp**
2. Activez le service WhatsApp
3. Renseignez l'**URL de l'API** de votre fournisseur
4. Saisissez votre **clé API**
5. Indiquez le **numéro** WhatsApp de l'entreprise
6. Cliquez sur **Enregistrer**
7. **Testez** l'envoi d'un message test

---

## 13.4 Configuration SMS (Twilio)

**URL :** `config_sms.php`  
**Accès :** 🔴 Admin uniquement  
**Vue :** `views/tools/config_sms.php`

### Prérequis

- Un compte **Twilio** (twilio.com)
- Un **numéro de téléphone Twilio** (acheté sur la plateforme)
- Les **identifiants API** (Account SID, Auth Token)

### Paramètres

| Paramètre | Description |
|-----------|-------------|
| **Activer SMS** | Active/désactive les notifications SMS |
| **Account SID** | Identifiant du compte Twilio |
| **Auth Token** | Token d'authentification Twilio |
| **Numéro Twilio** | Numéro expéditeur (format international: +XX...) |

### Configuration Twilio

**URL :** `config_twilio.php`  
**Accès :** 🔴 Admin

Page de configuration spécifique pour les paramètres Twilio avancés.

### Activation

**URL :** `activate_sms.php`  
**Accès :** 🔴 Admin

Page dédiée pour activer/désactiver le service SMS.

### Procédure

1. Créez un compte sur **twilio.com** (version d'essai gratuite disponible)
2. Obtenez un **numéro de téléphone** Twilio
3. Récupérez votre **Account SID** et **Auth Token** depuis le dashboard Twilio
4. Accédez à **Paramètres > SMS Twilio** dans MonResPro
5. Activez le service
6. Renseignez les identifiants
7. Cliquez sur **Enregistrer**
8. **Testez** l'envoi d'un SMS de test

### Coûts

Les SMS sont facturés par Twilio selon le pays de destination. Consultez la grille tarifaire sur twilio.com/sms/pricing.

### Bibliothèque utilisée

MonResPro utilise le SDK ClickSend ou Twilio via Composer (`helpers/vendor/`).

---

## 13.5 Modèles de notification

### Modèles Email

**URL :** `templates_email.php`  
**Accès :** 🔴 Admin  
**Vue :** `views/tools/templates_email.php`

Les modèles d'email définissent le **contenu** et la **mise en page** des emails envoyés :

#### Modèles disponibles

| Modèle | Événement déclencheur |
|--------|----------------------|
| **Création d'expédition** | Quand une nouvelle expédition est créée |
| **Mise à jour de statut** | Quand le statut d'un envoi change |
| **Livraison** | Quand un envoi est marqué comme livré |
| **Nouveau package** | Quand un package client est enregistré |
| **Nouvelle collecte** | Quand une collecte est planifiée |
| **Bienvenue** | Quand un nouveau client s'inscrit |
| **Mot de passe oublié** | Quand un utilisateur demande la réinitialisation |
| **Facture** | Quand une facture est envoyée |

#### Variables disponibles dans les modèles

Les modèles utilisent des **variables de remplacement** qui sont automatiquement remplacées par les données réelles lors de l'envoi :

| Variable | Description |
|----------|-------------|
| `{tracking}` | Numéro de suivi |
| `{client_name}` | Nom complet du client |
| `{client_email}` | Email du client |
| `{status}` | Statut actuel |
| `{origin}` | Ville/pays d'origine |
| `{destination}` | Ville/pays de destination |
| `{date}` | Date de l'événement |
| `{amount}` | Montant total |
| `{company_name}` | Nom de l'entreprise |
| `{company_phone}` | Téléphone de l'entreprise |
| `{company_email}` | Email de l'entreprise |
| `{tracking_url}` | Lien de suivi en ligne |

#### Éditeur de modèles

- Éditeur **WYSIWYG** (Summernote) pour le formatage HTML
- Mise en forme riche : gras, italique, liens, images, tableaux
- **Prévisualisation** avant envoi
- Les variables sont saisies entre accolades `{variable}`

### Modèles WhatsApp

**URL :** `templates_whatsapp.php`  
**Accès :** 🔴 Admin  
**Vue :** `views/tools/templates_whatsapp.php`

Les modèles WhatsApp sont en **texte brut** (pas de HTML) avec les mêmes variables de remplacement.

#### Spécificités WhatsApp

- Texte brut uniquement (pas de mise en forme HTML)
- Limité à certains caractères spéciaux
- Les liens sont automatiquement rendus cliquables
- Émojis supportés
- Longueur maximale selon les limites de WhatsApp

### Modèles SMS

**URL :** `templates_sms.php`  
**Accès :** 🔴 Admin  
**Vue :** `views/tools/templates_sms.php`

Les modèles SMS sont en **texte brut** avec les mêmes variables de remplacement.

#### Spécificités SMS

- Texte brut uniquement
- **Limite de 160 caractères** par SMS (au-delà, le message est envoyé en plusieurs parties)
- Évitez les caractères spéciaux (accents, émojis) qui augmentent la taille du message
- Soyez concis : incluez le tracking et le statut essentiel

### Modèles par défaut WhatsApp

**URL :** `templates_default.php`  
**Accès :** 🔴 Admin

Modèles WhatsApp prédéfinis fournis avec l'application, utilisables comme base de travail.

---

## 13.6 Notifications dans l'application

### Système de notifications internes

En plus des canaux externes (email, WhatsApp, SMS), MonResPro dispose d'un système de **notifications internes** visible dans la sidebar :

#### Icône de notification (cloche)

- Affiche le **nombre de notifications non lues** via un badge rouge
- Cliquer ouvre un **panneau déroulant** avec les dernières notifications
- Chaque notification affiche : icône, message, date relative (« il y a 5 min »)
- Lien « Voir toutes » pour accéder à la liste complète

#### Liste complète des notifications

**URL :** `notifications_list.php`  
**Accès :** Tous les rôles  
**Vue :** `views/notifications_list.php`

Affiche toutes les notifications de l'utilisateur connecté avec :
- Message de la notification
- Date et heure
- Type (nouvelle expédition, changement de statut, paiement, etc.)
- Statut lu/non lu
- Action (lien vers l'élément concerné)

### Table de la base de données

Table : `cdb_notifications`

| Champ | Description |
|-------|-------------|
| `id` | Identifiant unique |
| `user_id` | Utilisateur destinataire |
| `message` | Contenu de la notification |
| `type` | Type d'événement |
| `reference_id` | ID de l'objet concerné |
| `is_read` | Lu (1) / Non lu (0) |
| `created_at` | Date de création |

---

## 13.7 Bonnes pratiques

### Email

1. **Configurez SPF/DKIM/DMARC** sur votre domaine pour éviter les spams
2. **Personnalisez les modèles** avec le logo et les couleurs de l'entreprise
3. **Testez chaque modèle** après modification
4. **Incluez le tracking** et un lien de suivi dans chaque email
5. **Utilisez un email professionnel** (pas de Gmail/Yahoo) comme expéditeur

### WhatsApp

1. **Respectez les politiques** de WhatsApp Business API
2. **Soyez concis** — les messages WhatsApp doivent être courts et informatifs
3. **Incluez le numéro de suivi** en premier dans le message
4. **Ne spammez pas** — envoyez uniquement les notifications essentielles

### SMS

1. **Optimisez la longueur** — restez sous 160 caractères quand possible
2. **Évitez les accents** — ils augmentent la taille du message
3. **Incluez l'essentiel** — tracking + statut + lien court
4. **Surveillez les coûts** — les SMS sont facturés à l'unité

### Général

1. **Ne sur-notifiez pas** — trop de notifications agacent les clients
2. **Rendez les notifications cohérentes** — même ton et format sur tous les canaux
3. **Incluez toujours** : nom de l'entreprise, numéro de suivi, action requise (si applicable)
4. **Testez régulièrement** — vérifiez que les notifications sont bien reçues
