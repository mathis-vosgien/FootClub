# FootClub — TP 1 (PHP POO)

Ce projet répond au TP : modélisation en POO, base MySQL et interface graphique minimale.

## Prérequis
- PHP >= 8.1 avec extensions PDO et pdo_mysql
- MySQL/MariaDB
- Serveur web (Apache/Nginx) ou `php -S localhost:8000 -t public`

## Installation
1. Créez la base :
   ```sql
   CREATE DATABASE footclub CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```
2. Configurez `config/config.php` (si besoin).
3. Chargez le schéma et les données de test :
   ```bash
   php sql/seed.php
   ```

## Lancer l'appli
Depuis le dossier `footclub` :
```bash
php -S localhost:8000 -t public
```
Ensuite ouvrez http://localhost:8000

## Fonctionnalités
- CRUD simplifié : joueurs, équipes, clubs adverses, staff, matchs
- Relation plusieurs-à-plusieurs joueur⇄équipe avec rôle par équipe
- Upload de photos (stockées dans `public/uploads`)

## Sécurité et limites (à améliorer si vous le souhaitez)
- Validation basique des champs
- Pas d’authentification
- Pas de pagination
- Pas de tests unitaires

> Structure inspirée du TP "FootClub - Partie 1" fourni.
