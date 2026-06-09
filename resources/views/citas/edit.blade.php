@extends('layouts.admin')

@section('title', 'Editar Cita - CliniSync')
@section('hero_icon', '✏️')
@section('hero_title', 'Editar Cita #{{ str_pad($cita->id, 4, "0", STR_PAD_LEFT) }} | CliniSync')
@section('hero_subtitle', 'Actualización de registros y seguimiento de consultas médicas')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('citas.update', $cita) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Fecha y Hora de la Consulta</label>
                <input type="datetime-local" name="fecha" class="form-control" value="{{ old('fecha', \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group">
                <label>Ubicación / Consultorio</label>
                <input type="text" name="sala" class="form-control" value="{{ old('sala', $cita->sala) }}">
            </div>
            <div class="form-group">
                <label>Paciente</label>
                <select name="paciente_id" class="form-control" required>
                    @foreach(\App\Models\Paciente::orderBy('apellido')->get() as $p)
                    <option value="{{ $p->id }}" {{ old('paciente_id',$cita->paciente_id)==$p->id?'selected':'' }}>
                        {{ $p->apellido }}, {{ $p->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Médico Especialista</label>
                <select name="medico_id" class="form-control" required>
                    @foreach(\App\Models\Medico::orderBy('apellido')->get() as $m)
                    <option value="{{ $m->id }}" {{ old('medico_id',$cita->medico_id)==$m->id?'selected':'' }}>
                        Dr(a). {{ $m->nombre }} {{ $m->apellido }} — {{ $m->especialidad }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Estado de la Cita</label>
                <select name="estado" class="form-control">
                    @foreach(['pendiente','en curso','completada','cancelada'] as $e)
                    <option value="{{ $e }}" {{ old('estado',$cita->estado)==$e?'selected':'' }}>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-full">
                <label>Motivo de Consulta</label>
                <input type="text" name="motivo" class="form-control" value="{{ old('motivo', $cita->motivo) }}" required>
            </div>
            <div class="form-group form-full">
                <label>Observaciones Médicas</label>
                <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $cita->observaciones) }}</textarea>
            </div>
        </div>
        <div class="form-actions" style="margin-top: 1.5rem;">
            <a href="{{ route('citas.index') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">💾 Actualizar en CliniSync</button>
        </div>
    </form>
</div>
@endsection