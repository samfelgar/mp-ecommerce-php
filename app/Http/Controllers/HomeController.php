<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return response()->view('index');
    }

    public function result(Request $request): Response
    {
        $query = $request->query();
        $success = isset($query['collection_status']) && $query['collection_status'] === 'success';
        $feedback = $this->getFeedback($query['collection_status']);

        return response()->view('result', [
            'query' => $query,
            'success' => $success,
            'feedback' => $feedback,
        ]);
    }

    private function getFeedback(string $status): string
    {
        switch ($status) {
            case 'success':
                return 'O pagamento foi aprovado';
            case 'pending':
                return 'O pagamento está pendente';
            case 'authorized':
                return 'O pagamento foi autorizado, mas ainda não foi concluído';
            case 'in_process':
                return 'O pagamento está sendo processado';
            case 'in_mediation':
                return 'Foi iniciada uma disputa.';
            case 'cancelled':
                return 'O pagamento foi cancelado';
            case 'refunded':
                return 'O pagamento foi devolvido ao usuário';
            case 'charged_back':
                return 'O pagamento foi devolvido na fatura do usuário';
            default:
                return '';
        }
    }
}
