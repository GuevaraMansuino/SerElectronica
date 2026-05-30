<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña — SER Electrónica</title>
    <link rel="icon" type="image/png" href="/LogoPagina.svg">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500;600&family=Fira+Code:wght@400&display=swap" rel="stylesheet">
    @vite(['resources/css/login.css'])
</head>
<body>

<div class="login-left" aria-hidden="true">
    <div class="left-content">
        <div class="left-logo-hex">
            <img src="{{ asset('LogoPagina.svg') }}" alt="SER" style="width:100%;height:100%;object-fit:contain;">
        </div>
        <h1 class="left-brand">SER <em>ELECTRÓNICA</em></h1>
        <p class="left-sub">Panel de Administración</p>
    </div>
</div>

<div class="login-right">
    <div class="login-box">
        <div class="login-box__header">
            <p class="login-box__eyebrow">Recuperación</p>
            <h2 class="login-box__title" style="font-size:1.8rem">¿OLVIDASTE TU CONTRASEÑA?</h2>
            <p class="login-box__sub">Ingresá la dirección de correo electrónico asociada a tu cuenta y te enviaremos un enlace seguro para restablecerla.</p>
        </div>

        @if(session('status'))
        <div class="login-alert" role="alert" style="border-color:var(--lime);background:rgba(182,255,59,0.1);">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
            {{ session('status') }}
        </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" novalidate>
            @csrf

            <div class="fgroup">
                <label class="flabel" for="email">Correo electrónico</label>
                <input type="email" name="email" id="email"
                       class="finput"
                       value="{{ old('email') }}"
                       placeholder="admin@serelectronica.com"
                       required autofocus>
                @error('email')
                    <span style="font-size:0.75rem;color:#fca5a5;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="submit-btn" style="margin-top: 1.5rem">
                Enviar enlace de recuperación
            </button>
        </form>

        <div class="login-footer">
            <a href="{{ route('login') }}">← Volver al login</a>
        </div>
    </div>
</div>

</body>
</html>
