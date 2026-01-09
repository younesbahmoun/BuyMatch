<?php
require_once __DIR__ . "/User.php";
class Organisateur extends User {

    public function __construct() {
        parent::__construct();
        $this->role_id = 2;
        // $this->statut = "actif";
    }

        // Register a new buyer
    public function register($nom, $prenom, $email, $password) {
        // Step 1: Set the data
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->setPassword($password);  // This hashes the password
        
        // Step 2: Save to database (uses parent method)
        return $this->createUser();
    }

    public function createEquipe (string $nom, string $pays, string $ville):int {
        $sql = "INSERT INTO teams (nom, pays, ville)
        VALUES (:nom, :pays, :ville)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":nom" => $nom,
            ":pays" => $pays,
            ":ville" => $ville,
        ]);
        // user_id = $this->db->lastInsertId();
        return $this->db->lastInsertId();
    }

    public function createStade (string $nom, string $pays, string $ville, string $adresse, int $capacite_max):int {
        $sql = "INSERT INTO stades (nom, ville, adresse, pays, capacite_max)
        VALUES (:nom, :pays, :ville, :adresse, :capacite_max)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":nom" => $nom,
            ":ville" => $ville,
            ":adresse" => $adresse,
            ":pays" => $pays,
            ":capacite_max" => $capacite_max,
        ]);
        // user_id = $this->db->lastInsertId();
        return $this->db->lastInsertId();
    }

    public function createMatchs (array $data):int {
        $sql = "INSERT INTO matchs (date_match, time_match, nombre_places_total, organizer_id, team_home_id, team_away_id, stade_id)
        VALUES (:date_match, :time_match, :nombre_places_total, :organizer_id, :team_home_id, :team_away_id, :stade_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":date_match" => $data['date_match'],
            ":time_match" => $data['time_match'],
            // ":statut" => $data['$statut'],
            ":nombre_places_total" => $data['nombre_places_total'],
            ":organizer_id" => $data['organizer_id'],
            ":team_home_id" => $data['team_home_id'],
            ":team_away_id" => $data['team_away_id'],
            ":stade_id" => $data['stade_id'],
        ]);
        // user_id = $this->db->lastInsertId();
        return $this->db->lastInsertId();
    }

    public function createCategorie (array $data) {
        $sql = "INSERT INTO categorys (match_id, nom, prix, nombre_places)
        VALUES(:match_id_value, :nom_value, :prix_value, :nombre_places_value)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":match_id_value" => $data["match_id"],
            ":nom_value" => $data["nom"],
            ":prix_value" => $data["prix"],
            ":nombre_places_value" => $data["nombre_places"],
        ]);
        // return $stmt->fetch(PDO::FETCH_ASSOC);
        // return $stmt->fetchAll();
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return (int) $this->db->lastInsertId();
        // return $stmt->rowCount();
    }



}