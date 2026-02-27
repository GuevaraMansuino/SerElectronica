<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso — Panel Admin · SER Electrónica</title>

    <link rel="icon" type="image/png" href="/LogoPagina.svg">

    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&family=Fira+Code:wght@400&display=swap" rel="stylesheet">

    @vite(['resources/css/login.css'])
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

        @if(request()->get('expired'))
        <div class="login-alert" role="alert" style="border-color:var(--lime);background:rgba(182,255,59,0.1);">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
            Tu sesión expiró. Por favor, iniciá sesión nuevamente.
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