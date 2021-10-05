<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable=[
        'codigo',
        'nombre',
//        'unid_id',
        'estado'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function unids(){
        return $this->belongsToMany(Unid::class);
    }
    public function subitems(){
        return $this->hasMany(Subitem::class);
    }
}
