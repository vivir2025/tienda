<?php

// app/Models/Permiso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permiso extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tienda_id', 'fecha_permiso', 'certificado_bomberos', 'soporte_acripol'
    ];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }
}