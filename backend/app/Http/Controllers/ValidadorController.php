<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Str;

class ValidadorController extends Controller
{
    // Retorna todos os registros filtrados por data
    public function todos(Request $request)
    {
        $dataInicial = $request->input('startDate');
        $dataFinal   = $request->input('endDate');

        $query = DB::table('generic')
            ->select('*', DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') AS created_at"));

        if ($dataInicial && $dataFinal) {
            $query->whereBetween('created_at', [$dataInicial, $dataFinal]);
        } elseif ($dataInicial) {
            $query->whereDate('created_at', '=', $dataInicial);
        }

        $dados = $query->get();

        return response()->json([
            'dataUsada' => $dataInicial,
            'dados' => $dados
        ]);
    }

    // Busca por nome ou identificador
    public function buscarPorNomeOuIdentificador(Request $request)
    {
        $termo = $request->input('termo');

        if (!$termo) {
            return response()->json(['error' => 'Parâmetro "termo" é obrigatório.'], 400);
        }

        $termoNormalizado = strtolower(Str::ascii($termo));

        $dados = DB::table('generic')
            ->select('id', 'name', 'identifier', 'status', DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') AS created_at"))
            ->where(function ($query) use ($termo, $termoNormalizado) {
                $query->where('identifier', 'LIKE', "%$termo%")
                      ->orWhereRaw("LOWER(CONVERT(name USING utf8)) LIKE ?", ["%" . $termoNormalizado . "%"]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($dados);
    }

    // Resumo de status
    public function resumoStatus()
    {
        $status = DB::table('generic')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        $legendas = [
            0 => 'Inactive',
            1 => 'Active',
            2 => 'Pending',
        ];

        $resultado = [];
        foreach ($legendas as $codigo => $descricao) {
            $resultado[$codigo] = [
                'status' => $codigo,
                'descricao' => $descricao,
                'quantidade' => 0,
            ];
        }

        foreach ($status as $item) {
            $resultado[$item->status]['quantidade'] = $item->total;
        }

        return response()->json([
            'resumo' => array_values($resultado)
        ]);
    }

    // Atualizar status
    public function atualizarStatus(Request $request)
    {
        $id     = $request->input('id');
        $status = $request->input('status');

        DB::update("UPDATE generic SET status = ? WHERE id = ?", [$status, $id]);
        return response()->json(['mensagem' => 'Status atualizado com sucesso.']);
    }

    // Enviar e-mail genérico usando PHPMailer (placeholders)
    public function enviarEmail(Request $request)
    {
        $registro = DB::table('generic')->where('id', $request->id)->first();
        if (!$registro) {
            return response()->json(['error' => 'Registro não encontrado.']);
        }

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'SMTP_HOST';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'SMTP_USER';
            $mail->Password   = 'SMTP_PASSWORD';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('no-reply@example.com', 'App Demo');
            $mail->addAddress($request->email, $request->name);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Notificação do Sistema';
            $mail->Body    = "<p>Olá {$request->name},</p><p>Esta é uma mensagem de exemplo.</p>";

            $mail->send();

            return response()->json(['message' => 'Email enviado com sucesso.']);

        } catch (\Exception $e) {
            return response()->json(['error' => "Erro ao enviar e-mail: {$mail->ErrorInfo}"]);
        }
    }
}
