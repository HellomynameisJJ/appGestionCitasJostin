@extends('layouts.admin')

@section('title', 'Programación - CliniSync')
@section('hero_icon', '📅')
@section('hero_title', 'Gestión de Citas | CliniSync')
@section('hero_subtitle', 'Coordinación y programación de consultas en el sistema CliniSync')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('citas.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Fecha y Hora de la Consulta</label>
                <input type="datetime-local" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
            </div>
            <div class="form-group">
                <label>Ubicación / Consultorio</label>
                <input type="text" name="sala" class="form-control" value="{{ old('sala') }}" placeholder="Ej. Consultorio 302">
            </div>
            <div class="form-group">
                <label>Paciente Solicitante</label>
                <select name="paciente_id" class="form-control" required>
                    <option value="">Seleccionar paciente...</option>
                    @foreach(\App\Models\Paciente::orderBy('apellido')->get() as $p)
                    <option value="{{ $p->id }}" {{ old('paciente_id')==$p->id?'selected':'' }}>
                        {{ $p->apellido }}, {{ $p->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Médico Especialista</label>
                <select name="medico_id" class="form-control" required>
                    <option value="">Seleccionar especialista...</option>
                    @foreach(\App\Models\Medico::orderBy('apellido')->get() as $m)
                    <option value="{{ $m->id }}" {{ old('medico_id')==$m->id?'selected':'' }}>
                        Dr(a). {{ $m->nombre }} {{ $m->apellido }} — {{ $m->especialidad }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Estado de la Cita</label>
                <select name="estado" class="form-control">
                    @foreach(['pendiente','en curso','completada','cancelada'] as $e)
                    <option value="{{ $e }}" {{ old('estado')==$e?'selected':'' }}>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-full">
                <label>Motivo de Consulta</label>
                <input type="text" name="motivo" class="form-control" value="{{ old('motivo') }}" placeholder="Descripción breve del motivo clínico" required>
            </div>
            <div class="form-group form-full">
                <label>Observaciones Médicas</label>
                <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas adicionales relevantes para la atención...">{{ old('observaciones') }}</textarea>
            </div>
        </div>
        <div class="form-actions" style="margin-top: 1.5rem;">
            <a href="{{ route('citas.index') }}" class="btn-cancel">Descartar</a>
            <button type="submit" class="btn-submit">💾 Programar en CliniSync</button>
        </div>
    </form>
</div>
@endsection