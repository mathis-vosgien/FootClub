<?php

namespace DAO;

use Model\PlayerHasTeam; 

class PlayerHasTeamDAO {
    private \PDO $connexion;

    public function __construct(\PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function insert(PlayerHasTeam $relation): void {
        $stmt = $this->connexion->prepare("
            INSERT INTO player_has_team (player_id, team_id, role)
            VALUES (:player_id, :team_id, :role)
        ");
        $stmt->execute([
            ":player_id" => $relation->getPlayer()->getId(),
            ":team_id" => $relation->getTeamId()->getId(),
            ":role" => $relation->getRole()
        ]);
    }

    public function getAll(): array {
        $stmt = $this->connexion->query("SELECT * FROM player_has_team");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
