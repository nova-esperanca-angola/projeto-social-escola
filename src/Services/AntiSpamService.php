<?php
declare(strict_types=1);

namespace NovaEsperanca\Services;

/**
 * Serviço de Proteção Anti-Spam sem atrito para o usuário.
 * Combina Honeypot (campo armadilha invisível) e Time-Trap (validação de tempo mínimo de preenchimento).
 */
class AntiSpamService implements AntiSpamServiceInterface
{
    private const MIN_SECONDS = 2;

    public function generateToken(): array
    {
        return [
            'timestamp' => time()
        ];
    }

    public function validate(array $submissionData): array
    {
        // 1. Verificação de Honeypot (Campo armadilha para robôs)
        $honeypot = trim((string)($submissionData['hp_confirm_field'] ?? ''));
        if (!empty($honeypot)) {
            return [
                'passed' => false,
                'error_code' => 'SPAM_HONEYPOT_TRIGGERED',
                'message' => 'Submissão bloqueada por filtro de segurança.'
            ];
        }

        // 2. Verificação de Time-Trap (Preenchimento sobre-humano instantâneo)
        $startTime = (int)($submissionData['form_start_time'] ?? 0);
        if ($startTime > 0) {
            $elapsedSeconds = time() - $startTime;
            if ($elapsedSeconds < self::MIN_SECONDS) {
                return [
                    'passed' => false,
                    'error_code' => 'SPAM_TOO_FAST',
                    'message' => 'Submissão muito rápida detectada. Por favor, revise os dados com calma.'
                ];
            }
        }

        return [
            'passed' => true,
            'error_code' => null,
            'message' => 'Verificação anti-spam aprovada com sucesso.'
        ];
    }
}
