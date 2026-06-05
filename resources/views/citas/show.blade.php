@extends('layouts.admin')

@section('title', 'Detalle de Cita')
@section('hero_icon', '📅')
@section('hero_title', 'Cita #{{ $cita->id }}')
@section('hero_subtitle', '{{ \Carbon\Carbon::parse($cita->fecha)->format("d/m/Y H:i") }}')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="detail-grid observe">
    <div class="detail-card">
        <div class="detail-card-title">Información de la cita</div>
        <div class="detail-rows">
            <div class="dr"><span>Fecha y hora</span><strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y H:i') }}</strong></div>
            <div class="dr"><span>Sala</span><strong>{{ $cita->sala ?? '—' }}</strong></div>
            <div class="dr"><span>Estado</span>
                @php $e = $cita->estado ?? 'pendiente'; @endphp
                <span class="badge {{ $e=='completada'?'badge-green':($e=='cancelada'?'badge-red':'badge-blue') }}">{{ ucfirst($e) }}</span>
            </div>
            <div class="dr"><span>Motivo</span><strong>{{ $cita->motivo }}</strong></div>
            <div class="dr"><span>Observaciones</span><span>{{ $cita->observaciones ?? '—' }}</span></div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-title">Paciente</div>
        <div class="detail-rows">
            <div class="dr"><span>Nombre</span><strong>{{ $cita->paciente->nombre ?? '—' }} {{ $cita->paciente->apellido ?? '' }}</strong></div>
            <div class="dr"><span>Teléfono</span><strong>{{ $cita->paciente->telefono ?? '—' }}</strong></div>
            <div class="dr"><span>Tipo sangre</span><span class="badge badge-blood">{{ $cita->paciente->tipo_sangre ?? '—' }}</span></div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-card-title">Médico</div>
        <div class="detail-rows">
            <div class="dr"><span>Nombre</span><strong>Dr. {{ $cita->medico->nombre ?? '—' }} {{ $cita->medico->apellido ?? '' }}</strong></div>
            <div class="dr"><span>Especialidad</span><span class="badge badge-blue">{{ $cita->medico->especialidad ?? '—' }}</span></div>
            <div class="dr"><span>Licencia</span><strong>{{ $cita->medico->licencia ?? '—' }}</strong></div>
        </div>
    </div>
</div>

<div class="form-actions observe">
    <a href="{{ route('citas.index') }}" class="btn btn-ghost">← Volver</a>
    <a href="{{ route('citas.edit', $cita) }}" class="btn btn-fill">Editar cita</a>
</div>
@endsection