# Chapitre 12 — Configuration & Paramètres

> Ce chapitre couvre tous les paramètres système accessibles depuis le module **Paramètres** de la sidebar. Seuls les administrateurs (niveau 9) ont accès à la configuration complète.

---

## 12.1 Accès à la configuration

**URL :** `tools.php`  
**Accès :** 🔴 Admin uniquement  
**Vue :** `views/tools/all_tools.php`

La page de configuration est organisée en **menu latéral gauche** (`left_part_menu.php`) avec les sections suivantes :

| Section | URL | Description |
|---------|-----|-------------|
| **Paramètres généraux** | `tools.php?list=config_general` | Fuseau horaire, langue, devises |
| **Entreprise** | `tools.php?list=config` | Informations de l'entreprise |
| **Logo & Favicon** | `tools.php?list=configlogo` | Logos et icône du site |
| **Email SMTP** | `tools.php?list=config_email` | Configuration de l'envoi d'emails |
| **WhatsApp** | `config_whatsapp.php` | Configuration de l'API WhatsApp |
| **SMS** | `config_sms.php` | Configuration de Twilio SMS |
| **Modèles de notification** | Sous-menu | Templates email, WhatsApp, SMS |
| **Modèles par défaut** | Sous-menu | Templates WhatsApp par défaut |

---

## 12.2 Paramètres généraux

**URL :** `tools.php?list=config_general`  
**Vue :** `views/tools/config_general.php`

### Fuseau horaire

| Paramètre | Description |
|-----------|-------------|
| **Timezone** | Fuseau horaire de l'application (ex: `Africa/Douala`, `Europe/Paris`) |

Le fuseau horaire affecte toutes les dates et heures affichées dans l'application (créations, mises à jour, rapports, etc.).

### Langue

| Paramètre | Description |
|-----------|-------------|
| **Langue par défaut** | Langue de l'interface (fr, en, es, ar, pt) |
| **Direction** | LTR (gauche à droite) ou RTL (droite à gauche, pour l'arabe) |

### Devise

| Paramètre | Description |
|-----------|-------------|
| **Devise** | Code de la devise (ex: `XAF`, `EUR`, `USD`) |
| **Symbole** | Symbole affiché (ex: `FCFA`, `€`, `$`) |
| **Position** | Avant ou après le montant |

### Unités de mesure

| Paramètre | Description |
|-----------|-------------|
| **Poids** | kg ou lbs |
| **Dimensions** | cm ou inches |
| **Facteur volumétrique** | Diviseur pour le calcul du poids volumétrique (ex: 5000) |

### Pagination

| Paramètre | Description |
|-----------|-------------|
| **Éléments par page** | Nombre d'éléments affichés par page dans les tableaux (ex: 10, 25, 50) |

### Inscription

| Paramètre | Description |
|-----------|-------------|
| `reg_allowed` | Autoriser l'inscription publique (Oui/Non) |
| `reg_verify` | Vérification manuelle des nouveaux comptes (Oui/Non) |
| `auto_verify` | Activation automatique des comptes (Oui/Non) |

---

## 12.3 Informations de l'entreprise

**URL :** `tools.php?list=config`  
**Vue :** `views/tools/config.php`

### Coordonnées

| Paramètre | Description |
|-----------|-------------|
| **Nom du site** | Nom affiché dans l'application et les emails (ex: `MonResPro`) |
| **NIT / SIRET** | Numéro d'identification fiscale de l'entreprise |
| **Téléphone** | Numéro de téléphone principal |
| **Email** | Email de contact de l'entreprise |
| **Adresse** | Adresse physique du siège |
| **Ville** | Ville du siège |
| **Pays** | Pays du siège |
| **Code postal** | Code postal |
| **Site web** | URL du site web de l'entreprise |

### Termes et conditions

| Paramètre | Description |
|-----------|-------------|
| **Termes et conditions** | Éditeur WYSIWYG (Summernote) pour rédiger les CGV |
| **Politique de confidentialité** | Éditeur WYSIWYG pour la politique de confidentialité |

Ces textes sont affichés sur les pages publiques et dans les documents imprimés.

---

## 12.4 Logo & Favicon

**URL :** `tools.php?list=configlogo`  
**Vue :** `views/tools/configlogo.php`

| Paramètre | Format | Description |
|-----------|--------|-------------|
| **Logo principal** | PNG/JPG/SVG | Logo affiché dans la sidebar et les documents |
| **Logo clair** | PNG/JPG/SVG | Logo pour les fonds sombres |
| **Favicon** | PNG 16×16 | Icône affichée dans l'onglet du navigateur |

### Procédure de changement

1. Cliquez sur **Parcourir** pour sélectionner le fichier
2. Prévisualisez le résultat
3. Cliquez sur **Enregistrer**
4. Le logo est immédiatement mis à jour sur toutes les pages
5. Les fichiers sont stockés dans `assets/uploads/`

---

## 12.5 Suivi & Facturation

### Préfixes de numérotation

Ces paramètres définissent le format des numéros de suivi auto-générés :

| Paramètre | Description | Exemple |
|-----------|-------------|---------|
| `prefix` | Préfixe expéditions courier | `AWB` → `AWB00001` |
| `prefix_online_shopping` | Préfixe packages clients | `PKG` → `PKG00001` |
| `prefix_consolidate` | Préfixe consolidation | `COL` → `COL00001` |
| `prefix_consolidate_package` | Préfixe packages consolidés | `CPK` → `CPK00001` |
| `prefix_locker` | Préfixe casier virtuel | `LOC` → `LOC00042` |

### Compteurs

| Paramètre | Description |
|-----------|-------------|
| `order_no` | Prochain numéro d'expédition |
| `c_no` | Prochain numéro de consolidé |
| `code_number_locker` | Prochain numéro de casier |
| `digit_random_locker` | Nombre de chiffres du casier (ex: 5) |

### Tarification automatique

| Paramètre | Description |
|-----------|-------------|
| `c_tariffs` | Activer le calcul automatique des tarifs (Oui/Non) |

Quand activé, le système calcule automatiquement les frais d'expédition à partir de la grille tarifaire configurée.

---

## 12.6 Taxes

MonResPro supporte jusqu'à **7 taxes** configurables individuellement :

### Configuration de chaque taxe

| Paramètre | Description |
|-----------|-------------|
| **Nom** | Libellé de la taxe (ex: `TVA`, `Taxe douanière`, `Surtaxe`) |
| **Taux (%)** | Pourcentage de la taxe |
| **Actif** | Oui/Non — active ou désactive cette taxe |
| **Applicable sur** | Base de calcul (montant de l'expédition, valeur déclarée, etc.) |

### Paramètres de la table `cdb_settings`

| Champ | Description |
|-------|-------------|
| `tax_name1` à `tax_name7` | Noms des taxes |
| `tax_value1` à `tax_value7` | Taux en pourcentage |
| `tax_check1` à `tax_check7` | Activation (1=actif, 0=inactif) |

### Assurance

| Paramètre | Description |
|-----------|-------------|
| `insurance` | Taux d'assurance (%) sur la valeur déclarée |
| `insurance_check` | Activer le calcul automatique de l'assurance |

### Exemple de calcul

Pour une expédition de 50 000 FCFA avec TVA à 19,25% et assurance à 2% sur une valeur déclarée de 200 000 FCFA :

```
Frais d'expédition :    50 000 FCFA
TVA (19,25%) :           9 625 FCFA
Assurance (2%) :         4 000 FCFA
─────────────────────────────────────
Total :                 63 625 FCFA
```

---

## 12.7 Gestion des localisations

### Pays

| URL | Action |
|-----|--------|
| `countries_list.php` | Liste des pays |
| `countries_add.php` | Ajouter un pays |
| `countries_edit.php?edit={id}` | Modifier un pays |

**Champs :**
- Nom du pays
- Code ISO (2 lettres)
- Indicatif téléphonique
- Devise
- Actif (Oui/Non)

### États / Régions

| URL | Action |
|-----|--------|
| `states_list.php` | Liste des états |
| `states_add.php` | Ajouter un état |
| `states_edit.php?edit={id}` | Modifier un état |

**Champs :**
- Nom de l'état/région
- Pays de rattachement
- Code
- Actif (Oui/Non)

### Villes

| URL | Action |
|-----|--------|
| `cities_list.php` | Liste des villes |
| `cities_add.php` | Ajouter une ville |
| `cities_edit.php?edit={id}` | Modifier une ville |

**Champs :**
- Nom de la ville
- État/Région de rattachement
- Code postal
- Actif (Oui/Non)

### Zones

| URL | Action |
|-----|--------|
| `zone_list.php` | Liste des zones |
| `zone_add.php` | Ajouter une zone |
| `zone_edit.php?edit={id}` | Modifier une zone |

Les zones permettent de regrouper des pays/régions pour simplifier la configuration des tarifs.

---

## 12.8 Données maîtres (Master Data)

### Catégories de marchandises

| URL | Action |
|-----|--------|
| `category_list.php` | Liste |
| `category_add.php` | Ajouter |
| `category_edit.php?edit={id}` | Modifier |

Exemples : Documents, Électronique, Vêtements, Fragile, Denrées alimentaires, Produits chimiques...

### Types d'emballage

| URL | Action |
|-----|--------|
| `packaging_list.php` | Liste |
| `packaging_add.php` | Ajouter |
| `packaging_edit.php?edit={id}` | Modifier |

Exemples : Enveloppe, Carton petit, Carton moyen, Carton grand, Palette, Fût...

### Modes d'expédition

| URL | Action |
|-----|--------|
| `shipping_mode_list.php` | Liste |
| `shipping_mode_add.php` | Ajouter |
| `shipping_mode_edit.php?edit={id}` | Modifier |

Exemples : Aérien, Maritime, Terrestre, Express, Économique...

### Délais de livraison

| URL | Action |
|-----|--------|
| `delivery_time_list.php` | Liste |
| `delivery_time_add.php` | Ajouter |
| `delivery_time_edit.php?edit={id}` | Modifier |

Exemples : 24 heures, 48 heures, 3-5 jours, 1-2 semaines, 3-4 semaines...

### Entreprises de transport

| URL | Action |
|-----|--------|
| `courier_company_list.php` | Liste |
| `courier_company_add.php` | Ajouter |
| `courier_company_edit.php?edit={id}` | Modifier |

Champs : Nom, Logo, Contact, Téléphone, Email, Site web, Actif

### Incoterms

| URL | Action |
|-----|--------|
| `incoterms_list.php` | Liste |
| `incoterms_add.php` | Ajouter |
| `incoterms_edit.php?edit={id}` | Modifier |

Termes du commerce international (EXW, FCA, CPT, CIP, DAP, DPU, DDP, etc.)

### Statuts d'expédition

| URL | Action |
|-----|--------|
| `status_list.php` | Liste |
| `status_add.php` | Ajouter |
| `status_edit.php?edit={id}` | Modifier |

Chaque statut est défini par :
- **Nom** du statut (ex: « En transit », « Livré »)
- **Couleur** — code couleur hexadécimal pour le badge
- **Icône** — icône associée (optionnel)
- **Ordre** — position dans la liste

Table : `cdb_styles`

---

## 12.9 Tarifs d'expédition

| URL | Action |
|-----|--------|
| `tariffs_list.php` | Liste des tarifs |
| `tariffs_add.php` | Ajouter un tarif |
| `tariffs_edit.php?edit={id}` | Modifier un tarif |

### Structure d'un tarif

| Champ | Description |
|-------|-------------|
| **Pays d'origine** | Pays de départ |
| **Pays de destination** | Pays d'arrivée |
| **Zone** | Zone géographique (alternative aux pays individuels) |
| **Poids min** | Poids minimum de la plage (kg) |
| **Poids max** | Poids maximum de la plage (kg) |
| **Prix** | Tarif pour cette plage de poids |
| **Prix par kg supplémentaire** | Tarif au kg au-delà du poids max |
| **Mode d'expédition** | Applicable à un mode spécifique ou tous |

### Fonctionnement du calcul automatique

Quand le calcul automatique est activé (`c_tariffs = 1`) :

1. Le système identifie le **pays d'origine** et le **pays de destination**
2. Il cherche un tarif correspondant dans `cdb_tariffs`
3. Il sélectionne la **plage de poids** correspondante
4. Le tarif est appliqué automatiquement dans le formulaire
5. Si le poids dépasse le max de la plage, le prix par kg supplémentaire est ajouté

### Exemple

| Origine | Destination | Poids min | Poids max | Prix | Prix/kg supp |
|---------|------------|-----------|-----------|------|-------------|
| Cameroun | France | 0 | 5 | 25 000 | 5 000 |
| Cameroun | France | 5 | 10 | 40 000 | 4 500 |
| Cameroun | France | 10 | 20 | 70 000 | 4 000 |

Pour un colis de 7 kg du Cameroun vers la France :
- Plage applicable : 5-10 kg
- Prix : 40 000 FCFA

---

## 12.10 Bureaux et agences

### Bureaux

| URL | Action |
|-----|--------|
| `offices_list.php` | Liste des bureaux |
| `offices_add.php` | Ajouter |
| `offices_edit.php?edit={id}` | Modifier |

Champs : Nom, Adresse, Ville, Pays, Téléphone, Email, Responsable

### Agences / Succursales

| URL | Action |
|-----|--------|
| `branchoffices_list.php` | Liste des agences |
| `branchoffices_add.php` | Ajouter |
| `branchoffices_edit.php?edit={id}` | Modifier |

Champs : Nom, Bureau de rattachement, Adresse, Ville, Pays, Téléphone, Email, Coordonnées bancaires

---

## 12.11 Valeurs par défaut des expéditions

**URL :** `info_ship_default.php`  
**Accès :** 🔴 Admin  
**Vue :** `views/tools/info_ship_default.php`

Cette page permet de configurer les **valeurs pré-remplies** dans les formulaires de création d'expéditions :

| Paramètre | Description |
|-----------|-------------|
| **Catégorie par défaut** | Catégorie sélectionnée par défaut |
| **Emballage par défaut** | Type d'emballage par défaut |
| **Transporteur par défaut** | Entreprise de transport par défaut |
| **Mode d'expédition par défaut** | Mode par défaut (aérien, maritime, etc.) |
| **Délai de livraison par défaut** | Délai par défaut |
| **Mode de paiement par défaut** | Mode de paiement par défaut |
| **Méthode de paiement par défaut** | Méthode par défaut |
| **Statut par défaut** | Statut initial par défaut |

Table : `cdb_info_ship_default`

> **Conseil :** Configurez les valeurs les plus fréquemment utilisées pour accélérer la saisie des expéditions.

---

## 12.12 Sauvegardes

**URL :** `backup.php`  
**Accès :** 🔴 Admin uniquement

### Créer une sauvegarde

1. Accédez à **Paramètres > Sauvegardes**
2. Cliquez sur **Créer une sauvegarde**
3. Un fichier SQL est généré avec toutes les tables de la base de données
4. Le fichier est stocké dans le dossier `backups/`
5. Vous pouvez le télécharger immédiatement

### Restaurer une sauvegarde

1. Sélectionnez le fichier de sauvegarde dans la liste
2. Cliquez sur **Restaurer**
3. Confirmez l'opération (cette action remplace toutes les données actuelles)

> **Attention :** La restauration écrase toutes les données actuelles. Faites toujours une sauvegarde avant de restaurer.

### Bonnes pratiques

- Faites une **sauvegarde quotidienne** ou au minimum hebdomadaire
- **Téléchargez** les sauvegardes sur un stockage externe (pas uniquement sur le serveur)
- Faites une **sauvegarde avant** toute mise à jour ou modification majeure
- **Testez** régulièrement la restauration sur un environnement de test
