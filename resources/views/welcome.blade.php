<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CliniSync · Sistema de Gestión de Citas Médicas</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
    /* CURSOR */
    *{cursor:none!important}
    #cur{width:9px;height:9px;background:var(--green);border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:width .15s,height .15s}
    #cur-r{width:32px;height:32px;border:1px solid rgba(45,122,79,.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);transition:left .1s,top .1s,width .2s,height .2s}
    #cur.g{width:14px;height:14px}#cur-r.g{width:50px;height:50px}
    @media(max-width:640px){#cur,#cur-r{display:none}*{cursor:auto!important}}

    /* HERO */
    .hero{min-height:100vh;display:grid;grid-template-columns:1fr 1fr;align-items:center;padding:7rem 3rem 4rem;max-width:1280px;margin:0 auto;gap:4rem;position:relative;z-index:1}
    .hero-eyebrow{display:inline-flex;align-items:center;gap:.6rem;padding:.35rem 1rem;border-radius:100px;border:1px solid rgba(45,122,79,.2);background:rgba(45,122,79,.05);font-size:.7rem;color:var(--green);letter-spacing:.1em;text-transform:uppercase;font-weight:700;margin-bottom:1.8rem}
    .hero-display{font-family:'Fraunces',serif;font-size:clamp(3rem,5vw,4.8rem);font-weight:900;line-height:.97;letter-spacing:-.03em;margin-bottom:1.5rem}
    .hero-display em{font-style:italic;color:var(--green);display:block}
    .hero-lead{font-size:.97rem;line-height:1.9;color:var(--muted);max-width:460px;margin-bottom:2.5rem}
    .hero-btns{display:flex;gap:.8rem;flex-wrap:wrap}
    .hero-pills{display:flex;gap:1.2rem;flex-wrap:wrap;margin-top:2rem}
    .hero-pill{display:flex;align-items:center;gap:.5rem;font-size:.77rem;color:var(--muted)}
    .hero-pill strong{color:var(--text);font-weight:600}
    .pill-sep{width:1px;height:16px;background:var(--border)}

    /* HERO VISUAL */
    .hero-visual{position:relative;height:500px}
    .hero-img-main{position:absolute;right:0;top:50%;transform:translateY(-50%);width:90%;height:420px;border-radius:24px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-lg)}
    .hero-img-main img{width:100%;height:100%;object-fit:cover;filter:brightness(.85) saturate(.9)}
    .hero-img-main::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(45,122,79,.15) 0%,transparent 60%),linear-gradient(to top,rgba(45,122,79,.4) 0%,transparent 50%)}
    .hero-img-float{position:absolute;left:-10px;bottom:30px;width:170px;height:130px;border-radius:18px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-lg);animation:floatCard 7s ease-in-out infinite;z-index:2}
    .hero-img-float img{width:100%;height:100%;object-fit:cover}
    @keyframes floatCard{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
    .v-chip{position:absolute;z-index:3;background:rgba(255,255,255,.95);backdrop-filter:blur(12px);border:1px solid var(--border);border-radius:14px;padding:.65rem 1rem;box-shadow:var(--shadow)}
    .v-chip-label{font-size:.6rem;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:.2rem}
    .v-chip-val{font-size:.9rem;font-weight:700;color:var(--text)}
    .v-chip-val em{color:var(--green);font-style:normal}
    .vc1{top:18px;left:0;animation:floatCard 5s ease-in-out infinite}
    .vc2{top:50%;right:-14px;transform:translateY(-50%);animation:floatCard 6s ease-in-out infinite 1.5s}

    /* TRUST BAR */
    .trust-bar{border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:1.2rem 0;overflow:hidden;background:var(--sf);position:relative;z-index:1}
    .trust-track{display:flex;gap:3rem;align-items:center;animation:marquee 22s linear infinite;white-space:nowrap}
    .trust-item{font-size:.74rem;font-weight:600;color:var(--muted);letter-spacing:.08em;text-transform:uppercase;flex-shrink:0;display:flex;align-items:center;gap:.6rem}
    .trust-item::before{content:'✦';color:var(--green);font-size:.65rem}
    @keyframes marquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}

    /* SECTIONS */
    .lp{position:relative;z-index:1}
    .lp-inner{max-width:1280px;margin:0 auto;padding:6rem 3rem}
    .lp-dark{background:var(--sf);border-top:1px solid var(--border);border-bottom:1px solid var(--border)}
    .sec-sup{font-size:.67rem;letter-spacing:.16em;text-transform:uppercase;color:var(--green);font-weight:700;margin-bottom:.75rem}
    .sec-h{font-family:'Fraunces',serif;font-size:clamp(2rem,3.5vw,3rem);font-weight:900;line-height:1.05;letter-spacing:-.03em;margin-bottom:1rem}
    .sec-h em{font-style:italic;color:var(--green)}
    .sec-p{font-size:.93rem;line-height:1.9;color:var(--muted);max-width:520px}
    .sec-header{margin-bottom:3.5rem}

    /* MODULOS GRID */
    .modulos-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.4rem}
    .mod-card{background:var(--sf2);border:1px solid var(--border);border-radius:20px;overflow:hidden;transition:all .28s;cursor:pointer}
    .mod-card:hover{border-color:var(--green2);transform:translateY(-5px);box-shadow:var(--shadow-lg)}
    .mod-img{width:100%;height:180px;overflow:hidden;position:relative}
    .mod-img img{width:100%;height:100%;object-fit:cover;filter:brightness(.75) saturate(.85);transition:transform .5s}
    .mod-card:hover .mod-img img{transform:scale(1.06)}
    .mod-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,transparent 40%,rgba(45,122,79,.85))}
    .mod-img-label{position:absolute;bottom:.8rem;left:1rem;z-index:1;font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.25rem .7rem;border-radius:100px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);color:#fff}
    .mod-body{padding:1.5rem}
    .mod-body h3{font-family:'Fraunces',serif;font-size:1rem;font-weight:700;margin-bottom:.4rem}
    .mod-body p{font-size:.83rem;color:var(--muted);line-height:1.65}

    /* BENTO */
    .bento{display:grid;grid-template-columns:1.4fr 1fr 1fr;grid-template-rows:auto auto;gap:1.3rem}
    .bc{background:var(--sf);border:1px solid var(--border);border-radius:20px;padding:1.8rem;transition:all .25s}
    .bc:hover{border-color:var(--green2);transform:translateY(-3px)}
    .bc.tall{grid-row:span 2;display:flex;flex-direction:column}
    .bc.tall .bc-img{flex:1;border-radius:14px;overflow:hidden;margin-top:1.4rem;min-height:180px}
    .bc.tall .bc-img img{width:100%;height:100%;object-fit:cover;filter:brightness(.6) saturate(.8)}
    .bc-ico{font-size:1.8rem;margin-bottom:1.1rem;width:52px;height:52px;border-radius:14px;background:var(--green-lt);border:1px solid rgba(45,122,79,.14);display:flex;align-items:center;justify-content:center}
    .bc h3{font-family:'Fraunces',serif;font-size:.97rem;font-weight:700;margin-bottom:.4rem}
    .bc p{font-size:.82rem;color:var(--muted);line-height:1.7}
    .bc-num{font-family:'Fraunces',serif;font-size:3rem;font-weight:900;color:var(--green);line-height:1;margin-bottom:.3rem;letter-spacing:-.04em}

    /* CTA */
    .cta-banner{position:relative;overflow:hidden;border-top:1px solid var(--border);background:var(--sf)}
    .cta-inner{max-width:1280px;margin:0 auto;padding:6rem 3rem;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center}
    .cta-img{border-radius:22px;overflow:hidden;height:340px;border:1px solid var(--border);box-shadow:var(--shadow-lg)}
    .cta-img img{width:100%;height:100%;object-fit:cover;filter:brightness(.8) saturate(.85)}

    /* FOOTER */
    .lp-footer{border-top:1px solid var(--border);background:var(--sf2);padding:3.5rem 3rem 2rem;position:relative;z-index:1}
    .footer-grid{max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:3rem;margin-bottom:2.5rem}
    .footer-desc{font-size:.84rem;color:var(--muted);line-height:1.8;margin-top:.8rem;max-width:240px}
    .footer-col h5{font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:.9rem}
    .footer-col a{display:block;color:var(--muted);text-decoration:none;font-size:.83rem;margin-bottom:.5rem;transition:color .2s}
    .footer-col a:hover{color:var(--green)}
    .footer-bottom{max-width:1280px;margin:0 auto;padding-top:1.5rem;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem}
    .footer-bottom p{font-size:.76rem;color:var(--muted)}

    @media(max-width:1024px){.hero{grid-template-columns:1fr;padding-top:8rem}.hero-visual{height:300px}.modulos-grid{grid-template-columns:1fr}.bento{grid-template-columns:1fr 1fr}.cta-inner{grid-template-columns:1fr}.footer-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.bento{grid-template-columns:1fr}.footer-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div id="cur"></div><div id="cur-r"></div>
<div class="grid-bg"></div>

<!-- NAV -->
<nav class="n">
    <a href="/" class="n-brand">
        <div class="n-logo">S+</div>
        <div>
            <div class="n-name">CliniSync<span>+</span></div>
            <div class="n-sub">Sistema de Gestión Médica</div>
        </div>
    </a>
    <div style="display:flex;gap:2rem;align-items:center">
        <a href="#modulos" style="color:var(--muted);text-decoration:none;font-size:.84rem" onmouseover="this.style.color='var(--green)'" onmouseout="this.style.color='var(--muted)'">Módulos</a>
        <a href="#por-que" style="color:var(--muted);text-decoration:none;font-size:.84rem" onmouseover="this.style.color='var(--green)'" onmouseout="this.style.color='var(--muted)'">¿Por qué?</a>
    </div>
    @if(Route::has('login'))
    <div class="n-actions">
        @auth
            <a href="{{ url('/home') }}" class="btn btn-fill">Panel →</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost">Iniciar sesión</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-fill">Crear cuenta</a>
            @endif
        @endauth
    </div>
    @endif
</nav>

<!-- HERO -->
<section style="position:relative;overflow:hidden">
    <div class="hero">
        <div>
            <div class="hero-eyebrow"><span class="status-dot"></span> Plataforma activa — 2025</div>
            <h1 class="hero-display">Gestión médica<br><em>inteligente.</em></h1>
            <p class="hero-lead">Sistema integral para clínicas y consultorios. Administra pacientes, médicos, citas, diagnósticos, tratamientos y medicamentos desde un solo lugar.</p>
            <div class="hero-btns">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-fill btn-lg">Entrar al panel →</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-fill btn-lg">Comenzar ahora →</a>
                    <a href="{{ route('login') }}" class="btn btn-line btn-lg">Ya tengo cuenta</a>
                @endauth
            </div>
            <div class="hero-pills">
                <div class="hero-pill"><strong>6</strong> módulos</div>
                <div class="pill-sep"></div>
                <div class="hero-pill"><strong>100%</strong> seguro</div>
                <div class="pill-sep"></div>
                <div class="hero-pill"><strong>API</strong> REST</div>
                <div class="pill-sep"></div>
                <div class="hero-pill"><strong>Google</strong> OAuth</div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="v-chip vc1">
                <div class="v-chip-label">Estado</div>
                <div class="v-chip-val">Sistema <em>activo</em></div>
            </div>
            <div class="hero-img-main">
                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=900&auto=format&fit=crop&q=80" alt="Clínica">
            </div>
            <div class="v-chip vc2">
                <div class="v-chip-label">Pacientes</div>
                <div class="v-chip-val"><em>+500</em> registros</div>
            </div>
            <div class="hero-img-float">
                <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=400&auto=format&fit=crop&q=80" alt="Médico">
            </div>
        </div>
    </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar">
    <div class="trust-track">
        <span class="trust-item">Pacientes</span><span class="trust-item">Médicos</span>
        <span class="trust-item">Citas</span><span class="trust-item">Diagnósticos</span>
        <span class="trust-item">Tratamientos</span><span class="trust-item">Medicamentos</span>
        <span class="trust-item">API REST</span><span class="trust-item">Google OAuth</span>
        <span class="trust-item">Laravel 12</span><span class="trust-item">MySQL</span>
        <span class="trust-item">Pacientes</span><span class="trust-item">Médicos</span>
        <span class="trust-item">Citas</span><span class="trust-item">Diagnósticos</span>
        <span class="trust-item">Tratamientos</span><span class="trust-item">Medicamentos</span>
        <span class="trust-item">API REST</span><span class="trust-item">Google OAuth</span>
        <span class="trust-item">Laravel 12</span><span class="trust-item">MySQL</span>
    </div>
</div>

<!-- MÓDULOS -->
<div id="modulos" class="lp">
    <div class="lp-inner">
        <div class="sec-header">
            <div class="sec-sup observe">Módulos del sistema</div>
            <h2 class="sec-h observe">Todo en un <em>solo lugar</em></h2>
            <p class="sec-p observe">Seis módulos integrados que cubren todo el flujo clínico, desde el paciente hasta su medicación.</p>
        </div>
        <div class="modulos-grid">
            <div class="mod-card observe">
                <div class="mod-img"><img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=600&auto=format&fit=crop&q=80" alt="Pacientes"><div class="mod-img-label">Pacientes</div></div>
                <div class="mod-body"><h3>👤 Gestión de Pacientes</h3><p>Registro completo con datos personales, tipo de sangre, historial y estado de atención.</p></div>
            </div>
            <div class="mod-card observe">
                <div class="mod-img"><img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=600&auto=format&fit=crop&q=80" alt="Médicos"><div class="mod-img-label">Médicos</div></div>
                <div class="mod-body"><h3>🩺 Cuerpo Médico</h3><p>Gestiona especialistas, licencias, años de experiencia y disponibilidad para citas.</p></div>
            </div>
            <div class="mod-card observe">
                <div class="mod-img"><img src="https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=600&auto=format&fit=crop&q=80" alt="Citas"><div class="mod-img-label">Citas</div></div>
                <div class="mod-body"><h3>📅 Control de Citas</h3><p>Programa, edita y cancela citas con asignación de sala, médico y estado en tiempo real.</p></div>
            </div>
            <div class="mod-card observe">
                <div class="mod-img"><img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&auto=format&fit=crop&q=80" alt="Diagnósticos"><div class="mod-img-label">Diagnósticos</div></div>
                <div class="mod-body"><h3>🔬 Diagnósticos</h3><p>Registro de diagnósticos con gravedad, tipo y recomendaciones médicas por paciente.</p></div>
            </div>
            <div class="mod-card observe">
                <div class="mod-img"><img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=600&auto=format&fit=crop&q=80" alt="Tratamientos"><div class="mod-img-label">Tratamientos</div></div>
                <div class="mod-body"><h3>💊 Tratamientos</h3><p>Vincula tratamientos a diagnósticos con duración, frecuencia y estado de seguimiento.</p></div>
            </div>
            <div class="mod-card observe">
                <div class="mod-img"><img src="https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=600&auto=format&fit=crop&q=80" alt="Medicamentos"><div class="mod-img-label">Medicamentos</div></div>
                <div class="mod-body"><h3>🧪 Medicamentos</h3><p>Control de dosis, frecuencia, proveedor y efectos secundarios de cada medicamento.</p></div>
            </div>
        </div>
    </div>
</div>

<!-- POR QUÉ CliniSync -->
<div id="por-que" class="lp lp-dark">
    <div class="lp-inner">
        <div class="sec-header">
            <div class="sec-sup observe">¿Por qué CliniSync?</div>
            <h2 class="sec-h observe">Construido para <em>profesionales</em></h2>
        </div>
        <div class="bento">
            <div class="bc tall observe">
                <div class="bc-ico">🏥</div>
                <h3>Plataforma clínica completa</h3>
                <p>Todos los módulos interconectados para un flujo de atención sin interrupciones, desde la cita hasta la medicación.</p>
                <div class="bc-img"><img src="https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=500&auto=format&fit=crop&q=80" alt="Clínica"></div>
            </div>
            <div class="bc observe">
                <div class="bc-num">6</div>
                <h3>Módulos integrados</h3>
                <p>Pacientes · Médicos · Citas · Diagnósticos · Tratamientos · Medicamentos.</p>
            </div>
            <div class="bc observe">
                <div class="bc-ico">🔐</div>
                <h3>Seguridad con OAuth</h3>
                <p>Autenticación con Google vía Socialite. Acceso protegido para cada módulo.</p>
            </div>
            <div class="bc observe">
                <div class="bc-num">API</div>
                <h3>REST completa</h3>
                <p>Endpoints GET, POST, PUT y DELETE documentados y probados en Postman.</p>
            </div>
            <div class="bc observe">
                <div class="bc-ico">⚡</div>
                <h3>Laravel 12 + MySQL</h3>
                <p>Stack moderno y confiable. Migraciones, modelos con relaciones y seeders incluidos.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA FINAL -->
<div class="cta-banner">
    <div class="cta-inner">
        <div class="cta-img observe">
            <img src="https://images.unsplash.com/photo-1551190822-a9333d879b1f?w=800&auto=format&fit=crop&q=80" alt="Equipo médico">
        </div>
        <div class="observe">
            <div class="sec-sup">Acceso inmediato</div>
            <h2 class="sec-h">Comienza a <em>gestionar</em> hoy</h2>
            <p class="sec-p" style="margin-bottom:2rem">Crea tu cuenta, inicia sesión con Google y accede a todos los módulos del sistema en segundos.</p>
            <div style="display:flex;gap:.8rem;flex-wrap:wrap">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-fill btn-lg">Ir al panel →</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-fill btn-lg">Registrarse ahora →</a>
                    <a href="{{ route('login') }}" class="btn btn-line btn-lg">Iniciar sesión</a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="lp-footer">
    <div class="footer-grid">
        <div>
            <a href="/" class="n-brand" style="text-decoration:none;color:var(--text)">
                <div class="sb-logo">C+</div>
                <div><div class="n-name" style="font-size:.95rem">CliniSync<span style="color:var(--green)">+</span></div></div>
            </a>
            <p class="footer-desc">Sistema integral de gestión médica. Backend Developer Web · SENATI 2025.</p>
        </div>
        <div class="footer-col">
            <h5>Módulos</h5>
            <a href="#">Pacientes</a><a href="#">Médicos</a>
            <a href="#">Citas</a><a href="#">Diagnósticos</a>
            <a href="#">Tratamientos</a><a href="#">Medicamentos</a>
        </div>
        <div class="footer-col">
            <h5>Sistema</h5>
            <a href="{{ route('login') }}">Iniciar sesión</a>
            @if(Route::has('register'))<a href="{{ route('register') }}">Crear cuenta</a>@endif
            <a href="#">API Docs</a>
            <a href="#">GitHub</a>
        </div>
        <div class="footer-col">
            <h5>Tecnologías</h5>
            <a href="#">Laravel 12</a><a href="#">MySQL / HeidiSQL</a>
            <a href="#">Postman API</a><a href="#">Google Socialite</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} CliniSync · Sistema de Gestión de Citas Médicas · SENATI</p>
        <p>Backend Developer Web</p>
    </div>
</footer>

<script>
const cur=document.getElementById('cur'),ring=document.getElementById('cur-r');
document.addEventListener('mousemove',e=>{
    cur.style.left=e.clientX+'px';cur.style.top=e.clientY+'px';
    setTimeout(()=>{ring.style.left=e.clientX+'px';ring.style.top=e.clientY+'px';},90);
});
document.querySelectorAll('a,button,.mod-card,.bc').forEach(el=>{
    el.addEventListener('mouseenter',()=>{cur.classList.add('g');ring.classList.add('g');});
    el.addEventListener('mouseleave',()=>{cur.classList.remove('g');ring.classList.remove('g');});
});
const io=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');io.unobserve(x.target);}}),{threshold:.1});
document.querySelectorAll('.observe').forEach(el=>io.observe(el));
document.querySelectorAll('a[href^="#"]').forEach(a=>a.addEventListener('click',e=>{const t=document.querySelector(a.getAttribute('href'));if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});}}));
</script>
</body>
</html>