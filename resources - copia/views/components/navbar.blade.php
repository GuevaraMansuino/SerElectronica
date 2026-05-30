<nav class="navbar" role="navigation" aria-label="Navegación principal">
    <div class="navbar__inner">

        <a href="{{ route('home') }}" class="navbar__logo" aria-label="SER Electrónica — Inicio">
            <div class="logo-mark">
                <div class="logo-mark__hex">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width:100%;height:100%;">
                        <polygon points="100,20 170,60 170,140 100,180 30,140 30,60" fill="var(--lime)"/>
                        <g transform="translate(100,100) scale(0.25) translate(-275,-255)" fill="none" stroke="var(--bg)" stroke-width="55" stroke-linejoin="round" stroke-linecap="round">
                            <path d="M 375 155 L 175 155 L 375 355 L 175 355"/>
                        </g>
                    </svg>
                </div>
            </div>
            <span class="navbar__brand">SER <em>ELECTRÓNICA</em></span>
        </a>

        <ul class="navbar__links" role="list">
            <li><a href="{{ route('home') }}"              class="{{ request()->routeIs('home')        ? 'active' : '' }}">Inicio</a></li>
            <li><a href="{{ route('catalogo.index') }}"    class="{{ request()->routeIs('catalogo.*')  ? 'active' : '' }}">Productos</a></li>
            <li><a href="{{ route('promociones.index') }}" class="{{ request()->routeIs('promociones.*') ? 'active' : '' }}">Promociones</a></li>
            <li><a href="{{ route('soporte') }}">Soporte Técnico</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li>
                <a href="https://wa.me/5492613372353?text=Hola!+Quiero+consultar+sobre+un+producto"
                   target="_blank" rel="noopener" class="nav-cta">
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