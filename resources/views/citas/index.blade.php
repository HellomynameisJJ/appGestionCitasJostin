@extends('layouts.admin')

@section('title', 'Citas')
@section('hero_icon', '📅')
@section('hero_title', 'Gestión de Citas')
@section('hero_subtitle', 'Agenda y seguimiento de citas médicas')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="content-header observe">
    <div class="content-header-left">
        <h2>Todas las citas</h2>
        <p>{{ $citas->count() }} citas registradas</p>
    </div>
    <a href="{{ route('citas.create') }}" class="btn btn-fill">➕ Nueva Cita</a>
</div>

<div class="table-card observe">
    <div class="table-toolbar">
        <input type="text" class="search-input" placeholder="Buscar cita…">
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Motivo</th>
                <th>Sala</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citas as $c)
            <tr>
                <td><span class="row-id">{{ $c->id }}</span></td>
                <td>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y H:i') }}</td>
                <td>{{ $c->paciente->nombre ?? '—' }} {{ $c->paciente->apellido ?? '' }}</td>
                <td>Dr. {{ $c->medico->nombre ?? '—' }} {{ $c->medico->apellido ?? '' }}</td>
                <td>{{ Str::limit($c->motivo, 40) }}</td>
                <td>{{ $c->sala ?? '—' }}</td>
                <td>
                    @php $estado = $c->estado ?? 'pendiente'; @endphp
                    <span class="badge {{ $estado=='completada'?'badge-green':($estado=='cancelada'?'badge-red':'badge-blue') }}">
                        {{ ucfirst($estado) }}
                    </span>
                </td>
                <td class="actions-cell">
                    <a href="{{ route('citas.show', $c) }}" class="btn-icon">👁</a>
                    <a href="{{ route('citas.edit', $c) }}" class="btn-icon">✏️</a>
                    <button onclick="openModal({{ $c->id }},'citas')" class="btn-icon btn-icon-danger">🗑</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="empty-row">No hay citas registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="deleteModal" class="modal-overlay" style="display:none">
    <div class="modal">
        <div class="modal-icon">⚠</div>
        <h3>¿Eliminar cita?</h3>
        <p>Esta acción no se puede deshacer.</p>
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-ghost">Cancelar</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection