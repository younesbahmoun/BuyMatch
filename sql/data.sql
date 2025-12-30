-- ============================================================
-- BASE DE DONNÉES : PLATEFORME DE BILLETTERIE SPORTIVE
-- ============================================================
-- Auteur: Assistant Claude
-- Date: 2025
-- Description: Système de gestion de billetterie pour événements sportifs
-- ============================================================

-- Suppression de la base si elle existe
DROP DATABASE IF EXISTS billetterie_sportive;

-- Création de la base de données
CREATE DATABASE billetterie_sportive 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE billetterie_sportive;

-- ============================================================
-- TABLE: roles
-- Description: Définit les différents rôles du système
-- ============================================================
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertion des rôles par défaut
INSERT INTO roles (nom, description) VALUES
('visiteur', 'Peut consulter les matchs publiés'),
('utilisateur', 'Peut acheter des billets après inscription'),
('organisateur', 'Peut créer et gérer des événements sportifs'),
('administrateur', 'Supervise l''ensemble du système');

-- ============================================================
-- TABLE: utilisateurs
-- Description: Stocke tous les utilisateurs de la plateforme
-- ============================================================
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    adresse TEXT,
    avatar VARCHAR(255) DEFAULT NULL,
    role_id INT NOT NULL,
    est_actif BOOLEAN DEFAULT TRUE,
    email_verifie BOOLEAN DEFAULT FALSE,
    token_verification VARCHAR(255) DEFAULT NULL,
    token_reset_mdp VARCHAR(255) DEFAULT NULL,
    date_expiration_token DATETIME DEFAULT NULL,
    derniere_connexion DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT,
    INDEX idx_email (email),
    INDEX idx_role (role_id),
    INDEX idx_actif (est_actif)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: equipes
-- Description: Stocke les équipes sportives
-- ============================================================
CREATE TABLE equipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    logo VARCHAR(255) DEFAULT NULL,
    pays VARCHAR(100),
    ville VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nom (nom)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: lieux
-- Description: Stocke les stades et lieux des événements
-- ============================================================
CREATE TABLE lieux (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(150) NOT NULL,
    adresse TEXT NOT NULL,
    ville VARCHAR(100) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    capacite_max INT NOT NULL DEFAULT 2000,
    description TEXT,
    image VARCHAR(255) DEFAULT NULL,
    coordonnees_gps VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_ville (ville),
    INDEX idx_pays (pays)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: matchs
-- Description: Stocke les événements sportifs (matchs)
-- ============================================================
CREATE TABLE matchs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organisateur_id INT NOT NULL,
    equipe_domicile_id INT NOT NULL,
    equipe_exterieur_id INT NOT NULL,
    lieu_id INT NOT NULL,
    date_match DATETIME NOT NULL,
    duree_minutes INT NOT NULL DEFAULT 90,
    nombre_places_total INT NOT NULL,
    statut ENUM('en_attente', 'valide', 'refuse', 'annule', 'termine') DEFAULT 'en_attente',
    motif_refus TEXT DEFAULT NULL,
    est_publie BOOLEAN DEFAULT FALSE,
    description TEXT,
    image_affiche VARCHAR(255) DEFAULT NULL,
    score_domicile INT DEFAULT NULL,
    score_exterieur INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (equipe_domicile_id) REFERENCES equipes(id) ON DELETE RESTRICT,
    FOREIGN KEY (equipe_exterieur_id) REFERENCES equipes(id) ON DELETE RESTRICT,
    FOREIGN KEY (lieu_id) REFERENCES lieux(id) ON DELETE RESTRICT,
    CONSTRAINT chk_places CHECK (nombre_places_total > 0 AND nombre_places_total <= 2000),
    CONSTRAINT chk_equipes_differentes CHECK (equipe_domicile_id != equipe_exterieur_id),
    INDEX idx_date (date_match),
    INDEX idx_statut (statut),
    INDEX idx_organisateur (organisateur_id),
    INDEX idx_publie (est_publie)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: categories
-- Description: Catégories de places pour chaque match (max 3 par match)
-- ============================================================
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    match_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    nombre_places INT NOT NULL,
    places_disponibles INT NOT NULL,
    couleur VARCHAR(7) DEFAULT '#3498db',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (match_id) REFERENCES matchs(id) ON DELETE CASCADE,
    CONSTRAINT chk_prix CHECK (prix >= 0),
    CONSTRAINT chk_places_cat CHECK (nombre_places > 0),
    CONSTRAINT chk_places_dispo CHECK (places_disponibles >= 0 AND places_disponibles <= nombre_places),
    INDEX idx_match (match_id)
) ENGINE=InnoDB;

-- Trigger pour limiter à 3 catégories par match
DELIMITER //
CREATE TRIGGER before_insert_categorie
BEFORE INSERT ON categories
FOR EACH ROW
BEGIN
    DECLARE nb_categories INT;
    SELECT COUNT(*) INTO nb_categories FROM categories WHERE match_id = NEW.match_id;
    IF nb_categories >= 3 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Un match ne peut pas avoir plus de 3 catégories';
    END IF;
END//
DELIMITER ;

-- ============================================================
-- TABLE: places
-- Description: Places numérotées dans chaque catégorie
-- ============================================================
CREATE TABLE places (
    id INT PRIMARY KEY AUTO_INCREMENT,
    categorie_id INT NOT NULL,
    numero_place VARCHAR(20) NOT NULL,
    rang VARCHAR(10),
    section VARCHAR(50),
    est_disponible BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_place_categorie (categorie_id, numero_place),
    INDEX idx_disponible (est_disponible),
    INDEX idx_categorie (categorie_id)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: commandes
-- Description: Commandes d'achat de billets
-- ============================================================
CREATE TABLE commandes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    numero_commande VARCHAR(50) NOT NULL UNIQUE,
    montant_total DECIMAL(10, 2) NOT NULL,
    statut ENUM('en_attente', 'payee', 'annulee', 'remboursee') DEFAULT 'en_attente',
    methode_paiement VARCHAR(50),
    reference_paiement VARCHAR(255),
    date_paiement DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    INDEX idx_utilisateur (utilisateur_id),
    INDEX idx_statut (statut),
    INDEX idx_numero (numero_commande)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: billets
-- Description: Billets achetés par les utilisateurs
-- ============================================================
CREATE TABLE billets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    commande_id INT NOT NULL,
    match_id INT NOT NULL,
    place_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    code_unique VARCHAR(100) NOT NULL UNIQUE,
    qr_code TEXT,
    prix_achat DECIMAL(10, 2) NOT NULL,
    statut ENUM('valide', 'utilise', 'annule', 'expire') DEFAULT 'valide',
    date_utilisation DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (match_id) REFERENCES matchs(id) ON DELETE RESTRICT,
    FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE RESTRICT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    INDEX idx_code (code_unique),
    INDEX idx_match (match_id),
    INDEX idx_utilisateur (utilisateur_id),
    INDEX idx_statut (statut)
) ENGINE=InnoDB;

-- Trigger pour limiter à 4 billets par utilisateur par match
DELIMITER //
CREATE TRIGGER before_insert_billet
BEFORE INSERT ON billets
FOR EACH ROW
BEGIN
    DECLARE nb_billets INT;
    SELECT COUNT(*) INTO nb_billets 
    FROM billets 
    WHERE utilisateur_id = NEW.utilisateur_id 
    AND match_id = NEW.match_id
    AND statut != 'annule';
    
    IF nb_billets >= 4 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Un utilisateur ne peut pas acheter plus de 4 billets par match';
    END IF;
END//
DELIMITER ;

-- Trigger pour mettre à jour la disponibilité de la place
DELIMITER //
CREATE TRIGGER after_insert_billet
AFTER INSERT ON billets
FOR EACH ROW
BEGIN
    UPDATE places SET est_disponible = FALSE WHERE id = NEW.place_id;
    
    UPDATE categories c
    SET places_disponibles = places_disponibles - 1
    WHERE c.id = (SELECT categorie_id FROM places WHERE id = NEW.place_id);
END//
DELIMITER ;

-- ============================================================
-- TABLE: commentaires
-- Description: Commentaires et avis des utilisateurs après les matchs
-- ============================================================
CREATE TABLE commentaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    match_id INT NOT NULL,
    contenu TEXT NOT NULL,
    note INT CHECK (note >= 1 AND note <= 5),
    est_visible BOOLEAN DEFAULT TRUE,
    est_signale BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (match_id) REFERENCES matchs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_commentaire (utilisateur_id, match_id),
    INDEX idx_match (match_id),
    INDEX idx_visible (est_visible)
) ENGINE=InnoDB;

-- Trigger pour vérifier que le match est terminé avant de commenter
DELIMITER //
CREATE TRIGGER before_insert_commentaire
BEFORE INSERT ON commentaires
FOR EACH ROW
BEGIN
    DECLARE match_statut VARCHAR(20);
    DECLARE a_billet INT;
    
    SELECT statut INTO match_statut FROM matchs WHERE id = NEW.match_id;
    
    IF match_statut != 'termine' THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Vous ne pouvez commenter qu''après la fin du match';
    END IF;
    
    -- Vérifier que l'utilisateur a un billet pour ce match
    SELECT COUNT(*) INTO a_billet 
    FROM billets 
    WHERE utilisateur_id = NEW.utilisateur_id 
    AND match_id = NEW.match_id 
    AND statut IN ('valide', 'utilise');
    
    IF a_billet = 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Vous devez avoir assisté au match pour laisser un commentaire';
    END IF;
END//
DELIMITER ;

-- ============================================================
-- TABLE: notifications
-- Description: Notifications pour les utilisateurs
-- ============================================================
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    titre VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'succes', 'avertissement', 'erreur') DEFAULT 'info',
    est_lue BOOLEAN DEFAULT FALSE,
    lien VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    INDEX idx_utilisateur (utilisateur_id),
    INDEX idx_lue (est_lue)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: logs_activite
-- Description: Journal des activités du système
-- ============================================================
CREATE TABLE logs_activite (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT DEFAULT NULL,
    action VARCHAR(100) NOT NULL,
    table_concernee VARCHAR(50),
    enregistrement_id INT,
    details JSON,
    adresse_ip VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL,
    INDEX idx_utilisateur (utilisateur_id),
    INDEX idx_action (action),
    INDEX idx_date (created_at)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: parametres_systeme
-- Description: Paramètres de configuration du système
-- ============================================================
CREATE TABLE parametres_systeme (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cle VARCHAR(100) NOT NULL UNIQUE,
    valeur TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertion des paramètres par défaut
INSERT INTO parametres_systeme (cle, valeur, description) VALUES
('max_billets_par_match', '4', 'Nombre maximum de billets par utilisateur par match'),
('max_places_par_match', '2000', 'Nombre maximum de places par match'),
('max_categories_par_match', '3', 'Nombre maximum de catégories par match'),
('duree_match_defaut', '90', 'Durée par défaut d''un match en minutes'),
('email_expediteur', 'noreply@billetterie-sport.com', 'Email d''envoi des notifications'),
('nom_plateforme', 'SportTicket', 'Nom de la plateforme');

-- ============================================================
-- VUES (Views)
-- ============================================================

-- Vue: Matchs publiés avec détails complets
CREATE VIEW vue_matchs_publies AS
SELECT 
    m.id,
    m.date_match,
    m.duree_minutes,
    m.nombre_places_total,
    m.statut,
    m.description,
    m.image_affiche,
    m.score_domicile,
    m.score_exterieur,
    ed.nom AS equipe_domicile,
    ed.logo AS logo_domicile,
    ee.nom AS equipe_exterieur,
    ee.logo AS logo_exterieur,
    l.nom AS lieu_nom,
    l.ville AS lieu_ville,
    l.pays AS lieu_pays,
    CONCAT(u.prenom, ' ', u.nom) AS organisateur,
    (SELECT MIN(prix) FROM categories WHERE match_id = m.id) AS prix_min,
    (SELECT MAX(prix) FROM categories WHERE match_id = m.id) AS prix_max,
    (SELECT SUM(places_disponibles) FROM categories WHERE match_id = m.id) AS places_restantes
FROM matchs m
JOIN equipes ed ON m.equipe_domicile_id = ed.id
JOIN equipes ee ON m.equipe_exterieur_id = ee.id
JOIN lieux l ON m.lieu_id = l.id
JOIN utilisateurs u ON m.organisateur_id = u.id
WHERE m.est_publie = TRUE AND m.statut = 'valide';

-- Vue: Statistiques par match pour les organisateurs
CREATE VIEW vue_stats_matchs AS
SELECT 
    m.id AS match_id,
    m.organisateur_id,
    m.date_match,
    ed.nom AS equipe_domicile,
    ee.nom AS equipe_exterieur,
    m.nombre_places_total,
    COALESCE(SUM(CASE WHEN b.statut IN ('valide', 'utilise') THEN 1 ELSE 0 END), 0) AS billets_vendus,
    COALESCE(SUM(CASE WHEN b.statut IN ('valide', 'utilise') THEN b.prix_achat ELSE 0 END), 0) AS chiffre_affaires,
    ROUND(COALESCE(SUM(CASE WHEN b.statut IN ('valide', 'utilise') THEN 1 ELSE 0 END), 0) * 100.0 / m.nombre_places_total, 2) AS taux_remplissage
FROM matchs m
JOIN equipes ed ON m.equipe_domicile_id = ed.id
JOIN equipes ee ON m.equipe_exterieur_id = ee.id
LEFT JOIN billets b ON m.id = b.match_id
GROUP BY m.id, m.organisateur_id, m.date_match, ed.nom, ee.nom, m.nombre_places_total;

-- Vue: Statistiques globales pour l'administrateur
CREATE VIEW vue_stats_globales AS
SELECT 
    (SELECT COUNT(*) FROM utilisateurs WHERE role_id = 2) AS total_utilisateurs,
    (SELECT COUNT(*) FROM utilisateurs WHERE role_id = 3) AS total_organisateurs,
    (SELECT COUNT(*) FROM matchs WHERE statut = 'valide') AS matchs_valides,
    (SELECT COUNT(*) FROM matchs WHERE statut = 'en_attente') AS matchs_en_attente,
    (SELECT COUNT(*) FROM matchs WHERE statut = 'termine') AS matchs_termines,
    (SELECT COUNT(*) FROM billets WHERE statut IN ('valide', 'utilise')) AS total_billets_vendus,
    (SELECT COALESCE(SUM(prix_achat), 0) FROM billets WHERE statut IN ('valide', 'utilise')) AS chiffre_affaires_total,
    (SELECT COUNT(*) FROM commentaires) AS total_commentaires,
    (SELECT AVG(note) FROM commentaires WHERE note IS NOT NULL) AS note_moyenne;

-- Vue: Historique des billets par utilisateur
CREATE VIEW vue_historique_billets AS
SELECT 
    b.id AS billet_id,
    b.utilisateur_id,
    b.code_unique,
    b.prix_achat,
    b.statut AS statut_billet,
    b.created_at AS date_achat,
    m.date_match,
    m.statut AS statut_match,
    ed.nom AS equipe_domicile,
    ee.nom AS equipe_exterieur,
    l.nom AS lieu,
    l.ville,
    c.nom AS categorie,
    p.numero_place,
    p.rang,
    p.section
FROM billets b
JOIN matchs m ON b.match_id = m.id
JOIN equipes ed ON m.equipe_domicile_id = ed.id
JOIN equipes ee ON m.equipe_exterieur_id = ee.id
JOIN lieux l ON m.lieu_id = l.id
JOIN places p ON b.place_id = p.id
JOIN categories c ON p.categorie_id = c.id;

-- ============================================================
-- PROCÉDURES STOCKÉES
-- ============================================================

-- Procédure: Valider un match (par l'administrateur)
DELIMITER //
CREATE PROCEDURE valider_match(
    IN p_match_id INT,
    IN p_admin_id INT
)
BEGIN
    DECLARE v_role INT;
    
    SELECT role_id INTO v_role FROM utilisateurs WHERE id = p_admin_id;
    
    IF v_role != 4 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Seul un administrateur peut valider un match';
    END IF;
    
    UPDATE matchs 
    SET statut = 'valide', est_publie = TRUE, updated_at = NOW()
    WHERE id = p_match_id AND statut = 'en_attente';
    
    -- Notification à l'organisateur
    INSERT INTO notifications (utilisateur_id, titre, message, type)
    SELECT organisateur_id, 'Match validé', 
           CONCAT('Votre match a été validé et est maintenant publié.'),
           'succes'
    FROM matchs WHERE id = p_match_id;
    
    -- Log de l'activité
    INSERT INTO logs_activite (utilisateur_id, action, table_concernee, enregistrement_id)
    VALUES (p_admin_id, 'VALIDATION_MATCH', 'matchs', p_match_id);
END//
DELIMITER ;

-- Procédure: Refuser un match (par l'administrateur)
DELIMITER //
CREATE PROCEDURE refuser_match(
    IN p_match_id INT,
    IN p_admin_id INT,
    IN p_motif TEXT
)
BEGIN
    DECLARE v_role INT;
    
    SELECT role_id INTO v_role FROM utilisateurs WHERE id = p_admin_id;
    
    IF v_role != 4 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Seul un administrateur peut refuser un match';
    END IF;
    
    UPDATE matchs 
    SET statut = 'refuse', motif_refus = p_motif, est_publie = FALSE, updated_at = NOW()
    WHERE id = p_match_id AND statut = 'en_attente';
    
    -- Notification à l'organisateur
    INSERT INTO notifications (utilisateur_id, titre, message, type)
    SELECT organisateur_id, 'Match refusé', 
           CONCAT('Votre match a été refusé. Motif: ', p_motif),
           'erreur'
    FROM matchs WHERE id = p_match_id;
    
    -- Log de l'activité
    INSERT INTO logs_activite (utilisateur_id, action, table_concernee, enregistrement_id, details)
    VALUES (p_admin_id, 'REFUS_MATCH', 'matchs', p_match_id, JSON_OBJECT('motif', p_motif));
END//
DELIMITER ;

-- Procédure: Générer le code unique du billet
DELIMITER //
CREATE FUNCTION generer_code_billet() 
RETURNS VARCHAR(100)
DETERMINISTIC
BEGIN
    DECLARE v_code VARCHAR(100);
    SET v_code = CONCAT('TKT-', 
                        DATE_FORMAT(NOW(), '%Y%m%d'),
                        '-',
                        UPPER(SUBSTRING(MD5(RAND()), 1, 8)));
    RETURN v_code;
END//
DELIMITER ;

-- Procédure: Générer le numéro de commande
DELIMITER //
CREATE FUNCTION generer_numero_commande() 
RETURNS VARCHAR(50)
DETERMINISTIC
BEGIN
    DECLARE v_numero VARCHAR(50);
    SET v_numero = CONCAT('CMD-', 
                          DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'),
                          '-',
                          LPAD(FLOOR(RAND() * 10000), 4, '0'));
    RETURN v_numero;
END//
DELIMITER ;

-- Procédure: Créer une commande avec billets
DELIMITER //
CREATE PROCEDURE creer_commande_billets(
    IN p_utilisateur_id INT,
    IN p_match_id INT,
    IN p_places_ids JSON,
    OUT p_commande_id INT,
    OUT p_resultat VARCHAR(255)
)
BEGIN
    DECLARE v_montant_total DECIMAL(10,2) DEFAULT 0;
    DECLARE v_numero_commande VARCHAR(50);
    DECLARE v_nb_places INT;
    DECLARE v_place_id INT;
    DECLARE v_prix DECIMAL(10,2);
    DECLARE v_code_billet VARCHAR(100);
    DECLARE i INT DEFAULT 0;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_resultat = 'Erreur lors de la création de la commande';
    END;
    
    START TRANSACTION;
    
    -- Vérifier le nombre de places demandées
    SET v_nb_places = JSON_LENGTH(p_places_ids);
    
    IF v_nb_places > 4 THEN
        SET p_resultat = 'Maximum 4 billets par match';
        ROLLBACK;
    ELSE
        -- Calculer le montant total
        SELECT SUM(c.prix) INTO v_montant_total
        FROM places p
        JOIN categories c ON p.categorie_id = c.id
        WHERE JSON_CONTAINS(p_places_ids, CAST(p.id AS JSON));
        
        -- Générer le numéro de commande
        SET v_numero_commande = generer_numero_commande();
        
        -- Créer la commande
        INSERT INTO commandes (utilisateur_id, numero_commande, montant_total, statut)
        VALUES (p_utilisateur_id, v_numero_commande, v_montant_total, 'payee');
        
        SET p_commande_id = LAST_INSERT_ID();
        
        -- Créer les billets pour chaque place
        WHILE i < v_nb_places DO
            SET v_place_id = JSON_EXTRACT(p_places_ids, CONCAT('$[', i, ']'));
            
            SELECT c.prix INTO v_prix
            FROM places p
            JOIN categories c ON p.categorie_id = c.id
            WHERE p.id = v_place_id;
            
            SET v_code_billet = generer_code_billet();
            
            INSERT INTO billets (commande_id, match_id, place_id, utilisateur_id, code_unique, prix_achat)
            VALUES (p_commande_id, p_match_id, v_place_id, p_utilisateur_id, v_code_billet, v_prix);
            
            SET i = i + 1;
        END WHILE;
        
        SET p_resultat = 'Commande créée avec succès';
        COMMIT;
    END IF;
END//
DELIMITER ;

-- ============================================================
-- DONNÉES DE TEST
-- ============================================================

-- Insertion d'un administrateur par défaut
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id, est_actif, email_verifie) VALUES
('Admin', 'Système', 'admin@billetterie-sport.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, TRUE, TRUE);

-- Insertion d'organisateurs de test
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id, est_actif, email_verifie) VALUES
('Dupont', 'Jean', 'organisateur1@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, TRUE, TRUE),
('Martin', 'Sophie', 'organisateur2@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, TRUE, TRUE);

-- Insertion d'utilisateurs de test
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id, est_actif, email_verifie) VALUES
('Leblanc', 'Pierre', 'user1@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, TRUE, TRUE),
('Moreau', 'Marie', 'user2@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, TRUE, TRUE);

-- Insertion de quelques équipes
INSERT INTO equipes (nom, logo, pays, ville) VALUES
('Paris FC', '/images/equipes/paris-fc.png', 'France', 'Paris'),
('Olympique Lyonnais', '/images/equipes/ol.png', 'France', 'Lyon'),
('Olympique de Marseille', '/images/equipes/om.png', 'France', 'Marseille'),
('AS Monaco', '/images/equipes/asm.png', 'Monaco', 'Monaco'),
('LOSC Lille', '/images/equipes/losc.png', 'France', 'Lille'),
('FC Nantes', '/images/equipes/fcn.png', 'France', 'Nantes');

-- Insertion de quelques lieux
INSERT INTO lieux (nom, adresse, ville, pays, capacite_max) VALUES
('Stade de France', '93200 Saint-Denis', 'Paris', 'France', 2000),
('Groupama Stadium', '10 Avenue Simone Veil, 69150 Décines-Charpieu', 'Lyon', 'France', 2000),
('Orange Vélodrome', '3 Boulevard Michelet, 13008', 'Marseille', 'France', 2000),
('Stade Louis II', '7 Avenue des Castelans, 98000', 'Monaco', 'Monaco', 2000);

-- Insertion d'un match de test (validé et publié)
INSERT INTO matchs (organisateur_id, equipe_domicile_id, equipe_exterieur_id, lieu_id, date_match, nombre_places_total, statut, est_publie) VALUES
(2, 1, 2, 1, DATE_ADD(NOW(), INTERVAL 30 DAY), 1500, 'valide', TRUE);

-- Insertion des catégories pour le match
INSERT INTO categories (match_id, nom, description, prix, nombre_places, places_disponibles, couleur) VALUES
(1, 'Tribune VIP', 'Places premium avec accès lounge', 150.00, 200, 200, '#FFD700'),
(1, 'Tribune Latérale', 'Vue latérale sur le terrain', 75.00, 500, 500, '#3498db'),
(1, 'Tribune Populaire', 'Places derrière les buts', 35.00, 800, 800, '#27ae60');

-- Génération des places pour chaque catégorie
-- Catégorie VIP (200 places)
INSERT INTO places (categorie_id, numero_place, rang, section)
SELECT 1, CONCAT('V', LPAD(n, 3, '0')), 
       CONCAT('R', FLOOR((n-1)/20) + 1),
       'VIP'
FROM (SELECT @row := @row + 1 AS n FROM 
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t1,
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t2,
      (SELECT @row := 0) t3) numbers
WHERE n <= 200;

-- Catégorie Latérale (500 places)
INSERT INTO places (categorie_id, numero_place, rang, section)
SELECT 2, CONCAT('L', LPAD(n, 3, '0')), 
       CONCAT('R', FLOOR((n-1)/25) + 1),
       CASE WHEN n <= 250 THEN 'EST' ELSE 'OUEST' END
FROM (SELECT @row2 := @row2 + 1 AS n FROM 
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t1,
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t2,
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t3,
      (SELECT @row2 := 0) t4) numbers
WHERE n <= 500;

-- Catégorie Populaire (800 places)
INSERT INTO places (categorie_id, numero_place, rang, section)
SELECT 3, CONCAT('P', LPAD(n, 3, '0')), 
       CONCAT('R', FLOOR((n-1)/40) + 1),
       CASE WHEN n <= 400 THEN 'NORD' ELSE 'SUD' END
FROM (SELECT @row3 := @row3 + 1 AS n FROM 
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t1,
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t2,
      (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t3,
      (SELECT @row3 := 0) t4) numbers
WHERE n <= 800;

-- ============================================================
-- INDEX SUPPLÉMENTAIRES POUR OPTIMISATION
-- ============================================================

CREATE INDEX idx_matchs_date_statut ON matchs(date_match, statut);
CREATE INDEX idx_billets_match_statut ON billets(match_id, statut);
CREATE INDEX idx_commentaires_match_visible ON commentaires(match_id, est_visible);

-- ============================================================
-- FIN DU SCRIPT
-- ============================================================

SELECT 'Base de données créée avec succès!' AS message;
SELECT CONCAT('Tables créées: ', COUNT(*)) AS info FROM information_schema.tables WHERE table_schema = 'billetterie_sportive';