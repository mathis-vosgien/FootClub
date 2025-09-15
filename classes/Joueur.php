<?php
class Joueur {
    private string $nom;
    private string $prenom;
    private DateTime $dateNaissance;
    private string $photo;

    public function __construct($nom, $prenom, DateTime $dateNaissance, $photo) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->photo = $photo;
    }

    // Getters / setters …
}
