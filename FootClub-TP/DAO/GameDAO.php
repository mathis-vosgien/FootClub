<?php

class GameDAO {
    private \PDO $connexion;

    public function __construct(\PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function insert(Game $game): void {
        $stmt = $this->connexion->prepare("
            INSERT INTO matches (team_score, opponent_score, date, city, team_id, opposing_club_id)
            VALUES (:team_score, :opponent_score, :date, :city, :team_id, :opposing_club_id)
        ");
        $stmt->execute([
            ":team_score" => $game->getTeamScore(),
            ":opponent_score" => $game->getOpponentScore(),
            ":date" => $game->getDate()->format("Y-m-d H:i:s"),
            ":city" => $game->getCity(),
            ":team_id" => $game->getTeam()->getId(),
            ":opposing_club_id" => $game->getOpposingClub()->getId()
        ]);
    }

    public function findAll(): array {
        $stmt = $this->connexion->query("SELECT * FROM matches");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
