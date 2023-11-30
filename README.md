# Projet de site vitrine et back office pour une Maison Médicale.

## Le besoin

La SCI Pasteur-Santes gérée par plusieurs praticiens de santé a pour projet
d’ouvrir une maison médicale à Santes en Mars 2024.

Les représentants de la SCI ont exprimé leur souhait d’être présents sur le
web afin de communiquer et faciliter la prise de rendez-vous, c’est pourquoi ils nous
ont confié la fabrication de leur interface web.

Il a été convenu de la livraison d’une interface qui regroupe à la fois une page
d’accueil destinée au public et un back office destiné au personnel pour gérer le
contenu de l’accueil.

## Technologies utilisées
	Nous avons développé cette application en php grâce au framework Symfony
accompagné du moteur de templates TWIG et du WebPack-Encore pour compiler et
minifier le SCSS et le JavaScript.

## Prérequis

- Linux, Mac OS ou Windows
- Bash
- PHP 8
- Composer
- Symfony-cli
* MariaDB 10

## Installation

```
git clone https://github.com/SegoleneH/symfony_1
cd symfony
composer install
```

Puis créez une base de données & un utilisateur dédié pour cette base de données.

## Configuration

Créez un fichier `.env.local` à la racine du projet où figure le code suivant:

```
APP_ENV=dev
APP_DEBUG=true

APP_SECRET=123

DATABASE_URL="mysql://symfony:123@127.0.0.1:3306/symfony?serverVersion=mariadb-10.6.128&charset=utf8mb4"

```

Pensez à changer la variable `APP_SECRET` & les codes d'accès `123` dans la variable `DATABASE_URL`.

**ATTENTION : `APP_SECRET` doit être une chaîne de caractères de 32 caractères en hexadécimal**


## Migration & Fixtures

Pour que l'application soit utilisable, vous devez créer le schéma de la base de données & y charger des données :

```
bin/dofilo.sh
```


## Utilisation

Lancez le serveur web de développement

```
symfony serve
```

Puis ouvrez la page suivante : [https://localhost:8000](https://localhost:8000)
