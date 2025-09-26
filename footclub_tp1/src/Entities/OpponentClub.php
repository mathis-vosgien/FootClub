<?php
// src/Entities/OpponentClub.php
namespace App\Entities;

class OpponentClub {
    public ?int $id = null;
    public string $name;
    public ?string $city;
    public ?string $country;

    public function __construct(string $name, ?string $city = null, ?string $country = null) {
        $this->name = $name;
        $this->city = $city;
        $this->country = $country;
    }
}
