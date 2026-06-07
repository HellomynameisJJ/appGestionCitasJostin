@extends('layouts.admin')

{{-- Configuración dinámica del encabezado según la acción --}}
@if(request()->routeIs('tratamientos.edit') || isset($tratamiento))
    @section('title', 'Editar Tratamiento')
    @section('hero_icon', '✏️')
    @section('hero_title', 'Modificar Tratamiento')
    @section('hero_subtitle', 'Actualizar las especificaciones del plan clínico')
@elseif(request()->routeIs('tratamientos.create'))
    @section('title', 'Nuevo Tratamiento')
    @section('hero_icon', '➕')
    @section('hero_title', 'Registrar Tratamiento')
    @section('hero_subtitle', 'Añadir un nuevo plan clínico al sistema')
@else
    @section('title', 'Tratamientos')
    @section('hero_icon', '📋')
    @section('hero_title', 'Planes de Tratamiento')
    @section('hero_subtitle', 'Gestión de indicaciones clínicas, recetas y asignaciones')
@endif

@section('content')

{{-- Alertas de éxito --}}
@if(session('success'))
    <div class="alert alert-success" style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
        ✅ {{ session('success') }}
    </div>
@endif

<style>
    .form-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 30px;
        max-width: 750px;
        margin: 20px auto;
        font-family: 'Segoe UI', sans-serif;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .form-group { margin-bottom: 5px; }
    .form-group.full-width { grid-column: span 2; }
    .form-group label {
        display: block;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #0f172a;
        box-sizing: border-box;
    }
    .form-control:focus { outline: none; border-color: #0f172a; }
    .form-actions { grid-column: span 2; display: flex; gap: 15px; margin-top: 15px; }
    .btn-submit { background-color: #0f172a; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; font-size: 0.95rem; flex: 1; }
    .btn-update { background-color: #0284c7; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; font-size: 0.95rem; flex: 1; }
    .btn-cancel { display: inline-block; text-align: center; background-color: #f1f5f9; color: #475569; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-size: 0.95rem; font-weight: 500; }
</style>

{{-- ========================================== --}}
{{-- MODO VISTA 1: FORMULARIO DE EDICIÓN       --}}
{{-- ========================================== --}}
@if(request()->routeIs('tratamientos.edit') || isset($tratamiento))
<div class="form-card observe">
    <form action="{{ route('tratamientos.update', $tratamiento->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre del Tratamiento</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $tratamiento->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado Clínico</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="Activo" {{ $tratamiento->estado == 'Activo' ? 'selected' : '' }}>Activo / En curso</option>
                    <option value="Inactivo" {{ $tratamiento->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="Completado" {{ $tratamiento->estado == 'Completado' ? 'selected' : '' }}>Completado</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label for="descripcion">Descripción de las Indicaciones</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-control" required>{{ $tratamiento->descripcion }}</textarea>
            </div>
            <div class="form-group">
                <label for="duracion">Duración Total</label>
                <input type="text" name="duracion" id="duracion" class="form-control" value="{{ $tratamiento->duracion }}" required>
            </div>
            <div class="form-group">
                <label for="frecuencia_administracion">Frecuencia de Administración</label>
                <input type="text" name="frecuencia_administracion" id="frecuencia_administracion" class="form-control" value="{{ $tratamiento->frecuencia_administracion }}" required>
            </div>
            <div class="form-group">
                <label for="diagnostico_id">Diagnóstico Asociado</label>
                <select name="diagnostico_id" id="diagnostico_id" class="form-control" required>
                    @foreach($diagnosticos as $d)
                        <option value="{{ $d->id }}" {{ $tratamiento->diagnostico_id == $d->id ? 'selected' : '' }}>{{ $d->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="medico_id">Médico Prescriptor</label>
                <select name="medico_id" id="medico_id" class="form-control" required>
                    @foreach($medicos as $m)
                        <option value="{{ $m->id }}" {{ $tratamiento->medico_id == $m->id ? 'selected' : '' }}>Dr(a). {{ $m->nombre }} {{ $m->apellido }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-update">🔄 Actualizar Cambios</button>
                <a href="{{ route('tratamientos.index') }}" class="btn-cancel">Cancelar</a>
            </div>
        </div>
    </form>
</div>

{{-- ========================================== --}}
{{-- MODO VISTA 2: FORMULARIO DE CREACIÓN       --}}
{{-- ========================================== --}}
@elseif(request()->routeIs('tratamientos.create'))
<div class="form-card observe">
    <form action="{{ route('tratamientos.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre del Tratamiento</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Terapia Antibiótica" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="estado">Estado Inicial</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="Activo">Activo / En curso</option>
                    <option value="Inactivo">Inactivo</option>
                    <option value="Completado">Completado</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label for="descripcion">Descripción de las Indicaciones</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-control" placeholder="Escriba los detalles..." required></textarea>
            </div>
            <div class="form-group">
                <label for="duracion">Duración Total</label>
                <input type="text" name="duracion" id="duracion" class="form-control" placeholder="Ej. 7 días" required>
            </div>
            <div class="form-group">
                <label for="frecuencia_administracion">Frecuencia</label>
                <input type="text" name="frecuencia_administracion" id="frecuencia_administracion" class="form-control" placeholder="Ej. Cada 8 horas" required>
            </div>
            <div class="form-group">
                <label for="diagnostico_id">Diagnóstico Asociado</label>
                <select name="diagnostico_id" id="diagnostico_id" class="form-control" required>
                    <option value="">-- Seleccione un Diagnóstico --</option>
                    @foreach($diagnosticos as $d)
                        <option value="{{ $d->id }}">{{ $d->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="medico_id">Médico Prescriptor</label>
                <select name="medico_id" id="medico_id" class="form-control" required>
                    <option value="">-- Seleccione al Médico --</option>
                    @foreach($medicos as $m)
                        <option value="{{ $m->id }}">Dr(a). {{ $m->nombre }} {{ $m->apellido }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">💾 Guardar Plan Clínico</button>
                <a href="{{ route('tratamientos.index') }}" class="btn-cancel">Regresar</a>
            </div>
        </div>
    </form>
</div>

{{-- ========================================== --}}
{{-- MODO VISTA 3: TABLA GENERAL (INDEX)        --}}
{{-- ========================================== --}}
@else
<div class="content-header observe">
    <div class="content-header-left">
        <h2>Listado de Tratamientos</h2>
    </div>
    <a href="{{ route('tratamientos.create') }}" class="btn btn-fill">➕ Nuevo Tratamiento</a>
</div>

<div class="table-card observe">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Duración y Frecuencia</th>
                <th>Médico Responsable</th>
                <th>Estado</th>
                <th style="text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tratamientos as $t)
            <tr>
                <td style="font-weight: 600; color: #64748b;">TRAT-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td><strong>{{ $t->nombre }}</strong></td>
                <td>{{ $t->descripcion }}</td>
                <td>
                    <span>⏳ {{ $t->duracion }}</span>
                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">⏱️ {{ $t->frecuencia_administracion }}</div>
                </td>
                <td>Dr(a). {{ $t->medico->nombre ?? 'No asignado' }} {{ $t->medico->apellido ?? '' }}</td>
                <td>
                    <span class="badge {{ $t->estado == 'Activo' ? 'badge-green' : 'badge-blue' }}">
                        {{ ucfirst($t->estado) }}
                    </span>
                </td>
                <td style="text-align: center;">
                    <a href="{{ route('tratamientos.edit', $t->id) }}" class="btn-icon" title="Editar">✏️</a>
                    <form action="{{ route('tratamientos.destroy', $t->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon" style="background: none; border: none; cursor: pointer; padding: 0;">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px; font-style: italic;">
                    No hay planes de tratamiento registrados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif

@endsection