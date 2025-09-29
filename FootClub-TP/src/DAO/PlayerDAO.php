<?php

namespace DAO;

use Model\Player; 

class PlayerDAO {
    private \PDO $connexion;

    public function __construct(\PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function insert(Player $player): void {
        $stmt = $this->connexion->prepare("
            INSERT INTO player (firstname, lastname, birthdate, picture)
            VALUES (:firstname, :lastname, :birthdate, :picture)
        ");
        $stmt->execute([
            ":firstname" => $player->getFirstname(),
            ":lastname" => $player->getLastname(),
            ":birthdate" => $player->getBirthdate()->format("Y-m-d"),
            ":picture" => $player->getPicture()
        ]);
    }

    public function getAll(): array {
        $stmt = $this->connexion->query("SELECT * FROM player");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
