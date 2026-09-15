<?php
declare(strict_types=1);

namespace NovaEsperanca\Services;

class EmailNotificationService implements NotificationServiceInterface
{
    private string $logFile;
    private array $recentDispatches = [];

    public function __construct(string $logFile)
    {
        $this->logFile = $logFile;
        $this->ensureLogDirectoryExists();
    }

    private function ensureLogDirectoryExists(): void
    {
        $dir = dirname($this->logFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    public function notifyNewDonation(array $donationData): bool
    {
        $ref = $donationData['codigo_referencia'] ?? 'SEM-REF';
        $nome = $donationData['nome_padrinho'] ?? 'Anônimo';
        $valor = number_format((float)($donationData['valor_aoa'] ?? 0), 2, ',', '.') . ' AOA';
        $cota = $donationData['cota_tipo'] ?? 'Geral';
        $timestamp = date('c');

        $record = [
            'codigo_referencia' => $ref,
            'nome_padrinho' => $nome,
            'valor' => $valor,
            'cota' => $cota,
            'data_envio' => $timestamp,
            'status' => 'despachado'
        ];

        $this->recentDispatches[] = $record;

        $logLine = sprintf(
            "[%s] [NOTIFICACAO_DOACAO] Ref: %s | Padrinho: %s | Valor: %s | Cota: %s\n",
            $timestamp,
            $ref,
            $nome,
            $valor,
            $cota
        );

        @file_put_contents($this->logFile, $logLine, FILE_APPEND | LOCK_EX);

        // Se houver configuração de e-mail ativo na hospedagem Hostinger, aciona mail()
        $to = 'coordenacao@novaesperancaangola.org';
        $subject = "Nova Intenção de Apadrinhamento: {$ref}";
        $message = "Uma nova intenção de apadrinhamento foi registrada no portal:\n\n"
                 . "Código de Referência: {$ref}\n"
                 . "Padrinho: {$nome}\n"
                 . "Cota: {$cota}\n"
                 . "Valor: {$valor}\n"
                 . "Contato: " . ($donationData['contato'] ?? '-') . "\n"
                 . "Data: {$timestamp}\n";
        $headers = "From: no-reply@novaesperancaangola.org\r\nX-Mailer: PHP/" . phpversion();

        // Tentativa não-bloqueante
        if (function_exists('mail') && !empty($_SERVER['SERVER_NAME'])) {
            @mail($to, $subject, $message, $headers);
        }

        return true;
    }

    public function getRecentDispatches(): array
    {
        return $this->recentDispatches;
    }
}
