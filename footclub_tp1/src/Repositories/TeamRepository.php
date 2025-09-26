<?php
// src/Repositories/TeamRepository.php
namespace App\Repositories;
use App\Database\Connection;
use App\Entities\Team;

class TeamRepository {
    public function all(): array {
        $stmt = Connection::get()->query('SELECT * FROM teams ORDER BY name');
        return $stmt->fetchAll();
    }
    public function find(int $id): ?array {
        $stmt = Connection::get()->prepare('SELECT * FROM teams WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
    public function create(Team $t): int {
        $stmt = Connection::get()->prepare('INSERT INTO teams(name,category) VALUES(?,?)');
        $stmt->execute([$t->name, $t->category]);
        return (int)Connection::get()->lastInsertId();
    }
    public function update(int $id, Team $t): void {
        $stmt = Connection::get()->prepare('UPDATE teams SET name=?, category=? WHERE id=?');
        $stmt->execute([$t->name, $t->category, $id]);
    }
    public function delete(int $id): void {
        Connection::get()->prepare('DELETE FROM teams WHERE id=?')->execute([$id]);
    }
}
