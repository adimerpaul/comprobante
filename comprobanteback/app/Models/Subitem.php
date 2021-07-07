<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subitem extends Model
{
    use HasFactory;
    protected $fillable=[
        'codigo',
        'nombre',
        'monto',
        'estado',
        'item_id',
        'unid_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
