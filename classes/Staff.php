<?php
class Staff {
    private string $nom;
    private string $prenom;
    private string $photo;
    private string $roleClub;

    public function __construct($nom, $prenom, $photo, $roleClub) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->photo = $photo;
        $this->roleClub = $roleClub;
    }
}
