<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

    public function __construct(){
        $this->braintree = new \Braintree\Gateway([
            'environment' => config('app.braintree_env'),
            'merchantId' => config('app.braintree_merchant_id'),
            'publicKey' => config('app.braintree_public_key'),
            'privateKey' => config('app.braintree_private_key')
        ]);
    }

    /**
     * Exibe transações efetuadas.
     */

    public function index(Request $request)
    {
        $user = $request->user();
        $transaction = $user->transaction()->get();

        if(!$transaction->isEmpty()){
            return response()->json([
                'sucess' => true,
                'data' => $transaction
            ], 200);
        } else {
            return response()->json([
                'sucess' => false,
                'msg' => 'Nenhuma transação encontrada.'
            ], 404);
        }

    }

    /**
     * Função para criação de assinatura
     */

    public function make(Request $request)
    {
        $user = $request->user();
        $data = $request->all();

        /**
         * Verifica se usuário já possui algum plano ativo.
         */

        $validaTransaction = $user->transaction()->get();

        if(!$validaTransaction->isEmpty() && $validaTransaction[0]['status_id'] == 'Active'){
            return response()->json([
                'sucess' => false,
                'msg' => 'Usuário já possui plano ativo.'
            ], 200);
        }

        /**
         * Valida obrigatoriedade dos dados do cartão de crédito.
         */

        $validacao = Validator::make($data, [
            'number' => 'required|string|min:16',
            'expirationDate' => 'required|string',
            'cvv' => 'required|string|min:3'
    ]);

    if($validacao->fails()){
        return response()->json([
            'success'=>false, "msg"=>$validacao->errors()
        ], 400);
    }

        /**
         * Pega o customer ID do usuário
         */
        $customer = $user->customer()->get()->first();
        $customer_id = $customer->code;

        /**
         * Conecta ao Braintree.
         */

        $braintree = $this->braintree;

        /**
         * Registra o cartão de crédito.
         */

        $credtCard = $braintree->creditCard()->create([
            'customerId' => $customer_id,
            'number' => $data['number'],
            'expirationDate' => $data['expirationDate'],
            'cvv' => $data['cvv']
        ]);

        if($credtCard){
            $paymentToken = $credtCard->creditCard->token;
        } else {
            return response()->json([
                'success'=>false, "msg"=>'Ocorreu algum erro ao cadastrar o cartão. Por favor tente novamente.'
            ], 400);
        }

        /**
         * Cria a assinatura
         */

        $status = $braintree->subscription()->create([
            'paymentMethodToken' => $paymentToken,
            'planId' => 'mensal'
          ]);

        if($status->success){

            $transaction = $user->transaction()->create([
                'code' => $status->subscription->id,
                'status_id' => $status->subscription->status,
                'gateway_id' => 1,
            ]);

            return response()->json([
                'sucess' => true,
                'data' => $transaction
            ], 200);

        } else {
            return response()->json([
                'success'=>false, "msg"=>'Ocorreu algum erro ao realizar a transação. Por favor tente novamente.'
            ], 400);
        }
    }

    /**
     * Função para cancelamento da Assinatura
     */

    public function cancel(Request $request){

        $user = $request->user();

        /**
         * Verifica se usuário já possui algum plano ativo.
         */

        $validaTransaction = $user->transaction()->get();

        if($validaTransaction->isEmpty()){
            return response()->json([
                'sucess' => false,
                'msg' => 'Nenhuma assinatura encontrada.'
            ], 200);
        } else {

            /**
             * Conecta ao Braintree.
             */
            $braintree = $this->braintree;

            $sub_id = $validaTransaction[0]['code'];

            $result = $braintree->subscription()->cancel($sub_id);
        }



    }

    /**
     * Função para tratamento de status disparados via Webhook
     */

    public function update(Request $request){
        $data = $request->all();

        //return $data;

        /**
         * Conecta ao Braintree.
         */

        $braintree = $this->braintree;

        /**
         * Parse Webhook
         */

        if (
            isset($data["bt_signature"]) &&
            isset($data["bt_payload"])
        ) {
            $webhookNotification = $braintree->webhookNotification()->parse(
                $data["bt_signature"], $data["bt_payload"]
            );

            $status = $webhookNotification->kind;
            $sub_id = $webhookNotification->subscription->id;
            $transaction = Transaction::where('code', $sub_id)->first();

            /**
             * Tratamento de status utilizando switch para filtrar
             */

            switch ($status){
                case 'subscription_charged_successfully':
                    $transaction->status_id = 'Active';
                    $transaction->save();
                    break;
                case 'subscription_canceled':
                    $transaction->delete();
                    break;
                case 'subscription_charged_unsuccessfully':
                    $transaction->status_id = 'Charged Unsuccessfully';
                    $transaction->save();
                    break;
                case 'subscription_expired':
                    $transaction->status_id = 'Expired';
                    $transaction->save();
                    break;
                case 'subscription_trial_ended':
                    $transaction->status_id = 'Trial Expired';
                    $transaction->save();
                    break;
                case 'subscription_went_active':
                    $transaction->status_id = 'Active';
                    $transaction->save();
                    break;
                case 'subscription_went_past_due':
                    $transaction->status_id = 'Past Due';
                    $transaction->save();
                    break;
            }
        }

    }

}
