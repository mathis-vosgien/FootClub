<?php
// src/Entities/Match.php
namespace App\Entities;

class MatchGame {
    public ?int $id = null;
    public int $team_id;
    public int $opponent_club_id;
    public string $city;
    public string $match_date;
    public int $home_score;
    public int $away_score;

    public function __construct(int $team_id, int $opponent_club_id, string $city, string $match_date, int $home_score = 0, int $away_score = 0) {
        $this->team_id = $team_id;
        $this->opponent_club_id = $opponent_club_id;
        $this->city = $city;
        $this->match_date = $match_date;
        $this->home_score = $home_score;
        $this->away_score = $away_score;
    }
}
