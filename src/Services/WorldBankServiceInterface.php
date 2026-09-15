<?php
declare(strict_types=1);

namespace NovaEsperanca\Services;

interface WorldBankServiceInterface
{
    /**
     * Obtém indicadores educacionais de Angola a partir da World Bank Open Data API ou cache/fallback.
     * Retorna array estruturado com código do indicador, ano de referência, valor e metadados.
     *
     * @param array<string> $indicatorCodes Lista de códigos de indicadores (ex: ['SE.PRM.ENRR', 'SE.PRM.CMPT.ZS'])
     * @param bool $forceRefresh Se verdadeiro, ignora o cache local e tenta requisição cURL
     * @return array<string, mixed>
     */
    public function getAngolaEducationIndicators(array $indicatorCodes = [], bool $forceRefresh = false): array;

    /**
     * Retorna o status da última sincronização ou cache local.
     *
     * @return array{cached: bool, last_sync: ?string, source: string}
     */
    public function getSyncStatus(): array;
}
