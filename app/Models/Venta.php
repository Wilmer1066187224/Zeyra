<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'cliente_id',
        'cantidad',
        'precio_unitario',
        'total',
        'fecha_venta',
    ];

   // Una venta pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Una venta pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Una venta puede tener una factura
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }

    // Una venta puede tener muchas devoluciones
    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class);
    }

}
