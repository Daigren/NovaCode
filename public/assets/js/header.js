document.addEventListener('DOMContentLoaded', async function() {
    const profileLink = document.getElementById('navProfileLink');
    const header = document.querySelector('header'); 

    // ─── Determine auth state first ───
    let isLoggedIn = false;
    let profileHref = 'register.php';

    try {
        const response = await fetch('../api/check_auth.php');
        const data = await response.json();
        
        if (data.logged_in === true) {
            isLoggedIn = true;
            profileHref = 'profil.php';
        }
    } catch (error) {
        console.error('Ошибка проверки авторизации:', error);
    }

    // Update desktop profile link
    if (profileLink) {
        profileLink.href = profileHref;
        profileLink.style.opacity = '1';
    }

    // ─── Inject Hamburger & Mobile Nav ───
    if (header) {
        // Create hamburger button
        const hamburger = document.createElement('button');
        hamburger.className = 'hamburger-btn';
        hamburger.setAttribute('aria-label', 'Открыть меню');
        hamburger.innerHTML = '<span></span><span></span><span></span>';
        header.appendChild(hamburger);

        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'mobile-nav-overlay';
        document.body.appendChild(overlay);

        // Create mobile nav
        const mobileNav = document.createElement('nav');
        mobileNav.className = 'mobile-nav';
        mobileNav.innerHTML = `
            <a href="./index.html">Главная</a>
            <a href="./catalog.html">Курсы</a>
            <a href="${profileHref}">Профиль</a>
            <a href="./consultation.php" class="mobile-consultation-btn">Консультация</a>
        `;
        document.body.appendChild(mobileNav);

        // Toggle logic
        function toggleMenu() {
            const isActive = hamburger.classList.contains('active');
            hamburger.classList.toggle('active');
            mobileNav.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = isActive ? '' : 'hidden';
            hamburger.setAttribute('aria-label', isActive ? 'Открыть меню' : 'Закрыть меню');
        }

        hamburger.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Close on link click
        mobileNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (hamburger.classList.contains('active')) {
                    toggleMenu();
                }
            });
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && hamburger.classList.contains('active')) {
                toggleMenu();
            }
        });

        // Close menu on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024 && hamburger.classList.contains('active')) {
                toggleMenu();
            }
        });
    }
});