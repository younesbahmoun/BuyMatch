<?php
require_once 'Category.php';

class Matchsport {
    private ?int $match_id;
    private int $organizer_id;
    private int $team_home_id;
    private int $team_away_id;
    private int $stade_id;
    private string $date_match;
    private string $time_match;
    private int $duree_minutes;
    private ?int $nombre_places_total;
    private string $statut;
    private ?string $motif_refus;
    private ?int $validateur_id;
    private ?string $approved_at;

    // Composition : Match contient des Categories
    private array $categories = [];

    public function __construct(
        int $organizer_id,
        int $team_home_id,
        int $team_away_id,
        int $stade_id,
        string $date_match,
        string $time_match,
        int $duree_minutes = 90,
        ?int $nombre_places_total = null,
        string $statut = 'en_attente',
        ?string $motif_refus = null,
        ?int $validateur_id = null,
        ?string $approved_at = null,
        ?int $match_id = null
    ) {
        $this->match_id = $match_id;
        $this->organizer_id = $organizer_id;
        $this->team_home_id = $team_home_id;
        $this->team_away_id = $team_away_id;
        $this->stade_id = $stade_id;
        $this->date_match = $date_match;
        $this->time_match = $time_match;
        $this->duree_minutes = $duree_minutes;
        $this->nombre_places_total = $nombre_places_total;
        $this->statut = $statut;
        $this->motif_refus = $motif_refus;
        $this->validateur_id = $validateur_id;
        $this->approved_at = $approved_at;
    }

    // Getters
    public function getMatchId(): ?int {
        return $this->match_id;
    }

    public function getOrganizerId(): int {
        return $this->organizer_id;
    }

    public function getTeamHomeId(): int {
        return $this->team_home_id;
    }

    public function getTeamAwayId(): int {
        return $this->team_away_id;
    }

    public function getStadeId(): int {
        return $this->stade_id;
    }

    public function getDateMatch(): string {
        return $this->date_match;
    }

    public function getTimeMatch(): string {
        return $this->time_match;
    }

    public function getDureeMinutes(): int {
        return $this->duree_minutes;
    }

    public function getNombrePlacesTotal(): ?int {
        return $this->nombre_places_total;
    }

    public function getStatut(): string {
        return $this->statut;
    }

    public function getMotifRefus(): ?string {
        return $this->motif_refus;
    }

    public function getValidateurId(): ?int {
        return $this->validateur_id;
    }

    public function getApprovedAt(): ?string {
        return $this->approved_at;
    }

    // Setters
    public function setMatchId(int $match_id): void {
        $this->match_id = $match_id;
    }

    public function setOrganizerId(int $organizer_id): void {
        $this->organizer_id = $organizer_id;
    }

    public function setTeamHomeId(int $team_home_id): void {
        $this->team_home_id = $team_home_id;
    }

    public function setTeamAwayId(int $team_away_id): void {
        $this->team_away_id = $team_away_id;
    }

    public function setStadeId(int $stade_id): void {
        $this->stade_id = $stade_id;
    }

    public function setDateMatch(string $date_match): void {
        $this->date_match = $date_match;
    }

    public function setTimeMatch(string $time_match): void {
        $this->time_match = $time_match;
    }

    public function setDureeMinutes(int $duree_minutes): void {
        $this->duree_minutes = $duree_minutes;
    }

    public function setNombrePlacesTotal(?int $nombre_places_total): void {
        $this->nombre_places_total = $nombre_places_total;
    }

    public function setStatut(string $statut): void {
        $this->statut = $statut;
    }

    public function setMotifRefus(?string $motif_refus): void {
        $this->motif_refus = $motif_refus;
    }

    public function setValidateurId(?int $validateur_id): void {
        $this->validateur_id = $validateur_id;
    }

    public function setApprovedAt(?string $approved_at): void {
        $this->approved_at = $approved_at;
    }

    // ==================== COMPOSITION : Gestion des Categories ====================

    public function addCategory(Category $category): void {
        $this->categories[] = $category;
    }

    public function getCategories(): array {
        return $this->categories;
    }

    public function setCategories(array $categories): void {
        $this->categories = $categories;
    }

    public function removeCategory(int $category_id): void {
        foreach ($this->categories as $key => $category) {
            if ($category->getCategoryId() === $category_id) {
                unset($this->categories[$key]);
                break;
            }
        }
        $this->categories = array_values($this->categories);
    }

    public function getTotalPlacesFromCategories(): int {
        $total = 0;
        foreach ($this->categories as $category) {
            $total += $category->getNombrePlaces();
        }
        return $total;
    }


    

}