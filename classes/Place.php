<?php

class Place {
    private ?int $place_id;
    private int $categorie_id;
    private ?int $numero_place;
    private ?string $rangee;
    private ?string $section;
    private bool $est_disponible;

    public function __construct(
        int $categorie_id,
        ?int $numero_place = null,
        ?string $rangee = null,
        ?string $section = null,
        bool $est_disponible = true,
        ?int $place_id = null
    ) {
        $this->place_id = $place_id;
        $this->categorie_id = $categorie_id;
        $this->numero_place = $numero_place;
        $this->rangee = $rangee;
        $this->section = $section;
        $this->est_disponible = $est_disponible;
    }

    // Getters
    public function getPlaceId(): ?int {
        return $this->place_id;
    }

    public function getCategorieId(): int {
        return $this->categorie_id;
    }

    public function getNumeroPlace(): ?int {
        return $this->numero_place;
    }

    public function getRangee(): ?string {
        return $this->rangee;
    }

    public function getSection(): ?string {
        return $this->section;
    }

    public function isDisponible(): bool {
        return $this->est_disponible;
    }

    // Setters
    public function setPlaceId(int $place_id): void {
        $this->place_id = $place_id;
    }

    public function setCategorieId(int $categorie_id): void {
        $this->categorie_id = $categorie_id;
    }

    public function setNumeroPlace(?int $numero_place): void {
        $this->numero_place = $numero_place;
    }

    public function setRangee(?string $rangee): void {
        $this->rangee = $rangee;
    }

    public function setSection(?string $section): void {
        $this->section = $section;
    }

    public function setEstDisponible(bool $est_disponible): void {
        $this->est_disponible = $est_disponible;
    }
}