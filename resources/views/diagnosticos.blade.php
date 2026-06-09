@extends('layouts.admin')

@section('title', 'Diagnósticos - CliniSync')
@section('hero_img', 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=1400&auto=format&fit=crop&q=80')
@section('hero_icon', '🔬')
@section('hero_title') Registro de <em>Diagnósticos | CliniSync</em> @endsection
@section('hero_subtitle', 'Gestión de diagnósticos clínicos, niveles de gravedad y protocolos de recomendación médica.')

@section('content')
<style>
/* Estilos mantenidos... */
.modal-bg { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); backdrop-filter:blur(6px); z-index:3000; justify-content:center; align-items:center; }
.modal-bg.open { display:flex; }
.modal-box { background:#fff; border-radius:20px; border:1px solid var(--border); width:95%; max-width:680px; max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(45,122,79,.15); animation:slideUp .28s ease both; }
@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.modal-head { padding:1.3rem 1.8rem; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--sf2); border-radius:20px 20px 0 0; position:sticky; top:0; z-index:1; }
.modal-head-title { font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; letter-spacing:-.02em; display:flex; align-items:center; gap:.6rem; }
.modal-head-title em { color:var(--green); font-style:italic; }
.modal-close { width:32px; height:32px; border-radius:8px; border:1px solid var(--border); background:transparent; display:flex; align-items:center; justify-content:center; font-size:.95rem; cursor:pointer; color:var(--muted); transition:all .2s; }
.modal-close:hover { background:var(--red-lt); color:var(--red); border-color:rgba(192,57,43,.2); }
.modal-body { padding:1.8rem; }
.modal-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.modal-footer { padding:1.1rem 1.8rem; border-top:1px solid var(--border); display:flex; gap:.75rem; justify-content:flex-end; background:var(--sf2); border-radius:0 0 20px 20px; position:sticky; bottom:0; }
.field-section { font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin:.6rem 0 .8rem; padding-bottom:.4rem; border-bottom:1px solid var(--border); grid-column:1/-1; }
.field-full { grid-column:1/-1; }
.edit-btn { display:inline-flex; align-items:center; gap:.35rem; padding:.32rem .75rem; border-radius:6px; font-size:.76rem; font-weight:500; color:var(--blue); border:1px solid rgba(36,113,163,.3); background:transparent; text-decoration:none; transition:all .2s; }
.edit-btn:hover { background:var(--blue-lt); border-color:var(--blue); }
</style>

{{-- ── TOOLBAR ── --}}
<div class="prem-toolbar observe">
    <div>
        <div class="toolbar-count">Total CliniSync</div>
        <div class="toolbar-num">{{ count($diagnosticos) }} <span>registros</span></div>
    </div>
    <div class="prem-toolbar-right">
        <div class="search-wrap">
            <input type="text" class="field-input search-input" placeholder="Buscar en CliniSync...">
        </div>
        <button onclick="openCreate()" class="btn btn-fill">+ Nuevo Diagnóstico</button>
    </div>
</div>

{{-- ── TABLA COMPLETA ── --}}
<div class="table-card observe">
    <div class="table-card-head">
        <span class="tbl-label">Historial Clínico CliniSync</span>
        <span class="badge badge-muted">{{ count($diagnosticos) }} registros</span>
    </div>
    <div style="overflow-x:auto">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID Registro</th>
                <th>Paciente</th>
                <th>Especialista</th>
                <th>Tipo</th>
                <th>Gravedad</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Recomendaciones</th>
                <th>Gestión</th>
            </tr>
        </thead>
        <tbody>
            @forelse($diagnosticos as $d)
            <tr>
                <td style="color:var(--muted);font-size:.76rem">DX-{{ str_pad($d->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ substr($d->paciente->nombre ?? 'P', 0, 1) }}</div>
                        <div class="user-name">{{ $d->paciente->nombre ?? 'N/A' }} {{ $d->paciente->apellido ?? '' }}</div>
                    </div>
                </td>
                <td style="font-weight:500;font-size:.84rem">Dr(a). {{ $d->medico->nombre ?? 'N/A' }}</td>
                <td><span class="badge badge-blue">{{ $d->tipo_diagnostico ?? '—' }}</span></td>
                <td>
                    @php
                        $grav = $d->gravedad ?? '—';
                        $gcls = match(strtolower($grav)) { 'alta' => 'badge-red', 'media' => 'badge-amber', 'baja' => 'badge-green', default => 'badge-muted' };
                    @endphp
                    <span class="badge {{ $gcls }}">{{ $grav }}</span>
                </td>
                <td style="color:var(--muted);font-size:.81rem;white-space:nowrap">{{ \Carbon\Carbon::parse($d->fecha)->format('d M Y') }}</td>
                <td style="color:var(--muted);font-size:.81rem;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $d->descripcion ?? '—' }}</td>
                <td style="color:var(--muted);font-size:.81rem;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $d->recomendaciones ?? '—' }}</td>
                <td>
                    <a href="{{ route('diagnosticos.index', ['edit_id' => $d->id]) }}" class="edit-btn">✏️ Editar</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:3rem;color:var(--muted)">
                    <div style="font-size:2rem;margin-bottom:.8rem">🔬</div>
                    No existen registros clínicos en CliniSync actualmente.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

{{-- ════ MODAL EDITAR ════ --}}
@if(isset($diagnostico))
<div class="modal-bg open" id="modal-edit">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-head-title">✏️ Actualizar <em>Diagnóstico CliniSync</em></div>
            <a href="{{ route('diagnosticos.index') }}" class="modal-close" title="Cerrar">✕</a>
        </div>
        <form method="POST" action="{{ route('diagnosticos.update', $diagnostico->id) }}">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="modal-grid">
                    <div class="field-section">Parámetros del Diagnóstico</div>
                    <div class="field">
                        <label class="field-label">Paciente Asignado *</label>
                        <select name="paciente_id" class="field-input" required>
                            @foreach($pacientes as $p)
                                <option value="{{ $p->id }}" {{ $diagnostico->paciente_id == $p->id ? 'selected' : '' }}>{{ $p->nombre }} {{ $p->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label">Médico Responsable *</label>
                        <select name="medico_id" class="field-input" required>
                            @foreach($medicos as $m)
                                <option value="{{ $m->id }}" {{ $diagnostico->medico_id == $m->id ? 'selected' : '' }}>Dr(a). {{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label">Fecha de Evaluación *</label>
                        <input type="date" name="fecha" class="field-input" required value="{{ date('Y-m-d', strtotime($diagnostico->fecha)) }}">
                    </div>
                    <div class="field">
                        <label class="field-label">Tipo de Diagnóstico *</label>
                        <input type="text" name="tipo_diagnostico" class="field-input" value="{{ $diagnostico->tipo_diagnostico }}" required>
                    </div>
                    <div class="field">
                        <label class="field-label">Nivel de Gravedad *</label>
                        <select name="gravedad" class="field-input" required>
                            <option value="Baja" {{ $diagnostico->gravedad == 'Baja' ? 'selected' : '' }}>Baja</option>
                            <option value="Media" {{ $diagnostico->gravedad == 'Media' ? 'selected' : '' }}>Media</option>
                            <option value="Alta" {{ $diagnostico->gravedad == 'Alta' ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>
                    <div class="field field-full">
                        <label class="field-label">Descripción Clínica *</label>
                        <textarea name="descripcion" class="field-input" rows="3" required>{{ $diagnostico->descripcion }}</textarea>
                    </div>
                    <div class="field field-full">
                        <label class="field-label">Recomendaciones Médicas</label>
                        <textarea name="recomendaciones" class="field-input" rows="3">{{ $diagnostico->recomendaciones }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('diagnosticos.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-fill">✓ Guardar cambios en CliniSync</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ════ MODAL CREAR ════ --}}
<div class="modal-bg" id="modal-create">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-head-title">🔬 Nuevo <em>Registro CliniSync</em></div>
            <button class="modal-close" onclick="closeCreate()">✕</button>
        </div>
        <form method="POST" action="{{ route('diagnosticos.store') }}">
            @csrf
            <div class="modal-body">
                <div class="modal-grid">
                    <div class="field-section">Datos del Diagnóstico</div>
                    <div class="field">
                        <label class="field-label">Paciente *</label>
                        <select name="paciente_id" class="field-input" required>
                            <option value="">— Seleccionar paciente —</option>
                            @foreach($pacientes as $p) <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellido }}</option> @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label">Médico *</label>
                        <select name="medico_id" class="field-input" required>
                            <option value="">— Seleccionar médico —</option>
                            @foreach($medicos as $m) <option value="{{ $m->id }}">Dr(a). {{ $m->nombre }}</option> @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label">Fecha *</label>
                        <input type="date" name="fecha" class="field-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="field">
                        <label class="field-label">Tipo *</label>
                        <input type="text" name="tipo_diagnostico" class="field-input" placeholder="Ej: Etiológico" required>
                    </div>
                    <div class="field">
                        <label class="field-label">Gravedad *</label>
                        <select name="gravedad" class="field-input" required>
                            <option value="Baja">Baja</option><option value="Media">Media</option><option value="Alta">Alta</option>
                        </select>
                    </div>
                    <div class="field field-full">
                        <label class="field-label">Descripción *</label>
                        <textarea name="descripcion" class="field-input" rows="3" required></textarea>
                    </div>
                    <div class="field field-full">
                        <label class="field-label">Recomendaciones</label>
                        <textarea name="recomendaciones" class="field-input" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeCreate()" class="btn btn-ghost">Cancelar</button>
                <button type="submit" class="btn btn-fill">✓ Registrar en CliniSync</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openCreate() { document.getElementById('modal-create').classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeCreate() { document.getElementById('modal-create').classList.remove('open'); document.body.style.overflow = ''; }
document.getElementById('modal-create').addEventListener('click', function(e) { if (e.target === this) closeCreate(); });
document.querySelector('.search-input')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.data-table tbody tr').forEach(row => { row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none'; });
});
</script>
@endpush
@endsection