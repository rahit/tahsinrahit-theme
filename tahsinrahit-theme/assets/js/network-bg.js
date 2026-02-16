/**
 * Network Background — Canvas particle animation
 *
 * Ported from Figma's NetworkBackground.tsx.
 * Creates an animated network of particles with mouse interaction.
 *
 * @package TahsinRahit
 */
(function () {
    'use strict';

    const canvas = document.getElementById('network-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let width = window.innerWidth;
    let height = window.innerHeight;
    let mouseX = -1000;
    let mouseY = -1000;
    let animationId = null;

    const PARTICLE_COUNT = Math.min(60, Math.floor((width * height) / 25000));
    const CONNECTION_DISTANCE = 150;
    const MOUSE_RADIUS = 120;
    const PARTICLE_COLOR = 'rgba(0, 229, 255, 0.5)';
    const LINE_COLOR_BASE = [0, 229, 255];

    const particles = [];

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    }

    function createParticle() {
        return {
            x: Math.random() * width,
            y: Math.random() * height,
            vx: (Math.random() - 0.5) * 0.5,
            vy: (Math.random() - 0.5) * 0.5,
            radius: Math.random() * 2 + 1,
        };
    }

    function init() {
        resize();
        particles.length = 0;
        for (let i = 0; i < PARTICLE_COUNT; i++) {
            particles.push(createParticle());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < particles.length; i++) {
            const p = particles[i];

            // Update position.
            p.x += p.vx;
            p.y += p.vy;

            // Bounce off edges.
            if (p.x < 0 || p.x > width) p.vx *= -1;
            if (p.y < 0 || p.y > height) p.vy *= -1;

            // Clamp.
            p.x = Math.max(0, Math.min(width, p.x));
            p.y = Math.max(0, Math.min(height, p.y));

            // Mouse repulsion.
            const dx = p.x - mouseX;
            const dy = p.y - mouseY;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < MOUSE_RADIUS && dist > 0) {
                const force = (MOUSE_RADIUS - dist) / MOUSE_RADIUS;
                p.vx += (dx / dist) * force * 0.02;
                p.vy += (dy / dist) * force * 0.02;
            }

            // Speed limit.
            const speed = Math.sqrt(p.vx * p.vx + p.vy * p.vy);
            if (speed > 1) {
                p.vx *= 0.99;
                p.vy *= 0.99;
            }

            // Draw particle.
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = PARTICLE_COLOR;
            ctx.fill();

            // Draw connections.
            for (let j = i + 1; j < particles.length; j++) {
                const p2 = particles[j];
                const cdx = p.x - p2.x;
                const cdy = p.y - p2.y;
                const cDist = Math.sqrt(cdx * cdx + cdy * cdy);

                if (cDist < CONNECTION_DISTANCE) {
                    const opacity = (1 - cDist / CONNECTION_DISTANCE) * 0.3;
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.strokeStyle = `rgba(${LINE_COLOR_BASE[0]}, ${LINE_COLOR_BASE[1]}, ${LINE_COLOR_BASE[2]}, ${opacity})`;
                    ctx.lineWidth = 0.5;
                    ctx.stroke();
                }
            }
        }

        animationId = requestAnimationFrame(animate);
    }

    // Event listeners.
    window.addEventListener('resize', function () {
        resize();
    });

    document.addEventListener('mousemove', function (e) {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    document.addEventListener('mouseleave', function () {
        mouseX = -1000;
        mouseY = -1000;
    });

    // Reduced motion support.
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (!prefersReducedMotion.matches) {
        init();
        animate();
    }

    prefersReducedMotion.addEventListener('change', function (e) {
        if (e.matches) {
            cancelAnimationFrame(animationId);
        } else {
            init();
            animate();
        }
    });
})();
