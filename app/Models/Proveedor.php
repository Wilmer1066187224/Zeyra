<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // 👇 Muy importante: así Laravel usa la tabla correcta
    protected $table = 'proveedores';

    // 👇 Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
    ];

    // 👇 Relación con compras
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
