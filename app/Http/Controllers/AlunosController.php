<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alunos;

class AlunosController extends Controller
{
    public function index(){
        
        $itens = Alunos::all();

        return response()->json( $itens );
    }


    public function get( $id ){
        
        $item = Alunos::find($id);

        return response()->json( $item );
    }




    public function inserir( Request $request ){

        

        $validarData = $request->validate([
            'alu_nome' => 'required|string',
            'alu_email' => 'required|string',
            'alu_celular' => 'required|string'
        ]);

        $data = Alunos::create([
            'alu_nome' => $validarData['alu_nome'],
            'alu_email' => $validarData['alu_email'],
            'alu_celular' => $validarData['alu_celular'],
            'alu_disponivel' => 1
        ]);
        

        return response()->json( ['mensagem' => 'Aluno criado com sucesso!', 'data' => $data], 201 );
    }



    public function alterar( $id, Request $request ){
        
        
        $validarData = $request->validate([
            'alu_nome' => 'required|string',
            'alu_email' => 'required|string',
            'alu_celular' => 'required|string'
        ]);

        $data = Alunos::find($id);

        $data->update([
            'alu_nome' => $validarData['alu_nome'],
            'alu_email' => $validarData['alu_email'],
            'alu_celular' => $validarData['alu_celular'],
            'alu_disponivel' => 1
        ]);

        return response()->json( ['mensagem' => 'Aluno atualizado com sucesso!', 'data' => $data], 201 );
    }



    public function deletar( $id ){
        
        $data = Alunos::find($id);
        if( $data ){
            $data->delete();
            
            return response()->json( ['mensagem' => 'Aluno deletado com sucesso!'], 201 );

        }else{

            return response()->json( ['mensagem' => 'Nenhum aluno encontrado para deletar!'], 201 );
        }

    }
}
