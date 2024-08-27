<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedidos;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PedidosController extends Controller
{
    //

    public function index(){
        
        $itens = Pedidos::with(['inscricao.curso', 'inscricao.aluno'])->get();

        return response()->json( $itens );
    }


    public function get( $id ){
        
        $item = Pedidos::find($id);

        return response()->json( $item );
    }




    public function inserir( Request $request ){

        

        $validarData = $request->validate([
            'ins_id_inscricao' => 'required|numeric|min:0',
            'ped_valor' => 'numeric|min:0',
            'ped_status' => 'required|numeric|min:0'
        ]);

        $data = Pedidos::create([
            'ins_id_inscricao' => $validarData['ins_id_inscricao'],
            'ped_valor' => $validarData['ped_valor'],
            'ped_status' => $validarData['ped_status']
        ]);
        

        return response()->json( ['mensagem' => 'Pedido criado com sucesso!', 'data' => $data], 201 );
    }



    public function alterar( $id, Request $request ){
        
        
        $validarData = $request->validate([
            'ins_id_inscricao' => 'required|numeric|min:0',
            'ped_valor' => 'numeric|min:0',
            'ped_status' => 'required|numeric|min:0'
        ]);

        $data = Pedidos::find($id);

        $data->update([
            'ins_id_inscricao' => $validarData['ins_id_inscricao'],
            'ped_valor' => $validarData['ped_valor'],
            'ped_status' => $validarData['ped_status']
        ]);

        return response()->json( ['mensagem' => 'Pedido atualizado com sucesso!', 'data' => $data], 201 );
    }



    public function deletar( $id ){
        
        $data = Pedidos::find($id);
        if( $data ){
            $data->delete();
            
            return response()->json( ['mensagem' => 'Pedido deletado com sucesso!'], 201 );

        }else{

            return response()->json( ['mensagem' => 'Nenhum Pedido encontrado para deletar!'], 201 );
        }

    }



    public function criarPagamento( Request $request ){
        Stripe::setApiKey( config('services.stripe.secret') );

        
        $validarData = $request->validate([
            'valor' => 'numeric|min:0'
        ]);

        $pagamento = PaymentIntent::create([
            'amount' => $validarData['valor'],
            'currency' => 'brl'
        ]);

        return response()->json([
            'clientSecret' => $pagamento->client_secret
        ]);
    }
}
