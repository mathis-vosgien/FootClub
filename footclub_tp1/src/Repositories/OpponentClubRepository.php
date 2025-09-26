<?php
// src/Repositories/OpponentClubRepository.php
namespace App\Repositories;
use App\Database\Connection;
use App\Entities\OpponentClub;

class OpponentClubRepository {
    public function all(): array {
        $stmt = Connection::get()->query('SELECT * FROM opponent_clubs ORDER BY name');
        return $stmt->fetchAll();
    }
    public function create(OpponentClub $c): int {
        $stmt = Connection::get()->prepare('INSERT INTO opponent_clubs(name,city,country) VALUES(?,?,?)');
        $stmt->execute([$c->name, $c->city, $c->country]);
        return (int)Connection::get()->lastInsertId();
    }
    public function delete(int $id): void {
        Connection::get()->prepare('DELETE FROM opponent_clubs WHERE id=?')->execute([$id]);
    }
}
