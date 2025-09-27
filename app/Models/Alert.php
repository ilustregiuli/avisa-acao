<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_symbol',
        'min_price',
        'max_price',
    ];

    // Relação inversa: Um Alerta pertence a um Usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}