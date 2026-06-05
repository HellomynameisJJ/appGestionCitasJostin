<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model {
    protected $table = 'tratamientos';
    protected $fillable = ['nombre','descripcion','duracion','diagnostico_id','medico_id','estado','frecuencia_administracion'];
    public function diagnostico()  { return $this->belongsTo(Diagnostico::class, 'diagnostico_id'); }
    public function medico()       { return $this->belongsTo(Medico::class, 'medico_id'); }
    public function medicamentos() { return $this->hasMany(Medicamento::class, 'tratamiento_id'); }
}