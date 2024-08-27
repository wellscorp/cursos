<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alunos extends Model
{
    use HasFactory;
    
    protected $table = "alunos";

    protected $fillable = [
        'alu_nome',
        'alu_email',
        'alu_celular',
        'alu_disponivel'
    ];
}
