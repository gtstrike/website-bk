document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Simulation of login process
            const submitBtn = loginForm.querySelector('button');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Memproses...';
            
            // Redirect after 1 second simulation
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 1000);
        });
    }

    // Sidebar interactivity simulation
    const navLinks = document.querySelectorAll('.nav-link');
    if (navLinks.length > 0) {
        navLinks.forEach(link => {
            if (link.classList.contains('logout-btn')) return;
            
            link.addEventListener('click', (e) => {
                if (link.getAttribute('href') === '#') {
                    e.preventDefault();
                    navLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                    
                    // Here you would normally load different components or sections
                    const pageTitle = document.querySelector('.section-title');
                    if (pageTitle) {
                        const text = link.querySelector('.nav-text').textContent;
                        pageTitle.textContent = text;
                    }
                }
            });
        });
    }
});
