<?php
// src/Entities/Team.php
namespace App\Entities;

class Team {
    public ?int $id = null;
    public string $name;
    public ?string $category;

    public function __construct(string $name, ?string $category = null) {
        $this->name = $name;
        $this->category = $category;
    }
}
