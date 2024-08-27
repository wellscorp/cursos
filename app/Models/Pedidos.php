<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ins_id_inscricao',
        'ped_valor',
        'ped_status'
    ];



    public function inscricao(){
        return $this->belongsTo(Inscricoes::class, 'ins_id_inscricao', 'id');
    }

}
