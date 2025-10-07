<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total',
        'fecha_venta',
        'numero_factura'
    ];

    /**
     * Casts para convertir automáticamente atributos
     */
    protected $casts = [
        'fecha_venta'      => 'datetime',
        'cantidad'         => 'integer',
        'precio_unitario'  => 'decimal:2',
        'total'            => 'decimal:2',
    ];

    // Relación: Una venta pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación: Una venta pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación: Una venta puede tener una factura
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }

    // Relación: Una venta puede tener muchas devoluciones
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

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    protected static function booted()
    {
        static::creating(function ($venta) {
            if (!$venta->numero_factura) {
                $lastVenta = Venta::latest('id')->first();
                $nextNumber = $lastVenta ? $lastVenta->id + 1 : 1;
                $venta->numero_factura = 'FAC-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
