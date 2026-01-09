<?php
require_once __DIR__ . "/../config/auth_guard.php";
$organisateurId = requireOrganisateur();

require_once __DIR__ . "/../classes/Organisateur.php";
require_once __DIR__ . "/../config/Database.php";
$organisateur = new Organisateur();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Equipe
    $team_home = $_POST["team1Name"];
    $team_home_short = $_POST["team1Short"];
    $team_away = $_POST["team2Name"];
    $team_away_short = $_POST["team2Short"];
    // $equipeData = [
    //     "nom" => 
    // ];
    // echo "<script>console.log($idEquipeHome)</script>";

    // Date Lieu
    $matchDate = $_POST["matchDate"];
    $matchTime = $_POST["matchTime"];
    $stadiumName = $_POST["stadiumName"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $totalPlaces = $_POST["totalPlaces"];
    // $duration = $_POST["duration"]; // 90 min
    $competition = $_POST["competition"];
    
    // Category Prix

    $categoryName1 = $_POST["categoryName1"];
    $categoryPrix1 = $_POST["categoryPrix1"];
    $categoryPlaces1 = $_POST["categoryPlaces1"];
    $categoryDescription1 = $_POST["categoryDescription1"];

    $categoryName2 = $_POST["categoryName2"];
    $categoryPrix2 = $_POST["categoryPrix2"];
    $categoryPlaces2 = $_POST["categoryPlaces2"];
    $categoryDescription2 = $_POST["categoryDescription2"];

    $categoryName3 = $_POST["categoryName3"];
    $categoryPrix3 = $_POST["categoryPrix3"];
    $categoryPlaces3 = $_POST["categoryPlaces3"];
    $categoryDescription3 = $_POST["categoryDescription3"];

    // Début transaction
    $organisateur->beginTransaction();
    // Equipe
    $equipeHomeId =  $organisateur->createEquipe($team_home, "pays", "ville");
    $equipeAwayId = $organisateur->createEquipe($team_away, "pays", "ville");
    // Stade
    $stadeId = $organisateur->createStade($stadiumName, $city, $address, "Maroc", $totalPlaces);
    // match data
    $matchData = [
        'date_match' => $matchDate,
        'time_match' => $matchTime,
        'nombre_places_total' => $totalPlaces,
        'organizer_id' => $organisateurId,
        'team_home_id' => $equipeHomeId,
        'team_away_id' => $equipeAwayId,
        'stade_id' => $stadeId,
    ];
    // match
    $matchId = $organisateur->createMatchs($matchData);
    // data categories
    $categoryData1 = [
        "match_id" => $matchId,
        "nom" => $categoryName1,
        "prix" => $categoryPrix1,
        "nombre_places" => $categoryPlaces1,
    ];
    $categoryData2 = [
        "match_id" => $matchId,
        "nom" => $categoryName2,
        "prix" => $categoryPrix2,
        "nombre_places" => $categoryPlaces2,
    ];
    $categoryData3 = [
        "match_id" => $matchId,
        "nom" => $categoryName3,
        "prix" => $categoryPrix3,
        "nombre_places" => $categoryPlaces3,
    ];    
    // category
    $organisateur->createCategorie($categoryData1);
    $organisateur->createCategorie($categoryData2);
    $organisateur->createCategorie($categoryData3);
    // Fin transaction
    $organisateur->commit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Match - SportTicket</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="../index.html" class="logo">
                    <div class="logo-icon">⚽</div>
                    <span>SportTicket</span>
                </a>
                <div class="nav-actions">
                    <span style="color: var(--gray);">🏟️ FFP Events</span>
                    <a href="login.html" class="btn btn-outline btn-sm">Déconnexion</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Dashboard -->
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Tableau de bord</a></li>
                <li><a href="create-match.html" class="active"><i class="fas fa-calendar-plus"></i> Créer un match</a></li>
                <li><a href="my-matches.html"><i class="fas fa-futbol"></i> Mes matchs</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Statistiques</a></li>
                <li><a href="#"><i class="fas fa-comments"></i> Avis clients</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> Mon profil</a></li>
                <li><a href="login.html"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-content">
            <div class="d-flex justify-between align-center mb-3">
                <h2>⚽ CRÉER UN NOUVEAU MATCH</h2>
                <a href="dashboard.php" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <!-- Alert Info -->
            <div class="alert alert-info mb-3">
                <i class="fas fa-info-circle"></i>
                <span>Votre demande de match sera soumise à validation par l'administrateur avant publication.</span>
            </div>

            <!-- Create Match Form -->
            <div class="table-container">
                <form id="createMatchForm" method="POST">
                    <!-- Step Indicator -->
                    <div class="step-indicator mb-3">
                        <div class="step active" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-label">Équipes</div>
                        </div>
                        <div class="step active" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-label">Date & Lieu</div>
                        </div>
                        <div class="step active" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-label">Catégories & Prix</div>
                        </div>
                        <div class="step active" data-step="4">
                            <div class="step-number">4</div>
                            <div class="step-label">Confirmation</div>
                        </div>
                    </div>

                    <!-- Step 1: Teams -->
                    <div class="form-step active" id="step1">
                        <h3 style="margin-bottom: 25px; color: var(--accent);">🏆 INFORMATIONS DES ÉQUIPES</h3>
                        
                        <div class="teams-input-container">
                            <!-- Team 1 -->
                            <div class="team-input-card">
                                <h4>Équipe Domicile</h4>
                                <div class="team-logo-upload">
                                    <div class="logo-preview" id="logo1Preview">
                                        <i class="fas fa-futbol"></i>
                                    </div>
                                    <input type="file" id="team1Logo" accept="image/*" hidden>
                                    <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('team1Logo').click()">
                                        <i class="fas fa-upload"></i> Logo
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label for="team1Name">Nom de l'équipe *</label>
                                    <input type="text" name="team1Name" id="team1Name" class="form-control" placeholder="Ex: Paris Saint-Germain" required>
                                </div>
                                <div class="form-group">
                                    <label for="team1Short">Abréviation</label>
                                    <input type="text" name="team1Short" id="team1Short" class="form-control" placeholder="Ex: PSG" maxlength="5">
                                </div>
                            </div>

                            <div class="vs-separator">
                                <span>VS</span>
                            </div>

                            <!-- Team 2 -->
                            <div class="team-input-card">
                                <h4>Équipe Visiteur</h4>
                                <div class="team-logo-upload">
                                    <div class="logo-preview" id="logo2Preview">
                                        <i class="fas fa-futbol"></i>
                                    </div>
                                    <input type="file" id="team2Logo" accept="image/*" hidden>
                                    <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('team2Logo').click()">
                                        <i class="fas fa-upload"></i> Logo
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label for="team2Name">Nom de l'équipe *</label>
                                    <input type="text" name="team2Name" id="team2Name" class="form-control" placeholder="Ex: Olympique de Marseille" required>
                                </div>
                                <div class="form-group">
                                    <label for="team2Short">Abréviation</label>
                                    <input type="text" name="team2Short" id="team2Short" class="form-control" placeholder="Ex: OM" maxlength="5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Date & Location -->
                    <div class="form-step active" id="step2">
                        <h3 style="margin-bottom: 25px; color: var(--accent);">📅 DATE, HEURE & LIEU</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="matchDate">Date du match *</label>
                                <input type="date" name="matchDate" id="matchDate" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="matchTime">Heure de coup d'envoi *</label>
                                <input type="time" name="matchTime" id="matchTime" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stadiumName">Nom du stade *</label>
                            <input type="text" name="stadiumName" id="stadiumName" class="form-control" placeholder="Ex: Parc des Princes" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">Ville *</label>
                                <input type="text" name="city" id="city" class="form-control" placeholder="Ex: Paris" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Adresse</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Ex: 24 Rue du Commandant Guilbaud">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="totalPlaces">Nombre total de places * (max 2000)</label>
                                <input type="number" name="totalPlaces" id="totalPlaces" class="form-control" min="100" max="2000" value="2000" required>
                            </div>
                            <div class="form-group">
                                <label for="duration">Durée du match (minutes)</label>
                                <input type="number" name="duration" id="duration" class="form-control" value="90" readonly>
                                <small style="color: var(--gray);">Durée standard de 90 minutes</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="competition">Compétition</label>
                            <select name="competition" id="competition" class="form-control">
                                <option value="">Sélectionner une compétition</option>
                                <option value="ligue1">Ligue 1</option>
                                <option value="ligue2">Ligue 2</option>
                                <option value="coupe-france">Coupe de France</option>
                                <option value="coupe-ligue">Coupe de la Ligue</option>
                                <option value="champions-league">Champions League</option>
                                <option value="europa-league">Europa League</option>
                                <option value="amical">Match Amical</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                    </div>

                    <!-- Step 3: Categories & Prices -->
                    <div class="form-step active" id="step3">
                        <h3 style="margin-bottom: 25px; color: var(--accent);">💰 CATÉGORIES & TARIFICATION</h3>
                        <p style="color: var(--gray); margin-bottom: 25px;">Définissez jusqu'à 3 catégories de places avec leurs prix respectifs.</p>

                        <div id="categoriesContainer">
                            <!-- Category 1 -->
                            <div class="category-card" data-category="1">
                                <div class="category-header">
                                    <span class="category-badge vip">Catégorie 1</span>
                                    <label class="form-check">
                                        <input type="checkbox" checked disabled>
                                        <span>Active</span>
                                    </label>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nom de la catégorie *</label>
                                        <input type="text" name="categoryName1" class="form-control category-name" value="VIP" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Prix (€) *</label>
                                        <input type="number" name="categoryPrix1" class="form-control category-price" min="1" placeholder="120" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre de places *</label>
                                        <input type="number" name="categoryPlaces1" class="form-control category-places" min="1" placeholder="200" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" name="categoryDescription1" class="form-control category-desc" placeholder="Ex: Accès lounge, sièges premium, restauration incluse">
                                </div>
                            </div>

                            <!-- Category 2 -->
                            <div class="category-card" data-category="2">
                                <div class="category-header">
                                    <span class="category-badge tribune">Catégorie 2</span>
                                    <label class="form-check">
                                        <input type="checkbox" class="category-toggle" checked>
                                        <span>Active</span>
                                    </label>
                                </div>
                                <div class="category-content">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Nom de la catégorie</label>
                                            <input type="text" name="categoryName2" class="form-control category-name" value="Tribune">
                                        </div>
                                        <div class="form-group">
                                            <label>Prix (€)</label>
                                            <input type="number" name="categoryPrix2" class="form-control category-price" min="1" placeholder="65">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre de places</label>
                                            <input type="number" name="categoryPlaces2" class="form-control category-places" min="1" placeholder="800">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" name="categoryDescription2" class="form-control category-desc" placeholder="Ex: Vue dégagée sur le terrain">
                                    </div>
                                </div>
                            </div>

                            <!-- Category 3 -->
                            <div class="category-card" data-category="3">
                                <div class="category-header">
                                    <span class="category-badge pelouse">Catégorie 3</span>
                                    <label class="form-check">
                                        <input type="checkbox" class="category-toggle" checked>
                                        <span>Active</span>
                                    </label>
                                </div>
                                <div class="category-content">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Nom de la catégorie</label>
                                            <input type="text" name="categoryName3" class="form-control category-name" value="Pelouse">
                                        </div>
                                        <div class="form-group">
                                            <label>Prix (€)</label>
                                            <input type="number" name="categoryPrix3" class="form-control category-price" min="1" placeholder="45">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre de places</label>
                                            <input type="number" name="categoryPlaces3" class="form-control category-places" min="1" placeholder="1000">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" name="categoryDescription3" class="form-control category-desc" placeholder="Ex: Places économiques">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="places-summary">
                            <div class="summary-row">
                                <span>Total des places configurées:</span>
                                <span id="configuredPlaces">0</span>
                            </div>
                            <div class="summary-row">
                                <span>Places restantes à attribuer:</span>
                                <span id="remainingPlaces">2000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Confirmation -->
                    <div class="form-step active" id="step4">
                        <h3 style="margin-bottom: 25px; color: var(--accent);">✅ CONFIRMATION</h3>
                        <p style="color: var(--gray); margin-bottom: 25px;">Vérifiez les informations avant de soumettre votre demande.</p>

                        <div class="confirmation-preview">
                            <!-- Match Preview Card -->
                            <div class="match-card" style="max-width: 100%;">
                                <div class="match-header">
                                    <span class="match-date" id="previewDate">📅 -- --- ---- - --:--</span>
                                    <span class="match-status status-pending">En attente</span>
                                </div>
                                <div class="match-teams">
                                    <div class="team">
                                        <div class="team-logo" id="previewLogo1">🏠</div>
                                        <div class="team-name" id="previewTeam1">Équipe 1</div>
                                    </div>
                                    <div class="vs">VS</div>
                                    <div class="team">
                                        <div class="team-logo" id="previewLogo2">✈️</div>
                                        <div class="team-name" id="previewTeam2">Équipe 2</div>
                                    </div>
                                </div>
                                <div class="match-info">
                                    <div class="match-info-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span id="previewLocation">Stade, Ville</span>
                                    </div>
                                    <div class="match-info-item">
                                        <i class="fas fa-users"></i>
                                        <span id="previewPlaces">0 places</span>
                                    </div>
                                </div>
                                <div class="match-footer">
                                    <div class="match-price" id="previewPrice">À partir de --€</div>
                                </div>
                            </div>

                            <!-- Categories Summary -->
                            <div class="categories-summary mt-3">
                                <h4>Récapitulatif des catégories</h4>
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Catégorie</th>
                                            <th>Places</th>
                                            <th>Prix</th>
                                            <th>Revenus potentiels</th>
                                        </tr>
                                    </thead>
                                    <tbody id="categoriesSummaryBody">
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: bold; background: var(--dark);">
                                            <td>TOTAL</td>
                                            <td id="totalPlacesSummary">0</td>
                                            <td>-</td>
                                            <td id="totalRevenueSummary">0€</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-check">
                                <input type="checkbox" id="termsAccept" required>
                                <span>J'accepte les <a href="#" style="color: var(--accent);">conditions générales</a> et confirme que les informations sont exactes.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Form Navigation -->
                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                            <i class="fas fa-arrow-left"></i> Précédent
                        </button>
                        <button type="submit" class="btn btn-primary" id="nextBtn">
                            Suivant <i class="fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                            <i class="fas fa-paper-plane"></i> Soumettre la demande
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal">
            <div class="modal-body" style="text-align: center; padding: 50px;">
                <div style="font-size: 5rem; margin-bottom: 20px;">🎉</div>
                <h2 style="margin-bottom: 15px;">DEMANDE ENVOYÉE !</h2>
                <p style="color: var(--gray); margin-bottom: 30px;">
                    Votre demande de création de match a été soumise avec succès.<br>
                    Elle sera examinée par notre équipe dans les plus brefs délais.
                </p>
                <p style="margin-bottom: 30px;">
                    <span class="badge badge-warning" style="font-size: 1rem; padding: 10px 20px;">En attente de validation</span>
                </p>
                <div class="d-flex gap-2" style="justify-content: center;">
                    <a href="organizer-dashboard.html" class="btn btn-primary">
                        <i class="fas fa-home"></i> Tableau de bord
                    </a>
                    <a href="my-matches.html" class="btn btn-outline">
                        <i class="fas fa-futbol"></i> Mes matchs
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>