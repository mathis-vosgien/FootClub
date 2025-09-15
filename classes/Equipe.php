<?php
require_once 'RoleJoueurEquipe.php';
class Equipe {
    private string $nom;
    private array $rolesJoueurs = [];

    public function __construct($nom) {
        $this->nom = $nom;
    }

    public function ajouterJoueur(Joueur $joueur, string $role) {
        $this->rolesJoueurs[] = new RoleJoueurEquipe($joueur, $this, $role);
    }
}
