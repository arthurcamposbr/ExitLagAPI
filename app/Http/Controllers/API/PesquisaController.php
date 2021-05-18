<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questoe;

class PesquisaController extends Controller
{
    public function index()
    {
        $questoes = Questoe::all();

        if(!$questoes->isEmpty()){

            foreach($questoes as $key => $q){
                $q->respostas = $q->respostas()->get();
            }

            return response()->json([
                'sucess' => true,
                'data' => $questoes
            ], 200);
        } else {
            return response()->json([
                'sucess' => false,
                'msg' => 'Questão não encontrada.'
            ], 404);
        }

    }

    public function perguntas($id)
    {
        $questao = Questoe::find($id);

        if($questao){
            $respostas = $questao->respostas()->get();

            if(!$respostas->isEmpty()){
                return response()->json([
                    'sucess' => true,
                    'data' => $respostas
                ], 200);
            } else {
                return response()->json([
                    'sucess' => false,
                    'msg' => 'Nenhuma pergunta encontrada.'
                ], 404);
            }

        } else {
            return response()->json([
                'sucess' => false,
                'msg' => 'Questão não encontrada.'
            ], 404);
        }

    }
}
