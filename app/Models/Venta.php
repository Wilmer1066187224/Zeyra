<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'total',
        'fecha_venta',
        'numero_factura', // 👈 nuevo
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
        public function abonos()
    {
        return $this->hasMany(Abono::class);
    }

    public function getTotalAbonadoAttribute()
    {
        return $this->abonos()->sum('monto');
    }

    public function getSaldoPendienteAttribute()
    {
        return $this->total - $this->total_abonado;
    }
//     public function detalle()
// {
//     return $this->hasMany(DetalleVenta::class);
// }
public function detalles()
{
    return $this->hasMany(VentaDetalle::class);
}

    }
