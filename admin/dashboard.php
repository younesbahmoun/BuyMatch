<?php
require_once __DIR__ . "/../config/auth_guard.php";
$admin_id = requireAdmin();
// echo "<pre>";
// print_r($admin_id);
// echo "</pre>";
require_once __DIR__ . "/../classes/Admin.php";
$admin = new Admin();
// $admin->activerUtilisateur(2);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - SportTicket</title>
    <link rel="stylesheet" href="../css/style.css">
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
                    <span style="color: var(--accent);">🛡️ ADMINISTRATEUR</span>
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
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Utilisateurs</a></li>
                <li><a href="#"><i class="fas fa-calendar-check"></i> Demandes de matchs</a></li>
                <li><a href="#"><i class="fas fa-futbol"></i> Tous les matchs</a></li>
                <li><a href="#"><i class="fas fa-chart-pie"></i> Statistiques</a></li>
                <li><a href="#"><i class="fas fa-comments"></i> Commentaires</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Paramètres</a></li>
                <li><a href="login.html"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-content">
            <h2 style="margin-bottom: 30px;">🛡️ PANNEAU D'ADMINISTRATION</h2>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #00d26a 0%, #00a854 100%);"><i class="fas fa-users"></i></div>
                    <div class="stat-card-info">
                        <h3>2,458</h3>
                        <p>Utilisateurs inscrits</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);"><i class="fas fa-user-tie"></i></div>
                    <div class="stat-card-info">
                        <h3>34</h3>
                        <p>Organisateurs</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon"><i class="fas fa-futbol"></i></div>
                    <div class="stat-card-info">
                        <h3>156</h3>
                        <p>Matchs publiés</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);"><i class="fas fa-clock"></i></div>
                    <div class="stat-card-info">
                        <h3>8</h3>
                        <p>En attente</p>
                    </div>
                </div>
            </div>

            <!-- Pending Match Requests -->
            <div class="table-container mb-3">
                <div class="table-header">
                    <h3>⏳ DEMANDES DE MATCHS EN ATTENTE</h3>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Match</th>
                            <th>Organisateur</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Places</th>
                            <th>Soumis le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>PSG vs Lille</strong></td>
                            <td>FFP Events</td>
                            <td>10 Fév 2025</td>
                            <td>Parc des Princes</td>
                            <td>2,000</td>
                            <td>05 Jan 2025</td>
                            <td class="actions">
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit" style="background: rgba(0, 210, 106, 0.2); color: var(--success);"><i class="fas fa-check"></i></button>
                                <button class="action-btn delete"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>OM vs Rennes</strong></td>
                            <td>OM Events</td>
                            <td>15 Fév 2025</td>
                            <td>Vélodrome</td>
                            <td>1,800</td>
                            <td>06 Jan 2025</td>
                            <td class="actions">
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit" style="background: rgba(0, 210, 106, 0.2); color: var(--success);"><i class="fas fa-check"></i></button>
                                <button class="action-btn delete"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Lyon vs Strasbourg</strong></td>
                            <td>OL Group</td>
                            <td>18 Fév 2025</td>
                            <td>Groupama Stadium</td>
                            <td>2,000</td>
                            <td>07 Jan 2025</td>
                            <td class="actions">
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit" style="background: rgba(0, 210, 106, 0.2); color: var(--success);"><i class="fas fa-check"></i></button>
                                <button class="action-btn delete"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Users Management -->
            <div class="table-container mb-3">
                <div class="table-header">
                    <h3>👥 GESTION DES UTILISATEURS</h3>
                    <input type="text" class="search-input" placeholder="🔍 Rechercher..." style="max-width: 250px; padding: 10px 15px;">
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Inscrit le</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Jean Dupont</strong></td>
                            <td>jean.dupont@email.com</td>
                            <td><span class="badge badge-info">Acheteur</span></td>
                            <td>12 Oct 2024</td>
                            <td><span class="badge badge-success">Actif</span></td>
                            <td class="actions">
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn delete"><i class="fas fa-ban"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>FFP Events</strong></td>
                            <td>contact@ffp-events.com</td>
                            <td><span class="badge badge-warning">Organisateur</span></td>
                            <td>05 Sep 2024</td>
                            <td><span class="badge badge-success">Actif</span></td>
                            <td class="actions">
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn delete"><i class="fas fa-ban"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Marie Martin</strong></td>
                            <td>marie.martin@email.com</td>
                            <td><span class="badge badge-info">Acheteur</span></td>
                            <td>20 Nov 2024</td>
                            <td><span class="badge badge-danger">Désactivé</span></td>
                            <td class="actions">
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit"><i class="fas fa-check"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>OM Events</strong></td>
                            <td>events@om.fr</td>
                            <td><span class="badge badge-warning">Organisateur</span></td>
                            <td>15 Aug 2024</td>
                            <td><span class="badge badge-success">Actif</span></td>
                            <td class="actions">
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn delete"><i class="fas fa-ban"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination">
                    <span class="active">1</span>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">...</a>
                    <a href="#">10</a>
                </div>
            </div>

            <!-- Global Stats -->
            <div class="table-container">
                <h3 style="margin-bottom: 20px;">📈 STATISTIQUES GLOBALES</h3>
                <div class="stats-grid" style="margin-bottom: 0;">
                    <div class="stat-card" style="background: var(--dark);">
                        <div class="stat-card-info" style="text-align: center; width: 100%;">
                            <h3 style="color: var(--success);">45,892</h3>
                            <p>Billets vendus (total)</p>
                        </div>
                    </div>
                    <div class="stat-card" style="background: var(--dark);">
                        <div class="stat-card-info" style="text-align: center; width: 100%;">
                            <h3 style="color: var(--accent);">1,245,600€</h3>
                            <p>Chiffre d'affaires</p>
                        </div>
                    </div>
                    <div class="stat-card" style="background: var(--dark);">
                        <div class="stat-card-info" style="text-align: center; width: 100%;">
                            <h3 style="color: var(--warning);">4.6/5</h3>
                            <p>Satisfaction moyenne</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>