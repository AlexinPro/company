<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Capacitacion extends Model
{
    /** @use HasFactory<\Database\Factories\CapacitacionFactory> */
    use HasFactory;
    protected $fillable = ['nombre','empresa','descripcion',
    'duracion','imagen'];
    public function empleados() : BelongsToMany{
        return $this->belongsToMany(Empleado::class);
    }
}
