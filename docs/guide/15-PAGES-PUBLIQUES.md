# Chapitre 15 — Pages publiques

> MonResPro dispose de plusieurs pages accessibles sans authentification : le suivi en ligne, la page d'accueil, la page « À propos », les services et les pages par pays. Ces pages sont le point de contact principal avec les visiteurs et clients non connectés.

---

## 15.1 Page d'accueil

**URL :** `index.php` (si non connecté, redirige vers `login.php`)  
**Navigation publique :** `header_nav.php`

### Barre de navigation publique

La barre de navigation des pages publiques contient :

| Élément | Lien | Description |
|---------|------|-------------|
| **Logo** | Accueil | Logo MonResPro cliquable |
| **Accueil** | `index.php` | Page d'accueil |
| **Société** | `aboutus.php` | À propos de l'entreprise |
| **Suivi** | `tracking.php` | Suivi d'expédition en ligne |
| **Services** | Section services | Services proposés |
| **Pays** | Liste déroulante | Pays desservis |
| **Connexion** | `login.php` | Bouton de connexion |

---

## 15.2 Suivi en ligne (Tracking)

**URL :** `tracking.php`  
**Accès :** Public (sans authentification)

### Description

La page de suivi permet à **n'importe qui** (client ou non) de suivre un colis en saisissant son numéro de suivi. C'est la fonctionnalité publique la plus importante.

### Utilisation

1. Accédez à `tracking.php` (ou cliquez sur « Suivi » dans la navigation)
2. Saisissez le **numéro de suivi** dans le champ de recherche
3. Cliquez sur **Rechercher** ou appuyez sur Entrée
4. Les résultats s'affichent :

### Résultats du suivi

#### Si le numéro est trouvé

La page affiche :

| Information | Description |
|-------------|-------------|
| **Numéro de suivi** | Le tracking number recherché |
| **Statut actuel** | Badge coloré avec le statut en cours |
| **Expéditeur** | Nom (ou masqué selon la config) |
| **Destinataire** | Nom (ou masqué selon la config) |
| **Origine** | Ville / Pays d'origine |
| **Destination** | Ville / Pays de destination |
| **Date de création** | Date d'enregistrement de l'envoi |
| **Poids** | Poids du colis |

#### Timeline de suivi

L'historique complet du colis est affiché sous forme de **timeline verticale** :

- Chaque étape montre : **date**, **statut**, **localisation**, **commentaire**
- L'étape la plus récente est en haut
- Les statuts utilisent les couleurs configurées dans les paramètres

#### Si le numéro n'est pas trouvé

Un message d'erreur s'affiche : « Aucun envoi trouvé avec ce numéro de suivi. »

### Recherche multi-module

Le système de suivi recherche dans **toutes les tables** :
- `cdb_add_order` — Expéditions courier
- `cdb_customers_packages` — Packages clients
- `cdb_consolidate` — Envois consolidés
- `cdb_consolidate_packages` — Packages consolidés

Le premier résultat trouvé est affiché.

### Lien de suivi partageable

Le lien de suivi peut être partagé directement :
```
https://logistics.monrespro.com/tracking.php?tracking=AWB00001
```

Ce lien est utilisé dans les notifications email, WhatsApp et SMS pour permettre au client de suivre son colis en un clic.

---

## 15.3 Page « À propos »

**URL :** `aboutus.php`  
**Accès :** Public

### Contenu

La page « À propos » présente l'entreprise :

- **Nom de l'entreprise** — tiré de la configuration (`site_name`)
- **Description** — texte de présentation de l'entreprise
- **Services** — liste des services proposés
- **Équipe** — présentation de l'équipe (si configuré)
- **Contact** — coordonnées (adresse, téléphone, email)
- **Carte** — emplacement géographique (si configuré)

Le contenu est partiellement dynamique (nom, coordonnées) et partiellement statique (texte de présentation).

---

## 15.4 Pages par pays

MonResPro dispose de pages dédiées par pays desservi :

| Page | URL | Pays |
|------|-----|------|
| **Cameroun** | `livraison-cameroun.php` | Cameroun |
| **Congo-Brazzaville** | `livraison-congo-brazzaville.php` | Congo-Brazzaville |
| **Gabon** | `livraison-gabon.php` | Gabon |
| **Madagascar** | `livraison-madagascar.php` | Madagascar |
| **RD Congo** | `livraison-rdcongo.php` | République Démocratique du Congo |
| **Sénégal** | `livraison-senegal.php` | Sénégal |

### Contenu type d'une page pays

Chaque page pays présente :

1. **En-tête** — bannière avec le drapeau ou une image du pays
2. **Services disponibles** — services proposés vers/depuis ce pays
3. **Tarifs indicatifs** — grille tarifaire simplifiée
4. **Délais de livraison** — délais estimés par mode d'expédition
5. **Zones desservies** — villes et régions couvertes
6. **Points de collecte** — adresses des agences dans le pays
7. **Procédure** — étapes pour envoyer ou recevoir un colis
8. **Contact local** — coordonnées de l'agence locale

### Personnalisation

Ces pages sont des fichiers PHP statiques qui peuvent être personnalisés directement en modifiant le code HTML/PHP. Les informations dynamiques (nom de l'entreprise, téléphone, etc.) sont tirées de la configuration.

---

## 15.5 Calculateur de tarifs

**URL :** `calculator.php`  
**Accès :** Public (si activé)

### Description

Le calculateur de tarifs permet aux visiteurs d'estimer le coût d'un envoi sans être connecté :

1. Sélectionnez le **pays d'origine**
2. Sélectionnez le **pays de destination**
3. Saisissez le **poids** du colis
4. Optionnellement, saisissez les **dimensions** (pour le poids volumétrique)
5. Cliquez sur **Calculer**
6. Le tarif estimé s'affiche

Le calcul utilise la même grille tarifaire que le système interne (`cdb_tariffs`).

### Styles

Le calculateur utilise une feuille de style dédiée : `assets/css/calculator.css`.

---

## 15.6 Page de téléchargement

**URL :** `download.php`  
**Accès :** Authentifié

Permet aux utilisateurs de télécharger des fichiers associés à leurs expéditions :
- Documents joints aux colis
- Factures PDF
- Preuves de paiement

Le fichier est identifié par son chemin et vérifié pour l'autorisation avant téléchargement.

---

## 15.7 Template des pages publiques

### Structure

Les pages publiques utilisent un template distinct des pages authentifiées :

| Fichier | Rôle |
|---------|------|
| `header_nav.php` | Barre de navigation publique (logo, liens, bouton connexion) |
| `assets/templates/head_login.php` | En-tête HTML pour les pages publiques (CSS Bootstrap) |
| `assets/css/front.css` | Styles spécifiques aux pages publiques |
| `assets/css_main_monrespro/main.css` | Styles du template principal |

### Différences avec les pages authentifiées

| Aspect | Pages publiques | Pages authentifiées |
|--------|----------------|-------------------|
| **Framework CSS** | Bootstrap 4 + CSS custom | Tailwind CSS (tw-) + DaisyUI |
| **Sidebar** | Aucune | Sidebar complète avec navigation |
| **Mode sombre** | Non disponible | Disponible |
| **Responsive** | Oui (Bootstrap grid) | Oui (Tailwind responsive) |

---

## 15.8 SEO et accessibilité

### Métadonnées

Chaque page publique inclut :
- `<title>` dynamique avec le nom de la page et le nom du site
- `<meta name="description">` pour le référencement
- `<meta name="keywords">` avec les mots-clés
- `<link rel="icon">` avec le favicon configuré

### Bonnes pratiques SEO

1. **Titres uniques** — chaque page a un titre descriptif différent
2. **Descriptions** — renseignez les meta descriptions dans la configuration
3. **URLs lisibles** — les URLs des pages pays sont explicites (`livraison-cameroun.php`)
4. **Mobile-friendly** — toutes les pages sont responsive
5. **Performance** — minimisez les images et les scripts pour un chargement rapide

---

## 15.9 Bonnes pratiques

### Pour l'administrateur

1. **Personnalisez la page d'accueil** avec les informations de votre entreprise
2. **Ajoutez des pages pays** pour chaque pays desservi
3. **Testez le suivi** — vérifiez régulièrement que la page de tracking fonctionne correctement
4. **Optimisez pour le mobile** — la majorité des clients utilisent leur téléphone
5. **Incluez le lien de suivi** dans toutes les communications clients

### Pour les clients

1. **Utilisez la page de suivi** pour vérifier l'état de votre colis à tout moment
2. **Conservez votre numéro de suivi** — il est votre référence principale
3. **Consultez les pages pays** pour connaître les délais et tarifs
4. **Créez un compte** pour accéder à plus de fonctionnalités (pré-alertes, historique, etc.)
