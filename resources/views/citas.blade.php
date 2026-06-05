@extends('layouts.admin')

@section('title', 'Citas')
@section('hero_icon', '📅')
@section('hero_title', 'Gestión de Citas')
@section('hero_subtitle', 'Calendario y atención de pacientes')

@section('content')
<div class="content-header observe">
    <div class="content-header-left">
        <h2>Listado de Citas</h2>
    </div>
    <a href="{{ route('citas.create') }}" class="btn btn-fill">➕ Nueva Cita</a>
</div>

<div class="table-card observe">
    <table class="data-table">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citas as $c)
            <tr>
                <td>{{ $c->paciente->nombre }} {{ $c->paciente->apellido }}</td>
                <td>{{ $c->medico->nombre }} {{ $c->medico->apellido }}</td>
                <td>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</td>
                <td>{{ $c->motivo }}</td>
                <td><span class="badge {{ $c->estado == 'completada' ? 'badge-green' : 'badge-blue' }}">{{ ucfirst($c->estado) }}</span></td>
                <td><a href="{{ route('citas.edit', $c) }}" class="btn-icon">✏️</a></td>
            </tr>
            @empty
            <tr><td colspan="6">No hay citas programadas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection