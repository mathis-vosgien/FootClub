<?php
// sql/seed.php — run via CLI: php sql/seed.php
require __DIR__ . '/../public/index.php'; // bootstraps autoload + config + db

use App\Database\Connection;

$pdo = App\Database\Connection::get();

$pdo->exec(file_get_contents(__DIR__ . '/schema.sql'));

$pdo->exec("INSERT INTO players(first_name,last_name,birthdate) VALUES
 ('Kylian','Mbappé','1998-12-20'),
 ('Antoine','Griezmann','1991-03-21'),
 ('N''Golo','Kanté','1991-03-29')
");

$pdo->exec("INSERT INTO teams(name,category) VALUES
 ('Seniors A','Seniors'),
 ('U18 Elite','U18')
");

$pdo->exec("INSERT INTO opponent_clubs(name,city,country) VALUES
 ('AS Rivaux','Lyon','France'),
 ('FC Voisins','Marseille','France')
");

$pdo->exec("INSERT INTO staff(first_name,last_name,role) VALUES
 ('Didier','Deschamps','Coach'),
 ('Franck','Rossi','Kiné')
");

$pdo->exec("INSERT INTO matches(team_id, opponent_club_id, city, match_date, home_score, away_score) VALUES
 (1,1,'Paris','2025-08-31',3,1),
 (2,2,'Marseille','2025-09-10',1,1)
");

$pdo->exec("INSERT INTO team_players(team_id, player_id, role) VALUES
 (1,1,'attaquant'), (1,2,'milieu'), (1,3,'milieu'),
 (2,2,'attaquant')
");

echo "Base de données initialisée avec des données d'exemple.\n";
