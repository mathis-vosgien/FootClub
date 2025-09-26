<?php
// src/Repositories/PlayerRepository.php
namespace App\Repositories;
use App\Database\Connection;
use App\Entities\Player;
use PDO;

class PlayerRepository {
    public function all(): array {
        $stmt = Connection::get()->query('SELECT * FROM players ORDER BY last_name, first_name');
        return $stmt->fetchAll();
    }
    public function find(int $id): ?array {
        $stmt = Connection::get()->prepare('SELECT * FROM players WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
    public function create(Player $p): int {
        $stmt = Connection::get()->prepare('INSERT INTO players(first_name,last_name,birthdate,photo) VALUES(?,?,?,?)');
        $stmt->execute([$p->first_name, $p->last_name, $p->birthdate, $p->photo]);
        return (int)Connection::get()->lastInsertId();
    }
    public function update(int $id, Player $p): void {
        $stmt = Connection::get()->prepare('UPDATE players SET first_name=?, last_name=?, birthdate=?, photo=? WHERE id=?');
        $stmt->execute([$p->first_name, $p->last_name, $p->birthdate, $p->photo, $id]);
    }
    public function delete(int $id): void {
        $stmt = Connection::get()->prepare('DELETE FROM players WHERE id=?');
        $stmt->execute([$id]);
    }
}
