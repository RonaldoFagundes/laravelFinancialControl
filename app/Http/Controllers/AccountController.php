<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\Account;




class AccountController extends Controller
{
    

 /*
    |--------------------------------------------------------------------------
    | GET /accounts
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $accounts = Account::all();

        return response()->json([
            'success' => true,
            'data' => $accounts
        ]);
    }


    

    /*
    |--------------------------------------------------------------------------
    | GET /accounts/{id}
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $account = Account::find($id);

        if (!$account) {

            return response()->json([
                'success' => false,
                'message' => 'Conta não encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $account
        ]);
    }




    /*
    |--------------------------------------------------------------------------
    | GET /bank/{id}/accounts
    |--------------------------------------------------------------------------
    */

    public function byBank($bnkId)
    {
        \Log::info('BUSCANDO CONTAS DO BANCO', [
        'bnkId' => $bnkId
        ]);

        $accounts = Account::where(
            'fk_bnk',
            $bnkId
        )->get();

        \Log::info('CONTAS ENCONTRADAS', [
        'accounts' => $accounts->toArray()
         ]);

        return response()->json([
            'success' => true,
            'data' => $accounts
        ]);
    }







    /*
    |--------------------------------------------------------------------------
    | POST /accounts
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
         $validated = $request->validate([
        'number_act' => 'required|string|max:50',
        'type_act'   => 'required|string|max:50',
        'desc_act'   => 'nullable|string|max:100',
        'saldo_act'  => 'nullable|numeric',
        'fk_bnk'     => 'required|integer|exists:tb_bank,id_bnk',
    ]);

    $account = Account::create([
        'number_act' => $validated['number_act'],
        'type_act'   => $validated['type_act'],
        'desc_act'   => $validated['desc_act'] ?? null,
        'saldo_act'  => $validated['saldo_act'] ?? 0,
        'fk_bnk'     => $validated['fk_bnk'],
    ]);

    return response()->json([
        'success' => true,
        'data' => $account
    ], 201);
    }





    /*
    |--------------------------------------------------------------------------
    | PUT /accounts/{id}
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $account = Account::find($id);

        if (!$account) {

            return response()->json([
                'success' => false,
                'message' => 'Conta não encontrada.'
            ], 404);
        }


        $account->update([
            'number_act' =>
                $request->number_act
                ?? $account->number_act,

            'type_act' =>
                $request->type_act
                ?? $account->type_act,

            'desc_act' =>
                $request->desc_act
                ?? $account->desc_act,

            'saldo_act' =>
                $request->has('saldo_act')
                    ? $request->saldo_act
                    : $account->saldo_act,

            'fk_bnk' =>
                $request->fk_bnk
                ?? $account->fk_bnk,
        ]);


        return response()->json([
            'success' => true,
            'data' => $account
        ]);
    }






    /*
    |--------------------------------------------------------------------------
    | DELETE /accounts/{id}
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {

            return response()->json([
                'success' => false,
                'message' => 'Conta não encontrada.'
            ], 404);
        }


        $account->delete();


        return response()->json([
            'success' => true,
            'message' => 'Conta removida com sucesso.'
        ]);
    }

   

    
}
