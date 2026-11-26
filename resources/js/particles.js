/**
 * Interactive canvas particles background (ported from portofolio_v3)
 * Adapts automatically to light and dark themes.
 */
function initParticles() {
    const canvas = document.getElementById('particles-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const dpr = Math.min(window.devicePixelRatio || 1, 1.5);
    const staticity = 25;
    const ease = 50;
    const baseSize = 0.8;
    const desktopQuantity = 40;

    let circles = [];
    const mouse = { x: 0, y: 0 };
    const canvasSize = { w: 0, h: 0 };
    let rafId = null;

    const getRgbString = () => {
        const isDark = document.documentElement.classList.contains('dark');
        // Dark mode: crisp white particles; Light mode: subtle slate/neutral particles
        return isDark ? '255, 255, 255' : '64, 64, 64';
    };

    let rgbString = getRgbString();

    const circleParams = () => {
        const x = Math.floor(Math.random() * canvasSize.w);
        const y = Math.floor(Math.random() * canvasSize.h);
        const pSize = Math.floor(Math.random() * 2) + baseSize;
        const targetAlpha = parseFloat((Math.random() * 0.45 + 0.1).toFixed(2));
        const dx = (Math.random() - 0.5) * 0.12;
        const dy = (Math.random() - 0.5) * 0.12;
        const magnetism = 0.1 + Math.random() * 4;
        return {
            x,
            y,
            translateX: 0,
            translateY: 0,
            size: pSize,
            alpha: 0,
            targetAlpha,
            dx,
            dy,
            magnetism,
        };
    };

    const drawCircle = (circle, update = false) => {
        const { x, y, translateX, translateY, size: cSize, alpha } = circle;
        ctx.translate(translateX, translateY);
        ctx.beginPath();
        ctx.arc(x, y, cSize, 0, 2 * Math.PI);
        ctx.fillStyle = `rgba(${rgbString}, ${alpha})`;
        ctx.fill();
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

        if (!update) {
            circles.push(circle);
        }
    };

    const clearContext = () => {
        ctx.clearRect(0, 0, canvasSize.w, canvasSize.h);
    };

    const resizeCanvas = () => {
        circles = [];
        canvasSize.w = window.innerWidth;
        canvasSize.h = window.innerHeight;
        canvas.width = canvasSize.w * dpr;
        canvas.height = canvasSize.h * dpr;
        canvas.style.width = `${canvasSize.w}px`;
        canvas.style.height = `${canvasSize.h}px`;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };

    const drawParticles = () => {
        clearContext();
        const count = window.innerWidth < 768 ? 18 : desktopQuantity;
        for (let i = 0; i < count; i++) {
            drawCircle(circleParams());
        }
    };

    const setup = () => {
        resizeCanvas();
        drawParticles();
    };

    const remapValue = (value, start1, end1, start2, end2) => {
        const remapped = ((value - start1) * (end2 - start2)) / (end1 - start1) + start2;
        return remapped > 0 ? remapped : 0;
    };

    const animate = () => {
        if (!document.hidden) {
            clearContext();
            for (let i = circles.length - 1; i >= 0; i--) {
                const circle = circles[i];
                const closestEdge = Math.min(
                    circle.x + circle.translateX - circle.size,
                    canvasSize.w - circle.x - circle.translateX - circle.size,
                    circle.y + circle.translateY - circle.size,
                    canvasSize.h - circle.y - circle.translateY - circle.size
                );
                const remapClosestEdge = parseFloat(remapValue(closestEdge, 0, 20, 0, 1).toFixed(2));
                if (remapClosestEdge > 1) {
                    circle.alpha = Math.min(circle.alpha + 0.02, circle.targetAlpha);
                } else {
                    circle.alpha = circle.targetAlpha * remapClosestEdge;
                }
                circle.x += circle.dx;
                circle.y += circle.dy;
                circle.translateX += (mouse.x / (staticity / circle.magnetism) - circle.translateX) / ease;
                circle.translateY += (mouse.y / (staticity / circle.magnetism) - circle.translateY) / ease;

                drawCircle(circle, true);

                if (
                    circle.x < -circle.size ||
                    circle.x > canvasSize.w + circle.size ||
                    circle.y < -circle.size ||
                    circle.y > canvasSize.h + circle.size
                ) {
                    circles.splice(i, 1);
                    drawCircle(circleParams());
                }
            }
        }
        rafId = window.requestAnimationFrame(animate);
    };

    setup();
    rafId = window.requestAnimationFrame(animate);

    window.addEventListener('resize', setup, { passive: true });
    window.addEventListener(
        'mousemove',
        (event) => {
            const rect = canvas.getBoundingClientRect();
            const x = event.clientX - rect.left - canvasSize.w / 2;
            const y = event.clientY - rect.top - canvasSize.h / 2;
            if (x < canvasSize.w / 2 && x > -canvasSize.w / 2 && y < canvasSize.h / 2 && y > -canvasSize.h / 2) {
                mouse.x = x;
                mouse.y = y;
            }
        },
        { passive: true }
    );

    window.addEventListener('theme-changed', () => {
        rgbString = getRgbString();
    });

    window.addEventListener('beforeunload', () => {
        if (rafId) window.cancelAnimationFrame(rafId);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initParticles);
} else {
    initParticles();
}
