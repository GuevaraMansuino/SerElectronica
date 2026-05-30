<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña — SER Electrónica</title>
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
            <h2 class="login-box__title" style="font-size:1.8rem">NUEVA CONTRASEÑA</h2>
            <p class="login-box__sub">Creá una nueva contraseña segura para tu cuenta.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" novalidate>
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="fgroup">
                <label class="flabel" for="email">Correo electrónico</label>
                <input type="email" name="email" id="email"
                       class="finput"
                       value="{{ old('email', $request->email) }}"
                       required readonly style="opacity:0.7; cursor:not-allowed">
                @error('email')
                    <span style="font-size:0.75rem;color:#fca5a5;">{{ $message }}</span>
                @enderror
            </div>

            <div class="fgroup">
                <label class="flabel" for="password">Nueva contraseña</label>
                <input type="password" name="password" id="password"
                       class="finput"
                       placeholder="••••••••••"
                       required autofocus>
                @error('password')
                    <span style="font-size:0.75rem;color:#fca5a5;">{{ $message }}</span>
                @enderror
            </div>

            <div class="fgroup">
                <label class="flabel" for="password_confirmation">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="finput"
                       placeholder="••••••••••"
                       required>
                @error('password_confirmation')
                    <span style="font-size:0.75rem;color:#fca5a5;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="submit-btn" style="margin-top: 1.5rem">
                Restablecer contraseña
            </button>
        </form>

    </div>
</div>

</body>
</html>
