# Taches.md

# Projet : Système de simulation d'un opérateur Mobile Money

**Framework :** CodeIgniter 4  
**Base de données :** SQLite  
**Version :** Livraison 1

---

# Répartition des travaux

## Étudiant 1 : Conception de la base de données et logique métier

### 1. Analyse des besoins

Travaux réalisés :

- Analyse du cahier des charges.
- Identification des fonctionnalités principales du système.
- Identification des différents acteurs :
  - Administrateur (Opérateur)
  - Client
- Définition des différentes opérations possibles :
  - Dépôt
  - Retrait
  - Transfert

---

### 2. Conception de la base de données

Création du fichier :

```
base.sql
```

Travaux réalisés :

- Conception du schéma relationnel.
- Définition des relations entre les différentes tables.
- Définition des clés primaires.
- Définition des clés étrangères.
- Ajout des contraintes d'intégrité référentielle.

---

### 3. Création des tables

Création des tables suivantes :

#### prefixes

Responsabilités :

- Stockage des préfixes autorisés.
- Validation des numéros de téléphone.

Colonnes :

- id_prefixe
- prefixe
- actif
- date_creation

---

#### administrateurs

Responsabilités :

- Gestion des administrateurs.
- Authentification de l'opérateur.

Colonnes :

- id_admin
- login
- mot_de_passe
- date_creation

---

#### types_operation

Responsabilités :

- Définition des différents types d'opérations.

Valeurs créées :

- DEPOT
- RETRAIT
- TRANSFERT

---

#### baremes_frais

Responsabilités :

- Définition des frais applicables.
- Gestion des intervalles de montants.
- Paramétrage des frais de retrait.
- Paramétrage des frais de transfert.

---

#### baremes_frais_historique

Responsabilités :

- Historisation automatique des anciens barèmes.
- Conservation des anciennes valeurs.
- Traçabilité des modifications.

---

#### clients

Responsabilités :

- Stockage des numéros de téléphone.
- Identification des clients.

Aucune colonne "solde" n'est stockée conformément au cahier des charges.

---

#### operations

Responsabilités :

- Enregistrement des dépôts.
- Enregistrement des retraits.
- Enregistrement des transferts.
- Historique complet des opérations.

Les informations suivantes ne sont volontairement pas stockées :

- Solde avant
- Solde après
- Frais
- Statut

Ces informations sont calculées dynamiquement à l'aide des vues SQL.

---

### 4. Création des index

Ajout des index afin d'améliorer les performances :

- idx_operations_client
- idx_operations_destinataire
- idx_operations_type
- idx_baremes_type

---

### 5. Création des triggers

Création du trigger :

trg_archive_bareme_update

Fonction :

- Archivage automatique d'un ancien barème avant modification.

Création du trigger :

trg_archive_bareme_delete

Fonction :

- Archivage automatique d'un ancien barème avant suppression.

---

### 6. Création des vues SQL

Création de la vue :

v_operations_frais

Responsabilités :

- Calcul automatique des frais.
- Recherche des anciens barèmes si nécessaire.
- Application automatique du bon barème.

---

Création de la vue :

v_mouvements

Responsabilités :

- Transformation des opérations en mouvements financiers.
- Débit automatique des retraits.
- Débit automatique des transferts.
- Crédit automatique des dépôts.
- Crédit automatique des transferts reçus.

---

Création de la vue :

v_solde_clients

Responsabilités :

- Calcul automatique du solde.
- Suppression du besoin de stocker le solde.

---

Création de la vue :

v_historique_client

Responsabilités :

- Génération de l'historique complet.
- Calcul automatique du solde après chaque opération.

---

Création de la vue :

v_gains_operateur

Responsabilités :

- Calcul automatique des gains de l'opérateur.
- Calcul des frais encaissés.
- Nombre d'opérations par type.

---

### 7. Initialisation des données

Insertion des données de base :

- Préfixes autorisés.
- Administrateur.
- Types d'opérations.
- Barèmes de frais.
- Clients de démonstration.

---

### 8. Tests de la base de données

Tests réalisés :

- Vérification des clés étrangères.
- Vérification des vues.
- Vérification des triggers.
- Vérification des calculs de frais.
- Vérification des calculs de solde.
- Vérification des historiques.
- Vérification des gains opérateur.
---

# Étudiant 2 : Développement de l'application CodeIgniter 4

## 1. Initialisation et configuration du projet

### Création du projet CodeIgniter 4

Travaux réalisés :

- Création de l'application CodeIgniter 4.
- Organisation de l'architecture MVC :
  - Controllers
  - Models
  - Views
  - Config

---

### Configuration de la base de données

Fichier modifié :

```
app/Config/Database.php
```

Travaux réalisés :

- Configuration de la connexion avec SQLite.
- Définition du driver SQLite3.
- Configuration du chemin vers la base de données.
- Vérification de la connexion entre CodeIgniter et SQLite.

---

### Configuration des routes

Fichier modifié :

```
app/Config/Routes.php
```

Travaux réalisés :

- Définition des routes principales de l'application.
- Association des URLs aux contrôleurs correspondants.

Routes ajoutées :

- `/login`
- `/logout`
- `/client/dashboard`
- `/depot`
- `/depot/save`
- `/retrait`
- `/retrait/save`
- `/transfert`
- `/transfert/save`

---

# Partie Client

## 2. Authentification client

### Fichiers concernés :

```
app/Controllers/AuthController.php
app/Models/ClientModel.php
app/Models/PrefixModel.php
app/Views/auth/login.php
```

---

## Création de la page de connexion

Fichier :

```
app/Views/auth/login.php
```

Travaux réalisés :

- Création du formulaire de connexion.
- Ajout du champ numéro de téléphone.
- Ajout des messages d'erreur.
- Ajout du bouton de connexion.

---

## Développement du contrôleur d'authentification

Fichier :

```
app/Controllers/AuthController.php
```

Travaux réalisés :

- Récupération du numéro saisi par le client.
- Vérification que le numéro contient 10 chiffres.
- Vérification du préfixe autorisé.
- Recherche du client dans la base.
- Création automatique d'un client si le numéro n'existe pas.
- Création de la session utilisateur.

Informations stockées dans la session :

- id_client
- numéro de téléphone
- état de connexion

---

## Gestion des clients

Fichier :

```
app/Models/ClientModel.php
```

Travaux réalisés :

- Création du modèle client.
- Configuration de la table `clients`.
- Ajout de la méthode de recherche par numéro :
  - `findByNumero()`

---

## Gestion des préfixes

Fichier :

```
app/Models/PrefixModel.php
```

Travaux réalisés :

- Création du modèle des préfixes.
- Vérification automatique des préfixes autorisés.
- Validation des numéros avant création d'un client.

---

# 3. Tableau de bord client

### Fichiers concernés :

```
app/Controllers/ClientController.php
app/Views/client/dashboard.php
```

---

## Développement du contrôleur client

Fichier :

```
app/Controllers/ClientController.php
```

Travaux réalisés :

- Vérification de la connexion du client.
- Récupération de l'identifiant client depuis la session.
- Récupération du solde depuis la vue SQL :
  - `v_solde_clients`
- Récupération de l'historique depuis :
  - `v_historique_client`

---

## Création de l'interface tableau de bord

Fichier :

```
app/Views/client/dashboard.php
```

Travaux réalisés :

- Affichage du numéro du client connecté.
- Affichage du solde actuel.
- Affichage des dernières opérations.
- Affichage du solde après chaque opération.
- Ajout des boutons :
  - Dépôt
  - Retrait
  - Transfert
  - Déconnexion

---

# 4. Fonctionnalité Dépôt

## Objectif

Permettre au client d'ajouter de l'argent dans son compte Mobile Money.

---

### Fichiers modifiés :

```
app/Controllers/OperationController.php

app/Models/OperationModel.php

app/Views/client/depot.php

app/Config/Routes.php
```

---

## Création du formulaire de dépôt

Fichier :

```
app/Views/client/depot.php
```

Travaux réalisés :

- Création du champ montant.
- Création du bouton de validation.
- Gestion des messages d'erreur.
- Gestion du message de succès.

---

## Développement du traitement du dépôt

Fichier :

```
app/Controllers/OperationController.php
```

Travaux réalisés :

- Vérification de la connexion.
- Récupération du montant.
- Vérification que le montant est positif.
- Insertion d'une nouvelle opération.
- Utilisation du type d'opération DEPOT.

Insertion réalisée dans :

```
operations
```

Avec :

- id_client
- id_type_operation = DEPOT
- montant

---

## Tests réalisés

- Dépôt avec un montant valide.
- Dépôt avec un montant nul.
- Vérification de la mise à jour automatique du solde.
- Vérification de l'apparition dans l'historique.


---

# 5. Fonctionnalité Retrait

## Objectif

Permettre à un client de retirer de l'argent depuis son compte Mobile Money.

Le retrait est considéré comme automatique :
- aucune validation par un opérateur n'est nécessaire ;
- l'opération est enregistrée directement dans la table `operations` ;
- les frais sont calculés automatiquement grâce aux vues SQL.

---

## Fichiers concernés :

```
app/Controllers/OperationController.php

app/Models/OperationModel.php

app/Views/client/retrait.php

app/Config/Routes.php
```

---

## Création de la page de retrait

Fichier :

```
app/Views/client/retrait.php
```

Travaux réalisés :

- Création du formulaire de retrait.
- Ajout du champ de saisie du montant.
- Ajout du bouton de validation.
- Ajout des messages d'erreur et de succès.
- Ajout du bouton de retour vers le tableau de bord.

---

## Développement du traitement du retrait

Fichier :

```
app/Controllers/OperationController.php
```

Travaux réalisés :

- Création de la méthode d'affichage du formulaire de retrait.
- Création de la méthode de traitement du retrait.
- Récupération du client connecté.
- Récupération du montant demandé.
- Vérification de la validité du montant.
- Récupération du solde actuel depuis :

```
v_solde_clients
```

- Vérification que le client possède un solde suffisant.
- Création d'une opération de type :

```
RETRAIT
```

dans la table :

```
operations
```

---

## Gestion automatique du solde

Aucune modification directe du solde n'est effectuée.

Le nouveau solde est recalculé automatiquement grâce aux vues :

```
v_mouvements
v_solde_clients
```

Le retrait prend en compte :

- le montant retiré ;
- les frais associés au retrait.

---

## Tests réalisés

- Retrait avec un solde suffisant.
- Retrait avec un solde insuffisant.
- Vérification de l'ajout dans la table `operations`.
- Vérification de la diminution automatique du solde.
- Vérification de l'affichage dans l'historique.


---

# 6. Fonctionnalité Transfert

## Objectif

Permettre à un client d'envoyer de l'argent à un autre client Mobile Money.

Le transfert implique deux clients :

- client émetteur ;
- client destinataire.

---

## Fichiers concernés :

```
app/Controllers/OperationController.php

app/Models/ClientModel.php

app/Models/OperationModel.php

app/Views/client/transfert.php

app/Config/Routes.php
```

---

# Création de l'interface de transfert

Fichier :

```
app/Views/client/transfert.php
```

Travaux réalisés :

- Création du formulaire de transfert.
- Ajout du champ numéro du destinataire.
- Ajout du champ montant.
- Ajout du bouton de confirmation.
- Ajout du bouton retour vers le tableau de bord.

---

# Développement du transfert

Fichier :

```
app/Controllers/OperationController.php
```

Travaux réalisés :

- Création de la méthode d'affichage du formulaire.
- Création de la méthode de traitement du transfert.
- Récupération du client connecté.
- Récupération du numéro du destinataire.
- Recherche du destinataire dans la table :

```
clients
```

- Vérification que le destinataire existe.
- Vérification que le client ne peut pas se transférer de l'argent à lui-même.
- Récupération du solde du client émetteur.
- Vérification du solde disponible.
- Vérification des frais de transfert selon les barèmes.

---

## Enregistrement du transfert

Une seule opération est enregistrée dans :

```
operations
```

avec :

- id_client = expéditeur
- id_client_destinataire = destinataire
- id_type_operation = TRANSFERT
- montant

---

## Gestion automatique du transfert

Les vues SQL prennent en charge automatiquement :

### Pour l'expéditeur :

Déduction :

```
montant + frais
```

### Pour le destinataire :

Ajout :

```
montant envoyé
```

Les calculs sont réalisés dans :

```
v_mouvements
v_solde_clients
```

---

## Tests réalisés

- Transfert vers un client existant.
- Transfert vers un numéro inexistant.
- Transfert vers son propre numéro.
- Transfert avec solde insuffisant.
- Vérification de la réception chez le destinataire.
- Vérification de la diminution chez l'expéditeur.
- Vérification de l'apparition dans l'historique.


---

# 7. Fonctionnalité Consultation historique

## Objectif

Permettre au client de consulter toutes ses opérations réalisées.

Les informations affichées sont :

- Date de l'opération.
- Type d'opération.
- Montant.
- Solde après opération.

---

## Fichiers concernés :

```
app/Controllers/ClientController.php

app/Models/ClientModel.php

app/Views/client/dashboard.php
```

---

## Récupération des historiques

Fichier :

```
app/Controllers/ClientController.php
```

Travaux réalisés :

- Récupération de l'identifiant du client connecté.
- Consultation de la vue SQL :

```
v_historique_client
```

- Récupération des dernières opérations.
- Transmission des données vers la vue.

---

## Affichage de l'historique

Fichier :

```
app/Views/client/dashboard.php
```

Travaux réalisés :

- Création du tableau historique.
- Affichage des colonnes :

  - Date
  - Opération
  - Montant
  - Solde après

- Gestion du cas où aucune opération n'existe.

---

# 8. Partie opérateur (préparation)

## Objectif

Permettre à l'opérateur Mobile Money de gérer le système.

Fonctionnalités prévues :

- Gestion des préfixes.
- Gestion des barèmes de frais.
- Consultation des gains.
- Suivi des opérations.

---

## Base de données préparée

Tables utilisées :

```
administrateurs

prefixes

baremes_frais

baremes_frais_historique
```

Vues disponibles :

```
v_gains_operateur
```

---

## Fonctionnalités opérateur prévues pour les prochaines livraisons :

- Création de l'interface administrateur.
- Authentification opérateur.
- Gestion des préfixes.
- Modification des barèmes.
- Consultation des gains générés.
- Consultation des statistiques.