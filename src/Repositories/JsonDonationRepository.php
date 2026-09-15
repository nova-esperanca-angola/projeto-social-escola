<?php
declare(strict_types=1);

namespace NovaEsperanca\Repositories;

/**
 * Implementação de Repositório Flat-file JSON com bloqueio atômico de arquivo.
 * Ideal para execução imediata em hospedagens compartilhadas (Hostinger) sem necessidade de setup inicial de banco.
 */
class JsonDonationRepository implements DonationRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->ensureDirectoryExists();
    }

    private function ensureDirectoryExists(): void
    {
        $dir = dirname($this->filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function loadData(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }

        $fp = fopen($this->filePath, 'rb');
        if (!$fp) {
            return [];
        }

        flock($fp, LOCK_SH);
        $content = stream_get_contents($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        if (!$content) {
            return [];
        }

        $decoded = json_decode($content, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param array<string, array<string, mixed>> $data
     * @return bool
     */
    private function persistData(array $data): bool
    {
        $fp = fopen($this->filePath, 'c+b');
        if (!$fp) {
            return false;
        }

        flock($fp, LOCK_EX);
        ftruncate($fp, 0);
        rewind($fp);
        $encoded = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $written = fwrite($fp, (string)$encoded);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        return $written !== false;
    }

    public function save(array $donationData): bool
    {
        $ref = $donationData['codigo_referencia'] ?? null;
        if (!$ref || !is_string($ref)) {
            return false;
        }

        $currentData = $this->loadData();
        $currentData[$ref] = $donationData;

        return $this->persistData($currentData);
    }

    public function findByReference(string $referenceCode): ?array
    {
        $data = $this->loadData();
        return $data[$referenceCode] ?? null;
    }

    public function all(): array
    {
        $data = $this->loadData();
        return array_values($data);
    }

    public function getStatistics(): array
    {
        $all = $this->all();
        $totalValor = 0.0;
        $porFrequencia = [
            'mensal' => 0,
            'trimestral' => 0,
            'anual' => 0,
            'pontual' => 0,
        ];

        foreach ($all as $item) {
            $valor = (float)($item['valor_aoa'] ?? 0);
            $totalValor += $valor;

            $freq = (string)($item['frequencia'] ?? 'pontual');
            if (isset($porFrequencia[$freq])) {
                $porFrequencia[$freq]++;
            } else {
                $porFrequencia[$freq] = 1;
            }
        }

        return [
            'total_registros' => count($all),
            'total_valor_aoa' => $totalValor,
            'por_frequencia' => $porFrequencia
        ];
    }
}
