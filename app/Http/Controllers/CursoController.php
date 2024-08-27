<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    //


    public function index(){
        
        $cursos = Curso::all();

        return response()->json( $cursos );
    }


    public function get( $id ){
        
        $cursos = Curso::find($id);

        return response()->json( $cursos );
    }




    public function inserir( Request $request ){

        

        $validarData = $request->validate([
            'cur_nome' => 'required|string|max:45',
            'cur_valor' => 'numeric|min:0'
        ]);

        $curso = Curso::create([
            'cur_nome' => $validarData['cur_nome'],
            'cur_valor' => $validarData['cur_valor'],
            'cur_disponivel' => 1
        ]);
        

        return response()->json( ['mensagem' => 'Curso criado com sucesso!', 'data' => $curso], 201 );
    }



    public function alterar( $id, Request $request ){
        
        
        $validarData = $request->validate([
            'cur_nome' => 'required|string|max:45',
            'cur_valor' => 'numeric|min:0'
        ]);

        $curso = Curso::find($id);

        $curso->update([
            'cur_nome' => $validarData['cur_nome'],
            'cur_valor' => $validarData['cur_valor'],
            'cur_disponivel' => 1
        ]);

        return response()->json( ['mensagem' => 'Curso atualizado com sucesso!', 'data' => $curso], 201 );
    }



    public function deletar( $id ){
        
        $curso = Curso::find($id);
        if( $curso ){
            $curso->delete();
            
            return response()->json( ['mensagem' => 'Curso deletado com sucesso!'], 201 );

        }else{

            return response()->json( ['mensagem' => 'Nenhum curso encontrado para deletar!'], 201 );
        }

    }

}
