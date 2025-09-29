<?php

namespace DAO;

use Model\Team; 

class TeamDAO {
    private \PDO $connexion;

    public function __construct(\PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function insert(Team $team): void {
        $stmt = $this->connexion->prepare("
            INSERT INTO team (name) VALUES (:name)
        ");
        $stmt->execute([":name" => $team->getName()]);
    }

    public function getAll(): array {
        $stmt = $this->connexion->query("SELECT * FROM team");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}