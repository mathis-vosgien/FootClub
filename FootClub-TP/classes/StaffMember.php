<?php

Class StaffMember {
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $role;
    private string $picture;

    public function __construct(?int $id, string $firstname, string $lastname, string $role, string $picture) 
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->role = $role;
        $this->picture = $picture;
    }

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getFirstname(): string 
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname) 
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string 
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname) 
    {
        $this->lastname = $lastname;
    }

    public function getRole(): string 
    {
        return $this->role;
    }

    public function setRole(string $role) 
    {
        $this->role = $role;
    }

    public function getPicture(): string 
    {
        return $this->picture;
    }

    public function setPicture(string $picture) 
    {
        $this->picture = $picture;
    }

    public function setId(int $id) 
    {
        $this->id = $id;
    }
}