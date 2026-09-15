<?php
declare(strict_types=1);

namespace NovaEsperanca\Controllers;

use NovaEsperanca\Core\Request;
use NovaEsperanca\Core\Response;
use NovaEsperanca\Repositories\DonationRepositoryInterface;
use NovaEsperanca\Services\NotificationServiceInterface;

class DonationController
{
    public function __construct(
        private readonly DonationRepositoryInterface $repository,
        private readonly NotificationServiceInterface $notificationService
    ) {}

    public function apadrinhar(Request $request): Response
    {
        $params = $request->getParams();

        $errors = [];

        $nome = trim((string)($params['nome_padrinho'] ?? ''));
        if (mb_strlen($nome) < 3) {
            $errors['nome_padrinho'] = 'O nome do padrinho deve conter ao menos 3 caracteres.';
        }

        $contato = trim((string)($params['contato'] ?? ''));
        if (empty($contato)) {
            $errors['contato'] = 'Informe um telefone ou WhatsApp para confirmação do donativo.';
        }

        $valor = (float)($params['valor_aoa'] ?? 0);
        if ($valor < 1000.0) {
            $errors['valor_aoa'] = 'O valor mínimo para apadrinhamento é de 1.000 AOA.';
        }

        $cotaTipo = trim((string)($params['cota_tipo'] ?? 'nutricional'));
        $frequencia = trim((string)($params['frequencia'] ?? 'mensal'));
        $email = trim((string)($params['email'] ?? ''));
        $anonimo = (bool)($params['anonimo'] ?? false);
        $mensagem = trim((string)($params['mensagem'] ?? ''));

        if (!empty($errors)) {
            return Response::json([
                'success' => false,
                'mensagem' => 'Dados de apadrinhamento inválidos.',
                'erros' => $errors
            ], 422);
        }

        // Geração de Código de Referência Único (ex: NE-2026-8K2D)
        $suffix = strtoupper(bin2hex(random_bytes(2)));
        $refCode = "NE-2026-{$suffix}";

        $donationRecord = [
            'codigo_referencia' => $refCode,
            'cota_tipo' => $cotaTipo,
            'frequencia' => $frequencia,
            'valor_aoa' => $valor,
            'nome_padrinho' => $nome,
            'contato' => $contato,
            'email' => $email,
            'anonimo' => $anonimo,
            'mensagem' => $mensagem,
            'status' => 'aguardando_comprovativo',
            'data_registro' => date('c')
        ];

        // 1. Salvar no repositório
        $this->repository->save($donationRecord);

        // 2. Disparar notificação aos coordenadores
        $this->notificationService->notifyNewDonation($donationRecord);

        return Response::json([
            'success' => true,
            'codigo_referencia' => $refCode,
            'mensagem' => 'Intenção de apadrinhamento registrada com sucesso!',
            'dados_bancarios' => [
                'banco' => 'Banco Angolano de Investimentos (BAI)',
                'iban' => 'AO06.0040.0000.1234.5678.9012.3',
                'titular' => 'Igreja Missionária Nova Esperança - Escola',
                'multicaixa_express' => '+244 923 000 000',
                'instrucoes' => "Ao realizar a transferência, utilize a referência {$refCode} no descritivo."
            ]
        ], 201);
    }
}
