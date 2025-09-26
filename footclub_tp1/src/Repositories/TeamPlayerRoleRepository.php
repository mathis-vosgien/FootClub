<?php
// src/Repositories/TeamPlayerRoleRepository.php
namespace App\Repositories;
use App\Database\Connection;
use App\Entities\TeamPlayerRole;

class TeamPlayerRoleRepository {
    public function forTeam(int $team_id): array {
        $sql = 'SELECT tpr.*, p.first_name, p.last_name FROM team_players tpr
                JOIN players p ON p.id = tpr.player_id
                WHERE tpr.team_id = ? ORDER BY p.last_name, p.first_name';
        $stmt = Connection::get()->prepare($sql);
        $stmt->execute([$team_id]);
        return $stmt->fetchAll();
    }
    public function assign(TeamPlayerRole $tpr): void {
        $stmt = Connection::get()->prepare('REPLACE INTO team_players(team_id, player_id, role) VALUES(?,?,?)');
        $stmt->execute([$tpr->team_id, $tpr->player_id, $tpr->role]);
    }
    public function unassign(int $team_id, int $player_id): void {
        Connection::get()->prepare('DELETE FROM team_players WHERE team_id=? AND player_id=?')->execute([$team_id, $player_id]);
    }
}
