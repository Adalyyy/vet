<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Mascota extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'tipo_sangre',
        'comportamiento',
        'es_adoptado'
    ];

    public function dueno()
    {
        return $this->belongsTo(Dueno::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id, // Convert to string for LIKE query compatibility sometimes, but int is fine.
            'nombre' => $this->nombre,
        ];
    }
}
