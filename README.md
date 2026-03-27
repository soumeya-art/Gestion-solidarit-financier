
#  Projet : Système de Gestion de Solidarité Financière

##  Description

Ce projet est une application web développée avec le framework **Laravel** permettant de gérer une **solidarité financière** entre les membres d’une organisation.

Le système facilite :

* L’enregistrement des membres
* La gestion des cotisations
* Le suivi des paiements
* La gestion des demandes d’aide financière
* La validation des opérations

---

##  Objectifs

* Simplifier la gestion des contributions financières
* Assurer la transparence des transactions
* Automatiser les processus (paiement, validation, historique)
* Offrir une interface claire pour les utilisateurs

---

##  Technologies utilisées

* **Backend** : PHP (Laravel)
* **Frontend** : Blade, Tailwind CSS
* **Base de données** : MySQL
* **Outils** :

  * Composer
  * Node.js / NPM
  * Vite

---

##  Structure du projet

* `app/` : Contient la logique métier (modèles, contrôleurs)
* `bootstrap/` : Initialisation de l’application
* `config/` : Fichiers de configuration
* `database/` : Migrations et seeders
* `public/` : Fichiers accessibles (index.php)
* `resources/` : Vues (Blade), CSS, JS
* `routes/` : Définition des routes
* `storage/` : Fichiers temporaires
* `tests/` : Tests unitaires
* `vendor/` : Dépendances Composer

---

##  Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Gestion-solidarit-financier.git
cd votre-projet
```

### 2. Installer les dépendances

```bash
composer install
npm install
```

### 3. Configurer l’environnement

```bash
cp .env.example .env
php artisan key:generate
```

Configurer la base de données dans `.env`

---

### 4. Migration de la base de données

```bash
php artisan migrate
```

---

### 5. Lancer le serveur

```bash
php artisan serve
```

Puis ouvrir :
 http://127.0.0.1:8000

---

##  Fonctionnalités principales

*  Gestion des membres
*  Gestion des cotisations
*  Historique des paiements
*  Demande d’aide financière
*  Validation des demandes
*  Authentification des utilisateurs

---

## Diagrammes (dans le rapport)

* Diagramme de cas d’utilisation
* Diagramme de classes
* Diagramme de séquence
* Diagramme d’activité

---

##  Auteur

* Nom Des membres :
  -Moutaha Issa Aden
  -Rahma Guirreh
  -Rahma hamoud
  -Oumalkhaire Hamid 
* Projet académique

---

##  Remarque

Ce projet a été réalisé dans un cadre académique pour démontrer la conception et le développement d’un système de gestion complet.

