<?php

// app/Models/Propietario.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propietario extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nombre', 'direccion', 'telefono', 'foto', 'foto_url'
    ];

    public function tiendas()
    {
        return $this->hasMany(Tienda::class);
    }
}