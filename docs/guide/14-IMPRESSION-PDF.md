# Chapitre 14 — Impression & PDF

> MonResPro génère plusieurs types de documents imprimables : étiquettes de colis, factures, bordereaux d'expédition et relevés de compte. Tous les documents sont générés en PDF via les bibliothèques TCPDF et HTML2PDF.

---

## 14.1 Vue d'ensemble

### Types de documents

| Document | Module | Description |
|----------|--------|-------------|
| **Étiquette de colis** | Tous | Étiquette avec code-barres à coller sur le colis |
| **Facture / Bordereau** | Tous | Détail des frais avec informations client |
| **Bordereau de suivi** | Courier | Document avec QR code pour le suivi |
| **Relevé de charges** | Comptabilité | Détail des charges d'un client |
| **Étiquettes multiples** | Tous | Plusieurs étiquettes sur une même page |

### Bibliothèques PDF

| Bibliothèque | Dossier | Usage |
|--------------|---------|-------|
| **TCPDF** | `vendor/tecnickcom/tcpdf/` | Génération PDF avancée, codes-barres |
| **HTML2PDF** | `vendor/spipu/html2pdf/` | Conversion HTML en PDF |
| **myPdf** | `pdf/_class/myPdf.class.php` | Classe wrapper personnalisée |

---

## 14.2 Étiquettes de colis

### Étiquette Expédition Courier

**URL :** `print_label_ship.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

#### Contenu de l'étiquette

| Élément | Description |
|---------|-------------|
| **Logo** | Logo de l'entreprise |
| **Code-barres** | Code-barres du numéro de suivi (format Code 128) |
| **N° de suivi** | Numéro en texte lisible sous le code-barres |
| **Expéditeur** | Nom, adresse, téléphone |
| **Destinataire** | Nom, adresse, téléphone |
| **Origine → Destination** | Route de l'expédition |
| **Poids** | Poids du colis |
| **Dimensions** | L × l × H si renseignées |
| **Nombre de pièces** | Quantité |
| **Catégorie** | Type de marchandise |
| **Description** | Contenu du colis |
| **Date** | Date de création |
| **Instructions** | Instructions spéciales si renseignées |

#### Impression

1. Depuis la liste ou la page de détails d'une expédition, cliquez sur l'icône **Imprimer étiquette**
2. Le PDF est généré et s'ouvre dans un nouvel onglet
3. Utilisez la fonction d'impression du navigateur (`Ctrl+P`)
4. Recommandation : papier **A6** (105 × 148 mm) ou étiquette autocollante

### Étiquette Package Client

**URL :** `print_label_package.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Même structure que l'étiquette courier avec :
- Numéro de casier virtuel du client en plus
- Préfixe spécifique aux packages clients

### Étiquette Consolidé

**URL :** `print_label_consolidate.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Étiquette spécifique au conteneur consolidé avec mention du nombre d'envois inclus.

### Étiquette Package Consolidé

**URL :** `print_label_consolidate_package.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

---

## 14.3 Étiquettes multiples

### Expéditions Courier

**URL :** `print_label_ship_multiple.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Génère un PDF avec **plusieurs étiquettes** sur une ou plusieurs pages.

#### Procédure

1. Dans la liste des expéditions, **sélectionnez** les expéditions souhaitées (cases à cocher)
2. Cliquez sur **Imprimer les étiquettes sélectionnées**
3. Un PDF est généré avec une étiquette par page (ou plusieurs par page selon le format)
4. Imprimez le document complet

### Packages Clients

**URL :** `print_label_package_multiple.php`

Même fonctionnement pour les packages clients.

### Consolidés

**URL :** `print_label_consolidate_multiple.php`

### Packages Consolidés

**URL :** `print_label_consolidate_multiple_package.php`

---

## 14.4 Factures et bordereaux

### Facture Expédition Courier

**URL :** `print_inv_ship.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

#### Contenu de la facture

| Section | Contenu |
|---------|---------|
| **En-tête** | Logo, nom de l'entreprise, adresse, NIT/SIRET |
| **Informations client** | Nom, adresse, email, téléphone du client |
| **Référence** | Numéro de suivi, date, numéro de facture |
| **Détail de l'envoi** | Catégorie, emballage, mode, poids, dimensions |
| **Route** | Origine → Destination |
| **Tarification** | Tableau détaillé des frais |
| — Frais d'expédition | Montant de base |
| — Taxe 1 à 7 | Chaque taxe applicable avec nom et montant |
| — Assurance | Prime d'assurance |
| — Frais supplémentaires | Frais additionnels |
| — Remise | Remise éventuelle |
| — **Total** | **Montant total à payer** |
| **Paiement** | Mode et méthode de paiement, statut |
| **Pied de page** | Termes et conditions, coordonnées de l'entreprise |

### Facture Package Client

**URL :** `print_invoice_package.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Structure similaire à la facture courier, adaptée aux packages clients.

### Bordereau Consolidé

**URL :** `print_consolidate.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Bordereau spécifique aux consolidés incluant :
- Liste de tous les envois inclus dans le conteneur
- Poids et dimensions cumulés
- Détail des frais par envoi et total

### Bordereau de suivi

**URL :** `print_inv_ship_track.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Document compact destiné au suivi avec :
- Code-barres / QR code
- Informations essentielles
- Historique de suivi imprimé

---

## 14.5 Relevé de charges

**URL :** `print_charge.php?print={id}`  
**Accès :** 🔴 Admin, 🟠 Employé

Relevé détaillé des charges d'un client :
- Liste de toutes les factures
- Paiements reçus
- Solde restant
- Récapitulatif par période

---

## 14.6 Envoi de documents par email

### Facture expédition par email

**URL :** `send_email_pdf.php`  
**Accès :** 🔴 Admin, 🟠 Employé

Envoie automatiquement la facture PDF en pièce jointe par email au client :

1. Le PDF est généré en mémoire (pas enregistré sur le serveur)
2. L'email est composé avec le modèle configuré
3. Le PDF est attaché comme pièce jointe
4. L'email est envoyé via PHPMailer
5. Une confirmation s'affiche

### Facture package par email

**URL :** `send_email_pdf_packages.php`

### Facture consolidé par email

**URL :** `send_email_pdf_consolidate.php`

### Facture package consolidé par email

**URL :** `send_email_pdf_consolidate_packages.php`

### Prérequis

- L'email SMTP doit être configuré (voir Chapitre 13)
- Le client doit avoir une adresse email valide
- Le modèle de notification email doit être configuré

---

## 14.7 Personnalisation des documents

### Logo et en-tête

Les documents PDF utilisent le logo configuré dans **Configuration > Logo & Favicon**. Pour changer le logo sur les documents :

1. Accédez à **Paramètres > Logo & Favicon**
2. Uploadez votre logo (PNG ou JPG recommandé, fond transparent pour PNG)
3. Le logo sera automatiquement utilisé dans tous les documents générés

### Informations de l'entreprise

Les informations affichées dans l'en-tête et le pied de page proviennent de :
- **Configuration > Entreprise** (nom, adresse, NIT, téléphone, email)
- **Configuration > Termes et conditions** (texte en pied de page)

### Devise et format

- La devise utilisée dans les factures est celle configurée dans **Paramètres généraux**
- Les dates utilisent le format de la locale configurée
- Les poids utilisent l'unité configurée (kg ou lbs)

---

## 14.8 Dossiers de stockage

### Signatures de livraison

| Dossier | Contenu |
|---------|---------|
| `doc_signs/shipments_courier/` | Signatures des expéditions courier |
| `doc_signs/customer_packages/` | Signatures des packages clients |
| `doc_signs/consolidate/` | Signatures des consolidés |
| `doc_signs/consolidate_packages/` | Signatures des packages consolidés |

### Fichiers joints aux expéditions

| Dossier | Contenu |
|---------|---------|
| `order_files/` | Photos et documents joints aux expéditions |
| `pre_alert_files/` | Factures et documents des pré-alertes |
| `driver_files/` | Documents des chauffeurs (permis, assurance) |

---

## 14.9 Bonnes pratiques d'impression

1. **Utilisez du papier adapté** — A6 pour les étiquettes, A4 pour les factures
2. **Vérifiez l'aperçu** — consultez le PDF avant d'imprimer
3. **Imprimante thermique** — recommandée pour les étiquettes (codes-barres de meilleure qualité)
4. **Étiquettes autocollantes** — utilisez du papier autocollant pour les étiquettes de colis
5. **Conservez une copie numérique** — gardez les PDF dans un dossier d'archive
6. **Testez les codes-barres** — scannez un code-barres imprimé pour vérifier la lisibilité
