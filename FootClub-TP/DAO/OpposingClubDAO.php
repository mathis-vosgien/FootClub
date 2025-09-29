<?php
class OpposingClubDAO {
    private \PDO $connexion;

    public function __construct(\PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function insert(OpposingClub $club): void {
        $stmt = $this->connexion->prepare("
            INSERT INTO opposing_club (address, city) VALUES (:address, :city)
        ");
        $stmt->execute([
            ":address" => $club->getAddress(),
            ":city" => $club->getCity()
        ]);
    }

    public function getAll(): array {
        $stmt = $this->connexion->query("SELECT * FROM opposing_club");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
