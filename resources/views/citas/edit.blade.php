@extends('layouts.admin')

@section('title', 'Editar Cita')
@section('hero_icon', '✏️')
@section('hero_title', 'Editar Cita #{{ $cita->id }}')
@section('hero_subtitle', 'Modifica los datos de la cita')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('citas.update', $cita) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>FECHA Y HORA</label>
                <input type="datetime-local" name="fecha" value="{{ old('fecha', \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group">
                <label>SALA</label>
                <input type="text" name="sala" value="{{ old('sala', $cita->sala) }}">
            </div>
            <div class="form-group">
                <label>PACIENTE</label>
                <select name="paciente_id" required>
                    <option value="">Seleccionar paciente…</option>
                    @foreach(\App\Models\Paciente::orderBy('apellido')->get() as $p)
                    <option value="{{ $p->id }}" {{ old('paciente_id',$cita->paciente_id)==$p->id?'selected':'' }}>
                        {{ $p->nombre }} {{ $p->apellido }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>MÉDICO</label>
                <select name="medico_id" required>
                    <option value="">Seleccionar médico…</option>
                    @foreach(\App\Models\Medico::orderBy('apellido')->get() as $m)
                    <option value="{{ $m->id }}" {{ old('medico_id',$cita->medico_id)==$m->id?'selected':'' }}>
                        Dr. {{ $m->nombre }} {{ $m->apellido }} — {{ $m->especialidad }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>ESTADO</label>
                <select name="estado">
                    @foreach(['pendiente','en curso','completada','cancelada'] as $e)
                    <option value="{{ $e }}" {{ old('estado',$cita->estado)==$e?'selected':'' }}>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-full">
                <label>MOTIVO DE CONSULTA</label>
                <input type="text" name="motivo" value="{{ old('motivo', $cita->motivo) }}" required>
            </div>
            <div class="form-group form-full">
                <label>OBSERVACIONES</label>
                <textarea name="observaciones" rows="3">{{ old('observaciones', $cita->observaciones) }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('citas.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-fill">Actualizar →</button>
        </div>
    </form>
</div>
@endsection