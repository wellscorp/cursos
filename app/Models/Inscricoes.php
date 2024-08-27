<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricoes extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'cur_id_curso',
        'alu_id_aluno',
        'ins_disponivel'
    ];



    public function curso(){
        return $this->belongsTo(Curso::class, 'cur_id_curso', 'id');
    }

    public function aluno(){
        return $this->belongsTo(Alunos::class, 'alu_id_aluno', 'id');
    }

}
