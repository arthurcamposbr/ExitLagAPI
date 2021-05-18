<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gateway;

class GatewayController extends Controller
{
    /**
     * Exibe gateways disponíveis.
     */
    public function index(Request $request)
    {
        $gateway = Gateway::all();

        if(!$gateway->isEmpty()){
            return response()->json([
                'sucess' => true,
                'data' => $gateway
            ], 200);
        } else {
            return response()->json([
                'sucess' => false,
                'msg' => 'Nenhum gateway encontrado.'
            ], 404);
        }

    }
}
