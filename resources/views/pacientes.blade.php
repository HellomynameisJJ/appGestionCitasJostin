@extends('layouts.admin')

@section('title', 'Nuevo Paciente')
@section('hero_icon', '➕')
@section('hero_title', 'Registrar Paciente')
@section('hero_subtitle', 'Completa los datos del nuevo paciente')
@section('hero_img', 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('pacientes.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>NOMBRE</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Juan" required>
            </div>
            <div class="form-group">
                <label>APELLIDO</label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Pérez" required>
            </div>
            <div class="form-group">
                <label>FECHA DE NACIMIENTO</label>
                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
            </div>
            <div class="form-group">
                <label>GÉNERO</label>
                <select name="genero">
                    <option value="">Seleccionar…</option>
                    <option value="masculino" {{ old('genero')=='masculino'?'selected':'' }}>Masculino</option>
                    <option value="femenino"  {{ old('genero')=='femenino' ?'selected':'' }}>Femenino</option>
                    <option value="otro"      {{ old('genero')=='otro'     ?'selected':'' }}>Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label>TELÉFONO</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="+51 999 000 000">
            </div>
            <div class="form-group">
                <label>TIPO DE SANGRE</label>
                <select name="tipo_sangre">
                    <option value="">Seleccionar…</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $ts)
                    <option value="{{ $ts }}" {{ old('tipo_sangre')==$ts?'selected':'' }}>{{ $ts }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-full">
                <label>DIRECCIÓN</label>
                <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Av. Principal 123, Lima">
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('pacientes.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-fill">Guardar Paciente →</button>
        </div>
    </form>
</div>

<!-- Tabla de pacientes registrados -->
<div class="table-card observe" style="margin-top: 2rem;">
    <h2> Pacientes registrados recientemente</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Nacimiento</th>
                <th>Género</th>
                <th>Teléfono</th>
                <th>Tipo sangre</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pacientes as $p)
            <tr>
                <td><span class="row-id">{{ $p->id }}</span></td>
                <td><strong>{{ $p->nombre }} {{ $p->apellido }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($p->fecha_nacimiento)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($p->genero) }}</td>
                <td>{{ $p->telefono ?? '—' }}</td>
                <td><span class="badge badge-blood">{{ $p->tipo_sangre ?? '—' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" class="empty-row">No hay pacientes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection