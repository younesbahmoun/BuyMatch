<?php
require_once __DIR__ . "/User.php";
class Admin extends User {

    public function AcceptMatch (int $match_id, int $validateur_id) {
        $sql = "UPDATE matchs SET statut = approuve, validateur_id = :validateur_id WHERE match_id = :match_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':match_id' => $match_id,
            ':validateur_id' => $validateur_id,
        ]);
    }

    public function refusMatch (int $match_id, int $validateur_id, string $motif_refus) {
        $sql = "UPDATE matchs SET statut = refuse, validateur_id = :validateur_id, motif_refus = :motif_refus WHERE match_id = :match_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':match_id' => $match_id,
            ':validateur_id' => $validateur_id,
            ':motif_refus' => $motif_refus,
        ]);
    }

    public function activerUtilisateur (int $user_id) {
        $sql = "UPDATE users SET est_actif = 1 WHERE user_id = ? AND role_id = 2";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            // ':user_id' => $user_id
            $user_id
        ]);
    }

    public function desactiverUtilisateur (int $user_id) {
        $sql = "UPDATE users SET est_actif = 0 WHERE user_id = ? AND role_id = 2";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id]);
    }

}