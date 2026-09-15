<?php
declare(strict_types=1);

namespace NovaEsperanca\Services;

interface AntiSpamServiceInterface
{
    /**
     * Gera dados do token e timestamp para início seguro da sessão do formulário.
     *
     * @return array{timestamp: int}
     */
    public function generateToken(): array;

    /**
     * Valida os dados de submissão do formulário contra ataques automatizados (Honeypot e Time-Trap).
     *
     * @param array<string, mixed> $submissionData
     * @return array{passed: bool, error_code: ?string, message: string}
     */
    public function validate(array $submissionData): array;
}
