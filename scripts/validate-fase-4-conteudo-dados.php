<?php
declare(strict_types=1);

/**
 * Suíte de Testes Automatizados - WDLC Fase 4: Conteúdo Humanizado, Salvaguarda e Dados (Issue #4)
 * Valida a Política de Proteção Infantil, Narrativa de Impacto em Luanda, Relatório Analítico de Transparência
 * e o Pipeline cURL / Serviço para Indicadores Educacionais do World Bank.
 */

$rootDir = dirname(__DIR__);

// Arquivos de Documentação & Políticas
$docPolitica = $rootDir . '/docs/politica-protecao-infantil.md';
$docNarrativa = $rootDir . '/docs/narrativa-impacto-escola.md';
$docRelatorio = $rootDir . '/docs/relatorio-custos-transparencia.md';

// Schemas e Bases de Dados
$schemaPolitica = $rootDir . '/schemas/politica-protecao-infantil.schema.json';
$schemaRelatorio = $rootDir . '/schemas/relatorio-custos.schema.json';
$dataRelatorio = $rootDir . '/data/relatorio-custos-transparencia.json';
$dataWorldBank = $rootDir . '/data/worldbank-angola-indicadores.json';

// Código PHP de Serviços
$interfaceWorldBank = $rootDir . '/src/Services/WorldBankServiceInterface.php';
$serviceWorldBank = $rootDir . '/src/Services/WorldBankService.php';

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
echo "  TEST SUITE: Fase 4 - Conteúdo Humanizado & Salvaguarda" . PHP_EOL;
echo "==========================================================" . PHP_EOL . PHP_EOL;

// 1. Verificação de Existência dos Arquivos Obrigatórios
assertTest(file_exists($docPolitica), "Documento da Política de Proteção Infantil deve existir ({$docPolitica})");
assertTest(file_exists($docNarrativa), "Documento de Narrativa de Impacto deve existir ({$docNarrativa})");
assertTest(file_exists($docRelatorio), "Documento de Relatório Analítico de Custos deve existir ({$docRelatorio})");
assertTest(file_exists($schemaPolitica), "Schema da Política de Proteção Infantil deve existir ({$schemaPolitica})");
assertTest(file_exists($schemaRelatorio), "Schema do Relatório de Custos deve existir ({$schemaRelatorio})");
assertTest(file_exists($dataRelatorio), "Base de Dados do Relatório de Custos deve existir ({$dataRelatorio})");
assertTest(file_exists($dataWorldBank), "Base Canônica de Indicadores do Banco Mundial deve existir ({$dataWorldBank})");
assertTest(file_exists($interfaceWorldBank), "Interface WorldBankServiceInterface deve existir ({$interfaceWorldBank})");
assertTest(file_exists($serviceWorldBank), "Classe WorldBankService deve existir ({$serviceWorldBank})");

$criticalFilesMissing = !file_exists($docPolitica) || !file_exists($docNarrativa) ||
                        !file_exists($dataRelatorio) || !file_exists($serviceWorldBank);

if ($criticalFilesMissing) {
    echo PHP_EOL . "⚠️ Interrompendo testes aprofundados: componentes da Fase 4 ainda não criados (Fase RED confirmada)." . PHP_EOL;
    echo "Total de asserções executadas: {$assertions}" . PHP_EOL;
    echo "Total de falhas registradas: " . count($failures) . PHP_EOL;
    exit(1);
}

// 2. Validação da Política de Proteção Infantil (docs/politica-protecao-infantil.md)
$contentPolitica = file_get_contents($docPolitica);
assertTest(
    str_contains($contentPolitica, 'Igreja Missionária Nova Esperança') || str_contains($contentPolitica, 'IMNE'),
    "Política deve registrar aprovação expressa da mantenedora (IMNE)"
);
assertTest(
    str_contains($contentPolitica, '25/12') || str_contains($contentPolitica, 'Lei n'),
    "Política deve citar o marco legal de proteção da criança de Angola (Lei nº 25/12)"
);
assertTest(
    str_contains(strtolower($contentPolitica), 'dados nominais') || str_contains(strtolower($contentPolitica), 'nomes completos') || str_contains(strtolower($contentPolitica), 'identificação'),
    "Política deve proibir expressamente a exposição de dados nominais ou histórico sensível das crianças"
);
assertTest(
    str_contains(strtolower($contentPolitica), 'consentimento') || str_contains(strtolower($contentPolitica), 'encarregados de educação'),
    "Política deve prever autorização informada assinada pelos encarregados de educação"
);
assertTest(
    str_contains(strtolower($contentPolitica), 'ouvidoria') || str_contains(strtolower($contentPolitica), 'denúncia') || str_contains(strtolower($contentPolitica), 'canal'),
    "Política deve instituir canal claro para denúncias de desvio de conduta ou salvaguarda"
);
assertTest(
    str_contains(strtolower($contentPolitica), 'pedagógic') || str_contains(strtolower($contentPolitica), 'coletiv'),
    "Diretriz fotográfica deve priorizar planos médios e coletivos focados em atividades pedagógicas"
);

// Validação do Schema de Salvaguarda
$jsonSchemaPolitica = json_decode(file_get_contents($schemaPolitica), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Schema de Proteção Infantil possui JSON válido");
assertTest(isset($jsonSchemaPolitica['properties']['principios_fundamentais']), "Schema de Proteção define princípios fundamentais");
assertTest(isset($jsonSchemaPolitica['properties']['diretrizes_imagem']), "Schema de Proteção define diretrizes de captação de imagem");

// 3. Validação da Narrativa de Impacto Humanizado (docs/narrativa-impacto-escola.md)
$contentNarrativa = file_get_contents($docNarrativa);
assertTest(str_contains($contentNarrativa, 'Kifangondo'), "Narrativa deve contextualizar a comunidade de Kifangondo");
assertTest(str_contains($contentNarrativa, '93'), "Narrativa deve citar o acolhimento atual aos 93 alunos");
assertTest(str_contains($contentNarrativa, '5 salas') || str_contains($contentNarrativa, 'cinco salas'), "Narrativa deve referenciar a estrutura de 5 salas");
assertTest(str_contains(strtolower($contentNarrativa), 'parada'), "Narrativa deve descrever a Parada matinal cívico-pedagógica");
assertTest(str_contains(strtolower($contentNarrativa), 'merenda'), "Narrativa deve descrever o papel da merenda escolar diária balanceada");
assertTest(
    str_contains(strtolower($contentNarrativa), 'pseudônimo') || str_contains(strtolower($contentNarrativa), 'nome fictício') || str_contains(strtolower($contentNarrativa), 'proteção'),
    "Depoimentos e histórias na narrativa devem usar pseudônimos explicitamente identificados para proteger os menores"
);

// 4. Validação dos Relatórios Analíticos de Transparência & Custos
$jsonRelatorio = json_decode(file_get_contents($dataRelatorio), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Base de Custos de Transparência possui JSON válido");

$schemaRelatorioContent = json_decode(file_get_contents($schemaRelatorio), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Schema de Relatório de Custos possui JSON válido");

// Validações do detalhamento orçamentário
assertTest(($jsonRelatorio['moeda'] ?? '') === 'AOA', "Moeda do relatório deve ser AOA");
assertTest(isset($jsonRelatorio['execucao_semestral']['receita_total_aoa']), "Relatório deve indicar receita semestral");
assertTest(isset($jsonRelatorio['execucao_semestral']['despesa_total_aoa']), "Relatório deve indicar despesa semestral");

// Verificação do custo da merenda
$merenda = $jsonRelatorio['detalhamento_merenda'] ?? [];
assertTest(isset($merenda['custo_refeicao_diaria_aluno_aoa']), "Relatório deve detalhar o custo unitário por refeição diária");
assertTest(isset($merenda['refeicoes_servidas_mes']), "Relatório deve informar total de refeições mensais");
assertTest(count($merenda['itens_principais'] ?? []) >= 3, "Relatório deve discriminar ao menos 3 itens principais da merenda (pão, sopa, grãos)");

// Verificação do plano de ampliação predial (6 salas)
$obras = $jsonRelatorio['fundo_obras_detalhado'] ?? [];
assertTest(($obras['salas_planejadas'] ?? 0) === 6, "Plano de obras deve especificar exatamente 6 salas de aula");
assertTest(($obras['orcamento_total_aoa'] ?? 0) === 15000000.0 || ($obras['orcamento_total_aoa'] ?? 0) === 15000000, "Orçamento do Fundo de Salas deve totalizar 15.000.000 AOA");
assertTest(count($obras['composicao_custos'] ?? []) >= 4, "Plano de obras deve ter ao menos 4 categorias de composição de custos (alvenaria, cobertura, carteiras, instalações)");

// 5. Validação da Base Canônica e Serviço PHP World Bank
$jsonWb = json_decode(file_get_contents($dataWorldBank), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Base do Banco Mundial possui JSON válido");
assertTest(($jsonWb['pais_codigo'] ?? '') === 'AGO', "Código do país no Banco Mundial deve ser Angola (AGO)");
assertTest(isset($jsonWb['indicadores']['SE.PRM.ENRR']), "Base World Bank deve conter indicador de matrícula primária (SE.PRM.ENRR)");
assertTest(isset($jsonWb['indicadores']['SE.PRM.CMPT.ZS']), "Base World Bank deve conter indicador de conclusão primária (SE.PRM.CMPT.ZS)");

// Validação da Classe e Interface do WorldBankService
require_once $interfaceWorldBank;
require_once $serviceWorldBank;

assertTest(interface_exists('NovaEsperanca\Services\WorldBankServiceInterface'), "Interface WorldBankServiceInterface deve estar carregada");
assertTest(class_exists('NovaEsperanca\Services\WorldBankService'), "Classe WorldBankService deve estar carregada");

$reflection = new ReflectionClass('NovaEsperanca\Services\WorldBankService');
assertTest($reflection->implementsInterface('NovaEsperanca\Services\WorldBankServiceInterface'), "WorldBankService deve implementar WorldBankServiceInterface");

// Instanciação e Teste Unitário com Fallback / Cache
$cacheDir = $rootDir . '/storage/cache';
$wbService = new NovaEsperanca\Services\WorldBankService(
    cacheDir: $cacheDir,
    fallbackFile: $dataWorldBank,
    timeoutSeconds: 3
);

$indicadores = $wbService->getAngolaEducationIndicators(['SE.PRM.ENRR', 'SE.PRM.CMPT.ZS']);
assertTest(is_array($indicadores) && !empty($indicadores), "WorldBankService deve retornar array estruturado de indicadores");
assertTest(isset($indicadores['SE.PRM.ENRR']), "Resultado do serviço deve conter dados do indicador SE.PRM.ENRR");
assertTest(isset($indicadores['SE.PRM.ENRR']['valor']), "Indicador SE.PRM.ENRR deve possuir valor numérico apurado");

$status = $wbService->getSyncStatus();
assertTest(is_array($status) && isset($status['cached']), "Status de sincronização deve informar estado do cache");
assertTest(in_array($status['source'], ['cache', 'api', 'fallback'], true), "Fonte dos dados deve ser rastreada (cache, api ou fallback)");

echo PHP_EOL . "----------------------------------------------------------" . PHP_EOL;
echo "Total de asserções executadas: {$assertions}" . PHP_EOL;
echo "Total de falhas: " . count($failures) . PHP_EOL;

if (count($failures) === 0) {
    echo "🎉 SUCESSO ABSOLUTO: 100% dos testes da Fase 4 foram aprovados!" . PHP_EOL;
    exit(0);
} else {
    echo "⚠️ ATENÇÃO: Há falhas que precisam ser corrigidas." . PHP_EOL;
    exit(1);
}
