<?php

class Role {
    private ?int $role_id;
    private string $nom;

    public function __construct(string $nom, ?int $role_id = null) {
        $this->role_id = $role_id;
        $this->nom = $nom;
    }

    // Getters
    public function getRoleId(): ?int {
        return $this->role_id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    // Setters
    public function setRoleId(int $role_id): void {
        $this->role_id = $role_id;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }
}