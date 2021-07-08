<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable=[
        'razonsocial',
        'direccion',
        'telefono',
        'nit',
        'padron',
        'estado',
        'cliente_id'
    ];
    public function clientes(){
        return $this->belongsToMany(Cliente::class);
    }
}
