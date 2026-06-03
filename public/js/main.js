document.addEventListener('DOMContentLoaded', function() {
    initNavbarScroll();
    initScrollAnimations();
    initSmoothScroll();
    initAlertAutoDismiss();
    initFormValidation();
    initButtonRipple();
});

function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    let lastScroll = 0;
    const threshold = 50;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        if (currentScroll > threshold) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });
}

function initScrollAnimations() {
    const animateElements = document.querySelectorAll('[data-animate]');
    if (animateElements.length === 0) return;

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -80px 0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.delay || '0ms';
                entry.target.style.transitionDelay = delay;
                entry.target.classList.add('animate-visible');
            }
        });
    }, observerOptions);

    animateElements.forEach(el => observer.observe(el));
}

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

function initAlertAutoDismiss() {
    const alerts = document.querySelectorAll('.alert.success, .alert-success');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'slideOutUp 0.5s ease forwards';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
}

function initFormValidation() {
    const authForm = document.querySelector('.auth-wrapper .auth-form');
    if (!authForm) return;

    const inputs = authForm.querySelectorAll('input[required], input[type="email"], input[name="password"], input[name="confirm"]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(this);
        });
        
        input.addEventListener('focus', function() {
            this.classList.remove('input-error', 'input-success');
            const msg = this.parentElement.querySelector('.input-feedback');
            if (msg) msg.remove();
        });
    });

    authForm.addEventListener('submit', function(e) {
        let isValid = true;
        inputs.forEach(input => {
            if (!validateInput(input)) isValid = false;
        });
        if (!isValid) e.preventDefault();
    });
}

function validateInput(input) {
    const group = input.parentElement;
    let feedback = group.querySelector('.input-feedback');
    if (feedback) feedback.remove();
    
    input.classList.remove('input-error', 'input-success');
    
    let valid = true;
    let message = '';

    if (input.hasAttribute('required') && !input.value.trim()) {
        valid = false;
        message = 'Field ini wajib diisi.';
    }
    
    if (valid && input.type === 'email' && input.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(input.value)) {
            valid = false;
            message = 'Format email tidak valid.';
        }
    }
    
    const form = input.closest('form');
    if (valid && input.name === 'password' && form.querySelector('input[name="confirm"]') && input.value.length > 0 && input.value.length < 6) {
        valid = false;
        message = 'Password minimal 6 karakter.';
    }
    
    if (valid && input.name === 'confirm') {
        const passwordField = input.closest('form').querySelector('input[name="password"]');
        if (passwordField && input.value !== passwordField.value) {
            valid = false;
            message = 'Konfirmasi password tidak sesuai.';
        }
    }

    if (!valid) {
        input.classList.add('input-error');
        showFeedback(group, message, 'error');
    } else if (input.value.trim()) {
        input.classList.add('input-success');
    }

    return valid;
}

function showFeedback(group, message, type) {
    const feedback = document.createElement('span');
    feedback.className = `input-feedback input-feedback-${type}`;
    feedback.textContent = message;
    feedback.style.cssText = 'display:block;margin-top:6px;font-size:13px;color:#ef4444;';
    group.appendChild(feedback);
}

function initButtonRipple() {
    document.querySelectorAll('.btn-contact, .btn-beli, .btn-primary, .btn-daftar, .btn-konfirmasi').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.cssText = `
                position: absolute;
                background: rgba(255,255,255,0.4);
                border-radius: 50%;
                transform: scale(0);
                animation: rippleEffect 0.6s ease-out;
                pointer-events: none;
            `;
            
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x - size/2 + 'px';
            ripple.style.top = y - size/2 + 'px';
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
}
