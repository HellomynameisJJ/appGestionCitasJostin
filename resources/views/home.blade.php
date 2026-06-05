{{-- ═══════════════════════════════════════════
     resources/views/home.blade.php
     Dashboard principal de SANAR+
═══════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard · SANAR+</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
    *{cursor:none!important}
    #cur{width:9px;height:9px;background:var(--green);border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:width .15s,height .15s}
    #cur-r{width:32px;height:32px;border:1px solid rgba(45,122,79,.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);transition:left .1s,top .1s}
    #cur.g{width:14px;height:14px}#cur-r.g{width:50px;height:50px}
    @media(max-width:640px){#cur,#cur-r{display:none}*{cursor:auto!important}}
    .blob{position:fixed;border-radius:50%;filter:blur(120px);pointer-events:none;z-index:0;animation:bd 18s ease-in-out infinite}
    @keyframes bd{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(30px,-20px) scale(1.06)}}
    </style>
</head>
<body>
<div id="cur"></div><div id="cur-r"></div>
<div class="blob" style="width:400px;height:400px;background:rgba(45,122,79,.05);top:-80px;right:-80px"></div>
<div class="grid-bg"></div>

<nav class="n">
    <a href="/" class="n-brand">
        <div class="n-logo">S+</div>
        <div><div class="n-name">SANAR<span>+</span></div><div class="n-sub">Panel de gestión</div></div>
    </a>
    <div class="n-user">
        <div class="n-user-info">
            <span>Sesión iniciada</span>
            <strong>{{ Auth::user()->name }}</strong>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="btn btn-ghost">Salir</button>
        </form>
    </div>
</nav>

<div class="dash-layout">
    {{-- HERO --}}
    <div class="dash-hero observe">
        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&auto=format&fit=crop&q=80" alt="Clínica">
        <div class="dash-hero-overlay">
            <div class="status"><span class="status-dot"></span> Sistema sincronizado</div>
            <div class="dash-date">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</div>
            <h1>Bienvenido, <em>{{ explode(' ', Auth::user()->name)[0] }}.</em></h1>
            <p>Administra pacientes, citas, diagnósticos y más.</p>

<a href="#" class="btn btn-fill">Explorar sistema →</a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card observe"><div class="stat-ico">👤</div><div class="stat-n">{{ \App\Models\Paciente::count() }}</div><div class="stat-l">Pacientes</div></div>
        <div class="stat-card observe" style="transition-delay:.05s"><div class="stat-ico">🩺</div><div class="stat-n">{{ \App\Models\Medico::count() }}</div><div class="stat-l">Médicos</div></div>
        <div class="stat-card observe" style="transition-delay:.1s"><div class="stat-ico">📅</div><div class="stat-n">{{ \App\Models\Cita::count() }}</div><div class="stat-l">Citas</div></div>
        <div class="stat-card observe" style="transition-delay:.15s"><div class="stat-ico">🔬</div><div class="stat-n">{{ \App\Models\Diagnostico::count() }}</div><div class="stat-l">Diagnósticos</div></div>
        <div class="stat-card observe" style="transition-delay:.2s"><div class="stat-ico">💊</div><div class="stat-n">{{ \App\Models\Tratamiento::count() }}</div><div class="stat-l">Tratamientos</div></div>
        <div class="stat-card observe" style="transition-delay:.25s"><div class="stat-ico">🧪</div><div class="stat-n">{{ \App\Models\Medicamento::count() }}</div><div class="stat-l">Medicamentos</div></div>
    </div>

    {{-- BENTO --}}
    <div class="dash-bento">
        <div class="db-card observe">
            <img src="https://comex-assets.s3.amazonaws.com/comex-assets/web/posts/6328/hechos---salud-040920-032652.jpg" style="width:100%;height:160px;object-fit:cover;filter:brightness(.5) saturate(.7)">
            <div class="db-card-head" style="border-top:1px solid var(--border)">
                <div class="db-card-title"><span>⚡</span> Acceso rápido</div>
            </div>
            <div class="db-card-body">
                <div class="quick-nav">
                    <a href="{{ route('pacientes.index') }}" class="qnav"><div class="qnav-ico">👤</div>Pacientes</a>
                    <a href="{{ route('medicos.index') }}" class="qnav"><div class="qnav-ico">🩺</div>Médicos</a>
                    <a href="{{ route('citas.index') }}" class="qnav"><div class="qnav-ico">📅</div>Citas</a>
                    <a href="{{ route('diagnosticos.index') }}" class="qnav"><div class="qnav-ico">🔬</div>Diagnósticos</a>
                    <a href="{{ route('tratamientos.index') }}" class="qnav"><div class="qnav-ico">💊</div>Tratamientos</a>
                    <a href="{{ route('medicamentos.index') }}" class="qnav"><div class="qnav-ico">🧪</div>Medicamentos</a>
                </div>
            </div>
        </div>
        <div class="db-card observe">
            <div class="db-card-head">
                <div class="db-card-title"><span>✦</span> Estado del sistema</div>
                <span class="badge badge-green">En vivo</span>
            </div>
            <div class="db-card-body">
                <div class="status-list">
                    <div class="sr"><span class="sr-label">Plataforma</span><span class="badge badge-green">Operativa</span></div>
                    <div class="sr"><span class="sr-label">Google OAuth</span><span class="badge badge-green">Activo</span></div>
                    <div class="sr"><span class="sr-label">Base de datos</span><span class="badge badge-green">Conectada</span></div>
                    <div class="sr"><span class="sr-label">API REST</span><span class="badge badge-blue">Disponible</span></div>
                    <div class="sr"><span class="sr-label">Versión</span><span class="sr-val">Laravel 12</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const cur=document.getElementById('cur'),ring=document.getElementById('cur-r');
document.addEventListener('mousemove',e=>{cur.style.left=e.clientX+'px';cur.style.top=e.clientY+'px';setTimeout(()=>{ring.style.left=e.clientX+'px';ring.style.top=e.clientY+'px';},90);});
document.querySelectorAll('a,button,.stat-card,.qnav,.db-card').forEach(el=>{el.addEventListener('mouseenter',()=>{cur.classList.add('g');ring.classList.add('g');});el.addEventListener('mouseleave',()=>{cur.classList.remove('g');ring.classList.remove('g');});});
const io=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');io.unobserve(x.target);}}),{threshold:.1});
document.querySelectorAll('.observe').forEach(el=>io.observe(el));
</script>
</body>
</html>