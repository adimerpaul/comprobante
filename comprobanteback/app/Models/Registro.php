<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $fillable=[
        "temporada",
        "ubicacion",
        "coditem",
//        "nombreitem",
        "coditemsubitem",
//        "nombresubitem",
        "detalle",
        "largo",
        "ancho",
        "cliente_id",
        "rubro_id",
    ];
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function rubro(){
        return $this->belongsTo(Rubro::class);
    }
}
