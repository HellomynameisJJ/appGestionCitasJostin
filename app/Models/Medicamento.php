<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model {
    protected $table = 'medicamentos';
    protected $fillable = ['nombre','dosis','frecuencia','duracion','tratamiento_id','proveedor','efectos_secundarios'];
    public function tratamiento() { return $this->belongsTo(Tratamiento::class, 'tratamiento_id'); }
}