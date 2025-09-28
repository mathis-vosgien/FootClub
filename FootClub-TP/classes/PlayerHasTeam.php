<?php 

Class PlayerHasTeam {
    private Player $player;
    private Team $team;
    private string $role;

    public function __construct(Player $player, Team $team, string $role) 
    {
        $this->player = $player;
        $this->team = $team;
        $this->role = $role;
    }

    public function getPlayer(): Player 
    {
        return $this->player;
    }

    public function setPlayerId(Player $player) 
    {
        $this->player = $player;
    }

    public function getTeamId(): Team 
    {
        return $this->team;
    }

    public function setId(int $id) 
    {
        $this->id = $id;
    }

    public function setTeamId(Team $team) 
    {
        $this->team = $team;
    }

    public function getRole(): string 
    {
        return $this->role;
    }

    public function setRole(string $role) 
    {
        $this->role = $role;
    }
}