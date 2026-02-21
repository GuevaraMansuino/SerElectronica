<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso — Panel Admin · SER Electrónica</title>

    <link rel="icon" type="image/png" href="/LogoPagina.svg">

    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&family=Fira+Code:wght@400&display=swap" rel="stylesheet">

    <style>
    :root {
        --bg:      #07111C;
        --surface: #0E1E30;
        --surface-2: #132436;
        --border:  #1A3050;
        --lime:    #B6FF3B;
        --lime-dim: rgba(182,255,59,0.09);
        --text:    #F1F5F9;
        --text-2:  #94A3B8;
        --text-3:  #3D5A78;
        --danger:  #EF4444;
        --font-d:  'Barlow Condensed', sans-serif;
        --font-b:  'Barlow', sans-serif;
        --font-m:  'Fira Code', monospace;
        --r: 8px;
        --t: 0.2s ease;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: var(--font-b);
        background: var(--bg);
        color: var(--text);
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* ============================================================
       LEFT PANEL — Decorativo
    ============================================================ */
    .login-left {
        background: var(--surface);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }

    /* Circuit pattern */
    .login-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(182,255,59,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(182,255,59,0.04) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* Glow central */
    .login-left::after {
        content: '';
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(182,255,59,0.08) 0%, transparent 65%);
        pointer-events: none;
    }

    .left-content {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 380px;
    }

    /* Big logo */
    .left-logo-hex {
        width: 80px; height: 80px;
        background: var(--lime);
        clip-path: polygon(50% 0%, 95% 25%, 95% 75%, 50% 100%, 5% 75%, 5% 25%);
        display: grid;
        place-items: center;
        margin: 0 auto 1.8rem;
        box-shadow: 0 0 40px rgba(182,255,59,0.25);
    }

    .left-logo-hex span {
        font-family: var(--font-d);
        font-size: 38px;
        font-weight: 800;
        color: var(--bg);
        line-height: 1;
    }

    .left-brand {
        font-family: var(--font-d);
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .left-brand em { color: var(--lime); font-style: normal; }

    .left-sub {
        font-family: var(--font-m);
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.25em;
        color: var(--text-3);
        margin-bottom: 3rem;
    }

    /* Features list */
    .left-features { display: flex; flex-direction: column; gap: 0.9rem; text-align: left; }

    .left-feature {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-size: 0.88rem;
        color: var(--text-2);
    }

    .left-feature-icon {
        width: 32px; height: 32px;
        background: var(--lime-dim);
        border: 1px solid rgba(182,255,59,0.15);
        border-radius: 6px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    /* ============================================================
       RIGHT PANEL — Login form
    ============================================================ */
    .login-right {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .login-box {
        width: 100%;
        max-width: 400px;
    }

    .login-box__header {
        margin-bottom: 2.5rem;
    }

    .login-box__eyebrow {
        font-family: var(--font-m);
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: var(--lime);
        margin-bottom: 0.6rem;
    }

    .login-box__title {
        font-family: var(--font-d);
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: 0.04em;
        color: var(--text);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .login-box__sub {
        font-size: 0.88rem;
        color: var(--text-2);
    }

    /* Alert */
    .login-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.25);
        border-radius: var(--r);
        padding: 0.9rem 1.1rem;
        font-size: 0.86rem;
        color: #fca5a5;
        margin-bottom: 1.5rem;
    }

    /* Form */
    .fgroup { display: flex; flex-direction: column; gap: 0.45rem; margin-bottom: 1.2rem; }

    .flabel {
        font-size: 0.76rem;
        font-weight: 700;
        color: var(--text-2);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .finput {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        padding: 12px 16px;
        font-size: 0.92rem;
        color: var(--text);
        font-family: var(--font-b);
        outline: none;
        width: 100%;
        transition: border-color var(--t), box-shadow var(--t);
    }

    .finput:focus {
        border-color: var(--lime);
        box-shadow: 0 0 0 3px rgba(182,255,59,0.1);
    }

    .finput::placeholder { color: var(--text-3); }

    .fcheck {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.86rem;
        color: var(--text-2);
        cursor: pointer;
        margin-bottom: 1.8rem;
    }

    .fcheck input { accent-color: var(--lime); width: 17px; height: 17px; cursor: pointer; }

    .submit-btn {
        width: 100%;
        background: var(--lime);
        color: var(--bg);
        border: none;
        border-radius: var(--r);
        padding: 14px;
        font-family: var(--font-d);
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all var(--t);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .submit-btn:hover {
        background: #c8ff5a;
        box-shadow: 0 0 24px rgba(182,255,59,0.35);
        transform: translateY(-1px);
    }

    .submit-btn:active { transform: translateY(0); }

    .login-footer {
        margin-top: 2rem;
        text-align: center;
        font-size: 0.78rem;
        color: var(--text-3);
    }

    .login-footer a {
        color: var(--lime);
        text-decoration: none;
        transition: color var(--t);
    }

    .login-footer a:hover { color: #c8ff5a; }

    /* ============================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        body { grid-template-columns: 1fr; }
        .login-left { display: none; }
        .login-right { padding: 2rem 1.5rem; min-height: 100vh; }
    }
    </style>
</head>
<body>

{{-- Panel izquierdo --}}
<div class="login-left" aria-hidden="true">
    <div class="left-content">
        <div class="left-logo-hex">
            <img src="{{ asset('LogoPagina.svg') }}" alt="SER" style="width:100%;height:100%;object-fit:contain;">
        </div>
        <h1 class="left-brand">SER <em>ELECTRÓNICA</em></h1>
        <p class="left-sub">Panel de Administración</p>

        <div class="left-features">
            <div class="left-feature">
                <div class="left-feature-icon">📦</div>
                <span>Gestioná tu catálogo de productos</span>
            </div>
            <div class="left-feature">
                <div class="left-feature-icon">🗂️</div>
                <span>Creá y editá categorías fácilmente</span>
            </div>
            <div class="left-feature">
                <div class="left-feature-icon">⭐</div>
                <span>Publicá promociones activas</span>
            </div>
            <div class="left-feature">
                <div class="left-feature-icon">🖼️</div>
                <span>Subí imágenes y precios en segundos</span>
            </div>
        </div>
    </div>
</div>

{{-- Panel derecho (form) --}}
<div class="login-right">
    <div class="login-box">
        <div class="login-box__header">
            <p class="login-box__eyebrow">Panel de administración</p>
            <h2 class="login-box__title">INICIAR SESIÓN</h2>
            <p class="login-box__sub">Ingresá tus credenciales para continuar al panel.</p>
        </div>

        @if($errors->any())
        <div class="login-alert" role="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Credenciales incorrectas. Intentá de nuevo.
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" novalidate>
            @csrf

            <div class="fgroup">
                <label class="flabel" for="email">Correo electrónico</label>
                <input type="email" name="email" id="email"
                       class="finput"
                       value="{{ old('email') }}"
                       placeholder="admin@serelectronica.com"
                       autocomplete="email"
                       required>
                @error('email')
                    <span style="font-size:0.75rem;color:#fca5a5;">{{ $message }}</span>
                @enderror
            </div>

            <div class="fgroup">
                <label class="flabel" for="password">Contraseña</label>
                <input type="password" name="password" id="password"
                       class="finput"
                       placeholder="••••••••••"
                       autocomplete="current-password"
                       required>
                @error('password')
                    <span style="font-size:0.75rem;color:#fca5a5;">{{ $message }}</span>
                @enderror
            </div>

            <label class="fcheck">
                <input type="checkbox" name="remember" value="1">
                <span>Recordarme en este dispositivo</span>
            </label>

            <button type="submit" class="submit-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Entrar al panel
            </button>
        </form>

        <div class="login-footer">
            <a href="{{ route('home') }}">← Volver al sitio público</a>
        </div>
    </div>
</div>

</body>
</html>