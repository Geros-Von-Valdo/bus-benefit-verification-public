<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidadorController;

/*
|--------------------------------------------------------------------------
| API Routes (Demo/Portfólio)
|--------------------------------------------------------------------------
| Essas rotas são apenas exemplos para demonstrar organização de uma API.
| Implementações sensíveis (envio de e-mail, manipulação de arquivos, etc.)
| foram substituídas por versões mockadas.
|
*/

Route::prefix('demo')->group(function () {
    
    // Rota de teste simples
    Route::get('/check-session', function () {
        return response()->json(['session' => 'ok']);
    });

    // Exemplo de listagem
    Route::get('/todos', function () {
        return response()->json([
            ['id' => 1, 'nome' => 'Usuário Exemplo', 'status' => 'ativo'],
            ['id' => 2, 'nome' => 'Teste Demo', 'status' => 'pendente'],
        ]);
    });

    // Exemplo de busca
    Route::get('/pesquisar', function (Request $request) {
        $query = $request->query('q', 'demo');
        return response()->json([
            'termo' => $query,
            'resultados' => [
                ['id' => 99, 'nome' => 'Resultado Demo']
            ]
        ]);
    });

    // Exemplo de resumo
    Route::get('/resumo-status', function () {
        return response()->json([
            'ok' => 10,
            'pendente' => 3,
            'bloqueado' => 1,
        ]);
    });

    // Exemplo de atualização (mock)
    Route::patch('/atualizar-status', function (Request $request) {
        return response()->json([
            'id' => $request->input('id'),
            'novo_status' => $request->input('status', 'ok'),
            'mensagem' => 'Status atualizado (demo).'
        ]);
    });

    // Exemplo de envio de e-mail (mockado)
    Route::patch('/enviar-email', function () {
        return response()->json([
            'mensagem' => 'Simulação de envio de e-mail (demo). Nenhum e-mail real foi enviado.'
        ]);
    });

    // Exemplo de imagem
    Route::get('/imagem/{id}', function ($id) {
        return response()->json([
            'imagem_url' => asset('images/demo-placeholder.png'),
            'descricao' => "Imagem demo para o id {$id}"
        ]);
    });
});
