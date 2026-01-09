<?php
require_once __DIR__ . "/../config/Database.php";

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // ==================== CREATE ====================
    
    public function create($role_id, $email, $password, $nom, $prenom, $statut = null) {
        $sql = "INSERT INTO users (role_id, email, password_hash, nom, prenom, statut) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        return $stmt->execute([$role_id, $email, $password_hash, $nom, $prenom, $statut]);
    }
    
    // ==================== READ ====================
    
    public function getAll() {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function findById($user_id) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function findByRole($role_id) {
        $sql = "SELECT * FROM users WHERE role_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$role_id]);
        return $stmt->fetchAll();
    }
    
    public function getActiveUsers() {
        $sql = "SELECT * FROM users WHERE est_actif = TRUE";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    // ==================== UPDATE ====================
    
    public function update($user_id, $data) {
        $allowed = ['role_id', 'email', 'nom', 'prenom', 'statut', 'est_actif'];
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $values[] = $user_id;
        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($values);
    }
    
    public function updatePassword($user_id, $new_password) {
        $sql = "UPDATE users SET password_hash = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
        return $stmt->execute([$password_hash, $user_id]);
    }
    
    public function updateLastLogin($user_id) {
        $sql = "UPDATE users SET derniere_connexion = NOW() WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([$user_id]);
    }
    
    public function activate($user_id) {
        $sql = "UPDATE users SET est_actif = TRUE WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([$user_id]);
    }
    
    public function deactivate($user_id) {
        $sql = "UPDATE users SET est_actif = FALSE WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([$user_id]);
    }
    
    // ==================== DELETE ====================
    
    public function delete($user_id) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([$user_id]);
    }
    
    // ==================== AUTHENTIFICATION ====================
    
    public function login($email, $password) {
        $user = $this->findByEmail($email);
        
        if (!$user) {
            return false; // Utilisateur non trouvé
        }
        
        if (!$user['est_actif']) {
            return false; // Compte désactivé
        }
        
        if (password_verify($password, $user['password_hash'])) {
            $this->updateLastLogin($user['user_id']);
            return $user; // Connexion réussie
        }
        
        return false; // Mot de passe incorrect
    }
    
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        
        return $stmt->fetchColumn() > 0;
    }
    
    // ==================== UTILITAIRES ====================
    
    public function count() {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchColumn();
    }
    
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}