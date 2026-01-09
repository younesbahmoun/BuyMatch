<?php

class Team {
    private ?int $team_id;
    private string $nom;
    private ?string $logo_url;
    private ?string $pays;
    private ?string $ville;
    private ?string $date_creation;

    public function __construct(
        string $nom,
        ?string $logo_url = null,
        ?string $pays = null,
        ?string $ville = null,
        ?int $team_id = null,
        ?string $date_creation = null
    ) {
        $this->team_id = $team_id;
        $this->nom = $nom;
        $this->logo_url = $logo_url;
        $this->pays = $pays;
        $this->ville = $ville;
        $this->date_creation = $date_creation;
    }

    // Getters
    public function getTeamId(): ?int {
        return $this->team_id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getLogoUrl(): ?string {
        return $this->logo_url;
    }

    public function getPays(): ?string {
        return $this->pays;
    }

    public function getVille(): ?string {
        return $this->ville;
    }

    public function getDateCreation(): ?string {
        return $this->date_creation;
    }

    // Setters
    public function setTeamId(int $team_id): void {
        $this->team_id = $team_id;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setLogoUrl(?string $logo_url): void {
        $this->logo_url = $logo_url;
    }

    public function setPays(?string $pays): void {
        $this->pays = $pays;
    }

    public function setVille(?string $ville): void {
        $this->ville = $ville;
    }
}