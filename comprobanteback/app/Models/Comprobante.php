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
        'fechapago',
        'fechalimite',
        'tipo',
        'item',
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
        'unid_id',
    ];
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function unid(){
        return $this->belongsTo(Unid::class);
    }
    public function detalles(){
        return $this->hasMany(Detalle::class);
    }
}
