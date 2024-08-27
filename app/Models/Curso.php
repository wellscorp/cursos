<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = "curso";

    protected $fillable = [
        'cur_nome',
        'cur_valor',
        'cur_disponivel'
    ];
}
