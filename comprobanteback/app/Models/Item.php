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
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
