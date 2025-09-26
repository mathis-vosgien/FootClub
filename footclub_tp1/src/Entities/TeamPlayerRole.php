<?php
// src/Entities/TeamPlayerRole.php
namespace App\Entities;

class TeamPlayerRole {
    public int $team_id;
    public int $player_id;
    public string $role; // e.g., 'attaquant', 'milieu', 'défenseur', 'gardien'

    public function __construct(int $team_id, int $player_id, string $role) {
        $this->team_id = $team_id;
        $this->player_id = $player_id;
        $this->role = $role;
    }
}
