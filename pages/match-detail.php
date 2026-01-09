<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSG vs OM - SportTicket</title>
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
                    <li><a href="matches.html">Matchs</a></li>
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

    <!-- Match Detail -->
    <section class="match-detail">
        <div class="match-hero">
            <div class="container">
                <div class="match-hero-content">
                    <div class="team">
                        <div class="team-logo" style="width: 120px; height: 120px; font-size: 3.5rem;">🔴</div>
                        <div class="team-name" style="font-size: 1.8rem; margin-top: 15px;">PARIS SAINT-GERMAIN</div>
                    </div>
                    <div style="text-align: center;">
                        <div class="vs" style="font-size: 3rem;">VS</div>
                        <div style="margin-top: 15px; color: rgba(255,255,255,0.8);">
                            <div><i class="fas fa-calendar"></i> 15 Janvier 2025 - 21:00</div>
                            <div style="margin-top: 8px;"><i class="fas fa-map-marker-alt"></i> Parc des Princes, Paris</div>
                        </div>
                    </div>
                    <div class="team">
                        <div class="team-logo" style="width: 120px; height: 120px; font-size: 3.5rem;">🔵</div>
                        <div class="team-name" style="font-size: 1.8rem; margin-top: 15px;">OLYMPIQUE MARSEILLE</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Vous devez être connecté pour réserver des billets. <a href="login.html" style="color: var(--warning); text-decoration: underline;">Se connecter</a></span>
            </div>

            <div class="match-booking">
                <div class="stadium-map">
                    <h3>🏟️ SÉLECTIONNEZ VOS PLACES</h3>
                    <p style="color: var(--gray); margin-bottom: 20px;">Maximum 4 billets par personne</p>
                    
                    <div class="stadium-visual">
                        <div class="pitch">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: rgba(255,255,255,0.5); font-family: 'Bebas Neue', cursive; font-size: 1.5rem;">TERRAIN</div>
                        </div>
                        
                        <div class="seats-section">
                            <p style="text-align: center; color: var(--accent); margin-bottom: 10px; font-weight: 600;">TRIBUNE VIP - 120€</p>
                            <div class="seat-row">
                                <div class="seat vip" data-seat="A1" data-price="120">A1</div>
                                <div class="seat vip" data-seat="A2" data-price="120">A2</div>
                                <div class="seat vip taken">A3</div>
                                <div class="seat vip" data-seat="A4" data-price="120">A4</div>
                                <div class="seat vip" data-seat="A5" data-price="120">A5</div>
                                <div class="seat vip taken">A6</div>
                                <div class="seat vip" data-seat="A7" data-price="120">A7</div>
                                <div class="seat vip" data-seat="A8" data-price="120">A8</div>
                            </div>
                            <div class="seat-row">
                                <div class="seat vip" data-seat="B1" data-price="120">B1</div>
                                <div class="seat vip taken">B2</div>
                                <div class="seat vip" data-seat="B3" data-price="120">B3</div>
                                <div class="seat vip" data-seat="B4" data-price="120">B4</div>
                                <div class="seat vip taken">B5</div>
                                <div class="seat vip taken">B6</div>
                                <div class="seat vip" data-seat="B7" data-price="120">B7</div>
                                <div class="seat vip" data-seat="B8" data-price="120">B8</div>
                            </div>
                            
                            <p style="text-align: center; color: var(--success); margin: 20px 0 10px; font-weight: 600;">TRIBUNE - 65€</p>
                            <div class="seat-row">
                                <div class="seat tribune" data-seat="C1" data-price="65">C1</div>
                                <div class="seat tribune" data-seat="C2" data-price="65">C2</div>
                                <div class="seat tribune" data-seat="C3" data-price="65">C3</div>
                                <div class="seat tribune taken">C4</div>
                                <div class="seat tribune" data-seat="C5" data-price="65">C5</div>
                                <div class="seat tribune" data-seat="C6" data-price="65">C6</div>
                                <div class="seat tribune" data-seat="C7" data-price="65">C7</div>
                                <div class="seat tribune taken">C8</div>
                                <div class="seat tribune" data-seat="C9" data-price="65">C9</div>
                                <div class="seat tribune" data-seat="C10" data-price="65">C10</div>
                            </div>
                            <div class="seat-row">
                                <div class="seat tribune" data-seat="D1" data-price="65">D1</div>
                                <div class="seat tribune taken">D2</div>
                                <div class="seat tribune" data-seat="D3" data-price="65">D3</div>
                                <div class="seat tribune" data-seat="D4" data-price="65">D4</div>
                                <div class="seat tribune" data-seat="D5" data-price="65">D5</div>
                                <div class="seat tribune taken">D6</div>
                                <div class="seat tribune" data-seat="D7" data-price="65">D7</div>
                                <div class="seat tribune" data-seat="D8" data-price="65">D8</div>
                                <div class="seat tribune" data-seat="D9" data-price="65">D9</div>
                                <div class="seat tribune" data-seat="D10" data-price="65">D10</div>
                            </div>
                            
                            <p style="text-align: center; color: var(--warning); margin: 20px 0 10px; font-weight: 600;">PELOUSE - 45€</p>
                            <div class="seat-row">
                                <div class="seat pelouse" data-seat="E1" data-price="45">E1</div>
                                <div class="seat pelouse" data-seat="E2" data-price="45">E2</div>
                                <div class="seat pelouse" data-seat="E3" data-price="45">E3</div>
                                <div class="seat pelouse" data-seat="E4" data-price="45">E4</div>
                                <div class="seat pelouse taken">E5</div>
                                <div class="seat pelouse" data-seat="E6" data-price="45">E6</div>
                                <div class="seat pelouse" data-seat="E7" data-price="45">E7</div>
                                <div class="seat pelouse" data-seat="E8" data-price="45">E8</div>
                                <div class="seat pelouse" data-seat="E9" data-price="45">E9</div>
                                <div class="seat pelouse" data-seat="E10" data-price="45">E10</div>
                                <div class="seat pelouse" data-seat="E11" data-price="45">E11</div>
                                <div class="seat pelouse" data-seat="E12" data-price="45">E12</div>
                            </div>
                        </div>
                        
                        <div class="seats-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background: rgba(233, 69, 96, 0.3); border: 2px solid var(--accent);"></div>
                                <span>VIP - 120€</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: rgba(0, 210, 106, 0.3); border: 2px solid var(--success);"></div>
                                <span>Tribune - 65€</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: rgba(255, 193, 7, 0.3); border: 2px solid var(--warning);"></div>
                                <span>Pelouse - 45€</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background: var(--gray); opacity: 0.5;"></div>
                                <span>Occupé</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="booking-summary">
                    <h3>🎫 RÉCAPITULATIF</h3>
                    <div id="selectedSeats">
                        <p style="color: var(--gray); text-align: center; padding: 20px;">Sélectionnez vos places sur le plan</p>
                    </div>
                    <div class="summary-item"><span>Match</span><span>PSG vs OM</span></div>
                    <div class="summary-item"><span>Date</span><span>15 Jan 2025</span></div>
                    <div class="summary-item"><span>Heure</span><span>21:00</span></div>
                    <div class="summary-item"><span>Places</span><span id="seatCount">0</span></div>
                    <div class="summary-total"><span>TOTAL</span><span class="price" id="totalPrice">0€</span></div>
                    <button class="btn btn-primary btn-lg" style="width: 100%;" id="bookBtn" disabled>
                        <i class="fas fa-shopping-cart"></i> Réserver
                    </button>
                    <p style="text-align: center; margin-top: 15px; font-size: 0.85rem; color: var(--gray);">
                        <i class="fas fa-lock"></i> Paiement 100% sécurisé
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer mt-4">
        <div class="container">
            <div class="footer-bottom">
                <p>© 2025 SportTicket. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        let selectedSeats = [];
        const maxSeats = 4;

        document.querySelectorAll('.seat:not(.taken)').forEach(seat => {
            seat.addEventListener('click', function() {
                const seatId = this.dataset.seat;
                const price = parseInt(this.dataset.price);
                
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    selectedSeats = selectedSeats.filter(s => s.id !== seatId);
                } else if (selectedSeats.length < maxSeats) {
                    this.classList.add('selected');
                    selectedSeats.push({ id: seatId, price: price });
                } else {
                    alert('Maximum 4 billets par personne !');
                }
                updateSummary();
            });
        });

        function updateSummary() {
            const container = document.getElementById('selectedSeats');
            const countEl = document.getElementById('seatCount');
            const totalEl = document.getElementById('totalPrice');
            const bookBtn = document.getElementById('bookBtn');
            
            if (selectedSeats.length === 0) {
                container.innerHTML = '<p style="color: var(--gray); text-align: center; padding: 20px;">Sélectionnez vos places</p>';
                countEl.textContent = '0';
                totalEl.textContent = '0€';
                bookBtn.disabled = true;
            } else {
                let html = '';
                let total = 0;
                selectedSeats.forEach(seat => {
                    html += `<div class="summary-item"><span>Place ${seat.id}</span><span>${seat.price}€</span></div>`;
                    total += seat.price;
                });
                container.innerHTML = html;
                countEl.textContent = selectedSeats.length;
                totalEl.textContent = total + '€';
                bookBtn.disabled = false;
            }
        }

        document.getElementById('bookBtn').addEventListener('click', function() {
            alert('Veuillez vous connecter pour finaliser votre réservation.');
            window.location.href = 'login.html';
        });
    </script>
</body>
</html>