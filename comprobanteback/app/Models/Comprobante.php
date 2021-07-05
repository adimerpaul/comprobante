<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;
    protected $fillable=[
        'nrotramite',
        'nrocomprobante',
        'fecha',
        'tipo',
        'codigo',
        'valorcatastral',
        'mtsfrte',
        'placa',
        'marca',
        'modelo',
        'padron',
        'capital',
        'varios',
        'tipopago',
        'banco',
        'banconro',
        'intere',
        'multa',
        'otros',
        'formulario',
        'total',
        'literal',
        'controlinterno',
        'estado',
        'cajero',
        'user_id',
        'cliente_id',
    ];
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
