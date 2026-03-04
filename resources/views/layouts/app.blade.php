<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SER Electrónica – Mendoza')</title>
    <meta name="description" content="@yield('meta_description', 'Tienda de electrónica en Mendoza. Audio, equipos y tecnología. Lavalle 299, Mendoza.')">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="/LogoPagina.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/css/productCard.css', 'resources/js/app.js'])

    @stack('styles')

    @stack('styles')
</head>
<body>

{{-- ============================================================
     NAVBAR
============================================================ --}}
@include('components.navbar')

{{-- Mobile nav - Estilo cuadrado esquina superior derecha --}}
@include('components.mobile-nav')

{{-- ============================================================
     MAIN CONTENT
============================================================ --}}
<main id="main-content">
    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>
    
    @yield('content')
</main>

<script>
// Toast functions available globally
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.position = 'relative';
    
    const icons = {
        success: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
        error: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        warning: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        info: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
    };
    
    toast.innerHTML = `
        ${icons[type] || icons.success}
        <span>${message}</span>
        <button class="toast-close" onclick="dismissToast(this.parentElement)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="toast-progress" style="width: 100%; animation: shrink ${duration}ms linear forwards;"></div>
    `;
    
    container.appendChild(toast);
    
    const timeout = setTimeout(() => { dismissToast(toast); }, duration);
    
    toast.addEventListener('mouseenter', () => {
        clearTimeout(timeout);
        toast.querySelector('.toast-progress').style.animationPlayState = 'paused';
    });
    
    toast.addEventListener('mouseleave', () => {
        const remaining = toast.querySelector('.toast-progress').getBoundingClientRect().width;
        const total = toast.getBoundingClientRect().width;
        const percent = (remaining / total) * duration;
        setTimeout(() => { dismissToast(toast); }, percent);
        toast.querySelector('.toast-progress').style.animationPlayState = 'running';
    });
}

function dismissToast(toast) {
    if (toast.classList.contains('toast-exit')) return;
    toast.classList.add('toast-exit');
    setTimeout(() => { if (toast.parentElement) toast.parentElement.removeChild(toast); }, 300);
}
</script>

{{-- ============================================================
     FOOTER
============================================================ --}}
@include('components.footer')

<script>
    const burger   = document.getElementById('js-burger');
    const mobileNav = document.getElementById('js-mobile-nav');
    const mobileClose = document.getElementById('js-mobile-close');

    // Footer toggles
    document.querySelectorAll('.footer__col-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const group = this.parentElement;
            group.classList.toggle('open');
        });
    });

    burger.addEventListener('click', () => {
        mobileNav.classList.add('open');
        burger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    });

    mobileClose.addEventListener('click', closeMob);
    
    // Cerrar al hacer clic fuera del menú
    mobileNav.addEventListener('click', (e) => {
        if (e.target === mobileNav) {
            closeMob();
        }
    });

    function closeMob() {
        mobileNav.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    // Cerrar con Escape
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMob(); });
</script>

@stack('scripts')

@include('components.floating-whatsapp')
</body>
</html>