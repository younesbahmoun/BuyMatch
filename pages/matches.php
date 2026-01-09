<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matchs - SportTicket</title>
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
                
                <ul class="nav-links">
                    <li><a href="../index.html">Accueil</a></li>
                    <li><a href="matches.html" class="active">Matchs</a></li>
                    <li><a href="#">Stades</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                
                <div class="nav-actions">
                    <a href="login.html" class="btn btn-outline btn-sm">Connexion</a>
                    <a href="register.html" class="btn btn-primary btn-sm">Inscription</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Page Header -->
    <section class="section" style="padding-top: 120px; background: var(--gradient-primary);">
        <div class="container text-center">
            <h1 style="font-size: 3.5rem; margin-bottom: 15px;">🏆 TOUS LES MATCHS</h1>
            <p style="opacity: 0.9; font-size: 1.1rem;">Découvrez et réservez vos billets pour les prochains matchs</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="search-section" style="margin-top: 0; border-radius: 0;">
        <div class="container">
            <form class="search-box">
                <input type="text" class="search-input" placeholder="🔍 Rechercher un match ou une équipe...">
                <select class="search-select">
                    <option value="">📍 Tous les lieux</option>
                    <option value="paris">Paris</option>
                    <option value="marseille">Marseille</option>
                    <option value="lyon">Lyon</option>
                    <option value="bordeaux">Bordeaux</option>
                    <option value="lille">Lille</option>
                    <option value="saint-etienne">Saint-Étienne</option>
                </select>
                <select class="search-select">
                    <option value="">📅 Toutes les dates</option>
                    <option value="today">Aujourd'hui</option>
                    <option value="tomorrow">Demain</option>
                    <option value="week">Cette semaine</option>
                    <option value="month">Ce mois</option>
                </select>
                <select class="search-select">
                    <option value="">💰 Tous les prix</option>
                    <option value="0-30">0€ - 30€</option>
                    <option value="30-60">30€ - 60€</option>
                    <option value="60-100">60€ - 100€</option>
                    <option value="100+">100€+</option>
                </select>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>
    </section>

    <!-- Matches List -->
    <section class="section">
        <div class="container">
            <div class="d-flex justify-between align-center mb-3">
                <p style="color: var(--gray);">12 matchs trouvés</p>
                <select class="search-select" style="min-width: 150px;">
                    <option>Trier par date</option>
                    <option>Prix croissant</option>
                    <option>Prix décroissant</option>
                    <option>Places disponibles</option>
                </select>
            </div>
            
            <div class="matches-grid">
                <!-- Match Card 1 -->
                <div class="match-card">
                    <div class="match-header">
                        <span class="match-date">📅 15 Jan 2025 - 21:00</span>
                        <span class="match-status status-available">Disponible</span>
                    </div>
                    <div class="match-teams">
                        <div class="team">
                            <div class="team-logo">🔴</div>
                            <div class="team-name">PSG</div>
                        </div>
                        <div class="vs">VS</div>
                        <div class="team">
                            <div class="team-logo">🔵</div>
                            <div class="team-name">OM</div>
                        </div>
                    </div>
                    <div class="match-info">
                        <div class="match-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Parc des Princes, Paris</span>
                        </div>
                        <div class="match-info-item">
                            <i class="fas fa-users"></i>
                            <span>1,847 places disponibles</span>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-price">À partir de 45€ <span>/ place</span></div>
                        <a href="match-detail.html" class="btn btn-primary btn-sm">Réserver</a>
                    </div>
                </div>

                <!-- Match Card 2 -->
                <div class="match-card">
                    <div class="match-header">
                        <span class="match-date">📅 18 Jan 2025 - 17:00</span>
                        <span class="match-status status-available">Disponible</span>
                    </div>
                    <div class="match-teams">
                        <div class="team">
                            <div class="team-logo">🟢</div>
                            <div class="team-name">ASSE</div>
                        </div>
                        <div class="vs">VS</div>
                        <div class="team">
                            <div class="team-logo">🟡</div>
                            <div class="team-name">FC NANTES</div>
                        </div>
                    </div>
                    <div class="match-info">
                        <div class="match-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Geoffroy-Guichard, Saint-Étienne</span>
                        </div>
                        <div class="match-info-item">
                            <i class="fas fa-users"></i>
                            <span>956 places disponibles</span>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-price">À partir de 25€ <span>/ place</span></div>
                        <a href="match-detail.html" class="btn btn-primary btn-sm">Réserver</a>
                    </div>
                </div>

                <!-- Match Card 3 -->
                <div class="match-card">
                    <div class="match-header">
                        <span class="match-date">📅 22 Jan 2025 - 20:45</span>
                        <span class="match-status status-pending">Presque complet</span>
                    </div>
                    <div class="match-teams">
                        <div class="team">
                            <div class="team-logo">🔵</div>
                            <div class="team-name">OL</div>
                        </div>
                        <div class="vs">VS</div>
                        <div class="team">
                            <div class="team-logo">⚫</div>
                            <div class="team-name">MONACO</div>
                        </div>
                    </div>
                    <div class="match-info">
                        <div class="match-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Groupama Stadium, Lyon</span>
                        </div>
                        <div class="match-info-item">
                            <i class="fas fa-users"></i>
                            <span>124 places disponibles</span>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-price">À partir de 35€ <span>/ place</span></div>
                        <a href="match-detail.html" class="btn btn-primary btn-sm">Réserver</a>
                    </div>
                </div>

                <!-- Match Card 4 -->
                <div class="match-card">
                    <div class="match-header">
                        <span class="match-date">📅 25 Jan 2025 - 19:00</span>
                        <span class="match-status status-soldout">Complet</span>
                    </div>
                    <div class="match-teams">
                        <div class="team">
                            <div class="team-logo">🔴</div>
                            <div class="team-name">LOSC</div>
                        </div>
                        <div class="vs">VS</div>
                        <div class="team">
                            <div class="team-logo">🔴</div>
                            <div class="team-name">RENNES</div>
                        </div>
                    </div>
                    <div class="match-info">
                        <div class="match-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Pierre Mauroy, Lille</span>
                        </div>
                        <div class="match-info-item">
                            <i class="fas fa-users"></i>
                            <span>0 places disponibles</span>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-price">Complet</div>
                        <button class="btn btn-secondary btn-sm" disabled>Indisponible</button>
                    </div>
                </div>

                <!-- Match Card 5 -->
                <div class="match-card">
                    <div class="match-header">
                        <span class="match-date">📅 28 Jan 2025 - 21:00</span>
                        <span class="match-status status-available">Disponible</span>
                    </div>
                    <div class="match-teams">
                        <div class="team">
                            <div class="team-logo">🟣</div>
                            <div class="team-name">TOULOUSE</div>
                        </div>
                        <div class="vs">VS</div>
                        <div class="team">
                            <div class="team-logo">🔵</div>
                            <div class="team-name">STRASBOURG</div>
                        </div>
                    </div>
                    <div class="match-info">
                        <div class="match-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Stadium Municipal, Toulouse</span>
                        </div>
                        <div class="match-info-item">
                            <i class="fas fa-users"></i>
                            <span>1,523 places disponibles</span>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-price">À partir de 20€ <span>/ place</span></div>
                        <a href="match-detail.html" class="btn btn-primary btn-sm">Réserver</a>
                    </div>
                </div>

                <!-- Match Card 6 -->
                <div class="match-card">
                    <div class="match-header">
                        <span class="match-date">📅 01 Fév 2025 - 17:00</span>
                        <span class="match-status status-available">Disponible</span>
                    </div>
                    <div class="match-teams">
                        <div class="team">
                            <div class="team-logo">🔵</div>
                            <div class="team-name">OM</div>
                        </div>
                        <div class="vs">VS</div>
                        <div class="team">
                            <div class="team-logo">⚫</div>
                            <div class="team-name">NICE</div>
                        </div>
                    </div>
                    <div class="match-info">
                        <div class="match-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Vélodrome, Marseille</span>
                        </div>
                        <div class="match-info-item">
                            <i class="fas fa-users"></i>
                            <span>2,000 places disponibles</span>
                        </div>
                    </div>
                    <div class="match-footer">
                        <div class="match-price">À partir de 30€ <span>/ place</span></div>
                        <a href="match-detail.html" class="btn btn-primary btn-sm">Réserver</a>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <span class="active">1</span>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">→</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="logo" style="margin-bottom: 20px;">
                        <div class="logo-icon">⚽</div>
                        <span>SportTicket</span>
                    </div>
                    <p style="color: var(--gray);">La plateforme n°1 pour réserver vos billets de matchs.</p>
                </div>
                
                <div class="footer-col">
                    <h4>LIENS RAPIDES</h4>
                    <ul>
                        <li><a href="matches.html">Tous les matchs</a></li>
                        <li><a href="#">Stades</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>ESPACE MEMBRE</h4>
                    <ul>
                        <li><a href="login.html">Connexion</a></li>
                        <li><a href="register.html">Inscription</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>CONTACT</h4>
                    <ul>
                        <li><a href="#">support@sporticket.com</a></li>
                        <li><a href="#">+33 1 23 45 67 89</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© 2025 SportTicket. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="../js/main.js"></script>
</body>
</html>