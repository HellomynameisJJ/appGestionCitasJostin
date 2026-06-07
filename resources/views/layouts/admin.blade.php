<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') · SANAR+</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
    *{cursor:none!important}
    #cur{width:9px;height:9px;background:var(--green);border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:width .15s,height .15s}
    #cur-r{width:32px;height:32px;border:1px solid rgba(45,122,79,.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);transition:left .1s,top .1s}
    #cur.g{width:14px;height:14px}#cur-r.g{width:50px;height:50px}
    @media(max-width:640px){#cur,#cur-r{display:none}*{cursor:auto!important}}
    </style>
</head>
<body>
<div id="cur"></div><div id="cur-r"></div>
<div class="grid-bg" style="opacity:.25"></div>

<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="{{ url('/home') }}" class="sb-brand">
            <div class="sb-logo">S+</div>
            <div><div class="sb-name">SANAR<span>+</span></div><div class="sb-sub">Panel de control</div></div>
        </a>
        <div style="padding:.5rem .4rem;flex:1">
            <div class="sb-section">Principal</div>
            <a href="{{ url('/home') }}" class="sb-link {{ request()->is('home') ? 'active' : '' }}">
                <div class="sb-ico">🏠</div> Dashboard
            </a>
            <div class="sb-section" style="margin-top:.6rem">Gestión</div>
            <a href="{{ route('pacientes.index') }}" class="sb-link {{ request()->is('pacientes*') ? 'active' : '' }}"><div class="sb-ico">👤</div> Pacientes</a>
            <a href="{{ route('medicos.index') }}" class="sb-link {{ request()->is('medicos*') ? 'active' : '' }}"><div class="sb-ico">🩺</div> Médicos</a>
            <a href="{{ route('citas.index') }}" class="sb-link {{ request()->is('citas*') ? 'active' : '' }}"><div class="sb-ico">📅</div> Citas</a>
            <a href="{{ route('diagnosticos.index') }}" class="sb-link {{ request()->is('diagnosticos*') ? 'active' : '' }}"><div class="sb-ico">🔬</div> Diagnósticos</a>
            <a href="{{ route('tratamientos.index') }}" class="sb-link {{ request()->is('tratamientos*') ? 'active' : '' }}"><div class="sb-ico">💊</div> Tratamientos</a>
            <a href="{{ route('medicamentos.index') }}" class="sb-link {{ request()->is('medicamentos*') ? 'active' : '' }}"><div class="sb-ico">🧪</div> Medicamentos</a>
            
        </div>
        <div class="sb-footer">
            <div class="sb-user">
                <div class="sb-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div><div class="sb-uname">{{ explode(' ', Auth::user()->name)[0] }}</div><div class="sb-uemail">{{ Auth::user()->email }}</div></div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:.5rem">@csrf
                <button type="submit" class="btn btn-ghost btn-full" style="font-size:.78rem;height:36px">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-content">
        <!-- TOPNAV -->
        <div class="top-nav">
            <div class="top-nav-title">@yield('title')</div>
            <div class="top-nav-right">
                <span class="top-nav-user">Sesión: <strong>{{ Auth::user()->name }}</strong></span>
                <span class="badge badge-green">Sistema activo</span>
            </div>
        </div>

        <!-- PAGE HERO -->
        <div class="page-hero">
            <img src="@yield('hero_img','https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1400&auto=format&fit=crop&q=80')" alt="">
            <div class="page-hero-overlay"></div>
            <div class="page-hero-content">
                <div class="page-hero-icon">@yield('hero_icon','✦')</div>
                <div class="page-hero-text">
                    <h1>@yield('hero_title')</h1>
                    <p>@yield('hero_subtitle')</p>
                </div>
            </div>
        </div>

        <!-- ALERTS -->
        <div style="padding:1rem 2rem 0">
            @if(session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">⚠ {{ $errors->first() }}</div>
            @endif
        </div>

        <!-- CONTENT -->
        <div class="content-area">@yield('content')</div>
    </div>
</div>

<script>
const cur=document.getElementById('cur'),ring=document.getElementById('cur-r');
document.addEventListener('mousemove',e=>{cur.style.left=e.clientX+'px';cur.style.top=e.clientY+'px';setTimeout(()=>{ring.style.left=e.clientX+'px';ring.style.top=e.clientY+'px';},90);});
document.querySelectorAll('a,button,.data-table tr,.stat-card').forEach(el=>{el.addEventListener('mouseenter',()=>{cur.classList.add('g');ring.classList.add('g');});el.addEventListener('mouseleave',()=>{cur.classList.remove('g');ring.classList.remove('g');});});
const io=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');io.unobserve(x.target);}}),{threshold:.08});
document.querySelectorAll('.observe').forEach(el=>io.observe(el));

// Search
document.querySelectorAll('.search-input').forEach(input=>{
    input.addEventListener('input',function(){
        const q=this.value.toLowerCase();
        document.querySelectorAll('.data-table tbody tr').forEach(row=>{row.style.display=row.textContent.toLowerCase().includes(q)?'':'none';});
    });
});

// Modal
function openModal(id,resource){
    document.getElementById('deleteForm').action='/'+resource+'/'+id;
    document.getElementById('deleteModal').style.display='flex';
}
function closeModal(){document.getElementById('deleteModal').style.display='none';}
document.getElementById('deleteModal')?.addEventListener('click',function(e){if(e.target===this)closeModal();});
</script>
@stack('scripts')
</body>
</html>