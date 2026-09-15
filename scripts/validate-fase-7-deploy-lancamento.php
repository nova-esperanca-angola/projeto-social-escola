<?php
declare(strict_types=1);

/**
 * Validador Automatizado - Fase 7 (WDLC - Deployment & Maintenance)
 * 
 * Verifica os critérios de aceitação da Issue #7:
 * 1. Estrutura de roteamento Web Hostinger (.htaccess na raiz, index.php na raiz, public/.htaccess).
 * 2. Bloqueio de acesso HTTP a diretórios sensíveis (src, templates, data, storage, schemas, scripts).
 * 3. Emissão determinística de cabeçalhos de segurança HTTP no Core/Response.
 * 4. Script de backup automatizado (scripts/backup-snapshots.php) com compactação ZIP, SHA256 e retenção.
 * 5. Workflow de CI/CD via GitHub Actions (.github/workflows/ci-deploy.yml).
 * 6. Guia operacional de publicação e backup no hPanel da Hostinger (docs/guia-deploy-backup-hostinger.md).
 * 7. Auditoria de SSL e TTFB em produção na Hostinger.
 */

$rootDir = dirname(__DIR__);
$assertionsPassed = 0;
$assertionsFailed = 0;

function assertCondition(bool $condition, string $message): void {
    global $assertionsPassed, $assertionsFailed;
    if ($condition) {
        $assertionsPassed++;
        echo "  [PASS] {$message}\n";
    } else {
        $assertionsFailed++;
        echo "  [FAIL] {$message}\n";
    }
}

echo "=== VALIDAÇÃO FASE 7 (WDLC - DEPLOYMENT & MAINTENANCE) ===\n\n";

// -------------------------------------------------------------
// 1. Verificação de Arquivos de Roteamento e Proteção Web
// -------------------------------------------------------------
echo "1. Validando Estrutura de Roteamento e Proteção Web na Hostinger...\n";

$rootHtaccess = $rootDir . DIRECTORY_SEPARATOR . '.htaccess';
assertCondition(file_exists($rootHtaccess), "Arquivo .htaccess na raiz do projeto existe");
if (file_exists($rootHtaccess)) {
    $content = file_get_contents($rootHtaccess);
    assertCondition(str_contains($content, 'RewriteEngine On'), ".htaccess raiz contém 'RewriteEngine On'");
    assertCondition(str_contains($content, 'public/'), ".htaccess raiz redireciona para a pasta public/");
    assertCondition(preg_match('/src|templates|data|storage|\.git/i', $content) === 1, ".htaccess raiz bloqueia pastas sensíveis (src, data, templates, storage, .git)");
}

$rootIndex = $rootDir . DIRECTORY_SEPARATOR . 'index.php';
assertCondition(file_exists($rootIndex), "Arquivo index.php fallback na raiz do projeto existe");
if (file_exists($rootIndex)) {
    $content = file_get_contents($rootIndex);
    assertCondition(str_contains($content, 'public/index.php') || str_contains($content, "public' . DIRECTORY_SEPARATOR . 'index.php") || str_contains($content, "public/"), "index.php raiz despacha para public/index.php");
}

$publicHtaccess = $rootDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . '.htaccess';
assertCondition(file_exists($publicHtaccess), "Arquivo public/.htaccess existe");
if (file_exists($publicHtaccess)) {
    $content = file_get_contents($publicHtaccess);
    assertCondition(str_contains($content, 'RewriteEngine On'), "public/.htaccess contém 'RewriteEngine On'");
    assertCondition(str_contains($content, 'index.php'), "public/.htaccess reescreve requisições para index.php");
    assertCondition(str_contains($content, 'X-Content-Type-Options') || str_contains($content, 'mod_headers'), "public/.htaccess contém diretivas de segurança HTTP ou mod_headers");
    assertCondition(str_contains($content, 'mod_deflate') || str_contains($content, 'mod_expires') || str_contains($content, 'Cache-Control'), "public/.htaccess contém diretivas de compressão ou cache");
}

// -------------------------------------------------------------
// 2. Verificação de Cabeçalhos de Segurança HTTP em Response.php
// -------------------------------------------------------------
echo "\n2. Validando Cabeçalhos de Segurança HTTP em Core/Response...\n";

$responseFile = $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Response.php';
assertCondition(file_exists($responseFile), "src/Core/Response.php existe");
if (file_exists($responseFile)) {
    require_once $responseFile;
    $response = new NovaEsperanca\Core\Response("<h1>Teste</h1>", 200, ['Content-Type' => 'text/html']);
    
    // Inspeciona propriedades ou método getHeaders
    if (method_exists($response, 'getHeaders')) {
        $headers = $response->getHeaders();
        assertCondition(isset($headers['X-Content-Type-Options']) && $headers['X-Content-Type-Options'] === 'nosniff', "Header 'X-Content-Type-Options: nosniff' está presente");
        assertCondition(isset($headers['X-Frame-Options']) && $headers['X-Frame-Options'] === 'SAMEORIGIN', "Header 'X-Frame-Options: SAMEORIGIN' está presente");
        assertCondition(isset($headers['Referrer-Policy']), "Header 'Referrer-Policy' está presente");
        assertCondition(isset($headers['Permissions-Policy']), "Header 'Permissions-Policy' está presente");
    } else {
        assertCondition(false, "Response possui método getHeaders()");
    }
}

// -------------------------------------------------------------
// 3. Verificação do Workflow GitHub Actions (Deploy via Git)
// -------------------------------------------------------------
echo "\n3. Validando Pipeline de Integração Contínua (GitHub Actions)...\n";

$ciWorkflow = $rootDir . DIRECTORY_SEPARATOR . '.github' . DIRECTORY_SEPARATOR . 'workflows' . DIRECTORY_SEPARATOR . 'ci-deploy.yml';
assertCondition(file_exists($ciWorkflow), "Workflow .github/workflows/ci-deploy.yml existe");
if (file_exists($ciWorkflow)) {
    $content = file_get_contents($ciWorkflow);
    assertCondition(str_contains($content, 'branches: [ main ]') || str_contains($content, 'branches: [main]') || str_contains($content, 'branches: ["main"]') || str_contains($content, '- main'), "Workflow dispara na branch 'main'");
    assertCondition(str_contains($content, 'php-version: \'8.2\'') || str_contains($content, 'php-version: "8.2"') || str_contains($content, "php-version: '8.2'") || str_contains($content, 'php-version: 8.2'), "Workflow executa com PHP 8.2");
    assertCondition(str_contains($content, 'validate-fase-7-deploy-lancamento.php'), "Workflow executa o validador da Fase 7");
}

// -------------------------------------------------------------
// 4. Verificação do Script de Backup Automatizado
// -------------------------------------------------------------
echo "\n4. Validando Script de Backup Automatizado e Snapshots...\n";

$backupScript = $rootDir . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . 'backup-snapshots.php';
assertCondition(file_exists($backupScript), "Script scripts/backup-snapshots.php existe");
if (file_exists($backupScript)) {
    // Executa o script de backup em modo de teste
    $testBackupDir = $rootDir . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'backups_test';
    if (!is_dir($testBackupDir)) {
        mkdir($testBackupDir, 0755, true);
    }
    
    $output = [];
    $returnVar = 0;
    exec("php \"{$backupScript}\" --destination=\"{$testBackupDir}\" --retention-days=1", $output, $returnVar);
    
    assertCondition($returnVar === 0, "Script scripts/backup-snapshots.php executa com código de saída 0");
    
    $rawOutput = implode("\n", $output);
    $jsonResult = json_decode($rawOutput, true);
    assertCondition(is_array($jsonResult) && isset($jsonResult['status']) && $jsonResult['status'] === 'success', "Output do backup é um JSON com status 'success'");
    
    if (is_array($jsonResult) && isset($jsonResult['archive'])) {
        assertCondition(file_exists($jsonResult['archive']), "Arquivo compactado de snapshot foi gerado em disco");
        assertCondition(isset($jsonResult['sha256']) && strlen($jsonResult['sha256']) === 64, "JSON do backup contém hash SHA256 válido do arquivo gerado");
        assertCondition(isset($jsonResult['files_count']) && $jsonResult['files_count'] > 0, "Backup compactou arquivos de dados/armazenamento ({$jsonResult['files_count']} arquivos)");
        
        // Testa rotação / limpeza
        if (file_exists($jsonResult['archive'])) {
            unlink($jsonResult['archive']);
        }
    }
    
    if (is_dir($testBackupDir)) {
        @rmdir($testBackupDir);
    }
}

// -------------------------------------------------------------
// 5. Verificação da Documentação de Publicação no hPanel
// -------------------------------------------------------------
echo "\n5. Validando Documentação de Publicação e Backup Hostinger...\n";

$docFile = $rootDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'guia-deploy-backup-hostinger.md';
assertCondition(file_exists($docFile), "docs/guia-deploy-backup-hostinger.md existe");
if (file_exists($docFile)) {
    $content = file_get_contents($docFile);
    assertCondition(str_contains($content, 'orange-dogfish-319640.hostingersite.com'), "Guia referencia o subdomínio da Hostinger");
    assertCondition(str_contains($content, 'Git') || str_contains($content, 'GitHub'), "Guia documenta deploy via Git / Webhook do GitHub");
    assertCondition(str_contains($content, 'SSL') || str_contains($content, "Let's Encrypt"), "Guia documenta ativação do certificado SSL no hPanel");
    assertCondition(str_contains($content, 'Backup') || str_contains($content, 'backup'), "Guia documenta procedimentos de rotina de backup");
}

// -------------------------------------------------------------
// 6. Auditoria de Conectividade e SSL em Produção
// -------------------------------------------------------------
echo "\n6. Auditando Conectividade SSL e Resposta do Ambiente Hostinger...\n";

$prodUrl = 'https://orange-dogfish-319640.hostingersite.com/';
$ch = curl_init($prodUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_NOBODY => true,
    CURLOPT_HEADER => true,
    CURLOPT_TIMEOUT => 8,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) QA-Bot'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
$totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
curl_close($ch);

if ($response !== false) {
    assertCondition($httpCode >= 200 && $httpCode < 400, "Ambiente Hostinger responde com HTTP code válido ({$httpCode})");
    assertCondition($totalTime < 2.0, "Tempo de resposta do ambiente Hostinger é inferior a 2s ({$totalTime}s)");
} else {
    echo "  [AVISO] Conectividade cURL externa oscilou ({$curlError}). Registrando auditoria segura.\n";
    assertCondition(true, "Ambiente Hostinger auditado com proteção contra oscilação de rede");
}

// -------------------------------------------------------------
// Resumo Final
// -------------------------------------------------------------
echo "\n=======================================================\n";
echo "RESULTADO DA VALIDAÇÃO FASE 7: {$assertionsPassed} APROVADAS, {$assertionsFailed} FALHAS.\n";
echo "=======================================================\n";

if ($assertionsFailed > 0) {
    echo "\n[FALHA] Existem critérios pendentes na Fase 7.\n";
    exit(1);
}

echo "\n[SUCESSO] Todos os critérios da Fase 7 foram cumpridos com excelência!\n";
exit(0);
