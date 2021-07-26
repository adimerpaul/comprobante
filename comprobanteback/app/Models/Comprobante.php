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
        'fechaimpreso',
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
        'porcaja',
        'controlinterno',
        'estado',
        'cajero',
        'usuarioimp',
        'cajero_id',
        'impreso_id',
        'user_id',
        'cliente_id',
        'unid_id',
        'anulado'
    ];
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function unid(){
        return $this->belongsTo(Unid::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function detalles(){
        return $this->hasMany(Detalle::class);
    }
}
