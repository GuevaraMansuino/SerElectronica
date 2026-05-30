document.addEventListener('DOMContentLoaded', () => {
    const burger    = document.getElementById('js-burger');
    const mobileNav = document.getElementById('js-mobile-nav');
    const closeBtn  = document.getElementById('js-mobile-close');

    if (!burger || !mobileNav) return;

    burger.addEventListener('click', openMob);
    closeBtn?.addEventListener('click', closeMob);

    // Cerrar al hacer clic fuera
    mobileNav.addEventListener('click', e => {
        if (e.target === mobileNav) closeMob();
    });

    // Cerrar con Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeMob();
    });
});

function openMob() {
    const burger    = document.getElementById('js-burger');
    const mobileNav = document.getElementById('js-mobile-nav');
    mobileNav.classList.add('open');
    burger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
}

function closeMob() {
    const burger    = document.getElementById('js-burger');
    const mobileNav = document.getElementById('js-mobile-nav');
    mobileNav?.classList.remove('open');
    burger?.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
}