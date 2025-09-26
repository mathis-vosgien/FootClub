<?php
// src/Entities/Staff.php
namespace App\Entities;

class Staff {
    public ?int $id = null;
    public string $first_name;
    public string $last_name;
    public string $role;
    public ?string $photo;

    public function __construct(string $first_name, string $last_name, string $role, ?string $photo = null) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->role = $role;
        $this->photo = $photo;
    }

    public function fullName(): string {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
