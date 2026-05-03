<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    protected $fillable = [
        'block_id',
        'peso_teorico',
        'peso_real',
        'diferencia_peso',
        'estado',
        'fecha_fabricacion'
    ];

    protected $casts = [
        'peso_teorico' => 'decimal:2',
        'peso_real' => 'decimal:2',
        'diferencia_peso' => 'decimal:2',
        'fecha_fabricacion' => 'datetime',
    ];
    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
