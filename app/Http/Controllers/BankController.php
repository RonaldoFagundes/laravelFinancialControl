<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\Storage;


class BankController extends Controller
{

    /**
     * GET /api/banks
     */
    public function index()
    {
        return response()->json(Bank::all());
    }

    
     /**
     * GET /api/banks/{id}
     */
    public function show($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'erro' => 'Banco não encontrado.'
            ], 404);
        }

        return response()->json($bank);
    }


     /**
     * POST /api/banks
     */	
public function store(Request $request)
{
    // Converte o valor recebido do FormData
    if ($request->has('broker_bnk')) {
        $request->merge([
            'broker_bnk' => filter_var(
                $request->input('broker_bnk'),
                FILTER_VALIDATE_BOOLEAN
            )
        ]);
    }

    $data = $request->validate([
        'number_bnk'  => 'required|string|max:40',
        'name_bnk'    => 'required|string|max:40',
        'ein_bnk'     => 'required|string|max:19',
        'contact_bnk' => 'nullable|string|max:255',
        'desc_bnk'    => 'required|string|max:40',

        'broker_bnk'  => 'sometimes|boolean',

        'img_bnk'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

        'primary'     => 'sometimes|string|max:20',
        'secondary'   => 'sometimes|string|max:20',
    ]);

    // Upload da imagem
    if ($request->hasFile('img_bnk')) {

        $path = $request->file('img_bnk')
            ->store('banks', 'public');

        $data['img_bnk'] = $path;
    }

    // Cria o banco
    $bank = Bank::create($data);

    return response()->json([
        'success' => true,
        'message' => 'Banco criado com sucesso.',
        'data' => $bank
    ], 201);
}









public function storeTest(Request $request)
{
    dd([
        'method' => $request->method(),
        'all' => $request->all(),
        'files' => $request->allFiles(),
        'img' => $request->file('img_bnk'),
    ]);
}


public function storeImg(Request $request)
{
    if (!$request->hasFile('img_bnk')) {
        return response()->json([
            'success' => false,
            'message' => 'Arquivo não recebido.'
        ], 400);
    }

    $file = $request->file('img_bnk');

    $path = $file->store('banks', 'public');

    return response()->json([
        'success' => true,
        'path' => $path,
        'full_path' => storage_path('app/public/' . $path),
        'exists' => file_exists(
            storage_path('app/public/' . $path)
        )
    ]);
}      




public function store1(Request $request)
{
    // Validação dos dados vindos do React Native
    $request->validate([
        'number_bnk'  => 'required|string',
        'name_bnk'    => 'required|string',
        'ein_bnk'     => 'required|string',
        'img_bnk'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Valida o arquivo
    ]);

    $data = $request->all();

    // Tratamento e salvamento do arquivo de imagem
    if ($request->hasFile('img_bnk')) {
        $path = $request->file('img_bnk')->store('banks', 'public');
        $data['img_bnk'] = $path;
    }
	
	  $bank = Bank::create($data);

    return response()->json(['message' => 'SUCCESS', 'data' => $bank], 201);
}
	
	




public function store2(Request $request)
{
        $request->validate([
            'number_bnk' => 'required',
            'name_bnk' => 'required',
        ]);

        $path = null;

        if ($request->hasFile('img_bnk')) {
            $path = $request->file('img_bnk')->store('banks', 'public');
        }

        $bank = Bank::create([
            'number_bnk' => $request->number_bnk,
            'name_bnk' => $request->name_bnk,
            'ein_bnk' => $request->ein_bnk,
            'contact_bnk' => $request->contact_bnk,
            'desc_bnk' => $request->desc_bnk,
            'img_bnk' => $path,
        ]);

        return response()->json([
            'success' => true,
            'data' => $bank
        ]);
}
	



public function store5(Request $request)
{
    try {

        // 1. Verifica os dados recebidos
        $data = $request->validate([
            'number_bnk' => 'required|string|max:40',
            'name_bnk' => 'required|string|max:40',
            'ein_bnk' => 'required|string|max:19',
            'contact_bnk' => 'required|string|max:255',
            'desc_bnk' => 'required|string|max:100',

            'broker_bnk' => 'nullable|boolean',

            'img_bnk' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'primary' => 'nullable|string|max:20',
            'secondary' => 'nullable|string|max:20',
        ]);

        // 2. Upload
        if ($request->hasFile('img_bnk')) {

            $data['img_bnk'] = $request
                ->file('img_bnk')
                ->store('banks', 'public');
        }

        // 3. Verifica o que será gravado
        // RETIRE DEPOIS DO TESTE
        // dd($data);

        // 4. Grava no banco
        $bank = Bank::create($data);

        // 5. Retorno
        return response()->json([
            'success' => true,
            'message' => 'Banco criado com sucesso.',
            'data' => $bank
        ], 201);

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
}












    
	
	
	/**
     * PUT /api/banks/{id}
     */ 

public function update(Request $request, $id)
{
    $bank = Bank::find($id);

    if (!$bank) {
        return response()->json([
            'erro' => 'Banco não encontrado.'
        ], 404);
    }

    if ($request->has('broker_bnk')) {
        $request->merge([
            'broker_bnk' => filter_var(
                $request->input('broker_bnk'),
                FILTER_VALIDATE_BOOLEAN
            )
        ]);
    }

    $data = $request->validate([
        'number_bnk'  => 'sometimes|string|max:40',
        'name_bnk'    => 'sometimes|string|max:40',
        'ein_bnk'     => 'sometimes|string|max:19',
        'contact_bnk' => 'sometimes|string|max:255',
        'desc_bnk'    => 'sometimes|string|max:40',
        'broker_bnk'  => 'sometimes|boolean',
        'img_bnk'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'primary'     => 'sometimes|string|max:20',
        'secondary'   => 'sometimes|string|max:20',
    ]);

    // Se uma nova imagem foi enviada
    if ($request->hasFile('img_bnk')) {

        // Apaga a imagem antiga
        if ($bank->img_bnk) {
            Storage::disk('public')->delete($bank->img_bnk);
        }

        // Salva a nova imagem
        $data['img_bnk'] = $request
            ->file('img_bnk')
            ->store('banks', 'public');
    }

    $bank->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Banco atualizado com sucesso.',
        'data' => $bank->fresh()
    ]);
}


public function update2(Request $request, $id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'erro' => 'Banco não encontrado.'
            ], 404);
        }

        $data = $request->validate([
            'number_bnk' => 'sometimes|string|max:40',
            'name_bnk' => 'sometimes|string|max:100',
            'ein_bnk' => 'sometimes|string|max:19',
            'contact_bnk' => 'sometimes|string|max:255',
            'desc_bnk' => 'sometimes|string|max:100',

            'broker_bnk' => 'sometimes|boolean',

            'img_bnk' => 'nullable|string',

            'primary' => 'sometimes|string|max:20',
            'secondary' => 'sometimes|string|max:20',
        ]);

        $bank->update($data);

        return response()->json($bank);
}













    /**
     * DELETE /api/banks/{id}
     */
    public function destroy($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json([
                'erro' => 'Banco não encontrado.'
            ], 404);
        }

        $bank->delete();

        return response()->json([
            'message' => 'Banco excluído com sucesso.'
        ]);
    }



	
}