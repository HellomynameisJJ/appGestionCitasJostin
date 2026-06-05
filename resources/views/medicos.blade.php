@extends('layouts.admin')

@section('title', 'Médicos')
@section('hero_icon', '👨‍⚕️')
@section('hero_title', 'Gestionar Médicos')
@section('hero_subtitle', 'Registra nuevo personal médico')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('medicos.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" placeholder="Apellido" required>
            </div>
            <div class="form-group">
                <label>Especialidad</label>
                <input type="text" name="especialidad" placeholder="Ej. Cardiología" required>
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" placeholder="+51 999 000 000">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="form-group">
                <label>Licencia</label>
                <input type="text" name="licencia" placeholder="N° de licencia">
            </div>
            <div class="form-group">
                <label>Años de experiencia</label>
                <input type="number" name="anos_experiencia" placeholder="Ej. 5">
            </div>
        </div>
        <div class="form-actions" style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">Guardar Médico</button>
        </div>
    </form>
</div>

<div class="table-card observe" style="margin-top: 2rem;">
    <h2>Médicos registrados</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th>Teléfono</th>
                <th>Licencia</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicos as $m)
            <tr>
                <td><strong>{{ $m->nombre }} {{ $m->apellido }}</strong></td>
                <td>{{ $m->especialidad }}</td>
                <td>{{ $m->telefono }}</td>
                <td>{{ $m->licencia }}</td>
                <td>{{ $m->email }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="empty-row">No hay médicos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection