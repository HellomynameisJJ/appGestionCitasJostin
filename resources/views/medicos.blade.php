@extends('layouts.admin')

@section('title', 'Cuerpo Especialista')
@section('hero_icon', '🏢')
@section('hero_title', 'Registro de Facultativos')
@section('hero_subtitle', 'Alta, asignación y gestión del personal médico activo')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('medicos.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nombres</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ej. Carlos Alberto" required>
            </div>
            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" name="apellido" class="form-control" placeholder="Ej. Mendoza Ruiz" required>
            </div>
            <div class="form-group">
                <label>Área de Especialidad</label>
                <input type="text" name="especialidad" class="form-control" placeholder="Ej. Pediatría / Neurología" required>
            </div>
            <div class="form-group">
                <label>Línea Telefónica</label>
                <input type="text" name="telefono" class="form-control" placeholder="Ej. 999 111 222">
            </div>
            <div class="form-group">
                <label>Correo Institucional</label>
                <input type="email" name="email" class="form-control" placeholder="nombre.apellido@clinica.com" required>
            </div>
            <div class="form-group">
                <label>Colegiatura / Matrícula Profesional</label>
                <input type="text" name="licencia" class="form-control" placeholder="Ej. CMP-85421">
            </div>
            <div class="form-group">
                <label>Trayectoria (Años)</label>
                <input type="number" name="anos_experiencia" class="form-control" placeholder="Ej. 12">
            </div>
        </div>
        <div class="form-actions" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">💼 Dar de Alta Especialista</button>
        </div>
    </form>
</div>

<div class="table-card observe" style="margin-top: 2rem;">
    <h2>Plantilla Médica Activa</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Profesional / Colegiatura</th>
                <th>Área Terapéutica</th>
                <th>Contacto Directo</th>
                <th>Correo Electrónico</th>
                <th>Experiencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicos as $m)
            <tr>
                <td>
                    <strong>{{ $m->nombre }} {{ $m->apellido }}</strong>
                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">🆔 Reg: {{ $m->licencia ?? 'Pendiente' }}</div>
                </td>
                <td><span class="badge-tratamiento">🩺 {{ $m->especialidad }}</span></td>
                <td>📞 {{ $m->telefono ?: 'No asignado' }}</td>
                <td>✉️ {{ $m->email }}</td>
                <td style="font-weight: 500; color: #475569;">⏳ {{ $m->anos_experiencia }} años</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty-row" style="text-align: center; color: #94a3b8; padding: 30px; font-style: italic;">
                    No se registran profesionales de la salud dados de alta en el sistema.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection