/**
 * Navigation — Mobile menu, scroll spy, smooth scroll, reveal animations
 *
 * @package TahsinRahit
 */
(function () {
    'use strict';

    /* ---------------------------------------------------------------
     * Mobile Menu Toggle
     * --------------------------------------------------------------- */
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            const isOpen = mobileMenu.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', String(isOpen));
            mobileMenu.setAttribute('aria-hidden', String(!isOpen));

            // Toggle icon.
            const icon = menuToggle.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.textContent = isOpen ? 'close' : 'menu';
            }
        });

        // Close mobile menu when clicking a link.
        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.setAttribute('aria-hidden', 'true');
                const icon = menuToggle.querySelector('.material-symbols-outlined');
                if (icon) icon.textContent = 'menu';
            });
        });
    }

    /* ---------------------------------------------------------------
     * Scroll Progress Bar
     * --------------------------------------------------------------- */
    const scrollProgress = document.getElementById('scroll-progress');

    function updateScrollProgress() {
        if (!scrollProgress) return;
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        scrollProgress.style.width = progress + '%';
    }

    /* ---------------------------------------------------------------
     * Navbar Scroll Effect
     * --------------------------------------------------------------- */
    const nav = document.getElementById('site-nav');

    function updateNavScroll() {
        if (!nav) return;
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    }

    /* ---------------------------------------------------------------
     * Throttled Scroll Handler
     * --------------------------------------------------------------- */
    let scrollTicking = false;

    window.addEventListener('scroll', function () {
        if (!scrollTicking) {
            requestAnimationFrame(function () {
                updateScrollProgress();
                updateNavScroll();
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    }, { passive: true });

    /* ---------------------------------------------------------------
     * Smooth Scroll for Anchor Links
     * --------------------------------------------------------------- */
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const navHeight = nav ? nav.offsetHeight : 64;
                const targetTop = target.getBoundingClientRect().top + window.scrollY - navHeight - 20;
                window.scrollTo({ top: targetTop, behavior: 'smooth' });
            }
        });
    });

    /* ---------------------------------------------------------------
     * Scroll Reveal (IntersectionObserver)
     * --------------------------------------------------------------- */
    const revealElements = document.querySelectorAll('.reveal');

    if (revealElements.length > 0 && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
        );

        revealElements.forEach(function (el) {
            revealObserver.observe(el);
        });
    }

    /* ---------------------------------------------------------------
     * Experience Filters (front-page)
     * --------------------------------------------------------------- */
    const expFilterBtns = document.querySelectorAll('.exp-filter-btn');
    const expCards = document.querySelectorAll('.exp-card[data-type]');

    expFilterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = this.dataset.filter;

            // Update active button.
            expFilterBtns.forEach(function (b) { b.classList.remove('active'); });
            this.classList.add('active');

            // Filter cards.
            expCards.forEach(function (card) {
                if (filter === 'all' || card.dataset.type === filter) {
                    card.classList.remove('is-hidden');
                } else {
                    card.classList.add('is-hidden');
                }
            });
        });
    });

    /* ---------------------------------------------------------------
     * Research Tabs (front-page)
     * --------------------------------------------------------------- */
    const researchTabs = document.querySelectorAll('.research-tab');
    const researchPanels = document.querySelectorAll('.research-panel');

    researchTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const target = this.dataset.tab;

            // Update active tab.
            researchTabs.forEach(function (t) { t.classList.remove('active'); });
            this.classList.add('active');

            // Show/hide panels.
            researchPanels.forEach(function (panel) {
                if (panel.id === target) {
                    panel.classList.add('active');
                } else {
                    panel.classList.remove('active');
                }
            });
        });
    });

    /* ---------------------------------------------------------------
     * Prior Education Toggle (front-page)
     * --------------------------------------------------------------- */
    const eduToggle = document.getElementById('edu-toggle');
    const eduPrior = document.getElementById('edu-prior');

    if (eduToggle && eduPrior) {
        eduToggle.addEventListener('click', function () {
            const isOpen = eduPrior.classList.toggle('is-open');
            this.querySelector('.material-symbols-outlined').textContent =
                isOpen ? 'expand_less' : 'expand_more';
        });
    }

    /* ---------------------------------------------------------------
     * Initialize on load
     * --------------------------------------------------------------- */
    updateScrollProgress();
    updateNavScroll();
})();
