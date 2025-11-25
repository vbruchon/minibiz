# MiniBiz — ERP Freelance

Un ERP simple, rapide et moderne conçu pour les freelances français.  
Gérez vos devis, factures, clients et produits — avec des options avancées sur les produits pour offrir des workflows plus flexibles, complets et modernes.

> 📄 Vous cherchez une autre version ?

-   🇬🇧 Lire le **README anglais** : [`README.md`](./README.md)

## Introduction

**MiniBiz** est un ERP léger mais puissant conçu spécialement pour les freelances.  
Il offre tous les outils essentiels pour gérer l’activité au quotidien : clients, produits, devis, factures, ainsi que des options avancées sur les produits pour créer des offres plus modernes, détaillées et modulaires.

### À qui ça s’adresse ?

MiniBiz s’adresse aux **freelances**, **indépendants** et **auto-entrepreneurs** qui recherchent une alternative simple, rapide et auto-hébergeable aux solutions trop lourdes ou trop limitées.

### Quels problèmes ça résout ?

Les freelances rencontrent souvent des outils :

-   trop limités,
-   trop chers,
-   trop complexes,
-   ou pas assez personnalisables.

MiniBiz apporte une solution grâce à :

-   une interface moderne et claire,
-   un flux de facturation structuré (devis → facture),
-   des options produits avancées,
-   un contrôle total sur vos données,
-   un code simple à étendre selon vos besoins.

### Stack principale

#### Backend

-   **PHP 8.2+**
-   **Laravel 12**
-   **Blade Components**
-   **Spatie Browsershot** (génération PDF via Chrome headless)
-   **SQLite** ou **MySQL**

#### Frontend

-   **TailwindCSS v4**
-   **Vite**
-   **Blade Heroicons** (blade-ui-kit/blade-heroicons)

## Installation

### 1. Cloner le dépôt

(backtick)bash  
git clone https://github.com/votre-nom/minibiz.git  
cd minibiz  
(backtick)

### 2. Installer les dépendances backend

(backtick)bash  
composer install  
(backtick)

### 3. Installer les dépendances frontend

(backtick)bash  
npm install

# ou

pnpm install  
(backtick)

### 4. Configurer l'environnement

(backtick)bash  
cp .env.example .env  
(backtick)

Générer la clé de l'application :
(backtick)bash  
php artisan key:generate  
(backtick)

### 5. Configurer la base de données (MySQL)

MiniBiz utilise **MySQL** par défaut.

1. Créez une base de données MySQL (via votre client ou en ligne de commande), par exemple :
   (backtick)sql  
   CREATE DATABASE minibiz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;  
   (backtick)

2. Mettez à jour la section base de données dans votre fichier `.env` :
   (backtick)env  
   DB_CONNECTION=mysql  
   DB_HOST=127.0.0.1  
   DB_PORT=3306  
   DB_DATABASE=minibiz  
   DB_USERNAME=votre_utilisateur_mysql  
   DB_PASSWORD=votre_mot_de_passe  
   (backtick)

Si vous souhaitez utiliser un autre système (SQLite, PostgreSQL, etc.), référez-vous à la documentation officielle Laravel :  
https://laravel.com/docs/database

### 6. Lancer les migrations

(backtick)bash  
php artisan migrate  
(backtick)

### 7. Démarrer les serveurs de développement

#### Option A — Classique

(backtick)bash  
php artisan serve  
npm run dev  
(backtick)

#### Option B — Tout-en-un (recommandé)

(backtick)bash  
composer dev  
(backtick)

Vous pouvez maintenant accéder à l'application :  
👉 http://localhost:8000

## Fonctionnalités

MiniBiz propose un ensemble d’outils complet mais léger, spécialement conçu pour les freelances.  
L’objectif : offrir un ERP simple, moderne et flexible, sans la complexité des solutions professionnelles traditionnelles.

### 🔹 Devis & Factures

-   Création de **devis** et **factures**
-   Workflow fluide : **conversion** d’un devis en facture
-   Gestion complète des **statuts** (brouillon, envoyé, accepté, rejeté, converti, payé, en retard…)
-   Génération automatique des numéros de documents

### 🔹 Options Produits Avancées

Créez des offres plus riches et plus modernes grâce aux options produit :

-   **Cases à cocher**
-   **Choix unique**
-   **Options numériques (quantité, valeurs personnalisées)**
-   Les options apparaissent sur les devis/factures et mettent à jour les totaux automatiquement

Idéal pour des prestations détaillées, des packs ou des offres sur mesure.

### 🔹 Gestion des Clients

-   Création & gestion des fiches clients
-   Accès rapide à tous leurs devis et factures
-   Activité récente du client (documents, statuts, etc.)

### 🔹 Produits & Services

-   Catalogue de produits et services
-   Ajout d’options liées à chaque produit
-   Gestion automatique des prix dans la facturation

### 🔹 Export PDF

-   Export PDF propre et professionnel
-   Basé sur **Spatie Browsershot** (Chrome headless)
-   Mise en page complète : logo, totaux, TVA, options, structure…

### 🔹 Paramètres Entreprise

-   Informations légales (SIREN, SIRET, APE/NAF…)
-   Téléversement du logo
-   Configuration de la TVA, des délais de paiement, des mentions légales

### 🔹 Auto-hébergeable et Extensible

-   Vous gardez 100% du contrôle
-   Code simple à personnaliser (Laravel)
-   Fonctionne très bien en local (SQLite ou MySQL)

MiniBiz reste volontairement simple, rapide et parfaitement adapté aux besoins d’un freelance.

## Aperçus

Voici quelques captures d’écran de l’interface de MiniBiz.

### 📊 Tableau de bord

![Tableau de bord](./docs/screenshot/dashboard.png)

### 🧾 Liste des devis et factures

![Liste des documents](./docs/screenshot/bills-list.png)

### 💼 Vue d’un devis ou d’une facture

![Vue d’un document](./docs/screenshot/bill-show.png)

### 🧾 Création d’un devis

![Création d’un devis](./docs/screenshot/create-quote.png)

### 🧩 Options produits

![Options produits](./docs/screenshot/product-options.png)

### 👤 Détails d’un client

![Détails d’un client](./docs/screenshot/customer-detail.png)

### 📝 Paramètres de l’entreprise

![Paramètres entreprise](./docs/screenshot/company-settings.png)

## Exemple d’utilisation

MiniBiz est pensé pour simplifier le quotidien d’un freelance.  
Voici le workflow habituel :

### 1. Créer un client

Ajoutez un nouveau client avec ses informations, coordonnées et données d’entreprise.

### 2. Créer des produits et options

Définissez vos services/produits et attachez des options avancées  
(cases à cocher, choix unique, valeurs numériques) pour créer des offres flexibles.

### 3. Créer un devis

Générez un devis professionnel :

-   ajoutez des lignes,
-   sélectionnez des options produit,
-   les totaux se calculent automatiquement.

### 4. Envoyer le devis

Lorsque le devis est prêt, il suffit de **télécharger le PDF**.  
MiniBiz met automatiquement son statut à **envoyé**.

### 5. Convertir le devis → facture

Lorsque le client vous confirme le devis, convertissez-le en facture.

Le devis passe automatiquement au statut **accepté**.  
Choisissez ensuite le **mode de paiement** souhaité.

Une fois la facture finalisée, **téléchargez le PDF** pour l’envoyer au client :  
le document passera automatiquement en statut **envoyé**.

### 6. Exporter le PDF

Générez un PDF propre et clair grâce au moteur Browsershot.

### 7. Gérer les statuts

Suivez l’avancement de vos documents :

-   brouillon
-   envoyé
-   accepté
-   rejeté
-   converti
-   payé
-   en retard

MiniBiz offre une expérience de facturation moderne, fluide et rapide pour les freelances.

## Licence

MiniBiz est distribué sous licence **MIT**.  
Vous êtes libre de l’utiliser, le modifier ou l’adapter selon vos besoins.

## À propos

MiniBiz a été créé comme outil personnel pour gérer ma propre activité de freelance.  
Il fait également partie de mon portfolio développeur et démontre un projet Laravel/Tailwind complet et utilisé en conditions réelles.

Quelques collègues et freelances l’utilisent aussi au quotidien.

## Améliorations envisagées

Voici les améliorations prévues pour les futures versions de MiniBiz :

### 🔹 Importation des devis signés

Permettre d’**importer un devis signé** (PDF ou image) afin de remplacer le statut “accepté”.  
Cela permet au freelance de conserver une preuve officielle directement attachée au devis.
