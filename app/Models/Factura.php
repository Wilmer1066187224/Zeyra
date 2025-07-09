<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    
    // Factura.php
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
