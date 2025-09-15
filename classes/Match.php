<?php
class MatchFoot {
    private DateTime $date;
    private string $ville;
    private int $scoreEquipe;
    private int $scoreAdverse;
    private Equipe $equipe;
    private ClubAdverse $adversaire;

    public function __construct(DateTime $date, $ville, Equipe $equipe, ClubAdverse $adversaire, $scoreEquipe=0, $scoreAdverse=0) {
        $this->date = $date;
        $this->ville = $ville;
        $this->equipe = $equipe;
        $this->adversaire = $adversaire;
        $this->scoreEquipe = $scoreEquipe;
        $this->scoreAdverse = $scoreAdverse;
    }
}
