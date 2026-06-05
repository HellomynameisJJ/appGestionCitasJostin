<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido de vuelta · SANAR+</title>
    @vite(['resources/css/app.css'])
    <style>
        /* El logo arriba a la izquierda sin romper nada */
        .auth-logo-link {
            position: fixed;
            top: 2rem;
            left: 2rem;
            z-index: 100;
            display: block;
            width: 210px;
            height: 45px;
            text-decoration: none;
        }
    </style>
</head>
<body class="login-body">
    <div class="grid-bg"></div>

    <a href="/" class="auth-logo-link" title="Volver a la página principal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 420 90" width="100%" height="100%">
            <defs>
                <style>
                    .logo-mark { fill: var(--green); }
                    .logo-sparkle { fill: var(--green3); }
                    .text-main { font-family: var(--font-display); font-size: 34px; font-weight: 800; fill: var(--text); }
                    .text-plus { font-family: var(--font-body); font-size: 36px; font-weight: 700; fill: var(--green); }
                    .text-sub { font-family: var(--font-body); font-size: 10px; font-weight: 600; fill: var(--muted); letter-spacing: 0.22em; }
                </style>
            </defs>
            <g transform="translate(10, 5)">
                <rect width="65" height="65" rx="16" fill="#ffffff" stroke="var(--border)" stroke-width="2"/>
                <rect width="65" height="65" rx="16" fill="rgba(45, 122, 79, 0.03)"/>
                <path d="M 36,22 C 30,22 25,24 25,29 C 25,35 41,33 41,40 C 41,44 36,46 31,46 C 26,46 23,43 23,43" fill="none" stroke="var(--green)" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M 44,22 L 52,22 M 48,18 L 48,26" fill="none" stroke="var(--green3)" stroke-width="3.5" stroke-linecap="round"/>
            </g>
            <path d="M 92,30 Q 97,35 102,30 Q 97,25 92,30 Z M 92,30 Q 97,35 92,40 Q 87,35 92,30 Z" class="logo-sparkle"/>
            <text x="112" y="46" class="text-main">SANAR</text>
            <text x="234" y="46" class="text-plus">+</text>
            <text x="114" y="62" class="text-sub">SISTEMA DE GESTIÓN MÉDICA</text>
        </svg>
    </a>

    <div class="login-container" style="margin-top: 4rem;">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">✦</div>
                <h1>Bienvenido de vuelta</h1>
                <p>Ingresa tus credenciales para acceder a la plataforma.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">CORREO ELECTRÓNICO</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="correo@universidad.com" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">CONTRASEÑA</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit">Iniciar sesión →</button>
            </form>

            <div class="divider">
                <span>o continúa con</span>
            </div>

            <div class="social-login">
                <a href="{{ url('/login/google') }}" class="btn-social">
                    <svg style="width:20px; height:20px;" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M12 5.04c1.64 0 3.12.56 4.28 1.67l3.2-3.2C17.52 1.58 14.96 1 12 1 7.35 1 3.4 3.65 1.48 7.5l3.76 2.92C6.12 6.87 8.84 5.04 12 5.04z"/>
                        <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.34H12v4.42h6.44c-.28 1.46-1.1 2.7-2.34 3.53l3.63 2.82c2.13-1.96 3.76-4.85 3.76-8.43z"/>
                        <path fill="#FBBC05" d="M5.24 14.58a7.2 7.2 0 0 1 0-4.32L1.48 7.34a11.94 11.94 0 0 0 0 10.15l3.76-2.91z"/>
                        <path fill="#34A853" d="M12 18.96c-3.16 0-5.88-1.83-6.76-4.52l-3.76 2.91C3.4 21.35 7.35 24 12 24c2.96 0 5.44-.98 7.25-2.66l-3.63-2.82c-1 .67-2.28 1.44-3.62 1.44z"/>
                    </svg>
                    Google
                </a>
                <a href="{{ url('/login/github') }}" class="btn-social">
                    <svg style="width:20px; height:20px;" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1.27C5.37 1.27 0 6.64 0 13.27c0 5.3 3.43.98 8.2 11.57.6.11.82-.26.82-.58 0-.29-.01-1.04-.01-2.04-3.34.72-4.04-1.61-4.04-1.61-.55-1.39-1.34-1.76-1.34-1.76-1.09-.74.08-.73.08-.73 1.21.09 1.84 1.24 1.84 1.24 1.07 1.83 2.8 1.3 3.49 1 .11-.78.42-1.31.76-1.61-2.67-.3-5.47-1.33-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.54-1.52.12-3.18 0 0 1-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.28-1.55 3.29-1.23 3.29-1.23.66 1.66.24 2.88.12 3.18.77.84 1.24 1.91 1.24 3.22 0 4.61-2.8 5.62-5.47 5.92.43.37.81 1.1.81 2.22 0 1.6-.01 2.9-.01 3.29 0 .32.22.69.82.57 4.77-1.59 8.2-6.27 8.2-11.57 0-6.63-5.37-12-12-12z"/>
                    </svg>
                    GitHub
                </a>
            </div>

            <div class="login-footer">
                ¿No tienes cuenta? <a href="{{ route('register') }}">Crear cuenta</a>
            </div>
        </div>
    </div>
</body>
</html>