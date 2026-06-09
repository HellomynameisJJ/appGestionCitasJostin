@extends('layouts.admin')

{{-- Configuración dinámica del encabezado según la acción --}}
@if(request()->routeIs('medicamentos.edit') || isset($medicamento))
    @section('title', 'Actualizar Fármaco')
    @section('hero_icon', '⚙️')
    @section('hero_title', 'Ajustes del Medicamento')
    @section('hero_subtitle', 'Modificar las pautas, el laboratorio y las advertencias de la sustancia')
@elseif(request()->routeIs('medicamentos.create'))
    @section('title', 'Añadir Sustancia')
    @section('hero_icon', '📦')
    @section('hero_title', 'Alta de Medicamento')
    @section('hero_subtitle', 'Incorporar un nuevo recurso farmacológico al catálogo institucional')
@else
    @section('title', 'Catálogo de Fármacos')
    @section('hero_icon', '🛡️')
    @section('hero_title', 'Repositorio de Medicación')
    @section('hero_subtitle', 'Control global de existencias, regímenes de dosificación y terapias asociadas')
@endif

@section('content')

{{-- Alertas de éxito del sistema --}}
@if(session('success'))
    <div class="alert alert-success" style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
        ✨ {{ session('success') }}
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
                <label for="nombre">Denominación del Fármaco</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $medicamento->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Firma Farmacéutica / Fabricante</label>
                <input type="text" name="proveedor" id="proveedor" class="form-control" value="{{ $medicamento->proveedor }}" required>
            </div>
            <div class="form-group">
                <label for="dosis">Concentración / Gramaje</label>
                <input type="text" name="dosis" id="dosis" class="form-control" value="{{ $medicamento->dosis }}" placeholder="Ej. 850 mg / 5 ml" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Pauta de Administración</label>
                <input type="text" name="frecuencia" id="frecuencia" class="form-control" value="{{ $medicamento->frecuencia }}" placeholder="Ej. Cada 6 horas (con alimentos)" required>
            </div>
            <div class="form-group">
                <label for="duracion">Periodo del Régimen</label>
                <input type="text" name="duracion" id="duracion" class="form-control" value="{{ $medicamento->duracion }}" placeholder="Ej. 10 días o según evolución" required>
            </div>
            <div class="form-group">
                <label for="tratamiento_id">Vincular a Estrategia Terapéutica</label>
                <select name="tratamiento_id" id="tratamiento_id" class="form-control" required>
                    @foreach($tratamientos as $t)
                        <option value="{{ $t->id }}" {{ $medicamento->tratamiento_id == $t->id ? 'selected' : '' }}>
                            TERAPIA-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }} - {{ $t->nombre ?? $t->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group full-width">
                <label for="efectos_secundarios">Restricciones Clínicas y Efectos Adversos</label>
                <textarea name="efectos_secundarios" id="efectos_secundarios" rows="3" class="form-control" required>{{ $medicamento->efectos_secundarios }}</textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-update">💾 Guardar Cambios</button>
                <a href="{{ route('medicamentos.index') }}" class="btn-cancel">Descartar</a>
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
                <label for="nombre">Denominación del Fármaco</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Ibuprofeno / Omeprazol" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="proveedor">Firma Farmacéutica / Fabricante</label>
                <input type="text" name="proveedor" id="proveedor" class="form-control" placeholder="Ej. Sanofi, Novartis, Tecnoquímicas" required>
            </div>
            <div class="form-group">
                <label for="dosis">Concentración / Gramaje</label>
                <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Ej. 20 mg o 1 Ampolla" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Pauta de Administración</label>
                <input type="text" name="frecuencia" id="frecuencia" class="form-control" placeholder="Ej. Cada 24 horas en ayunas" required>
            </div>
            <div class="form-group">
                <label for="duracion">Periodo del Régimen</label>
                <input type="text" name="duracion" id="duracion" class="form-control" placeholder="Ej. 14 días completos" required>
            </div>
            <div class="form-group">
                <label for="tratamiento_id">Vincular a Estrategia Terapéutica</label>
                <select name="tratamiento_id" id="tratamiento_id" class="form-control" required>
                    <option value="">-- Vincular un plan terapéutico activo --</option>
                    @foreach($tratamientos as $t)
                        <option value="{{ $t->id }}">
                            TERAPIA-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }} - {{ $t->nombre ?? $t->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group full-width">
                <label for="efectos_secundarios">Restricciones Clínicas y Efectos Adversos</label>
                <textarea name="efectos_secundarios" id="efectos_secundarios" rows="3" class="form-control" placeholder="Ej. Monitorear presión arterial, evitar su consumo junto a lácteos, contraindicado en insuficiencia renal..." required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">🚀 Registrar en Catálogo</button>
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
        <h2>Stock Fármaco-Clínico</h2>
    </div>
    <a href="{{ route('medicamentos.create') }}" class="btn btn-fill">⚡ Nueva Entrada</a>
</div>

<div class="table-card observe">
    <table class="data-table">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Fármaco / Fabricante</th>
                <th>Esquema Clínico Destinado</th>
                <th>Dosificación e Intervalo</th>
                <th>Duración</th>
                <th>Advertencias / Notas</th>
                <th style="text-align: center;">Gestión</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicamentos as $m)
            <tr>
                <td style="font-weight: 600; color: #64748b;">FRM-{{ str_pad($m->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <strong>{{ $m->nombre }}</strong>
                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">🔬 Lab: {{ $m->proveedor }}</div>
                </td>
                <td>
                    <span class="badge-tratamiento">
                        📁 {{ $m->tratamiento->nombre ?? $m->tratamiento->descripcion ?? 'Régimen Abierto' }}
                    </span>
                </td>
                <td>
                    <span class="badge-dosis">🧬 {{ $m->dosis }}</span>
                    <div style="font-size: 0.8rem; color: #475569; margin-top: 4px;">⏳ {{ $m->frecuencia }}</div>
                </td>
                <td style="font-weight: 500; color: #475569;">📅 {{ $m->duracion }}</td>
                <td style="max-width: 220px; color: #64748b; font-size: 0.85rem; line-height: 1.3;">
                    {{ $m->efectos_secundarios ?: 'Sin alertas registradas' }}
                </td>
                <td style="text-align: center;">
                    <a href="{{ route('medicamentos.edit', $m->id) }}" class="btn-icon" title="Modificar Fármaco">🛠️</a>
                    <form action="{{ route('medicamentos.destroy', $m->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está completamente seguro de retirar esta sustancia del inventario activo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon" style="background: none; border: none; cursor: pointer; padding: 0;" title="Dar de baja">❌</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px; font-style: italic;">
                    No se registran recursos farmacológicos activos en este momento.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif

@endsection