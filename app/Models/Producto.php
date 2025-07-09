<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

     protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'precio',
        'stock',
        'stock_minimo',
        'categoria_id',
    ];
    public function categoria()
{
    return $this->belongsTo(Categoria::class);
}

    public function movimientos()
    {
    return $this->hasMany(Movimiento::class);
    }
    public function ventas()
    {
    return $this->hasMany(Venta::class);
    }

    
}
