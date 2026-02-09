<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'autos';
    protected $fillable = [
        'modelo',
        'marca',
        'anio',
        'color',
        'cilindrada',
        'precio',
    ];
}
