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
                            <g transform="translate(100,100) scale(0.25) translate(-275,-255)" fill="none" stroke="var(--bg)" stroke-width="55" stroke-linejoin="round" stroke-linecap="round">
                                <path d="M 375 155 L 175 155 L 375 355 L 175 355"/>
                            </g>
                        </svg>
                    </div>
                </div>
                <span class="footer__brand-name">SER <em>ELECTRÓNICA</em></span>
            </div>

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