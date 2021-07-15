<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unid extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'inicio',
        'fin',
        'codigo',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
