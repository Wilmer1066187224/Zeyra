<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    // Permitimos asignación masiva en estos campos
    protected $fillable = ['nombre', 'documento', 'email', 'telefono', 'direccion'];

   /**
     * Relación: Un cliente puede tener muchas ventas
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    /**
     * Relación: Un cliente puede tener muchas devoluciones
     */
    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class);
    }
}
