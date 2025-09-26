<?php
// src/Repositories/MatchRepository.php
namespace App\Repositories;
use App\Database\Connection;
use App\Entities\MatchGame;

class MatchRepository {
    public function all(): array {
        $sql = 'SELECT m.*, t.name AS team_name, o.name AS opponent_name
                FROM matches m
                JOIN teams t ON t.id = m.team_id
                JOIN opponent_clubs o ON o.id = m.opponent_club_id
                ORDER BY match_date DESC';
        return Connection::get()->query($sql)->fetchAll();
    }
    public function create(MatchGame $m): int {
        $stmt = Connection::get()->prepare('INSERT INTO matches(team_id, opponent_club_id, city, match_date, home_score, away_score) VALUES(?,?,?,?,?,?)');
        $stmt->execute([$m->team_id, $m->opponent_club_id, $m->city, $m->match_date, $m->home_score, $m->away_score]);
        return (int)Connection::get()->lastInsertId();
    }
    public function delete(int $id): void {
        Connection::get()->prepare('DELETE FROM matches WHERE id=?')->execute([$id]);
    }
}
