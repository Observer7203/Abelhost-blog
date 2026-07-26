# Abelhost Blog

Blog on PHP, MySQL, Smarty.

## Stack

PHP 8.1+ MySQL 8 Smarty 5 scssphp Docker

## Structure

```bash
public/ - webroot (index.php + assets)
src/ - Router, Database, View, Controllers, Models
templates/ - Smarty .tpl
scss/ - SCSS
database/ - schema.sql + seed.php
bin/ - build-css.php
```

## Run

```bash
composer install
mysql -u <user> -p -e "CREATE DATABASE abelhost_blog CHARACTER SET utf8mb4;"
mysql -u <user> -p abelhost_blog < database/schema.sql
cp config.example.php config.php
php database/seed.php
php -S localhost:8000 -t public public/index.php
```

http://localhost:8000

Rebuild CSS: `php bin/build-css.php`

## Run with Docker

```bash
docker compose up -d --build
docker compose exec app php database/seed.php
```

http://localhost:8000

stop: `docker compose down` (`-v` to reset DB)
