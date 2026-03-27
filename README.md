
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
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

