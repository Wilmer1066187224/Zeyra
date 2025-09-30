<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

     protected $fillable = [
        'producto_id',
        'proveedor_id', // 👈 agregar este
        'cantidad',
        'precio_unitario',
        'total',
        'fecha_compra',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function proveedor()
{
    return $this->belongsTo(Proveedor::class);
}
}
