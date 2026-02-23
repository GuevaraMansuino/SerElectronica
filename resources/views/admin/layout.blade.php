<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — SER Electrónica</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="/LogoPagina.svg">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    /* ================================================================
       ADMIN PANEL — SER ELECTRÓNICA
       Circuit Navy #0C1A2B  ·  Solar Lime #B6FF3B
    ================================================================ */
    :root {
        --bg:           #07111C;
        --surface:      #0E1E30;
        --surface-2:    #132436;
        --surface-3:    #182B3F;
        --border:       rgba(182,255,59,0.08);
        --border-solid: #1A3050;

        --lime:         #B6FF3B;
        --lime-dim:     rgba(182,255,59,0.1);
        --lime-glow:    rgba(182,255,59,0.2);

        --text:         #F1F5F9;
        --text-2:       #94A3B8;
        --text-3:       #3D5A78;

        --success:  #22C55E;
        --warning:  #F59E0B;
        --danger:   #EF4444;

        --font-display: 'Barlow Condensed', sans-serif;
        --font-body:    'Barlow', sans-serif;
        --font-mono:    'Fira Code', monospace;

        --radius:   6px;
        --radius-lg:12px;
        --t:        0.2s ease;
        --sidebar-w:250px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: var(--font-body);
        background: var(--bg);
        color: var(--text);
        display: flex;
        min-height: 100vh;
    }

    /* Circuit pattern sutil */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image:
            linear-gradient(rgba(182,255,59,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(182,255,59,0.02) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
        z-index: 0;
    }

    body > * { position: relative; z-index: 1; }

    /* ================================================================
       SIDEBAR
    ================================================================ */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--surface);
        border-right: 1px solid var(--border-solid);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0;
        height: 100vh;
        z-index: 100;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--border-solid) transparent;
    }

    /* Logo area */
    .sidebar__logo {
        padding: 1.4rem 1.2rem;
        border-bottom: 1px solid var(--border-solid);
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .s-logo-hex {
        width: 34px; height: 34px;
        background: var(--lime);
        clip-path: polygon(50% 0%, 95% 25%, 95% 75%, 50% 100%, 5% 75%, 5% 25%);
        display: grid;
        place-items: center;
        font-family: var(--font-display);
        font-size: 16px;
        font-weight: 800;
        color: var(--bg);
        flex-shrink: 0;
    }

    .sidebar__brand {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: var(--text);
        line-height: 1.1;
    }

    .sidebar__brand em { color: var(--lime); font-style: normal; }

    .sidebar__brand-sub {
        font-family: var(--font-mono);
        font-size: 0.55rem;
        color: var(--text-3);
        letter-spacing: 0.15em;
        text-transform: uppercase;
        display: block;
        margin-top: 1px;
    }

    /* Nav */
    .sidebar__nav {
        flex: 1;
        padding: 1.2rem 0;
    }

    .nav-group-label {
        display: block;
        font-family: var(--font-mono);
        font-size: 0.58rem;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: var(--text-3);
        padding: 0.9rem 1.2rem 0.4rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.62rem 1.2rem;
        font-size: 0.86rem;
        font-weight: 500;
        color: var(--text-2);
        text-decoration: none;
        border-left: 2px solid transparent;
        transition: all var(--t);
    }

    .nav-link:hover {
        color: var(--text);
        background: rgba(255,255,255,0.03);
    }

    .nav-link.active {
        color: var(--lime);
        background: var(--lime-dim);
        border-left-color: var(--lime);
    }

    .nav-link svg { flex-shrink: 0; opacity: 0.65; }
    .nav-link.active svg { opacity: 1; color: var(--lime); }

    .nav-link__badge {
        margin-left: auto;
        background: var(--lime);
        color: var(--bg);
        font-size: 0.6rem;
        font-weight: 700;
        font-family: var(--font-mono);
        padding: 2px 6px;
        border-radius: 10px;
    }

    /* Sidebar footer */
    .sidebar__footer {
        border-top: 1px solid var(--border-solid);
        padding: 1.2rem;
    }

    .sidebar__user {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 0.9rem;
    }

    .user-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--lime);
        display: grid;
        place-items: center;
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 700;
        color: var(--bg);
        flex-shrink: 0;
    }

    .user-name { font-size: 0.84rem; font-weight: 600; color: var(--text); }
    .user-role { font-size: 0.7rem; color: var(--text-3); font-family: var(--font-mono); }

    .sidebar__logout {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--text-3);
        background: none;
        border: none;
        cursor: pointer;
        font-family: var(--font-body);
        transition: color var(--t);
        padding: 0;
        width: 100%;
    }

    .sidebar__logout:hover { color: var(--danger); }

    /* ================================================================
       MAIN WRAPPER
    ================================================================ */
    .admin-main {
        margin-left: var(--sidebar-w);
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        position: relative;
        z-index: 1;
    }

    /* Topbar */
    .topbar {
        background: var(--surface);
        border-bottom: 1px solid var(--border-solid);
        padding: 0 2rem;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 50;
        gap: 1rem;
    }

    .topbar__title {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: var(--text);
    }

    .topbar__actions { display: flex; align-items: center; gap: 0.7rem; }

    /* Admin buttons */
    .abtn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: var(--radius);
        font-family: var(--font-body);
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        border: none;
        transition: all var(--t);
        text-decoration: none;
    }

    .abtn-lime { background: var(--lime); color: var(--bg); }
    .abtn-lime:hover { background: #c8ff5a; box-shadow: 0 0 16px rgba(182,255,59,0.3); }

    .abtn-outline { background: none; border: 1px solid var(--border-solid); color: var(--text-2); }
    .abtn-outline:hover { border-color: var(--lime); color: var(--lime); background: var(--lime-dim); }

    .abtn-danger { background: none; border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
    .abtn-danger:hover { background: rgba(239,68,68,0.1); }

    /* Content area */
    .admin-content {
        padding: 2rem;
        flex: 1;
    }

    /* ================================================================
       ALERTS
    ================================================================ */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        padding: 1rem 1.3rem;
        border-radius: var(--radius-lg);
        font-size: 0.88rem;
        margin-bottom: 1.5rem;
    }

    .alert svg { flex-shrink: 0; margin-top: 1px; }

    .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25); color: #86efac; }
    .alert-danger  { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #fca5a5; }
    .alert-warning { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.25); color: #fcd34d; }

    /* ================================================================
       CARD
    ================================================================ */
    .acard {
        background: var(--surface);
        border: 1px solid var(--border-solid);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .acard-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border-solid);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: var(--surface-2);
    }

    .acard-title {
        font-size: 0.84rem;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .acard-title svg { color: var(--lime); }

    .acard-body { padding: 1.5rem; }

    /* ================================================================
       TABLE
    ================================================================ */
    .atable { width: 100%; border-collapse: collapse; }

    .atable th {
        text-align: left;
        padding: 0.8rem 1rem;
        font-family: var(--font-mono);
        font-size: 0.62rem;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: var(--text-3);
        border-bottom: 1px solid var(--border-solid);
        white-space: nowrap;
        background: var(--surface-2);
    }

    .atable td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid var(--border-solid);
        font-size: 0.86rem;
        color: var(--text-2);
        vertical-align: middle;
    }

    .atable tr:last-child td { border-bottom: none; }

    .atable tbody tr:hover td { background: rgba(182,255,59,0.02); }

    .td-main { color: var(--text) !important; font-weight: 600; }

    .td-img {
        width: 52px; height: 40px;
        object-fit: cover;
        border-radius: var(--radius);
        background: var(--surface-3);
        display: block;
    }

    .td-img-ph {
        width: 52px; height: 40px;
        background: var(--surface-3);
        border-radius: var(--radius);
        display: inline-grid;
        place-items: center;
        font-size: 1.2rem;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 100px;
        font-family: var(--font-mono);
        font-size: 0.62rem;
        font-weight: 500;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .badge::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.7;
    }

    .badge-lime    { background: rgba(182,255,59,0.12); color: var(--lime);    border: 1px solid rgba(182,255,59,0.2); }
    .badge-success { background: rgba(34,197,94,0.12);  color: #86efac;         border: 1px solid rgba(34,197,94,0.2); }
    .badge-danger  { background: rgba(239,68,68,0.12);  color: #fca5a5;         border: 1px solid rgba(239,68,68,0.2); }
    .badge-neutral { background: rgba(255,255,255,0.06); color: var(--text-3);  border: 1px solid var(--border-solid); }

    /* Action buttons */
    .td-actions { display: flex; align-items: center; gap: 0.35rem; }

    .action-btn {
        width: 30px; height: 30px;
        border-radius: var(--radius);
        display: grid;
        place-items: center;
        border: 1px solid var(--border-solid);
        background: none;
        color: var(--text-3);
        cursor: pointer;
        transition: all var(--t);
        text-decoration: none;
    }

    .action-btn:hover { border-color: var(--lime); color: var(--lime); background: var(--lime-dim); }
    .action-btn.del:hover { border-color: var(--danger); color: #fca5a5; background: rgba(239,68,68,0.1); }

    /* ================================================================
       FORM
    ================================================================ */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.3rem; }
    .form-full  { grid-column: 1 / -1; }

    .fgroup { display: flex; flex-direction: column; gap: 0.45rem; }

    .flabel {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--text-2);
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .flabel em { color: var(--danger); font-style: normal; margin-left: 2px; }

    .finput,
    .fselect,
    .ftextarea {
        background: var(--bg);
        border: 1px solid var(--border-solid);
        border-radius: var(--radius);
        padding: 10px 14px;
        font-size: 0.9rem;
        color: var(--text);
        font-family: var(--font-body);
        outline: none;
        transition: border-color var(--t), box-shadow var(--t);
        width: 100%;
    }

    .finput:focus,
    .fselect:focus,
    .ftextarea:focus {
        border-color: var(--lime);
        box-shadow: 0 0 0 3px rgba(182,255,59,0.08);
    }

    .finput::placeholder, .ftextarea::placeholder { color: var(--text-3); }

    .ftextarea { resize: vertical; min-height: 130px; line-height: 1.6; }

    .ferror { font-size: 0.76rem; color: #fca5a5; }
    .fhint  { font-size: 0.76rem; color: var(--text-3); line-height: 1.4; }

    /* Checkbox */
    .fcheck {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        cursor: pointer;
        font-size: 0.88rem;
        color: var(--text-2);
    }

    .fcheck input[type="checkbox"] {
        width: 17px; height: 17px;
        accent-color: var(--lime);
        cursor: pointer;
        border-radius: 3px;
    }

    /* Dropzone */
    .dropzone {
        border: 2px dashed var(--border-solid);
        border-radius: var(--radius-lg);
        padding: 2.2rem;
        text-align: center;
        cursor: pointer;
        transition: all var(--t);
        background: var(--bg);
    }

    .dropzone:hover, .dropzone.drag-over {
        border-color: var(--lime);
        background: var(--lime-dim);
    }

    .dropzone input[type="file"] { display: none; }
    .dropzone__icon { font-size: 2.2rem; margin-bottom: 0.5rem; }

    .dropzone__text {
        font-size: 0.88rem;
        color: var(--text-2);
        margin-bottom: 0.3rem;
    }

    .dropzone__hint { font-size: 0.74rem; color: var(--text-3); }

    .dropzone__cta {
        display: inline-block;
        margin-top: 0.8rem;
        padding: 6px 16px;
        background: var(--lime);
        color: var(--bg);
        border-radius: var(--radius);
        font-size: 0.78rem;
        font-weight: 700;
        font-family: var(--font-body);
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .img-preview {
        margin-top: 1rem;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-solid);
        position: relative;
    }

    .img-preview img { width: 100%; max-height: 200px; object-fit: cover; display: block; }

    .img-preview__label {
        position: absolute;
        bottom: 8px; left: 8px;
        background: rgba(12,26,43,0.85);
        border: 1px solid var(--border-solid);
        border-radius: 4px;
        padding: 3px 8px;
        font-size: 0.65rem;
        color: var(--lime);
        font-family: var(--font-mono);
        backdrop-filter: blur(6px);
    }

    /* Form actions */
    .form-actions {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-solid);
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }

    /* ================================================================
       STATS
    ================================================================ */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .stat-box {
        background: var(--surface);
        border: 1px solid var(--border-solid);
        border-radius: var(--radius-lg);
        padding: 1.4rem;
        position: relative;
        overflow: hidden;
        transition: border-color var(--t);
    }

    .stat-box:hover { border-color: rgba(182,255,59,0.3); }

    .stat-box::after {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 2px;
        background: var(--lime);
        opacity: 0;
        transition: opacity var(--t);
    }

    .stat-box:hover::after { opacity: 1; }

    .stat-box__label {
        font-family: var(--font-mono);
        font-size: 0.62rem;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: var(--text-3);
        margin-bottom: 0.6rem;
    }

    .stat-box__value {
        font-family: var(--font-display);
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--lime);
        letter-spacing: 0.03em;
        line-height: 1;
    }

    .stat-box__sub {
        font-size: 0.75rem;
        color: var(--text-3);
        margin-top: 0.3rem;
    }

    .stat-box__icon {
        position: absolute;
        top: 1rem; right: 1rem;
        font-size: 1.6rem;
        opacity: 0.15;
    }

    /* ================================================================
       RESPONSIVE
    ================================================================ */
    @media (max-width: 900px) {
        .sidebar { display: none; }
        .admin-main { margin-left: 0; }
        .stats-row { grid-template-columns: 1fr 1fr; }
        .form-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 500px) {
        .stats-row { grid-template-columns: 1fr; }
        .admin-content { padding: 1.2rem; }
    }
    </style>
    @stack('styles')
</head>
<body>

{{-- ================================================================
     SIDEBAR
================================================================ --}}
<aside class="sidebar" role="navigation" aria-label="Panel de administración">

    <a href="{{ route('admin.dashboard') }}" class="sidebar__logo">
        <div class="s-logo-hex"><img src="{{ asset('LogoPagina.svg') }}" alt="SER" style="width:100%;height:100%;object-fit:contain;"></div>
        <div>
            <span class="sidebar__brand">SER <em>ELECTRÓNICA</em></span>
            <span class="sidebar__brand-sub">Panel Admin</span>
        </div>
    </a>

    <nav class="sidebar__nav">
        <span class="nav-group-label">General</span>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>

        <span class="nav-group-label">Catálogo</span>
        <a href="{{ route('admin.categorias.index') }}"
           class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h4l2-4h6l2 4h4"/><path d="M5 21h14"/><line x1="12" y1="7" x2="12" y2="21"/></svg>
            Categorías
        </a>
        <a href="{{ route('admin.productos.index') }}"
           class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/><rect x="16" y="3" width="6" height="6"/><rect x="2" y="10" width="6" height="11"/><rect x="9" y="10" width="13" height="11"/></svg>
            Productos
        </a>
        <a href="{{ route('admin.promociones.index') }}"
           class="nav-link {{ request()->routeIs('admin.promociones.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Promociones
        </a>

        <span class="nav-group-label">Sistema</span>
        <a href="{{ route('home') }}" target="_blank" class="nav-link" rel="noopener">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Ver sitio público
        </a>
    </nav>

    <div class="sidebar__footer">
        {{-- Logo watermark --}}
        <div style="text-align:center;padding:0.5rem 0;border-bottom:1px solid var(--border-solid);margin-bottom:0.8rem;">
            <img src="{{ asset('ggm-logo.svg') }}" alt="GGM" style="width:60px;height:auto;opacity:0.7;align-self:center;margin:0 auto;">
            <div style="font-size:0.65rem;color:var(--text-3);margin-top:0.3rem;">Desarrollador Web Gerónimo Guevara Mansuino</div>
        </div>
        <div class="sidebar__user">
            <div class="user-avatar" aria-hidden="true">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="user-role">Administrador</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar__logout">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- ================================================================
    MAIN
================================================================ --}}
<div class="admin-main">

    {{-- Topbar --}}
    <header class="topbar">
        <h1 class="topbar__title">@yield('page-title', 'Dashboard')</h1>
        <div class="topbar__actions">@yield('topbar-actions')</div>
    </header>

    {{-- Content --}}
    <div class="admin-content">

        {{-- Toast Container --}}
        <div id="toast-container" class="toast-container"></div>

        {{-- Flash Messages as Toasts --}}
        @if(session('success'))
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ session('success') }}', 'success'); });</script>
        @endif

        @if(session('error'))
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ session('error') }}', 'error'); });</script>
        @endif

        @yield('content')
    </div>
</div>

<style>
/* Toast Styles */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Confirm Modal Styles */
.confirm-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s, visibility 0.2s;
}

.confirm-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.confirm-modal {
    background: var(--surface, #0E1E30);
    border: 1px solid var(--border, #1A3050);
    border-radius: 12px;
    padding: 1.5rem;
    max-width: 400px;
    width: 90%;
    transform: scale(0.95);
    transition: transform 0.2s;
}

.confirm-modal-overlay.active .confirm-modal {
    transform: scale(1);
}

.confirm-modal__title {
    font-family: var(--font-d, 'Barlow Condensed', sans-serif);
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text, #F1F5F9);
    margin-bottom: 0.5rem;
}

.confirm-modal__message {
    color: var(--text-2, #94A3B8);
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.confirm-modal__actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.confirm-modal__btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-family: var(--font-b, 'Barlow', sans-serif);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.confirm-modal__btn--cancel {
    background: var(--surface-2, #132436);
    color: var(--text, #F1F5F9);
    border: 1px solid var(--border, #1A3050);
}

.confirm-modal__btn--cancel:hover {
    background: var(--border, #1A3050);
}

.confirm-modal__btn--danger {
    background: #DC2626;
    color: white;
}

.confirm-modal__btn--danger:hover {
    background: #B91C1C;
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
}

.toast.toast-exit {
    animation: slideOut 0.3s ease-in forwards;
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

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.toast-success {
    background: rgba(34, 197, 94, 0.95);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: white;
}

.toast-error {
    background: rgba(239, 68, 68, 0.95);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: white;
}

.toast-warning {
    background: rgba(245, 158, 11, 0.95);
    border: 1px solid rgba(245, 158, 11, 0.3);
    color: white;
}

.toast-info {
    background: rgba(59, 130, 246, 0.95);
    border: 1px solid rgba(59, 130, 246, 0.3);
    color: white;
}

.toast svg {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
}

.toast-close {
    margin-left: auto;
    background: none;
    border: none;
    color: white;
    opacity: 0.7;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s;
}

.toast-close:hover {
    opacity: 1;
}

.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: rgba(255,255,255,0.5);
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    transition: width linear;
}
</style>

<script>
function showToast(message, type = 'success', duration = 4000) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
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
    
    // Auto dismiss
    const timeout = setTimeout(() => {
        dismissToast(toast);
    }, duration);
    
    // Pause on hover
    toast.addEventListener('mouseenter', () => {
        clearTimeout(timeout);
        toast.querySelector('.toast-progress').style.animationPlayState = 'paused';
    });
    
    toast.addEventListener('mouseleave', () => {
        const remaining = toast.querySelector('.toast-progress').getBoundingClientRect().width;
        const total = toast.getBoundingClientRect().width;
        const percent = (remaining / total) * duration;
        const newTimeout = setTimeout(() => {
            dismissToast(toast);
        }, percent);
        toast.querySelector('.toast-progress').style.animationPlayState = 'running';
    });
}

function dismissToast(toast) {
    if (toast.classList.contains('toast-exit')) return;
    toast.classList.add('toast-exit');
    setTimeout(() => {
        if (toast.parentElement) {
            toast.parentElement.removeChild(toast);
        }
    }, 300);
}

// Custom confirm function
function confirmDelete(button) {
    const message = button.dataset.confirm;
    const form = button.closest('form');
    
    const modal = document.getElementById('confirmModal');
    const titleEl = document.getElementById('confirmModalTitle');
    const messageEl = document.getElementById('confirmModalMessage');
    const confirmBtn = document.getElementById('confirmModalConfirm');
    const cancelBtn = document.getElementById('confirmModalCancel');
    
    titleEl.textContent = 'Confirmar eliminación';
    messageEl.textContent = message;
    
    modal.classList.add('active');
    
    // Clean up previous event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    const newCancelBtn = cancelBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
    
    newConfirmBtn.addEventListener('click', () => {
        modal.classList.remove('active');
        form.submit();
    });
    
    newCancelBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });
}

// Confirm Modal Functions
let confirmCallback = null;

function confirmAction(title, message, onConfirm) {
    const modal = document.getElementById('confirmModal');
    const titleEl = document.getElementById('confirmModalTitle');
    const messageEl = document.getElementById('confirmModalMessage');
    const confirmBtn = document.getElementById('confirmModalConfirm');
    const cancelBtn = document.getElementById('confirmModalCancel');
    
    titleEl.textContent = title;
    messageEl.textContent = message;
    confirmCallback = onConfirm;
    
    modal.classList.add('active');
    
    // Handle button clicks
    const handleConfirm = () => {
        modal.classList.remove('active');
        if (confirmCallback) {
            confirmCallback();
            confirmCallback = null;
        }
        cleanup();
    };
    
    const handleCancel = () => {
        modal.classList.remove('active');
        confirmCallback = null;
        cleanup();
    };
    
    const cleanup = () => {
        confirmBtn.removeEventListener('click', handleConfirm);
        cancelBtn.removeEventListener('click', handleCancel);
        document.removeEventListener('keydown', handleEscape);
    };
    
    const handleEscape = (e) => {
        if (e.key === 'Escape') {
            handleCancel();
        }
    };
    
    confirmBtn.addEventListener('click', handleConfirm);
    cancelBtn.addEventListener('click', handleCancel);
    document.addEventListener('keydown', handleEscape);
}

// Override confirm for forms
document.addEventListener('submit', function(e) {
    const form = e.target;
    const confirmMsg = form.dataset.confirm || form.getAttribute('data-confirm');
    if (confirmMsg) {
        e.preventDefault();
        const title = form.dataset.confirmTitle || 'Confirmar acción';
        const message = confirmMsg;
        confirmAction(title, message, () => {
            // Submit the form normally
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                // Use method spoofing
                const tempForm = document.createElement('form');
                tempForm.action = form.action;
                tempForm.method = 'POST';
                
                // Copy all inputs from original form
                Array.from(form.querySelectorAll('input, select, textarea')).forEach(input => {
                    const clone = input.cloneNode(true);
                    tempForm.appendChild(clone);
                });
                
                document.body.appendChild(tempForm);
                tempForm.submit();
            } else {
                form.submit();
            }
        });
    }
});

// Handle onclick confirm for links and buttons
document.addEventListener('click', function(e) {
    const target = e.target.closest('[data-confirm]');
    if (target && !target.hasAttribute('data-confirm-processed')) {
        e.preventDefault();
        target.setAttribute('data-confirm-processed', 'true');
        
        const title = target.dataset.confirmTitle || 'Confirmar acción';
        const message = target.dataset.confirm;
        
        confirmAction(title, message, () => {
            // If it's a link, navigate
            if (target.tagName === 'A') {
                window.location.href = target.href;
            } else if (target.onclick) {
                target.onclick();
            } else if (target.type === 'submit') {
                target.form.submit();
            }
        });
    }
});

// Add shrink animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shrink {
        from { width: 100%; }
        to { width: 0%; }
    }
`;
document.head.appendChild(style);

// Handle 419 Page Expired - redirect to login
document.addEventListener('ajaxError', function(event) {
    if (event.detail && event.detail.status === 419) {
        window.location.href = '/login?expired=1';
    }
});

// Global fetch error handler for 419
const originalFetch = window.fetch;
window.fetch = function(...args) {
    return originalFetch.apply(this, args).then(response => {
        if (response.status === 419) {
            window.location.href = '/login?expired=1';
        }
        return response;
    });
};

// Intercept all form submissions to add CSRF token and handle 419
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form.method && form.method.toLowerCase() === 'post') {
        // Check if form has CSRF token
        const csrfInput = form.querySelector('input[name="_token"]');
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        
        if (!csrfInput && csrfMeta) {
            // Add CSRF token if missing
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = csrfMeta.content;
            form.insertBefore(token, form.firstChild);
        }
    }
});

// Also intercept XMLHttpRequest for AJAX
const originalXHROpen = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function(method, url) {
    this.addEventListener('load', function() {
        if (this.status === 419) {
            window.location.href = '/login?expired=1';
        }
    });
    return originalXHROpen.apply(this, arguments);
};
</script>

{{-- Confirm Modal --}}
<div class="confirm-modal-overlay" id="confirmModal">
    <div class="confirm-modal">
        <h3 class="confirm-modal__title" id="confirmModalTitle">Confirmar acción</h3>
        <p class="confirm-modal__message" id="confirmModalMessage">¿Estás seguro de que deseas continuar?</p>
        <div class="confirm-modal__actions">
            <button type="button" class="confirm-modal__btn confirm-modal__btn--cancel" id="confirmModalCancel">Cancelar</button>
            <button type="button" class="confirm-modal__btn confirm-modal__btn--danger" id="confirmModalConfirm">Eliminar</button>
        </div>
    </div>
</div>

@stack('scripts')
</body>
</html>