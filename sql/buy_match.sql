    -- =============================================
    -- DATABASE CREATION & SCHEMA - Football Ticket System
    -- =============================================

    -- Create database if not exists
    DROP DATABASE IF EXISTS buy_match;
    CREATE DATABASE IF NOT EXISTS buy_match;

    -- Use the database
    USE buy_match;

    -- =============================================
    -- TABLES
    -- =============================================

    -- Table ROLE
    CREATE TABLE IF NOT EXISTS roles (
        role_id INT PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(50) NOT NULL
    );

    -- Table USER
    CREATE TABLE IF NOT EXISTS users (
        user_id INT PRIMARY KEY AUTO_INCREMENT,
        role_id INT NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        statut VARCHAR(50),
        est_actif BOOLEAN DEFAULT TRUE,
        date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
        derniere_connexion DATETIME,
        FOREIGN KEY (role_id) REFERENCES roles(role_id)
    );

    -- Table TEAM
    CREATE TABLE IF NOT EXISTS teams (
        team_id INT PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(100) NOT NULL,
        logo_url VARCHAR(500),
        pays VARCHAR(100),
        ville VARCHAR(100),
        date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    -- Table STADE
    CREATE TABLE IF NOT EXISTS stades (
        stade_id INT PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(150) NOT NULL,
        ville VARCHAR(100) NOT NULL,
        adresse VARCHAR(255) NOT NULL,
        pays VARCHAR(100) DEFAULT 'Morocco',
        capacite_max INT Not NULL
    );

    -- Table MATCH
    CREATE TABLE IF NOT EXISTS matchs (
        match_id INT PRIMARY KEY AUTO_INCREMENT,
        organizer_id INT NOT NULL,
        team_home_id INT NOT NULL,
        team_away_id INT NOT NULL,
        stade_id INT NOT NULL,
        date_match DATE NOT NULL,
        time_match TIME NOT NULL,
        duree_minutes INT DEFAULT 90,
        nombre_places_total INT CHECK (nombre_places_total <= 2000),
        statut ENUM('en_attente', 'approuve', 'refuse', 'publie', 'termine', 'annule') DEFAULT 'en_attente',
        motif_refus TEXT,
        validateur_id INT,
        approved_at DATETIME,
        FOREIGN KEY (organizer_id) REFERENCES users(user_id),
        FOREIGN KEY (team_home_id) REFERENCES teams(team_id),
        FOREIGN KEY (team_away_id) REFERENCES teams(team_id),
        FOREIGN KEY (stade_id) REFERENCES stades(stade_id),
        FOREIGN KEY (validateur_id) REFERENCES users(user_id)
    );

    -- Table CATEGORY
    CREATE TABLE IF NOT EXISTS categorys (
        category_id INT PRIMARY KEY AUTO_INCREMENT,
        match_id INT NOT NULL,
        nom VARCHAR(50) NOT NULL,
        prix DECIMAL(10, 2) NOT NULL,
        nombre_places INT NOT NULL,
        FOREIGN KEY (match_id) REFERENCES matchs(match_id)
    );

    -- Table PLACE
    CREATE TABLE IF NOT EXISTS places (
        place_id INT PRIMARY KEY AUTO_INCREMENT,
        categorie_id INT NOT NULL,
        numero_place INT,
        rangee VARCHAR(20),
        section VARCHAR(50),
        est_disponible BOOLEAN DEFAULT TRUE,
        FOREIGN KEY (categorie_id) REFERENCES categorys(category_id)
    );

    -- Table TICKET
    CREATE TABLE IF NOT EXISTS tickets (
        ticket_id INT PRIMARY KEY AUTO_INCREMENT,
        match_id INT NOT NULL,
        category_id INT NOT NULL,
        place_id INT UNIQUE,
        seat_label VARCHAR(50),
        qr_value VARCHAR(255) UNIQUE,
        sent_at DATETIME,
        FOREIGN KEY (match_id) REFERENCES matchs(match_id),
        FOREIGN KEY (category_id) REFERENCES categorys(category_id),
        FOREIGN KEY (place_id) REFERENCES places(place_id)
    );

    -- Table REVIEW
    CREATE TABLE IF NOT EXISTS reviews (
        review_id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        match_id INT NOT NULL,
        rating INT CHECK (rating >= 1 AND rating <= 5),
        commentaire TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(user_id),
        FOREIGN KEY (match_id) REFERENCES matchs(match_id)
    );


    -- =============================================
    -- 1. ROLES (must be first - others depend on it)
    -- =============================================
    INSERT INTO roles (role_id, nom) VALUES
    (1, 'admin'),
    (2, 'acheteur'),
    (3, 'organisateur');

    -- =============================================
    -- 2. USERS (password is "password123" for all)
    -- =============================================
    -- Password hash for "password123"
    -- You can generate your own at: password_hash("password123", PASSWORD_DEFAULT)

    INSERT INTO users (role_id, email, password_hash, nom, prenom, statut) VALUES
    -- Admin
    (1, 'admin@sportticket.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Super', 'actif'),

    -- Acheteurs (Buyers)
    (2, 'ahmed@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Benjelloun', 'Ahmed', 'actif'),
    (2, 'sara@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'El Amrani', 'Sara', 'actif'),
    (2, 'karim@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Tazi', 'Karim', 'actif'),

    -- Organisateurs (Organizers)
    (3, 'org1@sportticket.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alaoui', 'Mohammed', 'actif'),
    (3, 'org2@sportticket.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Fassi', 'Youssef', 'actif');

    -- =============================================
    -- 3. TEAMS (Moroccan football teams)
    -- =============================================
    INSERT INTO teams (nom, pays, ville) VALUES
    ('Raja Club Athletic', 'Morocco', 'Casablanca'),
    ('Wydad AC', 'Morocco', 'Casablanca'),
    ('AS FAR', 'Morocco', 'Rabat'),
    ('FUS Rabat', 'Morocco', 'Rabat'),
    ('RS Berkane', 'Morocco', 'Berkane'),
    ('Maghreb Fès', 'Morocco', 'Fès');

    -- =============================================
    -- 4. STADES (Moroccan stadiums)
    -- =============================================
    INSERT INTO stades (nom, ville, adresse, pays, capacite_max) VALUES
    ('Stade Mohammed V', 'Casablanca', 'Avenue Mohammed V', 'Morocco', 67000),
    ('Complexe Moulay Abdellah', 'Rabat', 'Avenue Ibn Sina', 'Morocco', 52000),
    ('Stade de Fès', 'Fès', 'Route de Sefrou', 'Morocco', 45000),
    ('Stade Municipal de Berkane', 'Berkane', 'Centre Ville', 'Morocco', 15000);

    -- =============================================
    -- 5. MATCHS (some upcoming games)
    -- =============================================
    INSERT INTO matchs (organizer_id, team_home_id, team_away_id, stade_id, date_match, time_match, nombre_places_total, statut) VALUES
    -- Raja vs Wydad (Derby) - organized by org1 (user_id = 5)
    (5, 1, 2, 1, '2025-02-15', '20:00:00', 2000, 'publie'),

    -- AS FAR vs FUS Rabat - organized by org2 (user_id = 6)
    (6, 3, 4, 2, '2025-02-20', '18:00:00', 1500, 'publie'),

    -- RS Berkane vs Raja - waiting approval
    (5, 5, 1, 4, '2025-03-01', '17:00:00', 1000, 'en_attente'),

    -- Wydad vs Maghreb Fès - approved
    (6, 2, 6, 1, '2025-03-10', '20:00:00', 2000, 'approuve');

    -- =============================================
    -- 6. CATEGORYS (ticket categories per match)
    -- =============================================
    -- Match 1: Raja vs Wydad
    INSERT INTO categorys (match_id, nom, prix, nombre_places) VALUES
    (1, 'VIP', 500.00, 200),
    (1, 'Tribune', 200.00, 800),
    (1, 'Virage', 100.00, 1000);

    -- Match 2: AS FAR vs FUS
    INSERT INTO categorys (match_id, nom, prix, nombre_places) VALUES
    (2, 'VIP', 400.00, 150),
    (2, 'Tribune', 150.00, 600),
    (2, 'Virage', 80.00, 750);

    -- =============================================
    -- 7. PLACES (seats - just a few examples)
    -- =============================================
    -- VIP seats for Match 1 (category_id = 1)
    INSERT INTO places (categorie_id, numero_place, rangee, section, est_disponible) VALUES
    (1, 1, 'A', 'VIP-1', TRUE),
    (1, 2, 'A', 'VIP-1', TRUE),
    (1, 3, 'A', 'VIP-1', FALSE),  -- Already taken
    (1, 4, 'A', 'VIP-1', TRUE),
    (1, 5, 'A', 'VIP-1', TRUE);

    -- Tribune seats for Match 1 (category_id = 2)
    INSERT INTO places (categorie_id, numero_place, rangee, section, est_disponible) VALUES
    (2, 1, 'B', 'TRIB-1', TRUE),
    (2, 2, 'B', 'TRIB-1', TRUE),
    (2, 3, 'B', 'TRIB-1', TRUE),
    (2, 4, 'B', 'TRIB-1', FALSE),
    (2, 5, 'B', 'TRIB-1', TRUE);

    -- =============================================
    -- 8. TICKETS (some purchased tickets)
    -- =============================================
    INSERT INTO tickets (match_id, category_id, place_id, seat_label, qr_value, sent_at) VALUES
    -- Ahmed bought VIP seat 3
    (1, 1, 3, 'VIP-1 A3', 'QR-MATCH1-VIP-003', NOW()),
    -- Sara bought Tribune seat 4
    (1, 2, 9, 'TRIB-1 B4', 'QR-MATCH1-TRIB-004', NOW());

    -- =============================================
    -- 9. REVIEWS (some match reviews)
    -- =============================================
    -- Note: Only for past matches, but adding for testing
    INSERT INTO reviews (user_id, match_id, rating, commentaire) VALUES
    (2, 1, 5, 'Excellent match! Ambiance incroyable au stade.'),
    (3, 1, 4, 'Très bon match, juste un peu de retard au début.'),
    (4, 2, 5, 'Organisation parfaite, je recommande!');