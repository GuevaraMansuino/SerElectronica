@extends('layouts.app')

@section('title', 'Soporte Técnico | SER Electrónica')
@section('meta_description', 'Servicio técnico especializado en audio profesional y hogareño en Mendoza. Reparación de parlantes, potencias y equipos de música.')

@section('content')

{{-- Hero Section --}}
<section class="soporte-hero">
    <div class="container">
        <div class="soporte-hero__content fade-up">
            <span class="sec-label">Servicio Técnico</span>
            <h1 class="sec-title">REPARAMOS<br>TU SONIDO</h1>
            <p class="soporte-hero__text">
                Especialistas en audio profesional y hogareño. Diagnóstico preciso, repuestos de calidad y la garantía de más de 10 años de experiencia en Mendoza.
            </p>
            <div class="soporte-hero__actions">
                <a href="https://wa.me/5492613372353?text=Hola,%20tengo%20una%20consulta%20sobre%20reparaciones" target="_blank" class="btn btn-lime">
                    Consultar ahora
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Services Grid --}}
<section class="soporte-services">
    <div class="container">
        <div class="services-grid fade-up d2">
            {{-- Card 1 --}}
            <div class="service-card">
                <div class="service-card__icon">🎵</div>
                <h3 class="service-card__title">Equipos de Música</h3>
                <p class="service-card__desc">
                    Reparación de minicomponentes, sistemas Hi-Fi y equipos vintage. Solucionamos fallas de encendido, lectura y salidas de audio.
                </p>
            </div>
            {{-- Card 2 --}}
            <div class="service-card">
                <div class="service-card__icon">🔊</div>
                <h3 class="service-card__title">Parlantes y Bafles</h3>
                <p class="service-card__desc">
                    Reconado profesional, cambio de bobinas, reparación de crossovers y restauración de cajas acústicas pasivas y activas.
                </p>
            </div>
            {{-- Card 3 --}}
            <div class="service-card">
                <div class="service-card__icon">⚡</div>
                <h3 class="service-card__title">Potencias</h3>
                <p class="service-card__desc">
                    Servicio técnico para amplificadores de potencia, etapas de salida, fuentes de alimentación y circuitos de protección.
                </p>
            </div>
            {{-- Card 4 --}}
            <div class="service-card">
                <div class="service-card__icon">🎚️</div>
                <h3 class="service-card__title">Consolas y Mixers</h3>
                <p class="service-card__desc">
                    Limpieza y cambio de faders, potenciómetros, jacks y reparación de canales para consolas de vivo o estudio.
                </p>
            </div>
        </div>

        {{-- Exclusion Note --}}
        <div class="exclusion-note fade-up d3">
            <div class="exclusion-note__icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="exclusion-note__content">
                <strong>Información Importante</strong>
                <p>No realizamos reparaciones de <span>Televisores</span>, <span>Monitores</span> ni <span>Electrodomésticos</span>. Nuestro laboratorio se dedica exclusivamente al audio.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="soporte-cta">
    <div class="container">
        <div class="cta-box fade-up d4">
            <h2 class="cta-box__title">¿Tenés un equipo para reparar?</h2>
            <p class="cta-box__text">
                Traelo a nuestro local para un diagnóstico o escribinos por WhatsApp si tenés dudas sobre tu modelo.
            </p>
            <div class="cta-box__actions">
                <a href="https://wa.me/5492613372353?text=Hola,%20tengo%20una%20consulta%20sobre%20servicio%20técnico" target="_blank" class="btn btn-lime">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                    Consultar por WhatsApp
                </a>
                <a href="https://maps.app.goo.gl/zQw7RfhK1EuUhJQNA" target="_blank" class="btn btn-outline">
                    Ver Ubicación
                </a>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Hero */
.soporte-hero {
    padding: 6rem 0 4rem;
    position: relative;
    overflow: hidden;
}

.soporte-hero::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 800px; height: 800px;
    background: radial-gradient(circle, rgba(220, 208, 186, 0.08) 0%, transparent 70%);
    pointer-events: none;
}

.soporte-hero__content {
    max-width: 700px;
}

.soporte-hero__text {
    font-size: 1.15rem;
    color: var(--text-2);
    margin-top: 1.5rem;
    margin-bottom: 2.5rem;
    line-height: 1.6;
    font-weight: 300;
}

/* Services */
.soporte-services {
    padding-bottom: 5rem;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
    margin-bottom: 4rem;
}

.service-card {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    padding: 2rem;
    transition: all var(--t);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.service-card:hover {
    border-color: var(--lime);
    transform: translateY(-5px);
    box-shadow: var(--shadow);
}

.service-card__icon {
    font-size: 2.5rem;
    margin-bottom: 1.2rem;
}

.service-card__title {
    font-family: var(--font-display);
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 0.8rem;
    letter-spacing: 0.02em;
}

.service-card__desc {
    font-size: 0.9rem;
    color: var(--text-2);
    line-height: 1.6;
}

/* Exclusion Note */
.exclusion-note {
    background: rgba(20, 10, 10, 0.3);
    border: 1px solid rgba(220, 38, 38, 0.4);
    border-radius: var(--radius-lg);
    padding: 1.5rem 2rem;
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    max-width: 900px;
    margin: 0 auto;
}

.exclusion-note__icon {
    color: #ef4444;
    flex-shrink: 0;
    margin-top: 2px;
}

.exclusion-note__content strong {
    display: block;
    font-family: var(--font-display);
    font-size: 1.1rem;
    color: #ef4444;
    margin-bottom: 0.4rem;
    letter-spacing: 0.05em;
}

.exclusion-note__content p {
    font-size: 0.95rem;
    color: var(--text-2);
    line-height: 1.5;
}

.exclusion-note__content span {
    color: #fca5a5;
    font-weight: 600;
}

/* CTA Box */
.soporte-cta {
    padding-bottom: 6rem;
}

.cta-box {
    background: var(--surface);
    border: 1px solid var(--lime);
    border-radius: var(--radius-xl);
    padding: 4rem 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-lime);
}

.cta-box::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(220, 208, 186, 0.05), transparent 70%);
    pointer-events: none;
}

.cta-box__title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--text);
    margin-bottom: 1rem;
    line-height: 1.1;
}

.cta-box__text {
    font-size: 1.1rem;
    color: var(--text-2);
    margin-bottom: 2.5rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-box__actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
}

/* Animations */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.fade-up { opacity: 0; animation: fadeUp 0.6s ease forwards; }
.d2 { animation-delay: 0.2s; }
.d3 { animation-delay: 0.4s; }
.d4 { animation-delay: 0.6s; }

@media (max-width: 768px) {
    .soporte-hero { padding: 4rem 0 2rem; }
    .exclusion-note { flex-direction: column; text-align: center; align-items: center; gap: 1rem; }
    .cta-box { padding: 3rem 1.5rem; }
}
</style>
@endpush

@endsection