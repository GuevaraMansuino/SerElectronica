@extends('layouts.app')

@section('title', 'SER Electrónica – Tienda de Electrónica en Mendoza')
@section('meta_description', 'Audio profesional, equipos de música y electrónica en Mendoza. Lavalle 299. Excelente atención y los mejores precios.')

@push('styles')
<style>
/* ================================================================
   HOME PAGE — SER ELECTRÓNICA
================================================================ */

/* ----------------------------------------------------------------
   HERO
---------------------------------------------------------------- */
.hero {
    min-height: calc(100vh - 68px);
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 4rem;
    max-width: 100%;
    margin: 0 auto;
    padding: 5rem 8vw 4rem;
    position: relative;
    overflow: hidden;
}

/* Glow decorativo */
.hero::after {
    content: '';
    position: absolute;
    top: -20%;
    right: -10%;
    width: 600px;
    height: 600px;
    background: radial-gradient(ellipse, rgba(182,255,59,0.06) 0%, transparent 65%);
    pointer-events: none;
    z-index: 0;
}

.hero__content { position: relative; z-index: 1; }

/* Eyebrow */
.hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--lime-dim);
    border: 1px solid rgba(182,255,59,0.2);
    border-radius: 100px;
    padding: 5px 14px 5px 8px;
    margin-bottom: 1.8rem;
}

.hero__eyebrow-dot {
    width: 8px;
    height: 8px;
    background: var(--lime);
    border-radius: 50%;
    animation: pulse-dot 2s ease infinite;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.7); }
}

.hero__eyebrow-text {
    font-family: var(--font-mono);
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.18em;
    color: var(--lime);
}

/* Title */
.hero__title {
    font-family: var(--font-display);
    font-size: clamp(3.5rem, 7vw, 6.5rem);
    font-weight: 800;
    letter-spacing: 0.02em;
    line-height: 0.92;
    color: var(--text);
    margin-bottom: 1.6rem;
}

.hero__title-line {
    display: block;
}

.hero__title-highlight {
    color: var(--lime);
    display: block;
    position: relative;
}

/* Underline animado en highlight */
.hero__title-highlight::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 4px;
    width: 100%;
    height: 4px;
    background: var(--lime);
    opacity: 0.3;
    border-radius: 2px;
}

.hero__subtitle {
    font-size: 1.05rem;
    color: var(--text-2);
    line-height: 1.75;
    max-width: 440px;
    margin-bottom: 2.5rem;
    font-weight: 300;
}

.hero__actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 3.5rem;
}

/* Stats row */
.hero__stats {
    display: flex;
    gap: 2rem;
    padding-top: 2.5rem;
    border-top: 1px solid var(--border-solid);
}

.hero__stat {}

.hero__stat-value {
    font-family: var(--font-display);
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--lime);
    letter-spacing: 0.03em;
    line-height: 1;
    display: block;
}

.hero__stat-label {
    font-family: var(--font-mono);
    font-size: 0.62rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--text-3);
    display: block;
    margin-top: 3px;
}

/* Hero visual */
.hero__visual {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero__img-frame {
    position: relative;
    width: 100%;
    max-width: 100%;
    border-radius: var(--radius-xl);
    overflow: visible;
}

.hero__img-main {
    aspect-ratio: 4 / 3;
    border-radius: var(--radius-xl);
    overflow: hidden;
    background: var(--surface);
    border: 1px solid var(--border-solid);
    position: relative;
}

.hero__img-main img {
    width: 100%; height: 100%;
    object-fit: cover;
}

/* Overlay sutil en la imagen */
.hero__img-main::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(182,255,59,0.06) 0%, transparent 50%);
}

/* Esquinas decorativas */
.hero__corner {
    position: absolute;
    width: 24px;
    height: 24px;
    border-color: var(--lime);
    border-style: solid;
}

.hero__corner--tl { top: -8px; left: -8px; border-width: 2px 0 0 2px; }
.hero__corner--tr { top: -8px; right: -8px; border-width: 2px 2px 0 0; }
.hero__corner--bl { bottom: -8px; left: -8px; border-width: 0 0 2px 2px; }
.hero__corner--br { bottom: -8px; right: -8px; border-width: 0 2px 2px 0; }

/* Floating badge */
.hero__float-badge {
    position: absolute;
    bottom: -1.8rem;
    left: -2rem;
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    padding: 1rem 1.3rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    box-shadow: var(--shadow);
}

.hero__float-icon {
    width: 42px;
    height: 42px;
    background: var(--lime-dim);
    border-radius: var(--radius);
    display: grid;
    place-items: center;
    color: var(--lime);
    flex-shrink: 0;
}

.hero__float-text strong { display: block; font-size: 1rem; color: var(--text); }
.hero__float-text span  { font-size: 0.75rem; color: var(--text-3); }

/* Rating badge */
.hero__rating-badge {
    position: absolute;
    top: -1.5rem;
    right: -1.5rem;
    background: var(--lime);
    color: var(--bg);
    border-radius: 50%;
    width: 72px;
    height: 72px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    box-shadow: 0 0 20px rgba(182,255,59,0.4);
}

.hero__rating-badge .num { font-size: 1.5rem; font-weight: 800; line-height: 1; }
.hero__rating-badge .star { font-size: 0.75rem; }

/* ----------------------------------------------------------------
   CATEGORÍAS RÁPIDAS - ESTILO COMPACTO (COMO LÍNEA)
---------------------------------------------------------------- */
.cats-section {
    background: var(--surface);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 3.5rem 8vw;
}

.cats-section__inner { max-width: 100%; margin: 0 auto; }

.cats-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 2rem;
    gap: 1rem;
}

.cats-toggle {
    display: none;
}

.cats-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
}

.cat-pill {
    background: var(--bg);
    border: 1px solid var(--border-solid);
    border-radius: 100px;
    padding: 0.75rem 1.4rem;
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    cursor: pointer;
    transition: all var(--t);
    text-decoration: none;
    white-space: nowrap;
}

.cat-pill:hover {
    border-color: var(--lime);
    background: var(--lime-dim);
}

.cat-pill:hover .cat-pill__arrow { color: var(--lime); transform: translateX(3px); }

.cat-pill__icon {
    font-size: 1.2rem;
}

.cat-pill__name {
    font-family: var(--font-display);
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    color: var(--text);
}

.cat-pill__count {
    font-size: 0.8rem;
    color: var(--text-3);
}

.cat-pill__arrow {
    color: var(--text-3);
    font-size: 1rem;
    transition: all var(--t);
}

/* Mobile: Categorías colapsables */
@media (max-width: 768px) {
    .cats-section {
        padding: 1.5rem 5vw;
    }
    
    .cats-header {
        margin-bottom: 1rem;
    }
    
    .cats-grid {
        display: none;
    }
    
    .cats-grid.open {
        display: flex;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    
    .cats-toggle {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--bg);
        border: 1px solid var(--lime);
        color: var(--lime);
        padding: 0.5rem 1rem;
        border-radius: var(--radius);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--t);
    }
    
    .cats-toggle:hover {
        background: var(--lime);
        color: var(--bg);
    }
    
    .cats-toggle svg {
        transition: transform var(--t);
    }
    
    .cats-toggle.open svg {
        transform: rotate(180deg);
    }
    
    /* Grid de productos: 2 columnas estilo Mercado Libre */
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }
}

.cat-pill__count {
    font-family: var(--font-mono);
    font-size: 0.62rem;
    color: var(--text-3);
    letter-spacing: 0.1em;
}

.cat-pill__arrow {
    color: var(--text-3);
    margin-top: auto;
    transition: all var(--t);
}

/* ----------------------------------------------------------------
   PRODUCTOS DESTACADOS
---------------------------------------------------------------- */
.featured-section {
    padding: 7rem 8vw;
    max-width: 100%;
    margin: 0 auto;
}

.featured-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 3rem;
    gap: 1rem;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.6rem;
}

/* ----------------------------------------------------------------
   STRIP PROMO (banner full-width)
---------------------------------------------------------------- */
.promo-strip {
    background: var(--surface);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 6.5rem 8vw;
    position: relative;
    overflow: hidden;
}

.promo-strip::before {
    content: '';
    position: absolute;
    left: -10%;
    top: 50%;
    transform: translateY(-50%);
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(182,255,59,0.05) 0%, transparent 65%);
    pointer-events: none;
}

.promo-strip__inner {
    max-width: 100%;
    margin: 0 auto;
}

.promo-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 1.6rem;
    margin-top: 2.5rem;
}

.promo-card {
    background: var(--bg);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-xl);
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
    transition: all var(--t);
}

.promo-card:hover {
    border-color: var(--lime);
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(182,255,59,0.15);
}

.promo-card::after {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(182,255,59,0.08) 0%, transparent 60%);
    pointer-events: none;
}

.promo-card__tag {
    display: inline-block;
    background: var(--lime);
    color: var(--bg);
    font-family: var(--font-mono);
    font-size: 0.62rem;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 3px 10px;
    border-radius: 3px;
    margin-bottom: 1rem;
}

.promo-card__title {
    font-family: var(--font-display);
    font-size: clamp(1.4rem, 2.5vw, 2rem);
    font-weight: 800;
    letter-spacing: 0.03em;
    color: var(--text);
    line-height: 1.1;
    margin-bottom: 0.8rem;
}

.promo-card__desc {
    font-size: 0.85rem;
    color: var(--text-2);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.promo-card__time {
    font-size: 0.75rem;
    color: var(--lime);
    font-weight: 600;
    margin-bottom: 0.8rem;
    display: inline-block;
    background: rgba(182, 255, 59, 0.1);
    padding: 4px 10px;
    border-radius: 4px;
}

/* ----------------------------------------------------------------
   NOSOTROS
---------------------------------------------------------------- */
.about-section {
    max-width: 1320px;
    margin: 0 auto;
    padding: 6rem 5vw;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5rem;
    align-items: center;
}

.about__map-wrap {
    border-radius: var(--radius-xl);
    overflow: hidden;
    border: 1px solid var(--border-solid);
    height: 380px;
    position: relative;
}

.about__map-wrap iframe {
    width: 100%;
    height: 100%;
    border: none;
    filter: invert(0.88) hue-rotate(190deg) contrast(0.8) saturate(0.5) brightness(1.05);
}

/* Indicador sobre el mapa */
.about__map-pin {
    position: absolute;
    bottom: 1.2rem;
    left: 1.2rem;
    background: var(--bg);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius);
    padding: 0.7rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.8rem;
    color: var(--text-2);
    backdrop-filter: blur(10px);
}

.about__map-pin svg { color: var(--lime); }

.about__features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.9rem;
    margin-top: 2.5rem;
}

.feature-item {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    padding: 1.2rem;
    transition: border-color var(--t);
}

.feature-item:hover { border-color: var(--lime); }

.feature-item__icon {
    font-size: 1.4rem;
    margin-bottom: 0.5rem;
}

.feature-item__title {
    font-family: var(--font-display);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: 0.03em;
    margin-bottom: 0.2rem;
}

.feature-item__text {
    font-size: 0.78rem;
    color: var(--text-2);
    line-height: 1.5;
}

/* ----------------------------------------------------------------
   RESEÑAS
---------------------------------------------------------------- */
.reviews-section {
    background: var(--surface);
    border-top: 1px solid var(--border);
    padding: 6rem 5vw;
}

.reviews-inner { max-width: 1320px; margin: 0 auto; }

.reviews-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 3rem;
    gap: 2rem;
}

.reviews-score {
    text-align: right;
    flex-shrink: 0;
}

.reviews-score__num {
    font-family: var(--font-display);
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--lime);
    line-height: 1;
    display: block;
}

.reviews-score__stars { font-size: 1rem; color: var(--lime); letter-spacing: 2px; }
.reviews-score__total { font-size: 0.75rem; color: var(--text-3); font-family: var(--font-mono); display: block; margin-top: 3px; }

.reviews-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.2rem;
}

.review-card {
    background: var(--bg);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    padding: 1.6rem;
    transition: border-color var(--t);
}

.review-card:hover { border-color: rgba(182,255,59,0.3); }

.review-card__stars { color: var(--lime); font-size: 0.85rem; margin-bottom: 0.8rem; }

.review-card__text {
    font-size: 0.88rem;
    color: var(--text-2);
    line-height: 1.7;
    font-style: italic;
    margin-bottom: 1.3rem;
    position: relative;
}

.review-card__text::before {
    content: '"';
    font-family: var(--font-display);
    font-size: 3rem;
    color: var(--lime);
    opacity: 0.2;
    position: absolute;
    top: -1rem;
    left: -0.5rem;
    line-height: 1;
}

.review-card__author { display: flex; align-items: center; gap: 0.8rem; }

.review-card__avatar {
    width: 36px; height: 36px;
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

.review-card__name { font-weight: 600; font-size: 0.88rem; color: var(--text); }
.review-card__date { font-size: 0.73rem; color: var(--text-3); }

/* ----------------------------------------------------------------
   ANIMATIONS
---------------------------------------------------------------- */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}

.fade-up { opacity: 0; animation: fadeUp 0.6s ease forwards; }
.d1 { animation-delay: 0.1s; }
.d2 { animation-delay: 0.25s; }
.d3 { animation-delay: 0.4s; }
.d4 { animation-delay: 0.55s; }
.d5 { animation-delay: 0.7s; }

/* ----------------------------------------------------------------
   RESPONSIVE
---------------------------------------------------------------- */
@media (max-width: 1024px) {
    .hero { grid-template-columns: 1fr; min-height: auto; padding: 3rem 5vw 3rem; }
    .hero::after { display: none; }
    
    /* Imagen del local - ajustar para tablets */
    .hero__visual { 
        display: block !important; 
        margin-top: 1.5rem;
    }
    
    .hero__img-frame {
        max-width: 100%;
    }
    
    .hero__img-main {
        aspect-ratio: auto;
        border-radius: var(--radius-lg);
        background: transparent;
        border: none;
    }
    
    .hero__img-main img {
        width: 100%;
        height: auto;
        max-height: none;
        object-fit: contain;
        border-radius: var(--radius-lg);
    }
    
    /* Ocultar elementos decorativos en tablet */
    .hero__float-badge,
    .hero__rating-badge,
    .hero__corner {
        display: none;
    }
    
    /* Espaciado normal para tablets */
    .hero__eyebrow { margin-bottom: 1rem; }
    .hero__title { margin-bottom: 1rem; font-size: 3rem !important; }
    .hero__subtitle { margin-bottom: 1.5rem; font-size: 1rem; }
    .hero__actions { margin-bottom: 2rem; gap: 0.75rem; }
    .hero__stats { padding-top: 2rem; gap: 1.2rem; }
    
    .about-section { grid-template-columns: 1fr; gap: 2rem; }
    .promo-grid { grid-template-columns: 1fr; }
    .reviews-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 700px) {
    .cats-grid { grid-template-columns: repeat(2, 1fr); }
    .cats-header { flex-direction: column; align-items: flex-start; }
    .featured-header { flex-direction: column; align-items: flex-start; }
    .reviews-grid { grid-template-columns: 1fr; }
    .reviews-header { flex-direction: column; align-items: flex-start; }
    .about__features { grid-template-columns: 1fr; }
    .hero__stats { gap: 0.8rem; }
    
    /* Título más compacto */
    .hero__title {
        font-size: 1.8rem !important;
        margin-bottom: 0.5rem;
    }
    
    .hero__subtitle {
        font-size: 0.8rem;
        margin-bottom: 0.6rem;
    }
    
    .hero__actions {
        margin-bottom: 0.8rem;
    }
    
    .hero__stats {
        padding-top: 0.8rem;
    }
    
    .hero__stat-value {
        font-size: 1.8rem;
    }
}

/* ================================================================
   PANTALLAS GRANDES (PC) - Aprovechar todo el ancho
============================================================ */
@media (min-width: 1400px) {
    .hero {
        padding: 6rem 10vw 5rem;
    }
    
    .hero__title {
        font-size: clamp(4rem, 8vw, 7rem);
    }
    
    .cats-section {
        padding: 4rem 10vw;
    }
    
    .featured-section {
        padding: 8rem 10vw;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.2rem;
    }
    
    .promo-strip {
        padding: 7rem 10vw;
    }
    
    .promo-grid {
        gap: 1.5rem;
    }
    
    .promo-card {
        padding: 2.5rem;
    }
}

@media (min-width: 1920px) {
    .hero {
        padding: 7rem 15vw 6rem;
    }
    
    .cats-section {
        padding: 4rem 15vw;
    }
    
    .featured-section {
        padding: 9rem 15vw;
    }
    
    .promo-strip {
        padding: 8rem 15vw;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
}

/* ================================================================
   MODAL DE VISTA RÁPIDA
============================================================ */
.quick-view-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.quick-view-modal.open {
    opacity: 1;
    visibility: visible;
}

.quick-view-modal__backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(4px);
}

.quick-view-modal__container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-xl);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
}

.quick-view-modal__close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg);
    border: 1px solid var(--border-solid);
    border-radius: 50%;
    color: var(--text-2);
    cursor: pointer;
    transition: all var(--t);
    z-index: 10;
}

.quick-view-modal__close:hover {
    background: var(--lime);
    color: var(--bg);
    border-color: var(--lime);
}

.quick-view-modal__content {
    padding: 0;
}

/* Product Modal Grid */
.product-modal__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
}

.product-modal__image-wrap {
    position: relative;
    background: var(--surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}

.product-modal__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-modal__img--placeholder {
    font-size: 5rem;
    display: grid;
    place-items: center;
    min-height: 400px;
}

.product-modal__discount {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: var(--danger);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: var(--radius);
    font-family: var(--font-mono);
    font-size: 0.8rem;
    font-weight: 700;
}

.product-modal__info {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.product-modal__category {
    font-family: var(--font-mono);
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--lime);
}

.product-modal__name {
    font-family: var(--font-display);
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1.2;
}

.product-modal__prices {
    display: flex;
    align-items: baseline;
    gap: 0.8rem;
}

.product-modal__price {
    font-family: var(--font-display);
    font-size: 2rem;
    font-weight: 800;
    color: var(--lime);
}

.product-modal__price--old {
    font-family: var(--font-display);
    font-size: 1.2rem;
    color: var(--text-3);
    text-decoration: line-through;
}

.product-modal__desc {
    margin-top: 0.5rem;
}

.product-modal__desc h4 {
    font-family: var(--font-mono);
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-2);
    margin-bottom: 0.5rem;
}

.product-modal__desc p {
    font-size: 0.95rem;
    color: var(--text-2);
    line-height: 1.6;
}

.product-modal__details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1rem;
    background: var(--bg);
    border-radius: var(--radius);
}

.product-modal__detail {
    font-size: 0.85rem;
    color: var(--text-2);
}

.product-modal__detail span {
    color: var(--text-3);
    font-family: var(--font-mono);
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.product-modal__btn {
    margin-top: auto;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: var(--lime);
    color: var(--bg);
    font-family: var(--font-display);
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: var(--radius);
    text-decoration: none;
    transition: all var(--t);
}

.product-modal__btn:hover {
    background: var(--lime-dark);
    transform: translateY(-2px);
}

/* Mobile: Modal en columna */
@media (max-width: 768px) {
    .quick-view-modal__container {
        width: 95%;
        max-height: 85vh;
    }
    
    .product-modal__grid {
        grid-template-columns: 1fr;
    }
    
    .product-modal__image-wrap {
        min-height: 250px;
    }
    
    .product-modal__info {
        padding: 1.5rem;
    }
    
    .product-modal__name {
        font-size: 1.4rem;
    }
    
    .product-modal__price {
        font-size: 1.5rem;
    }
}
</style>
@endpush

@section('content')

{{-- ============================================================
     HERO
============================================================ --}}
<section class="hero" aria-label="Presentación">
    <div class="hero__content">

        <div class="hero__eyebrow fade-up">
            <span class="hero__eyebrow-dot"></span>
            <span class="hero__eyebrow-text">Mendoza · Lavalle 299 · Desde 2010</span>
        </div>

        <h1 class="hero__title fade-up d1">
            <span class="hero__title-line">AUDIO Y</span>
            <span class="hero__title-highlight">ELECTRÓNICA</span>
            <span class="hero__title-line">DE PRIMERA</span>
        </h1>

        <p class="hero__subtitle fade-up d2">
            Altavoces, amplificadores, equipos de música y tecnología. Asesoramiento personalizado y los mejores precios de Mendoza.
        </p>

        <div class="hero__actions fade-up d3">
            <a href="{{ route('catalogo.index') }}" class="btn btn-lime">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Ver Productos
            </a>
            <a href="https://wa.me/5492613372353?text=Hola!+Estaba+en+su+pagina+web+y+queria+consultarles" target="_blank" rel="noopener" class="btn btn-outline">
                Consultar precio
            </a>
        </div>

        <div class="hero__stats fade-up d4">
            <div class="hero__stat">
                <span class="hero__stat-value">4.3★</span>
                <span class="hero__stat-label">Google Rating</span>
            </div>
            <div class="hero__stat">
                <span class="hero__stat-value">+16</span>
                <span class="hero__stat-label">Reseñas</span>
            </div>
            <div class="hero__stat">
                <span class="hero__stat-value">+10</span>
                <span class="hero__stat-label">Años en Mendoza</span>
            </div>
        </div>
    </div>

    <div class="hero__visual fade-up d2" aria-hidden="true">
        <div class="hero__img-frame">
            <span class="hero__corner hero__corner--tl"></span>
            <span class="hero__corner hero__corner--tr"></span>
            <span class="hero__corner hero__corner--bl"></span>
            <span class="hero__corner hero__corner--br"></span>

            <div class="hero__img-main">
                {{-- Reemplazar con foto real de la tienda --}}
                <img src="{{ asset('images/SerElectronicaFuera.png') }}"
                     alt="Interior de SER Electrónica – Mendoza"
                     loading="eager">
            </div>

            <div class="hero__float-badge">
                <div class="hero__float-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div class="hero__float-text">
                    <strong>Garantizado</strong>
                    <span>Productos de primera</span>
                </div>
            </div>

            <div class="hero__rating-badge" aria-label="Rating 4.3 estrellas">
                <span class="num">4.3</span>
                <span class="star">★</span>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CATEGORÍAS
============================================================ --}}
<section class="cats-section" aria-labelledby="cats-heading">
    <div class="cats-section__inner">
        <div class="cats-header">
            <div>
                <span class="sec-label">Explorar</span>
                <h2 class="sec-title" id="cats-heading">CATEGORÍAS</h2>
            </div>
            <button class="cats-toggle" id="js-cats-toggle">
                Ver categorías
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </button>
        </div>

        <div class="cats-grid" id="js-cats-grid">
            @forelse($categorias as $categoria)
            <a href="{{ route('catalogo.index', ['categoria' => $categoria->slug]) }}" class="cat-pill">
                <div class="cat-pill__icon">
                    {{ $categoria->icono_emoji ?? '⚡' }}
                </div>
                <span class="cat-pill__name">{{ $categoria->name }}</span>
                <span class="cat-pill__count">{{ $categoria->products_count }} productos</span>
                <span class="cat-pill__arrow">→</span>
            </a>
            @empty
            {{-- Placeholders mientras se cargan datos --}}
            @foreach(['🔊 Audio','🎵 Música','⚡ Amplificadores','🎚️ Mezcladoras','💡 Iluminación','🔌 Cables'] as $placeholder)
            <div class="cat-pill">
                <div class="cat-pill__icon">{{ explode(' ', $placeholder)[0] }}</div>
                <span class="cat-pill__name">{{ ltrim(strstr($placeholder, ' ')) }}</span>
                <span class="cat-pill__count">— productos</span>
                <span class="cat-pill__arrow">→</span>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     PRODUCTOS DESTACADOS
============================================================ --}}
<section class="featured-section" aria-labelledby="featured-heading">
    <div class="featured-header">
        <div>
            <span class="sec-label">Lo mejor de la tienda</span>
            <h2 class="sec-title" id="featured-heading">PRODUCTOS<br>DESTACADOS</h2>
        </div>
        <a href="{{ route('catalogo.index') }}" class="btn btn-outline">Catálogo completo →</a>
    </div>

    <div class="products-grid">
        @forelse($productosDestacados as $producto)
        <article class="product-card">
            <div class="product-card__img">
                @if($producto->image)
                    <img src="{{ asset('storage/' . $producto->image) }}"
                         alt="{{ $producto->name }}" loading="lazy">
                @else
                    <div style="display:grid;place-items:center;height:100%;font-size:3rem;color:var(--text-3);">📦</div>
                @endif
                @if($producto->is_new)
                    <span class="product-card__badge">Nuevo</span>
                @endif
            </div>
            <div class="product-card__body">
                <span class="product-card__cat">{{ $producto->category->name }}</span>
                <h3 class="product-card__name">{{ $producto->name }}</h3>
                <p class="product-card__desc">{{ Str::limit($producto->description, 95) }}</p>
                <div class="product-card__footer">
                    <div>
                        <small>Precio</small>
                        <span class="product-card__price">${{ number_format($producto->price, 0, ',', '.') }}</span>
                    </div>
                    <a href="javascript:void(0)" onclick="openQuickView('{{ $producto->slug }}')" class="product-card__cta">
                        Ver más
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
        </article>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:5rem 0;color:var(--text-3);">
            <div style="font-size:3.5rem;margin-bottom:1rem">📦</div>
            <p>Los productos se mostrarán aquí.</p>
        </div>
        @endforelse
    </div>
</section>

{{-- ============================================================
     PROMOCIONES
============================================================ --}}
@if($promociones->count() > 0)
<section class="promo-strip" aria-labelledby="promo-heading">
    <div class="promo-strip__inner">
        <span class="sec-label">Ofertas activas</span>
        <h2 class="sec-title" id="promo-heading">PROMOCIONES</h2>

        <div class="promo-grid">
            @foreach($promociones->take(3) as $promo)
            <div class="promo-card">
                <span class="promo-card__tag">Promo</span>
                <h3 class="promo-card__title">{{ $promo->title }}</h3>
                <p class="promo-card__desc">{{ Str::limit($promo->description, 100) }}</p>
                @php
                    $ahora = now();
                    $muestraTiempo = '';
                    $startDate = $promo->start_date ? \Carbon\Carbon::parse($promo->start_date) : null;
                    $endDate = $promo->end_date ? \Carbon\Carbon::parse($promo->end_date) : null;
                    
                    if ($startDate && $startDate > $ahora) {
                        // La promo aún no ha comenzado
                        $diff = $startDate->diffForHumans(['parts' => 2, 'join' => true, 'short' => true]);
                        $muestraTiempo = 'Empieza en ' . $diff;
                    } elseif ($endDate && $endDate >= $ahora) {
                        // La promo está corriendo
                        $diff = $endDate->diffForHumans(['parts' => 2, 'join' => true, 'short' => true]);
                        $muestraTiempo = 'Finaliza en ' . $diff;
                    }
                @endphp
                @if($muestraTiempo)
                    <p class="promo-card__time">{{ $muestraTiempo }}</p>
                @endif
                <a href="{{ route('promociones.index') }}" class="btn btn-lime" style="font-size:0.78rem;padding:9px 18px;">
                    Ver promoción →
                </a>
            </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:2.5rem;">
            <a href="{{ route('promociones.index') }}" class="btn btn-outline">Ver todas las promociones</a>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     NOSOTROS / MAPA
============================================================ --}}
<section class="about-section" aria-labelledby="about-heading">
    <div class="about__map-wrap">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3350.358977304016!2d-68.83435650000001!3d-32.888675899999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x967e092283f797bf%3A0x545fd2d1106d8b5a!2sSER!5e0!3m2!1ses-419!2sar!4v1771630104700!5m2!1ses-419!2sar"
            allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            style="width:100%;height:400px;border:0;border-radius:var(--radius-xl);"
            title="Ubicación de SER Electrónica en Mendoza">
        </iframe>
        <div class="about__map-pin">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Lavalle 299, Mendoza Capital
        </div>
    </div>

    <div>
        <span class="sec-label">Dónde estamos</span>
        <h2 class="sec-title" id="about-heading">ENCONTRANOS<br>EN MENDOZA</h2>

        <p style="color:var(--text-2);margin-top:1.2rem;line-height:1.75;margin-bottom:0.8rem;font-size:0.95rem;">
            Somos una tienda especializada en electrónica ubicada en el centro de Mendoza. Más de 10 años vendiendo equipos de audio, altavoces pasivos y activos, y equipamiento de las mejores marcas.
        </p>
        <p style="color:var(--text-2);line-height:1.75;font-size:0.95rem;margin-bottom:2rem;">
            Nuestro equipo brinda asesoramiento real para que encontrés exactamente lo que necesitás al mejor precio.
        </p>

        <div class="about__features">
            <div class="feature-item">
                <div class="feature-item__icon">📍</div>
                <div class="feature-item__title">Ubicación</div>
                <div class="feature-item__text">Lavalle 299, Mendoza Capital</div>
            </div>
            <div class="feature-item">
                <div class="feature-item__icon">🕘</div>
                <div class="feature-item__title">Horario</div>
                <div class="feature-item__text">Lun–Vie 9–18h · Sáb 9–13h</div>
            </div>
            <div class="feature-item">
                <div class="feature-item__icon">📞</div>
                <div class="feature-item__title">Teléfono</div>
                <div class="feature-item__text">0261 337-2353</div>
            </div>
            <div class="feature-item">
                <div class="feature-item__icon">🚚</div>
                <div class="feature-item__title">Envíos</div>
                <div class="feature-item__text">Entrega a domicilio disponible</div>
            </div>
        </div>

        <div style="margin-top:2rem;display:flex;gap:1rem;flex-wrap:wrap;">
            <a href="https://wa.me/5492613372353" target="_blank" rel="noopener" class="btn btn-lime">
                Consultar por WhatsApp
            </a>
            <a href="tel:02613372353" class="btn btn-outline">
                Llamar ahora
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     RESEÑAS
============================================================ --}}
<section class="reviews-section" aria-labelledby="reviews-heading">
    <div class="reviews-inner">
        <div class="reviews-header">
            <div>
                <span class="sec-label">Google Reviews</span>
                <h2 class="sec-title" id="reviews-heading">LO QUE DICEN<br>NUESTROS CLIENTES</h2>
            </div>
            <div class="reviews-score">
                <span class="reviews-score__num">4.3</span>
                <span class="reviews-score__stars">★★★★☆</span>
                <span class="reviews-score__total">16 opiniones en Google</span>
            </div>
        </div>

        <div class="reviews-grid">
            @php
            // Set locale to Spanish for Carbon
            \Carbon\Carbon::setLocale('es');
            $reviews = [
                ['name' => 'Agus Taffe', 'date' => '2025-11-15', 'text' => 'La atención un lujo, los productos de primera. El equipo me ayudó con todo, incluso con algo de un juego. 11/10.', 'rating' => 5],
                ['name' => 'José Antonio Chaile', 'date' => '2025-10-20', 'text' => 'Excelente atención y precios. Muy buena calidad en sus productos. Unos genios, los recomiendo totalmente.', 'rating' => 5],
                ['name' => 'Marcos D.', 'date' => '2025-08-10', 'text' => 'Hay buenas marcas en equipo de música y altavoces pasivos y activos. Excelente asesoramiento y muy buenos precios.', 'rating' => 5],
            ];
            @endphp
            @foreach($reviews as $review)
            <article class="review-card">
                <div class="review-card__stars">{{ str_repeat('★', $review['rating']) }}</div>
                <p class="review-card__text">{{ $review['text'] }}</p>
                <div class="review-card__author">
                    <div class="review-card__avatar" aria-hidden="true">{{ substr($review['name'], 0, 1) }}</div>
                    <div>
                        <div class="review-card__name">{{ $review['name'] }}</div>
                        <div class="review-card__date">{{ \Carbon\Carbon::parse($review['date'])->diffForHumans() }}</div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<script>
// Toggle de categorías en móviles
(function() {
    const toggle = document.getElementById('js-cats-toggle');
    const grid = document.getElementById('js-cats-grid');
    
    if (toggle && grid) {
        toggle.addEventListener('click', function() {
            grid.classList.toggle('open');
            toggle.classList.toggle('open');
            
            if (grid.classList.contains('open')) {
                toggle.innerHTML = 'Ocultar <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>';
            } else {
                toggle.innerHTML = 'Ver categorías <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>';
            }
        });
    }
})();

// ============================================================
// MODAL DE VISTA RÁPIDA DEL PRODUCTO
// ============================================================
const quickViewModal = document.getElementById('quick-view-modal');
const quickViewClose = document.getElementById('quick-view-close');
const quickViewContent = document.getElementById('quick-view-content');

// Función para abrir el modal
window.openQuickView = function(slug) {
    fetch('/api/producto/' + slug)
        .then(response => response.json())
        .then(data => {
            const discountBadge = data.discount_percentage 
                ? `<span class="product-modal__discount">-${data.discount_percentage}%</span>` 
                : '';
            
            const priceSection = data.discount_percentage
                ? `<div class="product-modal__prices">
                        <span class="product-modal__price--old">${data.price_formatted}</span>
                        <span class="product-modal__price">${data.price_with_discount_formatted}</span>
                   </div>`
                : `<div class="product-modal__prices">
                        <span class="product-modal__price">${data.price_formatted}</span>
                   </div>`;
            
            const imageSection = data.image 
                ? `<img src="${data.image}" alt="${data.name}" class="product-modal__img">`
                : `<div class="product-modal__img product-modal__img--placeholder">📦</div>`;
            
            const detailsSection = data.marca || data.modelo || data.sku
                ? `<div class="product-modal__details">
                        ${data.marca ? `<div class="product-modal__detail"><span>Marca:</span> ${data.marca}</div>` : ''}
                        ${data.modelo ? `<div class="product-modal__detail"><span>Modelo:</span> ${data.modelo}</div>` : ''}
                        ${data.sku ? `<div class="product-modal__detail"><span>SKU:</span> ${data.sku}</div>` : ''}
                        ${data.stock !== null ? `<div class="product-modal__detail"><span>Stock:</span> ${data.stock > 0 ? data.stock + ' unidades' : 'Sin stock'}</div>` : ''}
                   </div>`
                : '';
            
            quickViewContent.innerHTML = `
                <div class="product-modal__grid">
                    <div class="product-modal__image-wrap">
                        ${discountBadge}
                        ${imageSection}
                    </div>
                    <div class="product-modal__info">
                        <span class="product-modal__category">${data.category || 'Sin categoría'}</span>
                        <h2 class="product-modal__name">${data.name}</h2>
                        ${priceSection}
                        <div class="product-modal__desc">
                            <h4>Descripción</h4>
                            <p>${data.description || 'Sin descripción disponible.'}</p>
                        </div>
                        ${detailsSection}
                        <a href="/catalogo/${data.slug}" class="product-modal__btn">Ver producto completo</a>
                    </div>
                </div>
            `;
            
            quickViewModal.classList.add('open');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el producto');
        });
};

// Cerrar modal
if (quickViewClose) {
    quickViewClose.addEventListener('click', function() {
        quickViewModal.classList.remove('open');
        document.body.style.overflow = '';
    });
}

// Cerrar al hacer clic fuera
if (quickViewModal) {
    quickViewModal.addEventListener('click', function(e) {
        if (e.target === quickViewModal) {
            quickViewModal.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
}

// Cerrar con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && quickViewModal && quickViewModal.classList.contains('open')) {
        quickViewModal.classList.remove('open');
        document.body.style.overflow = '';
    }
});
</script>

{{-- Modal de Vista Rápida --}}
<div id="quick-view-modal" class="quick-view-modal">
    <div class="quick-view-modal__backdrop"></div>
    <div class="quick-view-modal__container">
        <button id="quick-view-close" class="quick-view-modal__close" aria-label="Cerrar">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <div id="quick-view-content" class="quick-view-modal__content">
            {{-- Contenido cargado dinámicamente --}}
        </div>
    </div>
</div>

@endsection