<?php
// src/Entities/Player.php
namespace App\Entities;

class Player {
    public ?int $id = null;
    public string $first_name;
    public string $last_name;
    public ?string $birthdate;
    public ?string $photo;

    public function __construct(string $first_name, string $last_name, ?string $birthdate = null, ?string $photo = null) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->birthdate = $birthdate;
        $this->photo = $photo;
    }

    public function fullName(): string {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
