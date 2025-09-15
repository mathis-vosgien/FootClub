<?php
class ClubAdverse {
    private string $nom;
    private string $ville;
    private string $pays;

    public function __construct($nom, $ville, $pays) {
        $this->nom  = $nom;
        $this->ville = $ville;
        $this->pays  = $pays;
    }
}
