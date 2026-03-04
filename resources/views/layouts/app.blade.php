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
<nav class="navbar" role="navigation" aria-label="Navegación principal">
    <div class="navbar__inner">

        <a href="{{ route('home') }}" class="navbar__logo" aria-label="SER Electrónica — Inicio">
            <div class="logo-mark">
                <div class="logo-mark__hex">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width:100%;height:100%;">
                        <polygon points="100,20 170,60 170,140 100,180 30,140 30,60" fill="var(--lime)"/>
                        <g transform="translate(100, 100) scale(0.25) translate(-275, -255)" fill="none" stroke="var(--bg)" stroke-width="55" stroke-linejoin="round" stroke-linecap="round">
                            <path d="M 375 155 L 175 155 L 375 355 L 175 355" />
                        </g>
                    </svg>
                </div>
            </div>
            <span class="navbar__brand">SER <em>ELECTRÓNICA</em></span>
        </a>

        <ul class="navbar__links" role="list">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
            <li><a href="{{ route('catalogo.index') }}" class="{{ request()->routeIs('catalogo.*') ? 'active' : '' }}">Productos</a></li>
            <li><a href="{{ route('promociones.index') }}" class="{{ request()->routeIs('promociones.*') ? 'active' : '' }}">Promociones</a></li>
            <li><a href="{{ route('soporte') }}">Soporte Técnico</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li>
                <a href="https://wa.me/5492613372353?text=Hola!+Quiero+consultar+sobre+un+producto"
                   target="_blank"
                   rel="noopener"
                   class="nav-cta">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.852L.054 23.948l6.257-1.64A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.878 0-3.642-.493-5.163-1.354l-.37-.22-3.838 1.006 1.024-3.74-.241-.385A9.955 9.955 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                    </svg>
                    WhatsApp
                </a>
            </li>
        </ul>

        <button class="navbar__burger" id="js-burger" aria-label="Abrir menú" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- Mobile nav - Estilo cuadrado esquina superior derecha --}}
<div class="mobile-nav" id="js-mobile-nav" role="dialog" aria-label="Menú móvil">
    <div class="mobile-nav__header">
        <span class="mobile-nav__logo">SER <em>ELECTRÓNICA</em></span>
        <button class="mobile-nav__close" id="js-mobile-close" aria-label="Cerrar menú">✕</button>
    </div>
    
    <div class="mobile-nav__links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" onclick="closeMob()">
            Inicio
        </a>
        <a href="{{ route('catalogo.index') }}" class="{{ request()->routeIs('catalogo.*') ? 'active' : '' }}" onclick="closeMob()">
            Productos
        </a>
        <a href="{{ route('promociones.index') }}" class="{{ request()->routeIs('promociones.*') ? 'active' : '' }}" onclick="closeMob()">
            Promociones
        </a>
        <a href="#contacto" onclick="closeMob()">
            Contacto
        </a>
    </div>
    
    <div class="mobile-nav__whatsapp">
        <a href="https://wa.me/5492613372353" target="_blank">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Escribinos
        </a>
    </div>
</div>

{{-- ============================================================
     MAIN CONTENT
============================================================ --}}
<main id="main-content">
    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>
    
    @yield('content')
</main>

<style>
/* Toast Styles - Public Layout */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-radius: var(--radius-lg);
    font-size: 0.9rem;
    font-weight: 500;
    min-width: 280px;
    max-width: 400px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    animation: slideIn 0.3s ease-out;
    color: white;
}

.toast.toast-exit {
    animation: slideOut 0.3s ease-in forwards;
}

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}

.toast-success { background: rgba(34, 197, 94, 0.95); border: 1px solid rgba(34, 197, 94, 0.3); }
.toast-error { background: rgba(239, 68, 68, 0.95); border: 1px solid rgba(239, 68, 68, 0.3); }
.toast-warning { background: rgba(245, 158, 11, 0.95); border: 1px solid rgba(245, 158, 11, 0.3); }
.toast-info { background: rgba(59, 130, 246, 0.95); border: 1px solid rgba(59, 130, 246, 0.3); }

.toast svg { flex-shrink: 0; width: 20px; height: 20; }

.toast-close {
    margin-left: auto;
    background: none;
    border: none;
    color: white;
    opacity: 0.7;
    cursor: pointer;
    padding: 0;
    display: flex;
}

.toast-close:hover { opacity: 1; }

.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: rgba(255,255,255,0.5);
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
}

@keyframes shrink { from { width: 100%; } to { width: 0%; } }
</style>

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