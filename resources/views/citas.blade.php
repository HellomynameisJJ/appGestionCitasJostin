@extends('layouts.admin')

@section('title', 'Citas')
@section('hero_img', 'https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=1400&auto=format&fit=crop&q=80')
@section('hero_icon', '📅')
@section('hero_title') Gestión de <em>Citas</em> @endsection
@section('hero_subtitle', 'Calendario y atención médica de pacientes registrados.')

@section('content')
<style>
/* ── MODAL ── */
.modal-bg {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.45); backdrop-filter:blur(6px);
    z-index:3000; justify-content:center; align-items:center;
}
.modal-bg.open { display:flex; }
.modal-box {
    background:#fff; border-radius:20px;
    border:1px solid var(--border);
    width:95%; max-width:620px;
    max-height:90vh; overflow-y:auto;
    box-shadow:0 24px 80px rgba(45,122,79,.15);
    animation:slideUp .28s ease both;
}
@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.modal-head {
    padding:1.4rem 1.8rem;
    border-bottom:1px solid var(--border);
    display:flex; align-items:center; justify-content:space-between;
    background:var(--sf2);
    border-radius:20px 20px 0 0;
}
.modal-head-title {
    font-family:'Fraunces',serif; font-size:1.15rem;
    font-weight:700; letter-spacing:-.02em;
    display:flex; align-items:center; gap:.6rem;
}
.modal-head-title em { color:var(--green); font-style:italic; }
.modal-close {
    width:32px; height:32px; border-radius:8px;
    border:1px solid var(--border); background:transparent;
    display:flex; align-items:center; justify-content:center;
    font-size:1rem; cursor:pointer; color:var(--muted);
    transition:all .2s;
}
.modal-close:hover { background:var(--red-lt); color:var(--red); border-color:rgba(192,57,43,.2); }
.modal-body { padding:1.8rem; }
.modal-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.modal-footer {
    padding:1.2rem 1.8rem;
    border-top:1px solid var(--border);
    display:flex; gap:.75rem; justify-content:flex-end;
    background:var(--sf2); border-radius:0 0 20px 20px;
}
.field-section {
    font-size:.68rem; font-weight:700; letter-spacing:.1em;
    text-transform:uppercase; color:var(--muted);
    margin:1.2rem 0 .8rem; padding-bottom:.4rem;
    border-bottom:1px solid var(--border);
    grid-column:1/-1;
}

/* ── TABLE OVERRIDES ── */
.citas-table th { white-space:nowrap; }
.citas-table td { vertical-align:middle; }
.edit-btn {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.32rem .75rem; border-radius:6px; font-size:.76rem;
    font-weight:500; cursor:pointer;
    color:var(--blue); border:1px solid rgba(36,113,163,.3);
    background:transparent; transition:all .2s; text-decoration:none;
}
.edit-btn:hover { background:var(--blue-lt); border-color:var(--blue); }
</style>

{{-- ── TOOLBAR ── --}}
<div class="prem-toolbar observe">
    <div>
        <div class="toolbar-count">Total citas</div>
        <div class="toolbar-num">{{ count($citas) }} <span>registros</span></div>
    </div>
    <div class="prem-toolbar-right">
        <div class="search-wrap">
            <input type="text" class="field-input search-input" placeholder="Buscar cita...">
        </div>
        <button onclick="openCreate()" class="btn btn-fill">+ Registrar Cita</button>
    </div>
</div>

{{-- ── TABLA ── --}}
<div class="table-card observe">
    <div class="table-card-head">
        <span class="tbl-label">Agenda de citas médicas</span>
        <span class="badge badge-muted">{{ count($citas) }} registros</span>
    </div>
    <table class="data-table citas-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico Especialista</th>
                <th>Fecha y Hora</th>
                <th>Motivo</th>
                <th>Sala</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citas as $c)
            <tr>
                <td style="color:var(--muted);font-size:.76rem">{{ $c->id }}</td>
                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ substr($c->paciente->nombre ?? 'P', 0, 1) }}</div>
                        <div>
                            <div class="user-name">{{ $c->paciente->nombre ?? 'N/A' }} {{ $c->paciente->apellido ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-weight:500">
                    Dr(a). {{ $c->medico->nombre ?? 'N/A' }} {{ $c->medico->apellido ?? '' }}
                </td>
                <td style="color:var(--muted);font-size:.82rem">
                    {{ \Carbon\Carbon::parse($c->fecha)->format('d M Y · h:i A') }}
                </td>
                <td style="color:var(--muted);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    {{ $c->motivo }}
                </td>
                <td>
                    <span class="badge badge-blue">{{ $c->sala ?? 'Sin sala' }}</span>
                </td>
                <td>
                    @php
                        $est = $c->estado ?? 'Pendiente';
                        $cls = match(strtolower($est)) {
                            'completada','completado' => 'badge-green',
                            'cancelada','cancelado'   => 'badge-red',
                            default                   => 'badge-amber',
                        };
                    @endphp
                    <span class="badge {{ $cls }}">{{ $est }}</span>
                </td>
                <td>
                    <button class="edit-btn" onclick='openEdit(@json($c))'>✏️ Editar</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted)">
                    <div style="font-size:2rem;margin-bottom:.8rem">📅</div>
                    No hay citas registradas en el sistema.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ══════════════════════════════════
     MODAL — REGISTRAR NUEVA CITA
══════════════════════════════════ --}}
<div class="modal-bg" id="modal-create">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-head-title">📅 Registrar <em>Nueva Cita</em></div>
            <button class="modal-close" onclick="closeCreate()">✕</button>
        </div>
        <form method="POST" action="{{ route('citas.store') }}">
            @csrf
            <div class="modal-body">
                <div class="modal-grid">

                    <div class="field-section">Datos de la cita</div>

                    <div class="field">
                        <label class="field-label">Paciente *</label>
                        <select name="paciente_id" class="field-input" required>
                            <option value="">— Seleccionar paciente —</option>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellido }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label class="field-label">Médico *</label>
                        <select name="medico_id" class="field-input" required>
                            <option value="">— Seleccionar médico —</option>
                            @foreach($medicos as $m)
                                <option value="{{ $m->id }}">Dr(a). {{ $m->nombre }} {{ $m->apellido }} — {{ $m->especialidad }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label class="field-label">Fecha y Hora *</label>
                        <input type="datetime-local" name="fecha" class="field-input" required>
                    </div>

                    <div class="field">
                        <label class="field-label">Sala</label>
                        <input type="text" name="sala" class="field-input" placeholder="Ej: Consultorio 3">
                    </div>

                    <div class="field" style="grid-column:1/-1">
                        <label class="field-label">Motivo de consulta *</label>
                        <input type="text" name="motivo" class="field-input" placeholder="Describa el motivo de la cita" required>
                    </div>

                    <div class="field">
                        <label class="field-label">Estado</label>
                        <select name="estado" class="field-input">
                            <option value="Pendiente" selected>Pendiente</option>
                            <option value="Completada">Completada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="field" style="grid-column:1/-1">
                        <label class="field-label">Observaciones</label>
                        <textarea name="observaciones" class="field-input" placeholder="Observaciones adicionales (opcional)" rows="3"></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeCreate()" class="btn btn-ghost">Cancelar</button>
                <button type="submit" class="btn btn-fill">✓ Guardar Cita</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════
     MODAL — EDITAR CITA
══════════════════════════════════ --}}
<div class="modal-bg" id="modal-edit">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-head-title">✏️ Editar <em>Cita</em></div>
            <button class="modal-close" onclick="closeEdit()">✕</button>
        </div>
        <form method="POST" id="edit-form" action="">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="modal-grid">

                    <div class="field-section">Datos de la cita</div>

                    <div class="field">
                        <label class="field-label">Paciente *</label>
                        <select name="paciente_id" id="edit-paciente" class="field-input" required>
                            <option value="">— Seleccionar paciente —</option>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellido }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label class="field-label">Médico *</label>
                        <select name="medico_id" id="edit-medico" class="field-input" required>
                            <option value="">— Seleccionar médico —</option>
                            @foreach($medicos as $m)
                                <option value="{{ $m->id }}">Dr(a). {{ $m->nombre }} {{ $m->apellido }} — {{ $m->especialidad }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label class="field-label">Fecha y Hora *</label>
                        <input type="datetime-local" name="fecha" id="edit-fecha" class="field-input" required>
                    </div>

                    <div class="field">
                        <label class="field-label">Sala</label>
                        <input type="text" name="sala" id="edit-sala" class="field-input" placeholder="Ej: Consultorio 3">
                    </div>

                    <div class="field" style="grid-column:1/-1">
                        <label class="field-label">Motivo de consulta *</label>
                        <input type="text" name="motivo" id="edit-motivo" class="field-input" required>
                    </div>

                    <div class="field">
                        <label class="field-label">Estado</label>
                        <select name="estado" id="edit-estado" class="field-input">
                            <option value="Pendiente">Pendiente</option>
                            <option value="Completada">Completada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="field" style="grid-column:1/-1">
                        <label class="field-label">Observaciones</label>
                        <textarea name="observaciones" id="edit-observaciones" class="field-input" rows="3"></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeEdit()" class="btn btn-ghost">Cancelar</button>
                <button type="submit" class="btn btn-fill">✓ Actualizar Cita</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// ── MODAL CREAR ──
function openCreate() {
    document.getElementById('modal-create').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeCreate() {
    document.getElementById('modal-create').classList.remove('open');
    document.body.style.overflow = '';
}

// ── MODAL EDITAR ──
function openEdit(cita) {
    // Rellenar el formulario con los datos de la cita
    document.getElementById('edit-form').action = '/citas/' + cita.id;
    document.getElementById('edit-paciente').value   = cita.paciente_id;
    document.getElementById('edit-medico').value     = cita.medico_id;
    document.getElementById('edit-motivo').value     = cita.motivo;
    document.getElementById('edit-sala').value       = cita.sala ?? '';
    document.getElementById('edit-estado').value     = cita.estado ?? 'Pendiente';
    document.getElementById('edit-observaciones').value = cita.observaciones ?? '';

    // Formatear fecha para datetime-local (YYYY-MM-DDTHH:mm)
    if (cita.fecha) {
        const fecha = new Date(cita.fecha);
        const pad = n => String(n).padStart(2, '0');
        const local = fecha.getFullYear() + '-' + pad(fecha.getMonth()+1) + '-' + pad(fecha.getDate())
                    + 'T' + pad(fecha.getHours()) + ':' + pad(fecha.getMinutes());
        document.getElementById('edit-fecha').value = local;
    }

    document.getElementById('modal-edit').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEdit() {
    document.getElementById('modal-edit').classList.remove('open');
    document.body.style.overflow = '';
}

// Cerrar al hacer click fuera
document.getElementById('modal-create').addEventListener('click', function(e) {
    if (e.target === this) closeCreate();
});
document.getElementById('modal-edit').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
});

// Search
document.querySelector('.search-input')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.data-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush

@endsection