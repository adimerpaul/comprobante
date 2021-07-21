<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anulado extends Model
{
    use HasFactory;
    protected $fillable=[
        'nrocomprobante',
        'fecha',
        'hora',
        'comprobante_id',
        'unid_id',
        'user_id',
    ];
    public function comprobante(){
        return $this->belongsTo(Comprobante::class)->with('cliente');
    }
    public function unid(){
        return $this->belongsTo(Unid::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
