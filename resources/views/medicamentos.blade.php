@extends('layouts.admin')

{{-- Configuración dinámica del encabezado según la acción --}}
@if(request()->routeIs('medicamentos.edit') || isset($medicamento))
    @section('title', 'Editar Medicamento')
    @section('hero_icon', '✏️')
    @section('hero_title', 'Modificar Medicamento')
    @section('hero_subtitle', 'Actualizar especificaciones y dosificación del fármaco')
@elseif(request()->routeIs('medicamentos.create'))
    @section('title', 'Nuevo Medicamento')
    @section('hero_icon', '🧪')
    @section('hero_title', 'Registrar Medicamento')
    @section('hero_subtitle', 'Añadir un nuevo fármaco al inventario médico')
@else
    @section('title', 'Medicamentos')
    @section('hero_icon', '🧪')
    @section('hero_title', 'Control de Medicamentos')
    @section('hero_subtitle', 'Inventario, dosificación y tratamientos vinculados')
@endif

@section('content')

{{-- Alertas de éxito del sistema --}}
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
    .form-control:focus { outline: none; border-color: #0284c7; }
    .form-actions { grid-column: span 2; display: flex; gap: 15px; margin-top: 15px; }
    .btn-submit { background-color: #0284c7; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; font-size: 0.95rem; flex: 1; }
    .btn-update { background-color: #0f172a; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; font-size: 0.95rem; flex: 1; }
    .btn-cancel { display: inline-block; text-align: center; background-color: #f1f5f9; color: #475569; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-size: 0.95rem; font-weight: 500; }
    
    /* Estilos de la tabla formal */
    .badge-tratamiento { background-color: #f1f5f9; color: #334155; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; display: inline-block; }
    .badge-dosis { background-color: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; }
</style>

{{-- =================================================== --}}
{{-- MODO VISTA 1: FORMULARIO DE EDICIÓN                 --}}
{{-- =================================================== --}}
@if(request()->routeIs('medicamentos.edit') || isset($medicamento))
<div class="form-card observe">
    <form action="{{ route('medicamentos.update', $medicamento->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre Comercial / Genérico</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $medicamento->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Laboratorio / Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" class="form-control" value="{{ $medicamento->proveedor }}" required>
            </div>
            <div class="form-group">
                <label for="dosis">Dosis Asignada</label>
                <input type="text" name="dosis" id="dosis" class="form-control" value="{{ $medicamento->dosis }}" placeholder="Ej. 500mg" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Frecuencia de Administración</label>
                <input type="text" name="frecuencia" id="frecuencia" class="form-control" value="{{ $medicamento->frecuencia }}" placeholder="Ej. Cada 8 horas" required>
            </div>
            <div class="form-group">
                <label for="duracion">Duración del Tratamiento</label>
                <input type="text" name="duracion" id="duracion" class="form-control" value="{{ $medicamento->duracion }}" placeholder="Ej. 7 días" required>
            </div>
            <div class="form-group">
                <label for="tratamiento_id">Plan de Tratamiento Vinculado</label>
                <select name="tratamiento_id" id="tratamiento_id" class="form-control" required>
                    @foreach($tratamientos as $t)
                        <option value="{{ $t->id }}" {{ $medicamento->tratamiento_id == $t->id ? 'selected' : '' }}>
                            TRAT-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }} - {{ $t->nombre ?? $t->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group full-width">
                <label for="efectos_secundarios">Efectos Secundarios / Advertencias</label>
                <textarea name="efectos_secundarios" id="efectos_secundarios" rows="3" class="form-control" required>{{ $medicamento->efectos_secundarios }}</textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-update">🔄 Actualizar Medicamento</button>
                <a href="{{ route('medicamentos.index') }}" class="btn-cancel">Cancelar</a>
            </div>
        </div>
    </form>
</div>

{{-- =================================================== --}}
{{-- MODO VISTA 2: FORMULARIO DE CREACIÓN                --}}
{{-- =================================================== --}}
@elseif(request()->routeIs('medicamentos.create'))
<div class="form-card observe">
    <form action="{{ route('medicamentos.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre Comercial / Genérico</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Paracetamol / Amoxicilina" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="proveedor">Laboratorio / Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" class="form-control" placeholder="Ej. Pfizer, Bayer, Genfar" required>
            </div>
            <div class="form-group">
                <label for="dosis">Dosis Asignada</label>
                <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Ej. 500 mg / 1 Tableta" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Frecuencia</label>
                <input type="text" name="frecuencia" id="frecuencia" class="form-control" placeholder="Ej. Cada 12 horas" required>
            </div>
            <div class="form-group">
                <label for="duracion">Duración</label>
                <input type="text" name="duracion" id="duracion" class="form-control" placeholder="Ej. 5 días o Continuo" required>
            </div>
            <div class="form-group">
                <label for="tratamiento_id">Vincular a Plan Clínico</label>
                <select name="tratamiento_id" id="tratamiento_id" class="form-control" required>
                    <option value="">-- Seleccione un Plan Clínico --</option>
                    @foreach($tratamientos as $t)
                        <option value="{{ $t->id }}">
                            TRAT-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }} - {{ $t->nombre ?? $t->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group full-width">
                <label for="efectos_secundarios">Efectos Secundarios / Contraindicaciones</label>
                <textarea name="efectos_secundarios" id="efectos_secundarios" rows="3" class="form-control" placeholder="Ej. Puede causar somnolencia, náuseas o requiere administrarse con alimentos..." required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">💾 Registrar Fármaco</button>
                <a href="{{ route('medicamentos.index') }}" class="btn-cancel">Regresar</a>
            </div>
        </div>
    </form>
</div>

{{-- =================================================== --}}
{{-- MODO VISTA 3: TABLA GENERAL (INDEX)                 --}}
{{-- =================================================== --}}
@else
<div class="content-header observe">
    <div class="content-header-left">
        <h2>Inventario de Medicamentos</h2>
    </div>
    <a href="{{ route('medicamentos.create') }}" class="btn btn-fill">➕ Nuevo Medicamento</a>
</div>

<div class="table-card observe">
    <table class="data-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Medicamento</th>
                <th>Plan Clínico Asignado</th>
                <th>Dosificación e Intervalo</th>
                <th>Duración</th>
                <th>Efectos / Notas</th>
                <th style="text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicamentos as $m)
            <tr>
                <td style="font-weight: 600; color: #64748b;">MED-{{ str_pad($m->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <strong>{{ $m->nombre }}</strong>
                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">🧪 Lab: {{ $m->proveedor }}</div>
                </td>
                <td>
                    <span class="badge-tratamiento">
                        📋 {{ $m->tratamiento->nombre ?? $m->tratamiento->descripcion ?? 'Tratamiento General' }}
                    </span>
                </td>
                <td>
                    <span class="badge-dosis">💊 {{ $m->dosis }}</span>
                    <div style="font-size: 0.8rem; color: #475569; margin-top: 4px;">⏱️ {{ $m->frecuencia }}</div>
                </td>
                <td style="font-weight: 500; color: #475569;">⏳ {{ $m->duracion }}</td>
                <td style="max-width: 220px; color: #64748b; font-size: 0.85rem; line-height: 1.3;">
                    {{ $m->efectos_secundarios ?: 'Ninguno reportado' }}
                </td>
                <td style="text-align: center;">
                    <a href="{{ route('medicamentos.edit', $m->id) }}" class="btn-icon" title="Editar">✏️</a>
                    <form action="{{ route('medicamentos.destroy', $m->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este medicamento?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon" style="background: none; border: none; cursor: pointer; padding: 0;">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px; font-style: italic;">
                    No se encuentran medicamentos registrados en el sistema.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif

@endsection