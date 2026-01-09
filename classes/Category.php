<?php

class Category {
    private ?int $category_id;
    private int $match_id;
    private string $nom;
    private float $prix;
    private int $nombre_places;

    public function __construct(
        int $match_id,
        string $nom,
        float $prix,
        int $nombre_places,
        ?int $category_id = null
    ) {
        $this->category_id = $category_id;
        $this->match_id = $match_id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->nombre_places = $nombre_places;
    }

    // Getters
    public function getCategoryId(): ?int {
        return $this->category_id;
    }

    public function getMatchId(): int {
        return $this->match_id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getPrix(): float {
        return $this->prix;
    }

    public function getNombrePlaces(): int {
        return $this->nombre_places;
    }

    // Setters
    public function setCategoryId(int $category_id): void {
        $this->category_id = $category_id;
    }

    public function setMatchId(int $match_id): void {
        $this->match_id = $match_id;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setPrix(float $prix): void {
        $this->prix = $prix;
    }

    public function setNombrePlaces(int $nombre_places): void {
        $this->nombre_places = $nombre_places;
    }
}