<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Inscricoes;

class InscricoesController extends Controller
{
    //


    public function index(){
        
        $itens = Inscricoes::with(['curso', 'aluno'])->get();

        return response()->json( $itens );
    }


    public function get( $id ){
        
        $item = Inscricoes::find($id);

        return response()->json( $item );
    }




    public function inserir( Request $request ){

        

        $validarData = $request->validate([
            'cur_id_curso' => 'required|numeric|min:0',
            'alu_id_aluno' => 'required|numeric|min:0'
        ]);

        $data = Inscricoes::create([
            'cur_id_curso' => $validarData['cur_id_curso'],
            'alu_id_aluno' => $validarData['alu_id_aluno'],
            'ins_disponivel' => '1'
        ]);
        

        return response()->json( ['mensagem' => 'Inscrição criada com sucesso!', 'data' => $data], 201 );
    }



    public function alterar( $id, Request $request ){
        
        
        $validarData = $request->validate([
            'cur_id_curso' => 'numeric|min:0'
        ]);

        $data = Inscricoes::find($id);

        $data->update([
            'cur_id_curso' => $validarData['cur_id_curso']
        ]);

        return response()->json( ['mensagem' => 'Inscrição atualizada com sucesso!', 'data' => $data], 201 );
    }



    public function deletar( $id ){
        
        $data = Inscricoes::find($id);
        if( $data ){
            $data->delete();
            
            return response()->json( ['mensagem' => 'Inscrição deletado com sucesso!'], 201 );

        }else{

            return response()->json( ['mensagem' => 'Nenhum Inscrição encontrado para deletar!'], 201 );
        }

    }

}
