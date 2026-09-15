<?php
declare(strict_types=1);

namespace NovaEsperanca\Repositories;

/**
 * Interface do Repositório de Intenções de Doação e Apadrinhamento.
 * Garante uma arquitetura desacoplada e intercambiável entre armazenamento Flat-file JSON e banco relacional MySQL.
 */
interface DonationRepositoryInterface
{
    /**
     * Salva ou atualiza um registro de intenção de doação.
     *
     * @param array<string, mixed> $donationData
     * @return bool
     */
    public function save(array $donationData): bool;

    /**
     * Recupera um registro pelo código de referência único (ex: NE-2026-XXXX).
     *
     * @param string $referenceCode
     * @return array<string, mixed>|null
     */
    public function findByReference(string $referenceCode): ?array;

    /**
     * Retorna todas as intenções de doação cadastradas.
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(): array;

    /**
     * Calcula métricas agregadas da arrecadação e intenções registradas.
     *
     * @return array{total_registros: int, total_valor_aoa: float, por_frequencia: array<string, int>}
     */
    public function getStatistics(): array;
}
