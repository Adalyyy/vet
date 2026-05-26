<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    protected $fillable = [
        'mascota_id',
        'tipo',
        'descripcion',
        'fecha_deteccion',
        'archivos_medicos'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
