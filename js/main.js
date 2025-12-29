/**
 * SportTicket - Main JavaScript
 * Plateforme de Billetterie Sportive
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Navigation Toggle
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('navLinks');
    
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            
            // Animate hamburger
            const spans = hamburger.querySelectorAll('span');
            spans.forEach((span, index) => {
                span.style.transform = navLinks.classList.contains('active') 
                    ? index === 0 ? 'rotate(45deg) translate(5px, 5px)' 
                    : index === 1 ? 'opacity: 0' 
                    : 'rotate(-45deg) translate(7px, -6px)'
                    : '';
            });
        });
    }
    
    // Smooth Scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Header scroll effect
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.style.background = 'rgba(15, 15, 26, 0.98)';
                header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
            } else {
                header.style.background = 'rgba(15, 15, 26, 0.95)';
                header.style.boxShadow = 'none';
            }
        });
    }
    
    // Alert auto-dismiss
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--danger)';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('Veuillez remplir tous les champs obligatoires.', 'error');
            }
        });
    });
    
    // Password confirmation check
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');
    
    if (password && passwordConfirm) {
        passwordConfirm.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.style.borderColor = 'var(--danger)';
            } else {
                this.style.borderColor = 'var(--success)';
            }
        });
    }
    
    // Modal functionality
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };
    
    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    };
    
    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
    });
    
    // Notification system
    window.showNotification = function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        notification.style.position = 'fixed';
        notification.style.top = '100px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.animation = 'slideIn 0.3s ease';
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100px)';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    };
    
    // Rating stars interaction
    const ratingInputs = document.querySelectorAll('.rating-input');
    ratingInputs.forEach(container => {
        const stars = container.querySelectorAll('span');
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                stars.forEach((s, i) => {
                    s.classList.toggle('active', i <= index);
                    s.textContent = i <= index ? '★' : '☆';
                });
            });
            
            star.addEventListener('mouseenter', function() {
                stars.forEach((s, i) => {
                    s.style.color = i <= index ? 'var(--warning)' : 'var(--gray)';
                });
            });
            
            container.addEventListener('mouseleave', function() {
                stars.forEach(s => {
                    s.style.color = s.classList.contains('active') ? 'var(--warning)' : 'var(--gray)';
                });
            });
        });
    });
    
    // Search form handling
    const searchForms = document.querySelectorAll('.search-box');
    searchForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const searchInput = this.querySelector('.search-input');
            const query = searchInput ? searchInput.value.trim() : '';
            
            if (query) {
                // Simulate search - in production, this would redirect or filter
                showNotification(`Recherche de "${query}"...`, 'info');
            }
        });
    });
    
    // Animate elements on scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.match-card, .feature-card, .stat-card');
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight - 100) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Initial animation setup
    document.querySelectorAll('.match-card, .feature-card, .stat-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.5s ease';
    });
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Initial check
    
    // Table row click handler (for dashboards)
    document.querySelectorAll('.data-table tbody tr').forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.actions')) {
                // Row click action - could open detail view
                this.classList.toggle('selected');
            }
        });
    });
    
    // Action buttons handlers
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            if (this.classList.contains('view')) {
                showNotification('Affichage des détails...', 'info');
            } else if (this.classList.contains('edit')) {
                showNotification('Mode édition activé', 'info');
            } else if (this.classList.contains('delete')) {
                if (confirm('Êtes-vous sûr de vouloir effectuer cette action ?')) {
                    showNotification('Action effectuée', 'success');
                }
            }
        });
    });
    
    console.log('🎫 SportTicket initialized successfully!');
});

// Add CSS animation keyframes dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);