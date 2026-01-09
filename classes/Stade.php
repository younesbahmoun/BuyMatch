<?php

class Stade {
    private ?int $stade_id;
    private string $nom;
    private string $ville;
    private string $adresse;
    private string $pays;
    private int $capacite_max;

    public function __construct(
        string $nom,
        string $ville,
        string $adresse,
        int $capacite_max,
        string $pays = 'Morocco',
        ?int $stade_id = null
    ) {
        $this->stade_id = $stade_id;
        $this->nom = $nom;
        $this->ville = $ville;
        $this->adresse = $adresse;
        $this->pays = $pays;
        $this->capacite_max = $capacite_max;
    }

    // Getters
    public function getStadeId(): ?int {
        return $this->stade_id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getVille(): string {
        return $this->ville;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function getPays(): string {
        return $this->pays;
    }

    public function getCapaciteMax(): int {
        return $this->capacite_max;
    }

    // Setters
    public function setStadeId(int $stade_id): void {
        $this->stade_id = $stade_id;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setVille(string $ville): void {
        $this->ville = $ville;
    }

    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }

    public function setPays(string $pays): void {
        $this->pays = $pays;
    }

    public function setCapaciteMax(int $capacite_max): void {
        $this->capacite_max = $capacite_max;
    }
}