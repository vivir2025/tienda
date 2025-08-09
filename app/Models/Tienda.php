<?php

// app/Models/Tienda.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tienda extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'propietario_id', 'direccion_tienda', 'latitud', 'longitud', 
        'foto', 'foto_url'
    ];

    public function propietario()
    {
        return $this->belongsTo(Propietario::class);
    }

    public function permisos()
    {
        return $this->hasMany(Permiso::class);
    }
}
