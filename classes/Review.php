<?php

class Review {
    private ?int $review_id;
    private int $user_id;
    private int $match_id;
    private int $rating;
    private string $commentaire;
    private ?string $created_at;

    public function __construct(
        int $user_id,
        int $match_id,
        int $rating,
        string $commentaire,
        ?string $created_at = null,
        ?int $review_id = null
    ) {
        $this->review_id = $review_id;
        $this->user_id = $user_id;
        $this->match_id = $match_id;
        $this->setRating($rating);
        $this->commentaire = $commentaire;
        $this->created_at = $created_at;
    }

    // Getters
    public function getReviewId(): ?int {
        return $this->review_id;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function getMatchId(): int {
        return $this->match_id;
    }

    public function getRating(): int {
        return $this->rating;
    }

    public function getCommentaire(): string {
        return $this->commentaire;
    }

    public function getCreatedAt(): ?string {
        return $this->created_at;
    }

    // Setters
    public function setReviewId(int $review_id): void {
        $this->review_id = $review_id;
    }

    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }

    public function setMatchId(int $match_id): void {
        $this->match_id = $match_id;
    }

    public function setRating(int $rating): void {
        if ($rating < 1 || $rating > 5) {
            throw new InvalidArgumentException("Rating doit être entre 1 et 5");
        }
        $this->rating = $rating;
    }

    public function setCommentaire(string $commentaire): void {
        $this->commentaire = $commentaire;
    }
}