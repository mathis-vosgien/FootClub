<?php
class RoleJoueurEquipe {
    private Joueur $joueur;
    private Equipe $equipe;
    private string $role;

    public function __construct(Joueur $joueur, Equipe $equipe, string $role) {
        $this->joueur = $joueur;
        $this->equipe = $equipe;
        $this->role = $role;
    }
}
