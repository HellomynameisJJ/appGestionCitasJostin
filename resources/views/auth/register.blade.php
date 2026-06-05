<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta · SANAR+</title>
    @vite(['resources/css/app.css'])
    <style>
        /* Posiciona el logotipo exactamente en la esquina superior izquierda */
        .auth-logo-link {
            position: fixed;
            top: 2rem;
            left: 2rem;
            z-index: 100;
            display: block;
            width: 210px; /* Tamaño ideal para la esquina */
            height: 45px;
            transition: transform 0.2s ease;
            text-decoration: none;
        }
        .auth-logo-link:hover {
            transform: scale(1.03); /* Sutil efecto al pasar el mouse */
        }
        /* Ajuste para pantallas pequeñas (móviles) */
        @media(max-width: 768px) {
            .auth-logo-link {
                position: absolute;
                top: 1.5rem;
                left: 50%;
                transform: translateX(-50%);
            }
            .auth-logo-link:hover {
                transform: translateX(-50%) scale(1.03);
            }
        }
    </style>
</head>
<body class="login-body">
    <div class="grid-bg"></div>

    <!-- EL LOGO EN LA ESQUINA: Al presionarlo te lleva directo a welcome.blade.php -->
    <a href="{{ url('/') }}" class="auth-logo-link" title="Volver a la página principal">
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

    <!-- Tu tarjeta de registro centrada queda intacta aquí abajo -->
    <div class="login-container" style="margin-top: 4rem;">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">✦</div>
                <h1>Comienza con SANAR+</h1>
                <p>Crea tu cuenta para empezar a gestionar la plataforma médica.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">NOMBRE COMPLETO</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Juan Pérez" required autofocus>
                </div>
                <div class="form-group">
                    <label for="email">CORREO ELECTRÓNICO</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="correo@universidad.com" required>
                </div>
                <div class="form-group">
                    <label for="password">CONTRASEÑA</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label for="password-confirm">CONFIRMAR CONTRASEÑA</label>
                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit" style="margin-bottom: 1.5rem;">Registrarse ahora →</button>
            </form>

            <div class="login-footer">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </div>
        </div>
    </div>
</body>
</html>