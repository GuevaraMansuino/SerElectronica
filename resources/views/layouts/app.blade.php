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

    <style>
    /* ================================================================
       SER ELECTRÓNICA — DESIGN SYSTEM
       Circuit Navy #0C1A2B  ·  Solar Lime #B6FF3B
    ================================================================ */
    :root {
        /* 60% — Fondo principal (Verde Bosque) */
        --bg:           #2A4941;
        /* 20% — Superficies / Cards (Verde ligeramente más claro) */
        --surface:      #33524A;
        --surface-2:    #3C5F56;
        --surface-3:    #1E3630;

        /* Bordes */
        --border:       rgba(220, 208, 186, 0.15);
        --border-solid: #DCD0BA;

        /* 10% — Texto (Beige Claro para leer sobre verde) */
        --text:         #F0EAD6;
        --text-2:       #DCD0BA; /* Beige Original */
        --text-3:       #A89F8E;

        /* 10% — Acento (Beige) */
        --lime:         #DCD0BA;
        --lime-dim:     rgba(220, 208, 186, 0.1);
        --lime-glow:    rgba(220, 208, 186, 0.25);
        --lime-dark:    #C4B8A0;

        /* Estados */
        --danger:       #DC2626;
        --success:      #16A34A;
        --warning:      #D97706;

        /* Tipografía */
        --font-display: 'Barlow Condensed', sans-serif;
        --font-body:    'Barlow', sans-serif;
        --font-mono:    'Fira Code', monospace;

        /* Otros */
        --radius:       6px;
        --radius-lg:    12px;
        --radius-xl:    20px;
        --t:            0.22s cubic-bezier(0.4, 0, 0.2, 1);
        --shadow:       0 4px 24px rgba(0,0,0,0.4);
        --shadow-lime:  0 0 32px rgba(220, 208, 186, 0.15);
    }

    /* ================================================================
       RESET
    ================================================================ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
        font-family: var(--font-body);
        background: var(--bg);
        color: var(--text);
        line-height: 1.6;
        overflow-x: hidden;
    }

    /* Circuit board pattern sutil en el fondo */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image:
            linear-gradient(rgba(220,208,186,0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(220,208,186,0.05) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
        z-index: 0;
    }

    body > * { position: relative; z-index: 1; }
    img { max-width: 100%; display: block; }
    a { color: inherit; text-decoration: none; }

    /* ================================================================
       NAVBAR
    ================================================================ */
    .navbar {
        position: sticky;
        top: 0;
        z-index: 200;
        background: rgba(42, 73, 65, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border);
    }

    .navbar__inner {
        max-width: 100%;
        margin: 0 auto;
        padding: 0 8vw;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    /* Logo */
    .navbar__logo {
        display: flex;
        align-items: center;
        gap: 11px;
        flex-shrink: 0;
    }

    .logo-mark {
        position: relative;
        width: 38px;
        height: 38px;
    }

    .logo-mark__hex {
        width: 38px;
        height: 38px;
        clip-path: polygon(50% 0%, 95% 25%, 95% 75%, 50% 100%, 5% 75%, 5% 25%);
        display: grid;
        place-items: center;
    }

    .logo-mark__letter {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 800;
        color: var(--bg);
        letter-spacing: -0.02em;
    }

    .navbar__brand {
        font-family: var(--font-display);
        font-size: 1.55rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: var(--text);
        line-height: 1;
    }

    .navbar__brand em {
        color: var(--lime);
        font-style: normal;
    }

    /* Nav links */
    .navbar__links {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        list-style: none;
    }

    .navbar__links a {
        display: block;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-2);
        border-radius: var(--radius);
        transition: all var(--t);
    }

    .navbar__links a:hover {
        color: var(--text);
        background: var(--lime-dim);
    }

    .navbar__links a.active {
        color: var(--lime);
    }

    /* CTA button */
    .nav-cta {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 20px;
        background: var(--lime);
        color: var(--bg) !important;
        font-weight: 700 !important;
        border-radius: var(--radius);
        font-size: 0.82rem !important;
        letter-spacing: 0.08em;
        transition: all var(--t) !important;
    }

    .nav-cta:hover {
        background: #c8ff5a !important;
        box-shadow: var(--shadow-lime) !important;
        transform: translateY(-1px);
    }

    /* Burger mobile - Mejorado */
    .navbar__burger {
        display: none;
        background: var(--surface);
        border: 1px solid var(--lime);
        border-radius: var(--radius);
        padding: 10px;
        cursor: pointer;
        flex-direction: column;
        gap: 5px;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
    }

    .navbar__burger:hover {
        background: var(--lime-dim);
    }

    .navbar__burger span {
        display: block;
        width: 22px;
        height: 2px;
        background: var(--lime);
        border-radius: 2px;
        transition: var(--t);
    }

    /* Mobile nav overlay - Estilo cuadrado esquina superior */
    .mobile-nav {
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        width: 85%;
        max-width: 320px;
        height: 100vh;
        background: var(--surface);
        border-left: 2px solid var(--lime);
        z-index: 500;
        flex-direction: column;
        padding: 80px 30px 30px;
        gap: 0;
        box-shadow: -10px 0 40px rgba(0,0,0,0.5);
    }

    .mobile-nav.open { 
        display: flex; 
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .mobile-nav__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-solid);
    }

    .mobile-nav__logo {
        font-family: var(--font-display);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
    }

    .mobile-nav__logo em {
        color: var(--lime);
    }

    .mobile-nav__close {
        background: var(--surface-2);
        border: 1px solid var(--lime);
        border-radius: var(--radius);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--lime);
        font-size: 1.2rem;
        cursor: pointer;
        transition: var(--t);
    }

    .mobile-nav__close:hover {
        background: var(--lime);
        color: var(--bg);
    }

    .mobile-nav__links {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .mobile-nav a {
        font-family: var(--font-display);
        font-size: 1.4rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--text-2);
        padding: 14px 0;
        border-bottom: 1px solid var(--border-solid);
        transition: all var(--t);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .mobile-nav a:hover {
        color: var(--lime);
        padding-left: 10px;
    }

    /* Estado activo - página actual */
    .mobile-nav a.active {
        color: var(--lime);
        font-weight: 700;
    }

    .mobile-nav a.active::after {
        content: '●';
        font-size: 0.6rem;
        color: var(--lime);
    }

    .mobile-nav__whatsapp {
        margin-top: auto;
        padding-top: 1.5rem;
    }

    .mobile-nav__whatsapp a {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: var(--lime) !important;
        color: var(--bg) !important;
        font-size: 1rem !important;
        font-weight: 700;
        padding: 14px 24px !important;
        border-radius: var(--radius-lg) !important;
        border: none !important;
        width: 100%;
        transition: all var(--t) !important;
    }

    .mobile-nav__whatsapp a:hover {
        background: var(--lime-dark) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(182, 255, 59, 0.3);
        padding-left: 24px !important;
    }

    .mobile-nav__whatsapp a::before {
        content: '';
    }

    /* ================================================================
       FOOTER
    ================================================================ */
    .site-footer {
        background: var(--surface);
        border-top: 1px solid var(--border);
        margin-top: 7rem;
    }

    .footer__main {
        max-width: 100%;
        margin: 0 auto;
        padding: 4.5rem 8vw 3rem;
        display: grid;
        grid-template-columns: 1.8fr 1fr 1fr 1fr;
        gap: 3rem;
    }

    .footer__brand-block {}

    .footer__logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.2rem;
    }

    .footer__brand-name {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 0.06em;
    }

    .footer__brand-name em { color: var(--lime); font-style: normal; }

    .footer__desc {
        font-size: 0.98rem;
        color: var(--text-2);
        line-height: 1.75;
        max-width: 270px;
        margin-bottom: 1.8rem;
    }

    .footer__contact-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.85rem;
        color: var(--text-2);
        margin-bottom: 0.7rem;
        transition: color var(--t);
    }

    .footer__contact-row:hover { color: var(--lime); }

    .footer__contact-row svg { color: var(--lime); flex-shrink: 0; }

    .footer__col-title {
        font-family: var(--font-mono);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: var(--lime);
        margin-bottom: 1.2rem;
    }
    
    /* Footer toggle button - hidden on desktop */
    .footer__col-toggle {
        display: none;
    }

    .footer__nav-list { list-style: none; display: flex; flex-direction: column; gap: 0.65rem; }

    .footer__nav-list a {
        font-size: 0.88rem;
        color: var(--text-2);
        transition: color var(--t);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .footer__nav-list a::before {
        content: '›';
        color: var(--lime);
        font-size: 1rem;
        line-height: 1;
    }

    .footer__nav-list a:hover { color: var(--lime); }

    .footer__schedule div {
        font-size: 0.85rem;
        color: var(--text-2);
        margin-bottom: 0.4rem;
    }

    .footer__schedule strong { color: var(--text); font-size: 0.8rem; }

    .footer__bottom {
        border-top: 1px solid var(--border);
        padding: 1.4rem 5vw;
        max-width: 1320px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.78rem;
        color: var(--text-3);
    }

    .footer__lime-bar {
        height: 3px;
        background: linear-gradient(90deg, var(--lime) 0%, transparent 100%);
    }

    /* ================================================================
       UTILITIES COMPARTIDAS
    ================================================================ */
    .container {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 5vw;
    }

    /* Section label */
    .sec-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-mono);
        font-size: 0.68rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: var(--lime);
        margin-bottom: 0.9rem;
    }

    .sec-label::before {
        content: '';
        display: inline-block;
        width: 24px;
        height: 2px;
        background: var(--lime);
    }

    /* Section title */
    .sec-title {
        font-family: var(--font-display);
        font-size: clamp(2.2rem, 5vw, 3.8rem);
        font-weight: 800;
        letter-spacing: 0.03em;
        line-height: 1;
        color: var(--text);
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: var(--radius);
        font-family: var(--font-body);
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        cursor: pointer;
        border: none;
        transition: all var(--t);
        white-space: nowrap;
    }

    .btn-lime {
        background: var(--lime);
        color: var(--bg);
    }

    .btn-lime:hover {
        background: #c8ff5a;
        box-shadow: var(--shadow-lime);
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        color: var(--text-2);
        border: 1px solid var(--border-solid);
    }

    .btn-outline:hover {
        border-color: var(--lime);
        color: var(--lime);
        background: var(--lime-dim);
    }

    .btn-ghost {
        background: transparent;
        color: var(--lime);
        padding: 0;
        font-size: 0.82rem;
        letter-spacing: 0.08em;
    }

    .btn-ghost:hover {
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    /* Divisor decorativo */
    .divider-lime {
        height: 1px;
        background: linear-gradient(90deg, var(--lime) 0%, rgba(182,255,59,0.2) 40%, transparent 100%);
    }

    /* ================================================================
       RESPONSIVE
    ================================================================ */
    @media (max-width: 1024px) {
        .footer__main { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 820px) {
        .navbar__links { display: none; }
        .navbar__burger { display: flex; }
        .footer__main { 
            grid-template-columns: 1fr; 
            gap: 0; 
            padding: 1.5rem 5vw 1rem; 
        }
        .footer__desc { max-width: 100%; }
        .footer__bottom { flex-direction: column; gap: 0.5rem; text-align: center; }
        
        /* Footer toggles */
        .footer__col-group {
            border-bottom: 1px solid var(--border);
        }
        .footer__col-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            background: none;
            border: none;
            padding: 1rem 0;
            cursor: pointer;
            color: var(--text);
        }
        .footer__col-title {
            margin-bottom: 0;
        }
        .footer__col-arrow {
            transition: transform var(--t);
        }
        .footer__col-group.open .footer__col-arrow {
            transform: rotate(180deg);
        }
        .footer__nav-list,
        .footer__schedule {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding-bottom: 0;
        }
        .footer__col-group.open .footer__nav-list,
        .footer__col-group.open .footer__schedule {
            max-height: 300px;
            padding-bottom: 1rem;
        }
    }
    
    /* Pantallas grandes - aprovechar todo el ancho */
    @media (min-width: 1400px) {
        .navbar__inner {
            padding: 0 10vw;
        }
        .footer__main {
            padding: 5rem 10vw 3.5rem;
        }
    }
    
    @media (min-width: 1920px) {
        .navbar__inner {
            padding: 0 15vw;
        }
        .footer__main {
            padding: 6rem 15vw 4rem;
        }
    }
    </style>

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
<div class="footer__lime-bar"></div>

<footer class="site-footer" id="contacto" aria-label="Pie de página">
    <div class="footer__main">

        {{-- Brand --}}
        <div class="footer__brand-block">
            <div class="footer__logo">
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
                <span class="footer__brand-name">SER <em>ELECTRÓNICA</em></span>
            </div>
            {{-- GGM Watermark --}}
            <div style="margin-top:1rem;opacity:0.6;">
                <img src="{{ asset('ggm-logo.svg') }}" alt="GGM" style="width:50px;height:auto;">
                <div style="font-size:0.7rem;color:var(--text-3);margin-top:0.3rem;">Desarrollador Web Gerónimo Guevara Mansuino</div>
            </div>
            <p class="footer__desc">
                Tu tienda de electrónica en Mendoza. Audio profesional, equipos de música, altavoces y tecnología de primera calidad con asesoramiento personalizado.
            </p>
            <a href="https://maps.google.com/?q=SER+Mendoza" target="_blank" class="footer__contact-row">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Lavalle 299, Mendoza Capital
            </a>
            <a href="tel:02613372353" class="footer__contact-row">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.5a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .84h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.09a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0121.15 15l.77 1.92z"/></svg>
                0261 337-2353
            </a>
        </div>

        {{-- Navegación --}}
        <div class="footer__col-group">
            <button class="footer__col-toggle" type="button">
                <span class="footer__col-title">Navegación</span>
                <svg class="footer__col-arrow" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <ul class="footer__nav-list">
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('catalogo.index') }}">Todos los Productos</a></li>
                <li><a href="{{ route('promociones.index') }}">Promociones</a></li>
                <li><a href="{{ route('soporte') }}">Soporte Técnico</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </div>

        {{-- Categorías --}}
        <div class="footer__col-group">
            <button class="footer__col-toggle" type="button">
                <span class="footer__col-title">Categorías</span>
                <svg class="footer__col-arrow" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <ul class="footer__nav-list">
                @foreach(\App\Models\Category::take(6)->get() as $cat)
                <li><a href="{{ route('catalogo.index', ['categoria' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- Horarios --}}
        <div class="footer__col-group">
            <button class="footer__col-toggle" type="button">
                <span class="footer__col-title">Horarios</span>
                <svg class="footer__col-arrow" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            <div class="footer__schedule">
                <div><strong>Lun – Vie</strong></div>
                <div style="margin-bottom:0.8rem">09:00 – 18:00 hs</div>
                <div><strong>Sábado</strong></div>
                <div style="margin-bottom:0.8rem">09:00 – 13:00 hs</div>
                <div><strong>Domingo</strong></div>
                <div>Cerrado</div>
            </div>
        </div>
    </div>

    <div class="footer__bottom">
        <span>&copy; {{ date('Y') }} SER Electrónica — Todos los derechos reservados.</span>
        <span>Mendoza, Argentina</span>
    </div>
</footer>

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