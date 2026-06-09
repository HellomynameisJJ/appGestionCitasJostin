@extends('layouts.admin')

@section('title', 'Detalle de Cita - CliniSync')
@section('hero_icon', '📅')
@section('hero_title', 'Cita #{{ str_pad($cita->id, 4, "0", STR_PAD_LEFT) }} | CliniSync')
@section('hero_subtitle', 'Fecha de atención: {{ \Carbon\Carbon::parse($cita->fecha)->format("d/m/Y H:i") }}')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="detail-grid observe">
    {{-- INFORMACIÓN DE LA CITA --}}
    <div class="detail-card">
        <div class="detail-card-title">Detalles de la Consulta</div>
        <div class="detail-rows">
            <div class="dr"><span>Fecha y hora</span><strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y H:i') }}</strong></div>
            <div class="dr"><span>Ubicación</span><strong>{{ $cita->sala ?? '—' }}</strong></div>
            <div class="dr"><span>Estado</span>
                @php $e = $cita->estado ?? 'pendiente'; @endphp
                <span class="badge {{ $e=='completada'?'badge-green':($e=='cancelada'?'badge-red':'badge-blue') }}">{{ ucfirst($e) }}</span>
            </div>
            <div class="dr"><span>Motivo clínico</span><strong>{{ $cita->motivo }}</strong></div>
            <div class="dr"><span>Observaciones</span><span>{{ $cita->observaciones ?? 'Sin notas adicionales' }}</span></div>
        </div>
    </div>

    {{-- INFORMACIÓN DEL PACIENTE --}}
    <div class="detail-card">
        <div class="detail-card-title">Paciente</div>
        <div class="detail-rows">
            <div class="dr"><span>Nombre completo</span><strong>{{ $cita->paciente->apellido ?? '—' }}, {{ $cita->paciente->nombre ?? '' }}</strong></div>
            <div class="dr"><span>Contacto telefónico</span><strong>{{ $cita->paciente->telefono ?? '—' }}</strong></div>
            <div class="dr"><span>Grupo sanguíneo</span><span class="badge badge-blood">{{ $cita->paciente->tipo_sangre ?? '—' }}</span></div>
        </div>
    </div>

    {{-- INFORMACIÓN DEL MÉDICO --}}
    <div class="detail-card">
        <div class="detail-card-title">Médico Tratante</div>
        <div class="detail-rows">
            <div class="dr"><span>Profesional</span><strong>Dr(a). {{ $cita->medico->nombre ?? '—' }} {{ $cita->medico->apellido ?? '' }}</strong></div>
            <div class="dr"><span>Especialidad</span><span class="badge badge-blue">{{ $cita->medico->especialidad ?? '—' }}</span></div>
            <div class="dr"><span>N° Licencia</span><strong>{{ $cita->medico->licencia ?? '—' }}</strong></div>
        </div>
    </div>
</div>

<div class="form-actions observe" style="margin-top: 2rem;">
    <a href="{{ route('citas.index') }}" class="btn btn-ghost">← Volver al historial</a>
    <a href="{{ route('citas.edit', $cita) }}" class="btn btn-fill">✏️ Editar registro de CliniSync</a>
</div>
@endsection