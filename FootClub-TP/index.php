<?php
include 'classes/Game.php';
include 'classes/OpposingClub.php';
include 'classes/Player.php';
include 'classes/PlayerHasTeam.php';
include 'classes/StaffMember.php';
include 'classes/Team.php';

include 'includes/db.php';

include 'DAO/GameDAO.php';
include 'DAO/PlayerDAO.php';
include 'DAO/PlayerHasTeamDAO.php';
include 'DAO/StaffMemberDAO.php';
include 'DAO/OpposingClubDAO.php';
include 'DAO/TeamDAO.php';

$teamDAO = new TeamDAO($connexion);
$opponentDAO = new OpposingClubDAO($connexion);
$playerDAO = new PlayerDAO($connexion);
$relationDAO = new PlayerHasTeamDAO($connexion);
$gameDAO = new GameDAO($connexion);

// --- 1. Insérer une équipe ---
$team = new Team(null, "Equipe A");
$teamDAO->insert($team);
$team->setId($connexion->lastInsertId());

// --- 2. Insérer un club adverse ---
$opponent = new OpposingClub(null, "123 rue du Stade", "Paris");
$opponentDAO->insert($opponent);
$opponent->setId($connexion->lastInsertId());

// --- 3. Insérer un joueur ---
$player = new Player(null, "Kylian", "Mbappé", new DateTime("1998-12-20"), "mbappe.png");
$playerDAO->insert($player);
$player->setId($connexion->lastInsertId());

// --- 4. Créer la relation joueur-équipe ---
$relation = new PlayerHasTeam($player, $team, "Attaquant");
$relationDAO->insert($relation);
$player->addTeam($relation);

// --- 5. Insérer un match ---
$match = new Game(null, new DateTime("2023-09-15 18:00:00"), "Lyon", 3, 2, $team, $opponent);
$gameDAO->insert($match);
$match->setId($connexion->lastInsertId());

// --- 6. Afficher ---
echo $player->getFirstname() . " joue comme " . $relation->getRole() . " dans " . $team->getName();
