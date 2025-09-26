<?php
// src/Repositories/StaffRepository.php
namespace App\Repositories;
use App\Database\Connection;
use App\Entities\Staff;

class StaffRepository {
    public function all(): array {
        $stmt = Connection::get()->query('SELECT * FROM staff ORDER BY last_name, first_name');
        return $stmt->fetchAll();
    }
    public function create(Staff $s): int {
        $stmt = Connection::get()->prepare('INSERT INTO staff(first_name,last_name,role,photo) VALUES(?,?,?,?)');
        $stmt->execute([$s->first_name, $s->last_name, $s->role, $s->photo]);
        return (int)Connection::get()->lastInsertId();
    }
    public function delete(int $id): void {
        Connection::get()->prepare('DELETE FROM staff WHERE id=?')->execute([$id]);
    }
}
