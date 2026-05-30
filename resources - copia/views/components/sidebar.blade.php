<aside class="sidebar" role="navigation" aria-label="Panel de administración">

    <a href="{{ route('admin.dashboard') }}" class="sidebar__logo">
        <div class="s-logo-hex">
            <img src="{{ asset('LogoPagina.svg') }}" alt="SER"
                 style="width:100%;height:100%;object-fit:contain;">
        </div>
        <div>
            <span class="sidebar__brand">SER <em>ELECTRÓNICA</em></span>
            <span class="sidebar__brand-sub">Panel Admin</span>
        </div>
    </a>

    <nav class="sidebar__nav">
        <span class="nav-group-label">General</span>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            Dashboard
        </a>

        <span class="nav-group-label">Catálogo</span>
        <a href="{{ route('admin.categorias.index') }}"
           class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 7h4l2-4h6l2 4h4"/><path d="M5 21h14"/><line x1="12" y1="7" x2="12" y2="21"/>
            </svg>
            Categorías
        </a>
        <a href="{{ route('admin.productos.index') }}"
           class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/>
                <rect x="16" y="3" width="6" height="6"/><rect x="2" y="10" width="6" height="11"/>
                <rect x="9" y="10" width="13" height="11"/>
            </svg>
            Productos
        </a>
        <a href="{{ route('admin.promociones.index') }}"
           class="nav-link {{ request()->routeIs('admin.promociones.*') ? 'active' : '' }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            Promociones
        </a>

        <span class="nav-group-label">Sistema</span>
        <a href="{{ route('home') }}" target="_blank" rel="noopener" class="nav-link">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
            Ver sitio público
        </a>
    </nav>

    <div class="sidebar__footer">
        <div style="text-align:center;padding:0.5rem 0;border-bottom:1px solid var(--border-solid);margin-bottom:0.8rem;">
            <img src="{{ asset('ggm-logo.svg') }}" alt="GGM"
                 style="width:60px;height:auto;opacity:0.7;margin:0 auto;">
            <div style="font-size:0.65rem;color:var(--text-3);margin-top:0.3rem;">
                Desarrollador Web Gerónimo Guevara Mansuino
            </div>
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
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>

</aside>