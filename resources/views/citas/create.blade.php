@extends('layouts.admin')

@section('title', 'Nueva Cita')
@section('hero_icon', '📋')
@section('hero_title', 'Registrar Cita')
@section('hero_subtitle', 'Programa una nueva cita médica')
@section('hero_img', 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=1400&auto=format&fit=crop&q=80')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('citas.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>FECHA Y HORA</label>
                <input type="datetime-local" name="fecha" value="{{ old('fecha') }}" required>
            </div>
            <div class="form-group">
                <label>SALA</label>
                <input type="text" name="sala" value="{{ old('sala') }}" placeholder="Sala 3 / Consultorio A">
            </div>
            <div class="form-group">
                <label>PACIENTE</label>
                <select name="paciente_id" required>
                    <option value="">Seleccionar paciente…</option>
                    @foreach(\App\Models\Paciente::orderBy('apellido')->get() as $p)
                    <option value="{{ $p->id }}" {{ old('paciente_id')==$p->id?'selected':'' }}>
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
                    <option value="{{ $m->id }}" {{ old('medico_id')==$m->id?'selected':'' }}>
                        Dr. {{ $m->nombre }} {{ $m->apellido }} — {{ $m->especialidad }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>ESTADO</label>
                <select name="estado">
                    @foreach(['pendiente','en curso','completada','cancelada'] as $e)
                    <option value="{{ $e }}" {{ old('estado')==$e?'selected':'' }}>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-full">
                <label>MOTIVO DE CONSULTA</label>
                <input type="text" name="motivo" value="{{ old('motivo') }}" placeholder="Describe el motivo de la cita" required>
            </div>
            <div class="form-group form-full">
                <label>OBSERVACIONES</label>
                <textarea name="observaciones" rows="3" placeholder="Notas adicionales…">{{ old('observaciones') }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('citas.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-fill">Guardar Cita →</button>
        </div>
    </form>
</div>
@endsection