# GUIDE OPERATIONNEL PAR AGENCE — Monrespro Logistics

**Version :** 1.0  
**Date :** 12 mars 2026  
**Projet :** Monrespro Logistics  
**Agences :** Belgique (Hub Europe) — Kinshasa, RDC — Libreville, Gabon

---

## TABLE DES MATIERES

1. [Vue d'ensemble du réseau](#1-vue-densemble-du-réseau)
2. [Agence Belgique — Hub Europe](#2-agence-belgique--hub-europe)
3. [Agence Kinshasa — Hub RDC](#3-agence-kinshasa--hub-rdc)
4. [Agence Gabon — Hub Libreville](#4-agence-gabon--hub-libreville)
5. [Matrice des flux inter-agences](#5-matrice-des-flux-inter-agences)
6. [Processus de paiement par agence](#6-processus-de-paiement-par-agence)
7. [Configuration système par agence](#7-configuration-système-par-agence)
8. [Ressources humaines par agence](#8-ressources-humaines-par-agence)

---

## 1. VUE D'ENSEMBLE DU RESEAU

### 1.1 Architecture du réseau Monrespro

```
                    ┌─────────────────────────────────┐
                    │       PLATEFORMES EN LIGNE       │
                    │  Shein · Zara · AliExpress ·     │
                    │  Amazon · Alibaba · ASOS · etc.  │
                    └──────────────┬──────────────────┘
                                   │
                                   │ Livraison vers casier virtuel
                                   ▼
              ┌─────────────────────────────────────────────┐
              │         AGENCE BELGIQUE (Hub Europe)         │
              │         Bruxelles / Anvers                   │
              │                                              │
              │  • Réception colis achats en ligne            │
              │  • Gestion casiers virtuels                  │
              │  • Consolidation des envois                  │
              │  • Expédition vers Afrique                   │
              │  • Redistribution vers Europe                │
              │  • Point de réception envois Afrique→Europe  │
              └───────────┬───────────────┬─────────────────┘
                          │               │
            Fret aérien/  │               │  Fret aérien/
            maritime      │               │  maritime
                          ▼               ▼
    ┌──────────────────────────┐  ┌──────────────────────────┐
    │  AGENCE KINSHASA (RDC)   │  │  AGENCE GABON            │
    │  Hub Afrique Centrale    │  │  Hub Libreville           │
    │                          │  │                           │
    │  • Réception colis       │  │  • Réception colis        │
    │    depuis Belgique       │  │    depuis Belgique        │
    │  • Dédouanement          │  │  • Dédouanement           │
    │  • Livraison locale      │  │  • Livraison locale       │
    │  • Collecte envois       │  │  • Collecte envois        │
    │    vers le monde         │  │    vers le monde          │
    │  • Point de dépôt client │  │  • Point de dépôt client  │
    └──────────────────────────┘  └──────────────────────────┘
```

### 1.2 Rôle de chaque agence

| Agence | Rôle principal | Rôle secondaire |
|--------|---------------|-----------------|
| **Belgique** | Hub de réception des achats en ligne (Europe) | Point d'arrivée pour envois Afrique→Europe |
| **Kinshasa** | Hub de distribution Afrique (RDC) | Point de collecte pour envois RDC→monde |
| **Gabon** | Hub de distribution Gabon | Point de collecte pour envois Gabon→monde |

---

## 2. AGENCE BELGIQUE — HUB EUROPE

### 2.1 Fiche d'identité

| Élément | Valeur |
|---------|--------|
| **Nom dans le système** | Monrespro Belgium |
| **Type** | Hub principal / Entrepôt |
| **Localisation** | Bruxelles ou Anvers, Belgique |
| **Fuseau horaire** | Europe/Brussels (UTC+1 / UTC+2 été) |
| **Devise principale** | EUR (Euro) |
| **Devises acceptées** | EUR, USD |
| **Langue interface** | Français |

### 2.2 Missions principales

#### A. Réception des achats en ligne
1. Réceptionner les colis livrés par les vendeurs en ligne (Shein, Zara, AliExpress, Amazon, etc.)
2. Scanner et identifier le colis via le numéro de casier virtuel
3. Rattacher le colis à la pré-alerte du client
4. Peser et mesurer le colis
5. Photographier le colis (preuve de réception)
6. Mettre à jour le statut dans le système

#### B. Gestion des casiers virtuels
- Chaque client inscrit reçoit une adresse Belgique unique :
  ```
  [Prénom Nom]
  Casier MRP-[NUMERO]
  [Adresse entrepôt Monrespro]
  [Code postal] [Ville]
  Belgique
  ```
- L'adresse est affichée dans le tableau de bord du client
- Le client utilise cette adresse sur toutes les plateformes de vente en ligne

#### C. Consolidation des colis
- Quand un client a plusieurs colis en attente, l'employé propose la consolidation
- Les colis sont regroupés dans un seul emballage
- Les frais sont recalculés (généralement plus avantageux)

#### D. Expédition vers l'Afrique
- Préparer les envois groupés vers Kinshasa et Libreville
- Gérer les documents d'expédition (manifeste, factures commerciales)
- Organiser le fret (aérien ou maritime selon l'urgence/le coût)
- Mettre à jour le tracking à chaque étape

#### E. Réception des envois depuis l'Afrique
- Réceptionner les colis en provenance de Kinshasa/Gabon
- Redistribuer vers les destinataires européens
- Ou réexpédier vers d'autres destinations mondiales

### 2.3 Processus opérationnel quotidien

```
JOURNEE TYPE — AGENCE BELGIQUE
═══════════════════════════════

08h00 - 09h00  │ OUVERTURE
               │ ├─ Connexion au système (Admin/Employé)
               │ ├─ Consultation du tableau de bord
               │ ├─ Vérification des nouvelles pré-alertes
               │ └─ Planification de la journée

09h00 - 12h00  │ RECEPTION COLIS
               │ ├─ Arrivée des livraisons (PostNL, Bpost, DHL, etc.)
               │ ├─ Pour chaque colis :
               │ │   ├─ Scanner le colis
               │ │   ├─ Identifier le casier virtuel (étiquette)
               │ │   ├─ Aller dans "Online Shopping > Enregistrer colis"
               │ │   ├─ Rattacher à la pré-alerte (si existante)
               │ │   ├─ Peser et mesurer
               │ │   ├─ Photographier
               │ │   ├─ Saisir dans le système
               │ │   └─ Notification auto au client
               │ └─ Traiter les colis sans pré-alerte
               │     └─ Contacter le client pour identification

12h00 - 13h00  │ PAUSE

13h00 - 15h00  │ CONSOLIDATION ET PREPARATION
               │ ├─ Identifier les clients avec plusieurs colis
               │ ├─ Proposer la consolidation
               │ ├─ Emballer les lots consolidés
               │ ├─ Créer les consolidations dans le système
               │ └─ Préparer les documents d'expédition

15h00 - 17h00  │ EXPEDITION
               │ ├─ Préparer les envois vers Kinshasa
               │ ├─ Préparer les envois vers Libreville
               │ ├─ Préparer les redistributions Europe
               │ ├─ Remettre au transporteur (DHL, cargo aérien, etc.)
               │ ├─ Mettre à jour les statuts tracking
               │ └─ Envoyer les notifications de départ

17h00 - 18h00  │ CLOTURE
               │ ├─ Traitement des paiements reçus
               │ ├─ Mise à jour des comptes à recevoir
               │ ├─ Génération des rapports du jour
               │ └─ Réponse aux réclamations clients
```

### 2.4 Fonctionnalités système utilisées

| Module | Usage quotidien | Fréquence |
|--------|----------------|-----------|
| Online Shopping > Pré-alertes | Consulter les nouvelles déclarations | Continu |
| Online Shopping > Enregistrer colis | Saisir chaque colis reçu | Continu |
| Online Shopping > Enregistrer multiple | Saisie par lot | Ponctuel |
| Online Shopping > Depuis pré-alerte | Rattacher colis à pré-alerte | Continu |
| Consolidation > Créer | Regrouper les colis d'un client | Quotidien |
| Consolidation > Liste | Suivre les consolidations en cours | Quotidien |
| Expéditions > Créer | Créer les envois vers Afrique | Quotidien |
| Tracking > Mise à jour | Mettre à jour les statuts | Continu |
| Rapports | Rapports fin de journée | Quotidien |
| Paiements | Vérifier les paiements en ligne | Continu |

### 2.5 KPI de l'agence Belgique

| Indicateur | Description |
|------------|-------------|
| Colis reçus/jour | Nombre de colis arrivés à l'entrepôt |
| Colis traités/jour | Nombre de colis enregistrés dans le système |
| Taux de rattachement pré-alerte | % de colis avec pré-alerte existante |
| Délai traitement | Temps entre réception et enregistrement |
| Consolidations/jour | Nombre de lots consolidés |
| Expéditions/jour | Nombre d'envois partis vers Afrique |
| Taux de paiement | % de colis payés avant expédition |

---

## 3. AGENCE KINSHASA — HUB RDC

### 3.1 Fiche d'identité

| Élément | Valeur |
|---------|--------|
| **Nom dans le système** | Monrespro Kinshasa |
| **Type** | Hub distribution + Point de collecte |
| **Localisation** | Kinshasa, République Démocratique du Congo |
| **Fuseau horaire** | Africa/Kinshasa (UTC+1) |
| **Devise principale** | CDF (Franc Congolais) |
| **Devises acceptées** | CDF, USD, EUR |
| **Langue interface** | Français |

### 3.2 Missions principales

#### A. Réception et dédouanement
1. Réceptionner les envois en provenance de Belgique
2. Gérer les formalités douanières (DGDA — Direction Générale des Douanes et Accises)
3. Payer les droits de douane si nécessaire
4. Dédouaner les colis
5. Stocker dans l'entrepôt en attendant le paiement/retrait

#### B. Distribution locale à Kinshasa
1. Notifier les clients de l'arrivée de leur colis
2. Attendre le paiement du client
3. Organiser la livraison locale :
   - **Retrait en agence** : le client vient chercher
   - **Livraison à domicile** : via chauffeur/livreur
4. Confirmer la livraison dans le système

#### C. Collecte d'envois vers le monde
1. Recevoir les colis des clients qui veulent envoyer à l'étranger
2. Peser, mesurer, calculer les frais
3. Collecter le paiement
4. Consolider les envois vers Belgique (hub de redistribution)
5. Organiser l'expédition

#### D. Gestion des ramassages (Pickup)
1. Recevoir les demandes de pickup des clients
2. Assigner un chauffeur/livreur
3. Le chauffeur collecte le colis chez le client
4. Ramener le colis à l'agence pour traitement

### 3.3 Processus opérationnel quotidien

```
JOURNEE TYPE — AGENCE KINSHASA
═══════════════════════════════

08h00 - 09h00  │ OUVERTURE
               │ ├─ Connexion au système
               │ ├─ Consultation du tableau de bord
               │ ├─ Vérification des arrivages (colis depuis Belgique)
               │ ├─ Vérification des demandes de pickup
               │ └─ Attribution des livraisons aux chauffeurs

09h00 - 12h00  │ OPERATIONS MATIN
               │ ├─ ARRIVAGES :
               │ │   ├─ Réceptionner les colis arrivés de Belgique
               │ │   ├─ Vérifier l'intégrité des colis
               │ │   ├─ Mettre à jour statut → "Arrivé à Kinshasa"
               │ │   ├─ Notifier chaque client (WhatsApp prioritaire)
               │ │   └─ Stocker en attendant paiement/retrait
               │ │
               │ ├─ LIVRAISONS SORTANTES :
               │ │   ├─ Chauffeurs partent avec les colis assignés
               │ │   ├─ Mise à jour statut → "En cours de livraison"
               │ │   └─ Confirmation à la livraison
               │ │
               │ └─ PICKUP :
               │     ├─ Chauffeurs vont chercher les colis clients
               │     └─ Retour à l'agence avec les colis collectés

12h00 - 13h00  │ PAUSE

13h00 - 15h00  │ TRAITEMENT
               │ ├─ CLIENTS AU COMPTOIR :
               │ │   ├─ Accueil des clients qui viennent retirer
               │ │   ├─ Encaissement (Mobile Money / Cash / USD)
               │ │   ├─ Remise du colis
               │ │   └─ Mise à jour statut → "Livré"
               │ │
               │ ├─ ENVOIS SORTANTS :
               │ │   ├─ Réception des colis à expédier
               │ │   ├─ Pesée, mesure, calcul des frais
               │ │   ├─ Encaissement
               │ │   ├─ Création de l'expédition dans le système
               │ │   └─ Stockage pour envoi groupé vers Belgique
               │ │
               │ └─ DEDOUANEMENT :
               │     ├─ Suivi des colis en douane
               │     ├─ Paiement des droits
               │     └─ Récupération des colis dédouanés

15h00 - 17h00  │ CONSOLIDATION ET EXPEDITION
               │ ├─ Consolider les envois vers Belgique
               │ ├─ Préparer les documents d'expédition
               │ ├─ Remettre au transporteur
               │ └─ Mettre à jour les statuts

17h00 - 18h00  │ CLOTURE
               │ ├─ Chauffeurs rentrent — mise à jour des livraisons
               │ ├─ Bilan des encaissements du jour
               │ ├─ Rapports (espèces, Mobile Money, soldes)
               │ └─ Préparation du lendemain
```

### 3.4 Fonctionnalités système utilisées

| Module | Usage quotidien | Fréquence |
|--------|----------------|-----------|
| Dashboard | Vue globale, compteurs, alertes | Continu |
| Online Shopping > Liste colis | Voir colis arrivés pour les clients | Continu |
| Online Shopping > Tracking | Mettre à jour "Arrivé Kinshasa" | A chaque arrivage |
| Expéditions > Créer | Envois sortants (Kinshasa→monde) | Quotidien |
| Expéditions > Liste | Suivi des expéditions en cours | Continu |
| Pickup > Liste | Gérer les demandes de ramassage | Quotidien |
| Pickup > Créer (complet) | Créer pickup avec assignation chauffeur | Quotidien |
| Consolidation > Créer | Consolider envois vers Belgique | Hebdomadaire |
| Paiements | Encaisser (Mobile Money, Cash, USD) | Continu |
| Comptes à recevoir | Suivi des impayés | Quotidien |
| Rapports | Rapports journaliers | Quotidien |

### 3.5 Spécificités Kinshasa

| Aspect | Détail |
|--------|--------|
| **Paiement** | Mobile Money (M-Pesa, Airtel Money, Orange Money) dominant. Cash en CDF et USD. Carte bancaire très rare. **Mode opératoire Phase A** : le client envoie l'argent vers le numéro Mobile Money de l'agence puis charge la preuve (screenshot/reçu) sur la plateforme. L'employé vérifie sur le relevé Mobile Money et valide dans le système. |
| **Livraison** | Pas d'adressage postal standard. Livraison par repères (« à côté de... », « en face de... »). Besoin de numéro de téléphone obligatoire. |
| **Communication** | WhatsApp est le canal principal (quasi universel). SMS en backup. Email peu utilisé. |
| **Douane** | Passage obligatoire par la DGDA. Frais variables selon la nature et la valeur du colis. Délais imprévisibles (1 à 7 jours). |
| **Logistique** | Embouteillages importants. Livraison le matin privilégiée. Zones d'accès difficile (Masina, Kimbanseke, etc.). |
| **Devises** | Double circulation USD/CDF. Taux de change fluctuant. Nécessité de gérer les deux devises simultanément. |
| **Sécurité** | Colis de valeur : livraison avec accusé de réception obligatoire. Vérification d'identité au retrait. |

### 3.6 KPI de l'agence Kinshasa

| Indicateur | Description |
|------------|-------------|
| Colis arrivés/semaine | Volume entrant depuis Belgique |
| Colis livrés/jour | Nombre de livraisons effectuées |
| Délai livraison locale | Temps entre arrivée et livraison au client |
| Taux de retrait en agence | % de clients qui viennent chercher vs livraison |
| Encaissements/jour | Total encaissé (CDF + USD) |
| Colis en attente paiement | Stock de colis non payés |
| Envois sortants/semaine | Volume expédié vers Belgique/monde |
| Délai dédouanement moyen | Temps de passage en douane |

---

## 4. AGENCE GABON — HUB LIBREVILLE

### 4.1 Fiche d'identité

| Élément | Valeur |
|---------|--------|
| **Nom dans le système** | Monrespro Gabon |
| **Type** | Hub distribution + Point de collecte |
| **Localisation** | Libreville, Gabon |
| **Fuseau horaire** | Africa/Libreville (UTC+1) |
| **Devise principale** | XAF (Franc CFA CEMAC) |
| **Devises acceptées** | XAF, EUR, USD |
| **Langue interface** | Français |

### 4.2 Missions principales

#### A. Réception et dédouanement
1. Réceptionner les envois en provenance de Belgique
2. Gérer les formalités douanières (Direction Générale des Douanes du Gabon)
3. Dédouaner les colis
4. Stocker en attendant paiement/retrait

#### B. Distribution locale au Gabon
1. Notifier les clients de l'arrivée de leur colis
2. Attendre le paiement du client
3. Organiser la livraison :
   - Retrait en agence (Libreville)
   - Livraison locale (Libreville et environs)
   - Expédition vers d'autres villes gabonaises (Port-Gentil, Franceville, etc.)
4. Confirmer la livraison

#### C. Collecte d'envois vers le monde
1. Recevoir les colis des clients gabonais qui veulent expédier
2. Traitement identique à Kinshasa
3. Consolidation et expédition vers Belgique

#### D. Gestion des ramassages
1. Service de pickup dans Libreville
2. Coordination avec les chauffeurs locaux

### 4.3 Processus opérationnel quotidien

```
JOURNEE TYPE — AGENCE GABON
═══════════════════════════════

08h00 - 09h00  │ OUVERTURE
               │ ├─ Connexion au système
               │ ├─ Consultation du tableau de bord
               │ ├─ Vérification des arrivages depuis Belgique
               │ ├─ Vérification des demandes de pickup
               │ └─ Planification livraisons

09h00 - 12h00  │ OPERATIONS MATIN
               │ ├─ ARRIVAGES :
               │ │   ├─ Réception colis depuis Belgique
               │ │   ├─ Vérification intégrité
               │ │   ├─ Mise à jour statut → "Arrivé à Libreville"
               │ │   ├─ Notification clients (WhatsApp)
               │ │   └─ Stockage
               │ │
               │ ├─ LIVRAISONS :
               │ │   ├─ Départ des chauffeurs
               │ │   ├─ Livraisons dans Libreville
               │ │   └─ Confirmation des livraisons
               │ │
               │ └─ PICKUP :
               │     ├─ Collecte chez les clients
               │     └─ Retour à l'agence

12h00 - 13h30  │ PAUSE

13h30 - 15h30  │ TRAITEMENT
               │ ├─ RETRAIT AU COMPTOIR :
               │ │   ├─ Accueil clients
               │ │   ├─ Encaissement (Airtel Money / Cash XAF)
               │ │   ├─ Remise colis
               │ │   └─ Mise à jour statut
               │ │
               │ ├─ ENVOIS SORTANTS :
               │ │   ├─ Réception colis à expédier
               │ │   ├─ Pesée, calcul frais
               │ │   ├─ Encaissement
               │ │   └─ Stockage pour envoi groupé
               │ │
               │ └─ TRANSIT NATIONAL :
               │     ├─ Préparation envois vers Port-Gentil
               │     ├─ Préparation envois vers Franceville
               │     └─ Remise au transporteur local

15h30 - 17h00  │ CONSOLIDATION ET EXPEDITION
               │ ├─ Consolidation envois vers Belgique
               │ ├─ Documents d'expédition
               │ └─ Mise à jour statuts

17h00 - 18h00  │ CLOTURE
               │ ├─ Bilan livraisons
               │ ├─ Bilan encaissements (XAF)
               │ ├─ Rapports
               │ └─ Préparation lendemain
```

### 4.4 Fonctionnalités système utilisées

| Module | Usage quotidien | Fréquence |
|--------|----------------|-----------|
| Dashboard | Vue globale | Continu |
| Online Shopping > Liste colis | Colis arrivés pour les clients gabonais | Continu |
| Online Shopping > Tracking | Mise à jour statut | A chaque arrivage |
| Expéditions > Créer | Envois sortants (Gabon→monde) | Quotidien |
| Expéditions > Liste | Suivi expéditions | Continu |
| Pickup > Liste | Demandes de ramassage | Quotidien |
| Consolidation > Créer | Envois groupés vers Belgique | Hebdomadaire |
| Paiements | Encaissements | Continu |
| Rapports | Rapports journaliers | Quotidien |

### 4.5 Spécificités Gabon

| Aspect | Détail |
|--------|--------|
| **Paiement** | Airtel Money dominant au Gabon. Cash en XAF. Mobicash (Moov). Carte bancaire rare mais plus courante qu'en RDC. **Mode opératoire Phase A** : le client envoie l'argent vers le numéro Airtel Money ou Mobicash de l'agence puis charge la preuve sur la plateforme. L'employé valide après vérification. |
| **Devise** | Franc CFA (XAF) — taux fixe avec l'Euro (1 EUR = 655,957 XAF). Avantage : pas de fluctuation de change avec l'Europe. |
| **Livraison** | Libreville : adressage approximatif mais meilleur qu'en RDC. Quartiers : Akanda, Owendo, PK. Port-Gentil et Franceville nécessitent un transporteur local. |
| **Communication** | WhatsApp dominant. SMS courant. Email plus utilisé qu'en RDC (diaspora). |
| **Douane** | Direction Générale des Douanes. Processus plus prévisible qu'en RDC. Droits de douane calculés sur valeur CIF. |
| **Marché** | Forte diaspora gabonaise en France/Belgique → flux achats en ligne important. Pouvoir d'achat plus élevé qu'en RDC. |
| **Logistique** | Libreville relativement petite — livraisons faciles en ville. Difficultés pour les villes de l'intérieur (routes). |
| **Concurrence** | DHL, Chronopost présents mais chers. Marché de niche pour le forwarding d'achats en ligne. |

### 4.6 KPI de l'agence Gabon

| Indicateur | Description |
|------------|-------------|
| Colis arrivés/semaine | Volume entrant depuis Belgique |
| Colis livrés/jour | Nombre de livraisons effectuées |
| Délai livraison locale | Temps entre arrivée et livraison |
| Encaissements/jour | Total encaissé (XAF) |
| Envois sortants/mois | Volume expédié vers Belgique/monde |
| Colis en transit national | Colis vers Port-Gentil, Franceville, etc. |
| Délai dédouanement moyen | Temps de passage en douane |

---

## 5. MATRICE DES FLUX INTER-AGENCES

### 5.1 Flux entrants/sortants par agence

```
                     BELGIQUE
                    ┌────────┐
         Achats     │        │     Envois depuis
         en ligne ──►        ◄── Kinshasa/Gabon
                    │        │
                    │  HUB   │
                    │ EUROPE │
                    │        │──── Redistribution Europe
                    │        │
                    └───┬──┬─┘
                        │  │
          ┌─────────────┘  └──────────────┐
          │ Envois vers RDC               │ Envois vers Gabon
          ▼                               ▼
     ┌─────────┐                     ┌─────────┐
     │KINSHASA │                     │  GABON  │
     │         │                     │         │
     │ Distribu│                     │ Distribu│
     │ tion    │                     │ tion    │
     │ locale  │                     │ locale  │
     │         │──── Envois ────────►│         │
     │         │◄─── directs ────────│         │
     └─────────┘                     └─────────┘
```

### 5.2 Tableau des flux

| Origine | Destination | Type de flux | Volume estimé | Fréquence |
|---------|-------------|-------------|---------------|-----------|
| Vendeurs en ligne → Belgique | Colis achats en ligne | Entrant quotidien | Élevé | Quotidien |
| Belgique → Kinshasa | Colis clients RDC | Expédition groupée | Moyen-élevé | 2-3x/semaine |
| Belgique → Gabon | Colis clients Gabon | Expédition groupée | Moyen | 1-2x/semaine |
| Kinshasa → Belgique | Envois vers Europe/monde | Expédition groupée | Faible-moyen | 1x/semaine |
| Gabon → Belgique | Envois vers Europe/monde | Expédition groupée | Faible | 1-2x/mois |
| Kinshasa → Gabon | Colis directs | Ponctuel | Faible | Ponctuel |
| Gabon → Kinshasa | Colis directs | Ponctuel | Faible | Ponctuel |
| Belgique → Europe | Redistribution | Ponctuel | Faible | Ponctuel |

### 5.3 Modes de transport entre agences

| Route | Mode principal | Mode alternatif | Délai estimé |
|-------|---------------|----------------|-------------|
| Belgique → Kinshasa | Fret aérien | Fret maritime | 3-5 jours (aérien) / 4-6 semaines (maritime) |
| Belgique → Libreville | Fret aérien | Fret maritime | 3-5 jours (aérien) / 3-5 semaines (maritime) |
| Kinshasa → Belgique | Fret aérien | — | 3-5 jours |
| Libreville → Belgique | Fret aérien | — | 3-5 jours |
| Kinshasa → Libreville | Fret aérien | Route (transit via Brazzaville) | 1-2 jours (aérien) |

---

## 6. PROCESSUS DE PAIEMENT PAR AGENCE

### 6.1 Stratégie de paiement — Phase A (Preuves de paiement)

Le système de paiement fonctionne en deux temps :
1. Le client paie **en dehors de la plateforme** (Mobile Money, virement, cash)
2. Le client **charge la preuve** de son paiement sur la plateforme
3. L'employé/admin **vérifie et valide** la preuve

Ce mode est temporaire jusqu'à l'intégration d'un agrégateur de paiement automatisé (Phase B).

### 6.2 Coordonnées de paiement — Agence Kinshasa

| Mode | Opérateur | Nom du compte | Numéro | Devise |
|------|-----------|--------------|--------|--------|
| Mobile Money | M-Pesa (Vodacom) | Monrespro SARL | +243 XXX XXX XXX | USD |
| Mobile Money | Airtel Money | Monrespro SARL | +243 XXX XXX XXX | USD |
| Mobile Money | Orange Money | Monrespro SARL | +243 XXX XXX XXX | CDF |
| Virement | Banque XXX | Monrespro SARL | XXXX-XXXX-XXXX | USD |
| Cash | En agence | — | — | USD / CDF |

**Processus de vérification (Kinshasa) :**
1. L'employé reçoit la notification "Nouvelle preuve de paiement"
2. Il ouvre l'app Mobile Money correspondante (M-Pesa, Airtel, Orange)
3. Il vérifie dans l'historique : montant, expéditeur, date, référence
4. Si tout correspond → **Approuver** dans le système
5. Si problème → **Rejeter** avec motif (montant incorrect, référence introuvable, etc.)
6. Le client est notifié par WhatsApp dans les deux cas
7. **Délai maximum de vérification : 24h** (objectif : 2-4h en journée)

### 6.3 Coordonnées de paiement — Agence Gabon

| Mode | Opérateur | Nom du compte | Numéro | Devise |
|------|-----------|--------------|--------|--------|
| Mobile Money | Airtel Money | Monrespro Gabon | +241 XX XX XX XX | XAF |
| Mobile Money | Mobicash (Moov) | Monrespro Gabon | +241 XX XX XX XX | XAF |
| Virement | Banque XXX | Monrespro Gabon | XXXX-XXXX-XXXX | XAF |
| Cash | En agence | — | — | XAF |

**Processus de vérification identique à Kinshasa.**

### 6.4 Coordonnées de paiement — Agence Belgique

| Mode | Opérateur | Nom du compte | Numéro | Devise |
|------|-----------|--------------|--------|--------|
| Virement SEPA | Banque XXX | Monrespro SRL | BE00 0000 0000 0000 | EUR |
| PayPal | PayPal | monrespro@email.com | — | EUR |
| Stripe | Carte bancaire | — | — | EUR |
| Cash | En agence | — | — | EUR |

**Note :** En Belgique, les paiements Stripe et PayPal (existants dans DEPRIXA) restent actifs en parallèle du système de preuves. Les clients européens utilisent principalement la carte bancaire ou le virement SEPA.

### 6.5 Types de preuves acceptées

| Type de preuve | Description | Exemple |
|---------------|-------------|---------|
| **Screenshot Mobile Money** | Capture d'écran du message de confirmation du transfert | Message SMS "Vous avez envoyé 45 USD à..." |
| **Reçu de transaction** | Reçu imprimé par l'agent Mobile Money | Ticket de caisse avec référence |
| **Bordereau de virement** | Preuve de virement bancaire | Bordereau tamponné par la banque |
| **Reçu Western Union / MoneyGram** | Preuve d'envoi d'argent | Reçu avec MTCN |
| **Capture d'écran application bancaire** | Preuve de virement depuis l'app mobile | Confirmation de transfert |
| **Photo du reçu en agence** | Pour les paiements cash en agence | Reçu signé par l'agent |

### 6.6 Flux quotidien — Vérification des preuves

```
MATIN (priorité haute)
├─ Consulter la liste des preuves en attente
├─ Trier par date (les plus anciennes d'abord)
├─ Pour chaque preuve :
│   ├─ Ouvrir le détail
│   ├─ Vérifier sur l'app Mobile Money / relevé bancaire
│   ├─ Comparer montant, référence, date
│   ├─ Approuver ou rejeter
│   └─ Le client est notifié automatiquement
└─ Objectif : 0 preuve en attente de plus de 24h

APRES-MIDI
├─ Vérifier les nouvelles preuves arrivées
├─ Traiter les preuves resoumises (après rejet)
└─ Rapprocher les encaissements du jour
```

---

## 7. CONFIGURATION SYSTEME PAR AGENCE

### 7.1 Configuration à créer dans DEPRIXA PRO

#### Offices (Bureaux)

| Champ | Belgique | Kinshasa | Gabon |
|-------|----------|----------|-------|
| Nom | Monrespro Belgium | Monrespro Kinshasa | Monrespro Gabon |
| Adresse | [Adresse entrepôt] | [Adresse bureau] | [Adresse bureau] |
| Ville | Bruxelles | Kinshasa | Libreville |
| Pays | Belgique | RDC | Gabon |
| Téléphone | +32 XXX XX XX XX | +243 XXX XXX XXX | +241 XX XX XX XX |
| Email | belgium@monrespro.com | kinshasa@monrespro.com | gabon@monrespro.com |

#### Branch Offices (Agences)

Créer 3 agences dans `cdb_branchoffices`, chacune rattachée au bureau correspondant.

#### Casier virtuel (Virtual Locker)

Configurer l'adresse du casier virtuel pour la Belgique :
- Adresse physique de l'entrepôt en Belgique
- Format du numéro de casier : `MRP-[ID_CLIENT]`
- Ville, code postal

#### Devises par agence

| Agence | Devise affichée | Devises acceptées |
|--------|----------------|-------------------|
| Belgique | EUR | EUR, USD |
| Kinshasa | USD (référence) | USD, CDF |
| Gabon | XAF | XAF, EUR |

#### Tarifs d'expédition

Configurer dans `cdb_shipping_fees` :

| Route | Mode | Prix/kg (estimatif) |
|-------|------|-----------|
| Belgique → Kinshasa (aérien) | Express | 15-25 EUR/kg |
| Belgique → Kinshasa (maritime) | Économique | 5-8 EUR/kg |
| Belgique → Libreville (aérien) | Express | 15-25 EUR/kg |
| Belgique → Libreville (maritime) | Économique | 5-8 EUR/kg |
| Kinshasa → Belgique | Standard | 20-30 USD/kg |
| Gabon → Belgique | Standard | 15-25 EUR/kg |
| Livraison locale Kinshasa | Standard | 5-10 USD |
| Livraison locale Libreville | Standard | 3 000-5 000 XAF |

#### Statuts de suivi par agence

| Statut | Belgique | Kinshasa | Gabon |
|--------|----------|----------|-------|
| Reçu à l'entrepôt | X | — | — |
| En cours de traitement | X | X | X |
| Consolidé | X | — | — |
| Expédié | X | X | X |
| En transit | X | X | X |
| Arrivé en douane | — | X | X |
| En cours de dédouanement | — | X | X |
| Dédouané | — | X | X |
| Prêt pour retrait/livraison | — | X | X |
| En cours de livraison | — | X | X |
| Livré | X | X | X |

---

## 8. RESSOURCES HUMAINES PAR AGENCE

### 8.1 Organigramme type

#### Agence Belgique (démarrage)

| Poste | Rôle système | Nombre | Responsabilités |
|-------|-------------|--------|-----------------|
| Responsable Hub | Admin (9) | 1 | Gestion globale, paramétrage, rapports |
| Opérateur entrepôt | Employé (2) | 1-2 | Réception, pesée, enregistrement colis |
| Opérateur consolidation | Employé (2) | 1 | Consolidation, préparation envois |

#### Agence Kinshasa (démarrage)

| Poste | Rôle système | Nombre | Responsabilités |
|-------|-------------|--------|-----------------|
| Responsable agence | Admin (9) ou Employé (2) | 1 | Gestion opérations Kinshasa |
| Agent d'accueil | Employé (2) | 1-2 | Accueil clients, encaissement, remise colis |
| Agent dédouanement | Employé (2) | 1 | Suivi douane, récupération colis |
| Chauffeur/livreur | Chauffeur (3) | 2-3 | Livraisons et pickups |

#### Agence Gabon (démarrage)

| Poste | Rôle système | Nombre | Responsabilités |
|-------|-------------|--------|-----------------|
| Responsable agence | Admin (9) ou Employé (2) | 1 | Gestion opérations Gabon |
| Agent polyvalent | Employé (2) | 1 | Accueil, enregistrement, encaissement |
| Chauffeur/livreur | Chauffeur (3) | 1-2 | Livraisons et pickups |

### 8.2 Matrice d'accès par poste

| Poste | Modules accessibles |
|-------|-------------------|
| **Responsable Hub (Admin)** | Tout : dashboard, colis, expéditions, consolidation, rapports, paiements, configuration, utilisateurs |
| **Opérateur entrepôt** | Online Shopping (enregistrement, pré-alertes), Expéditions (créer, lister), Tracking (mise à jour) |
| **Agent d'accueil** | Colis (lister), Paiements (encaisser), Expéditions (créer), Clients (consulter) |
| **Agent dédouanement** | Colis (lister, tracking), Expéditions (lister) |
| **Chauffeur/livreur** | Dashboard chauffeur, Pickups, Expéditions (les siennes), Colis (livrer) |

---

*Document généré le 12 mars 2026 — Monrespro Logistics*
