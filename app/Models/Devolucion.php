<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    // Devolucion.php
        public function venta()
        {
            return $this->belongsTo(Venta::class);
        }
        public function producto()
        {
            return $this->belongsTo(Producto::class);
        }
}
