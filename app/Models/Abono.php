<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;
    protected $fillable = ['venta_id', 'monto', 'metodo_pago', 'fecha_abono'];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    
}
