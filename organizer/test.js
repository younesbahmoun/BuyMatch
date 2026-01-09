// create-match.php
// Multi-step form logic
let currentStep = 1;
const totalSteps = 4;

const nextBtn = document.getElementById('nextBtn');
const prevBtn = document.getElementById('prevBtn');
const submitBtn = document.getElementById('submitBtn');

function updateSteps() {
    // Update step indicators
    document.querySelectorAll('.step').forEach((step, index) => {
        step.classList.remove('active', 'completed');
        if (index + 1 < currentStep) {
            step.classList.add('completed');
        } else if (index + 1 === currentStep) {
            step.classList.add('active');
        }
    });

    // Update form steps
    document.querySelectorAll('.form-step').forEach((step, index) => {
        step.classList.remove('active');
        if (index + 1 === currentStep) {
            step.classList.add('active');
        }
    });

    // Update buttons
    prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
    nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
    submitBtn.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';

    // Update preview on step 4
    if (currentStep === 4) {
        updatePreview();
    }
}

nextBtn.addEventListener('click', () => {
    if (validateStep(currentStep)) {
        currentStep++;
        updateSteps();
    }
});

prevBtn.addEventListener('click', () => {
    currentStep--;
    updateSteps();
});

function validateStep(step) {
    // Basic validation per step
    if (step === 1) {
        const team1 = document.getElementById('team1Name').value;
        const team2 = document.getElementById('team2Name').value;
        if (!team1 || !team2) {
            alert('Veuillez renseigner les noms des deux équipes.');
            return false;
        }
    } else if (step === 2) {
        const date = document.getElementById('matchDate').value;
        const time = document.getElementById('matchTime').value;
        const stadium = document.getElementById('stadiumName').value;
        const city = document.getElementById('city').value;
        if (!date || !time || !stadium || !city) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return false;
        }
    } else if (step === 3) {
        // Check at least category 1 has values
        const cat1Price = document.querySelector('[data-category="1"] .category-price').value;
        const cat1Places = document.querySelector('[data-category="1"] .category-places').value;
        if (!cat1Price || !cat1Places) {
            alert('Veuillez configurer au moins la catégorie 1.');
            return false;
        }
    }
    return true;
}

function updatePreview() {
    // Update preview with form data
    document.getElementById('previewTeam1').textContent = document.getElementById('team1Name').value || 'Équipe 1';
    document.getElementById('previewTeam2').textContent = document.getElementById('team2Name').value || 'Équipe 2';
    
    const date = document.getElementById('matchDate').value;
    const time = document.getElementById('matchTime').value;
    if (date && time) {
        const dateObj = new Date(date);
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        document.getElementById('previewDate').textContent = `📅 ${dateObj.toLocaleDateString('fr-FR', options)} - ${time}`;
    }
    
    const stadium = document.getElementById('stadiumName').value;
    const city = document.getElementById('city').value;
    document.getElementById('previewLocation').textContent = `${stadium}, ${city}`;
    
    const totalPlaces = document.getElementById('totalPlaces').value;
    document.getElementById('previewPlaces').textContent = `${totalPlaces} places`;

    // Categories summary
    let summaryHtml = '';
    let totalPlacesSum = 0;
    let totalRevenue = 0;
    let minPrice = Infinity;

    document.querySelectorAll('.category-card').forEach(card => {
        const name = card.querySelector('.category-name').value;
        const price = parseInt(card.querySelector('.category-price').value) || 0;
        const places = parseInt(card.querySelector('.category-places').value) || 0;
        
        if (places > 0 && price > 0) {
            const revenue = price * places;
            totalPlacesSum += places;
            totalRevenue += revenue;
            if (price < minPrice) minPrice = price;
            
            summaryHtml += `
                <tr>
                    <td>${name}</td>
                    <td>${places}</td>
                    <td>${price}€</td>
                    <td>${revenue.toLocaleString()}€</td>
                </tr>
            `;
        }
    });

    document.getElementById('categoriesSummaryBody').innerHTML = summaryHtml;
    document.getElementById('totalPlacesSummary').textContent = totalPlacesSum;
    document.getElementById('totalRevenueSummary').textContent = totalRevenue.toLocaleString() + '€';
    document.getElementById('previewPrice').textContent = `À partir de ${minPrice === Infinity ? '--' : minPrice}€`;
}

// Logo preview
['team1Logo', 'team2Logo'].forEach((id, index) => {
    document.getElementById(id).addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(`logo${index + 1}Preview`).innerHTML = `<img src="${e.target.result}" alt="Logo">`;
            };
            reader.readAsDataURL(file);
        }
    });
});

// Category toggle
document.querySelectorAll('.category-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const card = this.closest('.category-card');
        card.classList.toggle('disabled', !this.checked);
    });
});

// Calculate places
document.querySelectorAll('.category-places').forEach(input => {
    input.addEventListener('input', updatePlacesSummary);
});

function updatePlacesSummary() {
    let total = 0;
    document.querySelectorAll('.category-card:not(.disabled) .category-places').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    document.getElementById('configuredPlaces').textContent = total;
    const maxPlaces = parseInt(document.getElementById('totalPlaces').value) || 2000;
    document.getElementById('remainingPlaces').textContent = maxPlaces - total;
}

// Form submission
document.getElementById('createMatchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (document.getElementById('termsAccept').checked) {
        document.getElementById('successModal').classList.add('active');
    } else {
        alert('Veuillez accepter les conditions générales.');
    }
});