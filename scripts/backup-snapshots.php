<?php
declare(strict_types=1);

/**
 * Utilitário de Backup Automatizado & Snapshots de Dados
 * Projeto Social Escola - Kifangondo, Luanda, Angola
 * 
 * Compacta dados operacionais (storage/ e data/) em arquivo ZIP com hash SHA-256
 * e remove snapshots com idade superior à retenção configurada.
 * 
 * Uso via CLI:
 *   php scripts/backup-snapshots.php [--destination=storage/backups] [--retention-days=30]
 */

$options = getopt('', ['destination::', 'retention-days::']);
$rootDir = dirname(__DIR__);

$destDirParam = $options['destination'] ?? 'storage' . DIRECTORY_SEPARATOR . 'backups';
$destinationDir = (str_starts_with($destDirParam, '/') || (strlen($destDirParam) > 1 && $destDirParam[1] === ':'))
    ? $destDirParam
    : $rootDir . DIRECTORY_SEPARATOR . $destDirParam;

$retentionDays = isset($options['retention-days']) ? (int)$options['retention-days'] : 30;

if (!class_exists('ZipArchive')) {
    fwrite(STDERR, json_encode([
        'status' => 'error',
        'message' => 'Extensão ZipArchive do PHP não está disponível.'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);
    exit(1);
}

if (!is_dir($destinationDir)) {
    if (!mkdir($destinationDir, 0755, true) && !is_dir($destinationDir)) {
        fwrite(STDERR, json_encode([
            'status' => 'error',
            'message' => "Não foi possível criar o diretório de destino: {$destinationDir}"
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);
        exit(1);
    }
}

$timestamp = gmdate('Y-m-d\TH:i:s\Z');
$archiveFilename = 'snapshot-' . gmdate('Ymd-His') . '.zip';
$archivePath = $destinationDir . DIRECTORY_SEPARATOR . $archiveFilename;

$zip = new ZipArchive();
if ($zip->open($archivePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, json_encode([
        'status' => 'error',
        'message' => "Falha ao inicializar arquivo compactado em: {$archivePath}"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);
    exit(1);
}

// Diretórios para incluir no snapshot
$sourceDirs = [
    'data' => $rootDir . DIRECTORY_SEPARATOR . 'data',
    'storage' => $rootDir . DIRECTORY_SEPARATOR . 'storage'
];

$filesCount = 0;
$realDestDir = realpath($destinationDir) ?: $destinationDir;

foreach ($sourceDirs as $prefix => $sourceDir) {
    if (!is_dir($sourceDir)) {
        continue;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $realItemPath = $item->getRealPath();
        if ($realItemPath === false) {
            continue;
        }

        // Não incluir o diretório de backups dentro do próprio backup
        if (str_starts_with($realItemPath, $realDestDir)) {
            continue;
        }

        $relativePath = $prefix . DIRECTORY_SEPARATOR . substr($realItemPath, strlen(realpath($sourceDir)) + 1);
        $zipEntryPath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);

        if ($item->isDir()) {
            $zip->addEmptyDir($zipEntryPath);
        } elseif ($item->isFile()) {
            $zip->addFile($realItemPath, $zipEntryPath);
            $filesCount++;
        }
    }
}

$zip->close();

if (!file_exists($archivePath)) {
    fwrite(STDERR, json_encode([
        'status' => 'error',
        'message' => 'Arquivo compactado não foi gravado em disco.'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);
    exit(1);
}

$sizeBytes = filesize($archivePath);
$sha256 = hash_file('sha256', $archivePath);

// Rotação de snapshots antigos (> $retentionDays dias)
$prunedCount = 0;
$cutoffTime = time() - ($retentionDays * 86400);

$backupFiles = glob($destinationDir . DIRECTORY_SEPARATOR . 'snapshot-*.zip');
if ($backupFiles !== false) {
    foreach ($backupFiles as $backupFile) {
        if ($backupFile === $archivePath) {
            continue;
        }
        $fileMtime = filemtime($backupFile);
        if ($fileMtime !== false && $fileMtime < $cutoffTime) {
            if (@unlink($backupFile)) {
                $prunedCount++;
            }
        }
    }
}

$response = [
    'status' => 'success',
    'timestamp' => $timestamp,
    'archive' => $archivePath,
    'size_bytes' => $sizeBytes,
    'sha256' => $sha256,
    'files_count' => $filesCount,
    'pruned_archives_count' => $prunedCount
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
exit(0);
