<?php
declare(strict_types=1);

/**
 * Suíte de Testes Automatizados - WDLC Fase 2: Planejamento & UX (Issue #2)
 * Valida os contratos de Arquitetura de Informação, Transparência, Repositório PHP e Fluxo de Apadrinhamento em 2 etapas.
 */

$rootDir = dirname(__DIR__);
$schemaTransparencia = $rootDir . '/schemas/transparencia-prestacao-contas.schema.json';
$schemaIntencao = $rootDir . '/schemas/intencao-apadrinhamento.schema.json';
$dataTransparencia = $rootDir . '/data/transparencia-prestacao-contas.json';
$dataDiagnostico = $rootDir . '/data/diagnostico-educacional-luanda.json';
$docSitemap = $rootDir . '/docs/arquitetura-informacao-sitemap.md';
$interfaceRepo = $rootDir . '/src/Repositories/DonationRepositoryInterface.php';
$jsonRepo = $rootDir . '/src/Repositories/JsonDonationRepository.php';

$assertions = 0;
$failures = [];

function assertTest(bool $condition, string $description, ?string $detail = null): void {
    global $assertions, $failures;
    $assertions++;
    if (!$condition) {
        $msg = "❌ FAIL: {$description}";
        if ($detail) {
            $msg .= " -> Detalhe: {$detail}";
        }
        $failures[] = $msg;
        echo $msg . PHP_EOL;
    } else {
        echo "✅ PASS: {$description}" . PHP_EOL;
    }
}

echo "==========================================================" . PHP_EOL;
echo "  TEST SUITE: Fase 2 - Planejamento, Transparência & UX" . PHP_EOL;
echo "==========================================================" . PHP_EOL . PHP_EOL;

// 1. Arquivos Obrigatórios da Fase 2
assertTest(file_exists($schemaTransparencia), "Schema de Transparência deve existir ({$schemaTransparencia})");
assertTest(file_exists($schemaIntencao), "Schema de Intenção de Apadrinhamento deve existir ({$schemaIntencao})");
assertTest(file_exists($dataTransparencia), "Base de Dados de Transparência deve existir ({$dataTransparencia})");
assertTest(file_exists($dataDiagnostico), "Base de Diagnóstico Educacional de Luanda deve existir ({$dataDiagnostico})");
assertTest(file_exists($docSitemap), "Documento de Arquitetura de Informação & Sitemap deve existir ({$docSitemap})");
assertTest(file_exists($interfaceRepo), "Interface DonationRepositoryInterface deve existir ({$interfaceRepo})");
assertTest(file_exists($jsonRepo), "Classe JsonDonationRepository deve existir ({$jsonRepo})");

if (!file_exists($schemaTransparencia) || !file_exists($dataTransparencia) || !file_exists($interfaceRepo)) {
    echo PHP_EOL . "⚠️ Interrompendo testes aprofundados: arquivos essenciais ainda não implementados." . PHP_EOL;
    exit(1);
}

// 2. Validação Sintática dos Arquivos JSON
$tSchema = json_decode(file_get_contents($schemaTransparencia), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Schema de Transparência possui JSON válido");

$iSchema = json_decode(file_get_contents($schemaIntencao), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Schema de Intenção possui JSON válido");

$tData = json_decode(file_get_contents($dataTransparencia), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Dados de Transparência possuem JSON válido");

$dData = json_decode(file_get_contents($dataDiagnostico), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Dados de Diagnóstico possuem JSON válido");

// 3. Validação do Painel de Transparência & Prestação de Contas
assertTest(($tData['moeda_base'] ?? '') === 'AOA', "Moeda base da transparência deve ser Kwanza (AOA)");
assertTest(isset($tData['resumo_financeiro']['total_receitas_aoa']), "Deve conter total de receitas");
assertTest(isset($tData['resumo_financeiro']['total_despesas_aoa']), "Deve conter total de despesas");
assertTest(isset($tData['resumo_financeiro']['reserva_tecnica_aoa']), "Deve conter reserva técnica de segurança");

$reserva = $tData['resumo_financeiro']['reserva_tecnica_aoa'] ?? 0;
$receitas = $tData['resumo_financeiro']['total_receitas_aoa'] ?? 1;
$percentualReserva = round(($reserva / $receitas) * 100);
assertTest($percentualReserva >= 10, "Reserva técnica deve representar no mínimo 10% da receita arrecadada (Atual: {$percentualReserva}%)");

// Validação do Fundo de Novas Salas de Aula
$fundoSalas = $tData['fundo_obras_salas'] ?? [];
assertTest(isset($fundoSalas['meta_financeira_aoa']) && $fundoSalas['meta_financeira_aoa'] > 0, "Fundo de obras deve ter meta financeira definida em AOA");
assertTest(($fundoSalas['salas_alvo'] ?? 0) === 8, "Fundo de obras deve especificar exatamente 8 salas alvo que precisamos");

// 4. Validação do Diagnóstico Educacional
assertTest(($dData['regiao']['provincia'] ?? '') === 'Ícolo e Bengo' || ($dData['regiao']['provincia'] ?? '') === 'Icolo e Bengo', "Diagnóstico deve focar na Província de Ícolo e Bengo");
assertTest(($dData['regiao']['municipio'] ?? '') === 'Sequele', "Diagnóstico deve abranger o Município do Sequele");
assertTest(isset($dData['indicadores_chave']['taxa_matricula_pre_escolar_percentual']), "Deve conter taxa de matrícula na pré-escola");
assertTest(isset($dData['indicadores_chave']['deficit_vagas_comunidade_kifangondo']), "Deve conter estimativa de déficit em Kifangondo");

// 5. Validação da Arquitetura de Informação & Sitemap (Issue #2: 6 rotas obrigatórias)
$sitemapText = file_get_contents($docSitemap);
$rotasObrigatorias = [
    '/' => 'Início / Apresentação',
    '/sobre' => 'História e Diagnóstico',
    '/apadrinhe' => 'Como Apoiar e Fluxo de Apadrinhamento',
    '/transparencia' => 'Prestação de Contas',
    '/galeria' => 'Atividades Pedagógicas',
    '/voluntariado' => 'Cadastro de Voluntários'
];

foreach ($rotasObrigatorias as $rota => $nome) {
    assertTest(str_contains($sitemapText, "`{$rota}`") || str_contains($sitemapText, "{$rota}"), "Sitemap deve documentar rota obrigatória: {$rota} ({$nome})");
}

// 6. Validação do Critério de Aceitação: Fluxo em no Máximo 2 Etapas
assertTest(str_contains($sitemapText, 'Etapa 1') && str_contains($sitemapText, 'Etapa 2'), "Documento deve especificar o fluxo em exatamente 2 etapas");
assertTest(!str_contains($sitemapText, 'Etapa 3'), "Fluxo de apadrinhamento NÃO deve possuir Etapa 3 (critério estrito: max 2 etapas)");

// 7. Validação Funcional da Camada de Repositório PHP 8.2+
require_once $interfaceRepo;
require_once $jsonRepo;

assertTest(interface_exists('NovaEsperanca\Repositories\DonationRepositoryInterface'), "Interface DonationRepositoryInterface deve estar declarada no namespace correto");
assertTest(class_exists('NovaEsperanca\Repositories\JsonDonationRepository'), "Classe JsonDonationRepository deve estar declarada no namespace correto");

// Teste de gravação e consulta no JsonDonationRepository
$testStorageDir = $rootDir . '/storage/test';
if (!is_dir($testStorageDir)) {
    mkdir($testStorageDir, 0777, true);
}
$testFile = $testStorageDir . '/test-donations.json';
if (file_exists($testFile)) {
    unlink($testFile);
}

$repo = new \NovaEsperanca\Repositories\JsonDonationRepository($testFile);
$intencaoExemplo = [
    'codigo_referencia' => 'NE-2026-TEST',
    'cota_id' => 'cota-nutricional',
    'frequencia' => 'mensal',
    'valor_aoa' => 12500,
    'padrinho' => [
        'nome' => 'Padrinho Teste',
        'contato' => '+244923000000',
        'tipo_contato' => 'whatsapp',
        'pais_residencia' => 'Angola',
        'exibir_no_mural_publico' => true
    ],
    'metodo_pagamento_preferencial' => 'multicaixa_express',
    'data_registro' => date('Y-m-d H:i:s'),
    'status' => 'aguardando_comprovativo'
];

$salvo = $repo->save($intencaoExemplo);
assertTest($salvo === true, "JsonDonationRepository deve salvar intenção com sucesso");

$buscado = $repo->findByReference('NE-2026-TEST');
assertTest($buscado !== null && $buscado['codigo_referencia'] === 'NE-2026-TEST', "JsonDonationRepository deve recuperar registro pelo código de referência");

$todas = $repo->all();
assertTest(count($todas) === 1, "JsonDonationRepository deve listar todas as intenções");

$stats = $repo->getStatistics();
assertTest($stats['total_registros'] === 1 && $stats['total_valor_aoa'] === 12500.0, "JsonDonationRepository deve calcular estatísticas corretas");

// Limpeza de arquivo de teste
if (file_exists($testFile)) {
    unlink($testFile);
}

echo PHP_EOL . "==========================================================" . PHP_EOL;
echo "RESULTADO DA EXECUÇÃO: {$assertions} asserções executadas." . PHP_EOL;

if (!empty($failures)) {
    echo "STATUS: ❌ FALHAS DETECTADAS (" . count($failures) . ")" . PHP_EOL;
    foreach ($failures as $f) {
        echo "  - {$f}" . PHP_EOL;
    }
    exit(1);
}

echo "STATUS: ✅ 100% DOS TESTES DA FASE 2 PASSARAM COM SUCESSO!" . PHP_EOL;
echo "==========================================================" . PHP_EOL;
exit(0);
