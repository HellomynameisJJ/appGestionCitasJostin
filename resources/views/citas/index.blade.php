@extends('layouts.admin')

@section('title', 'Programación - CliniSync')
@section('hero_icon', '📅')
@section('hero_title', 'Gestión de Citas | CliniSync')
@section('hero_subtitle', 'Control administrativo de consultas y agenda médica')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="content-header observe">
    <div class="content-header-left">
        <h2>Historial de Citas</h2>
        <p>{{ $citas->count() }} registros en el sistema CliniSync</p>
    </div>
    <a href="{{ route('citas.create') }}" class="btn btn-fill">➕ Nueva Cita</a>
</div>

<div class="table-card observe">
    <div class="table-toolbar">
        <input type="text" class="search-input" placeholder="Buscar en la agenda...">
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Motivo</th>
                <th>Ubicación</th>
                <th>Estado</th>
                <th>Gestión</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citas as $c)
            <tr>
                <td><span class="row-id">#{{ str_pad($c->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                <td style="white-space:nowrap">{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y H:i') }}</td>
                <td>{{ $c->paciente->apellido ?? '—' }}, {{ $c->paciente->nombre ?? '' }}</td>
                <td>Dr(a). {{ $c->medico->nombre ?? '—' }} {{ $c->medico->apellido ?? '' }}</td>
                <td>{{ Str::limit($c->motivo, 35) }}</td>
                <td>{{ $c->sala ?? '—' }}</td>
                <td>
                    @php $estado = $c->estado ?? 'pendiente'; @endphp
                    <span class="badge {{ $estado=='completada'?'badge-green':($estado=='cancelada'?'badge-red':'badge-blue') }}">
                        {{ ucfirst($estado) }}
                    </span>
                </td>
                <td class="actions-cell">
                    <a href="{{ route('citas.show', $c) }}" class="btn-icon" title="Ver detalle">👁</a>
                    <a href="{{ route('citas.edit', $c) }}" class="btn-icon" title="Editar cita">✏️</a>
                    <button onclick="openModal({{ $c->id }},'citas')" class="btn-icon btn-icon-danger" title="Eliminar registro">🗑</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="empty-row">No existen citas programadas en CliniSync.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL ELIMINAR --}}
<div id="deleteModal" class="modal-overlay" style="display:none">
    <div class="modal">
        <div class="modal-icon">⚠</div>
        <h3>¿Eliminar cita de CliniSync?</h3>
        <p>Esta acción eliminará el registro permanentemente de la agenda.</p>
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-ghost">Cancelar</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Confirmar eliminación</button>
            </form>
        </div>
    </div>
</div>
@endsection