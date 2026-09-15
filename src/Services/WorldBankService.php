<?php
declare(strict_types=1);

namespace NovaEsperanca\Services;

/**
 * Serviço de Integração com a World Bank Open Data API via cURL nativo
 * Fornece dados educacionais de Angola com suporte a cache resiliente em disco
 * e fallback estático para tolerância a falhas e execução offline.
 */
class WorldBankService implements WorldBankServiceInterface
{
    private string $cacheFile;
    private array $syncStatus = [
        'cached' => false,
        'last_sync' => null,
        'source' => 'fallback'
    ];

    public function __construct(
        private readonly string $cacheDir,
        private readonly string $fallbackFile,
        private readonly int $timeoutSeconds = 4,
        private readonly int $cacheTtlSeconds = 604800, // 7 dias
        private readonly string $apiBaseUrl = 'https://api.worldbank.org/v2/country/AGO/indicator/'
    ) {
        $this->cacheFile = rtrim($this->cacheDir, '/\\') . '/worldbank-angola.json';
    }

    public function getAngolaEducationIndicators(array $indicatorCodes = [], bool $forceRefresh = false): array
    {
        $data = null;

        // 1. Tentar ler do cache se válido e forceRefresh não estiver ativo
        if (!$forceRefresh && $this->isCacheValid()) {
            $cachedContent = @file_get_contents($this->cacheFile);
            if ($cachedContent !== false) {
                $decoded = json_decode($cachedContent, true);
                if (is_array($decoded) && isset($decoded['indicadores'])) {
                    $this->syncStatus = [
                        'cached' => true,
                        'last_sync' => date('c', (int) filemtime($this->cacheFile)),
                        'source' => 'cache'
                    ];
                    $data = $decoded;
                }
            }
        }

        // 2. Se não houver cache válido ou forceRefresh solicitado, tentar cURL na API externa
        if ($data === null && function_exists('curl_init')) {
            $apiData = $this->fetchFromWorldBankApi();
            if ($apiData !== null) {
                $this->saveToCache($apiData);
                $this->syncStatus = [
                    'cached' => true,
                    'last_sync' => date('c'),
                    'source' => 'api'
                ];
                $data = $apiData;
            }
        }

        // 3. Fallback: Se API falhou ou cURL indisponível, utilizar cache antigo ou arquivo canônico
        if ($data === null) {
            if (file_exists($this->cacheFile)) {
                $raw = @file_get_contents($this->cacheFile);
                $decoded = is_string($raw) ? json_decode($raw, true) : null;
                if (is_array($decoded) && isset($decoded['indicadores'])) {
                    $this->syncStatus = [
                        'cached' => true,
                        'last_sync' => date('c', (int) filemtime($this->cacheFile)),
                        'source' => 'cache'
                    ];
                    $data = $decoded;
                }
            }

            if ($data === null && file_exists($this->fallbackFile)) {
                $rawFallback = @file_get_contents($this->fallbackFile);
                $decodedFallback = is_string($rawFallback) ? json_decode($rawFallback, true) : null;
                if (is_array($decodedFallback) && isset($decodedFallback['indicadores'])) {
                    $this->syncStatus = [
                        'cached' => false,
                        'last_sync' => null,
                        'source' => 'fallback'
                    ];
                    $data = $decodedFallback;
                }
            }
        }

        $indicadores = $data['indicadores'] ?? [];

        // 4. Filtrar por códigos solicitados, se especificados
        if (!empty($indicatorCodes)) {
            $filtered = [];
            foreach ($indicatorCodes as $code) {
                if (isset($indicadores[$code])) {
                    $filtered[$code] = $indicadores[$code];
                }
            }
            return $filtered;
        }

        return $indicadores;
    }

    public function getSyncStatus(): array
    {
        return $this->syncStatus;
    }

    private function isCacheValid(): bool
    {
        if (!file_exists($this->cacheFile)) {
            return false;
        }

        $mtime = filemtime($this->cacheFile);
        if ($mtime === false) {
            return false;
        }

        return (time() - $mtime) < $this->cacheTtlSeconds;
    }

    private function fetchFromWorldBankApi(): ?array
    {
        // Códigos padrão de educação monitorados
        $targetCodes = [
            'SE.PRM.ENRR' => 'Taxa Bruta de Matrícula no Ensino Primário (%)',
            'SE.PRM.CMPT.ZS' => 'Taxa de Conclusão do Ensino Primário (%)',
            'SE.XPD.TOTL.GD.ZS' => 'Despesa Pública em Educação (% do PIB)',
            'SE.ADT.LITR.ZS' => 'Taxa de Alfabetização de Adultos (%)'
        ];

        $indicadores = [];

        foreach ($targetCodes as $code => $nomePt) {
            $url = $this->apiBaseUrl . urlencode($code) . '?format=json&per_page=10';
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => $this->timeoutSeconds,
                CURLOPT_TIMEOUT => $this->timeoutSeconds,
                CURLOPT_USERAGENT => 'EscolaNovaEsperanca-Client/1.0',
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => true
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errNo = curl_errno($ch);
            curl_close($ch);

            if ($errNo !== 0 || $httpCode !== 200 || !is_string($response)) {
                // Em caso de falha em qualquer indicador, aborta e preserva o cache/fallback
                return null;
            }

            $json = json_decode($response, true);
            if (!is_array($json) || !isset($json[1]) || !is_array($json[1])) {
                return null;
            }

            // O World Bank retorna array com página no índice 0 e dados no índice 1
            $entries = $json[1];
            $latestVal = null;
            $latestYear = null;

            foreach ($entries as $entry) {
                if (isset($entry['value']) && $entry['value'] !== null) {
                    $latestVal = (float) $entry['value'];
                    $latestYear = (int) ($entry['date'] ?? date('Y'));
                    break;
                }
            }

            if ($latestVal !== null) {
                $indicadores[$code] = [
                    'codigo' => $code,
                    'nome' => $entries[0]['indicator']['value'] ?? $code,
                    'nome_pt' => $nomePt,
                    'ano_referencia' => $latestYear,
                    'valor' => round($latestVal, 2),
                    'unidade' => 'Percentual'
                ];
            }
        }

        if (empty($indicadores)) {
            return null;
        }

        return [
            'pais_codigo' => 'AGO',
            'pais_nome' => 'Angola',
            'fonte_oficial' => 'World Bank Open Data API (v2)',
            'data_atualizacao' => date('Y-m-d'),
            'indicadores' => $indicadores
        ];
    }

    private function saveToCache(array $data): void
    {
        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0755, true);
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json !== false) {
            @file_put_contents($this->cacheFile, $json, LOCK_EX);
        }
    }
}
