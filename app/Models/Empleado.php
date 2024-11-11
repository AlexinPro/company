<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Empleado extends Model
{
    /** @use HasFactory<\Database\Factories\EmpleadoFactory> */
    use HasFactory;
    protected $fillable = ['nombre','apellidos','puesto_id','email'];

    public function capacitacions(): BelongsToMany{
        return $this->belongsToMany(Capacitacion::class);
    }
    public function puesto(): BelongsTo {
        return $this->belongsTo(Puesto::class);
    }
}
