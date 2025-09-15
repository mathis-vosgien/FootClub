<?php
require_once 'classes/Joueur.php';
require_once 'classes/Equipe.php';
require_once 'classes/RoleJoueurEquipe.php';
require_once 'classes/ClubAdverse.php';
require_once 'classes/Match.php';
require_once 'classes/Staff.php';

$joueur1 = new Joueur("Dupont", "Lucas", new DateTime("2000-05-10"), "lucas.jpg");
$joueur2 = new Joueur("Martin", "Paul", new DateTime("1998-07-22"), "paul.jpg");

$equipeA = new Equipe("Les Lions");
$equipeA->ajouterJoueur($joueur1, "Attaquant");
$equipeA->ajouterJoueur($joueur2, "Milieu");

$adversaire = new ClubAdverse("Tigres FC", "Lyon", "France");
$match1 = new MatchFoot(new DateTime("2025-09-20"), "Paris", $equipeA, $adversaire, 3, 2);

$coach = new Staff("Durand", "Marc", "marc.jpg", "Entraîneur");

var_dump($joueur1, $equipeA, $match1, $coach);
?>
