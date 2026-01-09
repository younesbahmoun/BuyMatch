<?php
require_once __DIR__ . "/../config/Database.php";

abstract class User {

    protected PDO $db;
    protected $user_id;
    protected $role_id;
    protected $email;
    protected $password_hash;
    protected $nom;
    protected $prenom;
    protected $statut;
    protected $est_actif;
    protected $date_inscription;
    protected $derniere_connexion;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        // $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // transaction function
    public function beginTransaction(): bool { return $this->db->beginTransaction(); }
    public function commit(): bool { return $this->db->commit(); }
    public function rollBack(): bool { return $this->db->rollBack(); }

    // Getters (protected access from children)
    public function getUserId() { return $this->user_id; }
    public function getRoleId() { return $this->role_id; }
    public function getEmail() { return $this->email; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getStatut() { return $this->statut; }
    public function isActif() { return $this->est_actif; }
    public function getDateInscription() { return $this->date_inscription; }
    public function getDerniereConnexion() { return $this->derniere_connexion; }

    // Setters
    public function setEmail($email) { 
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        }
    }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setActif($est_actif) { $this->est_actif = $est_actif; }
        // Set password with hashing
    public function setPassword($password) {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }
    // Verify password
    public function verifyPassword($password) {
        return password_verify($password, $this->password_hash);
    }

    // methode
    protected function createUser() {
        $sql = "INSERT INTO users 
            (role_id, email, password_hash, nom, preno)
            VALUES 
            (:role_id, :email, :password_hash, :nom, :prenom)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':role_id' => $this->role_id,
            ':email' => $this->email,
            ':password_hash' => $this->password_hash,
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
        ]);
        
        $this->user_id = $this->db->lastInsertId();
        return $this->user_id;
    }

    protected function updateUser() {
        $sql = "UPDATE users SET 
                email = :email,
                nom = :nom,
                prenom = :prenom,
                WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':email' => $this->email,
            ':nom' => $this->nom,
            ':prenom' => $this->prenom,
            ':user_id' => $this->user_id
        ]);
    }

}