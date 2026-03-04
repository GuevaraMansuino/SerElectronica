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
            <a href="https://wa.me/5492613372353" target="_blank" class="footer__contact-row">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
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
                @try
                    @foreach(\App\Models\Category::take(6)->get() as $cat)
                        <li><a href="{{ route('catalogo.index', ['categoria' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                    @endforeach
                @catch(\Exception $e)
                    <li><a href="{{ route('catalogo.index') }}">Audio</a></li>
                    <li><a href="{{ route('catalogo.index') }}">Parlantes</a></li>
                    <li><a href="{{ route('catalogo.index') }}">Cables</a></li>
                @endtry
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