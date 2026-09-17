<?php
declare(strict_types=1);

/**
 * Script de Teste Automatizado e Validação SDD (TDD Test-First)
 * Valida a conformidade da base de dados e do schema JSON com a Especificação Técnica da Fase 1 (WDLC #1).
 */

$rootDir = dirname(__DIR__);
$schemaFile = $rootDir . '/schemas/demanda-pedagogica-apadrinhamento.schema.json';
$dataFile = $rootDir . '/data/demanda-pedagogica-apadrinhamento.json';
$docFile = $rootDir . '/docs/requisitos-pedagogicos-apadrinhamento.md';

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
echo "  TEST SUITE: Validação de Demandas Pedagógicas & Apadrinhamento" . PHP_EOL;
echo "==========================================================" . PHP_EOL . PHP_EOL;

// 1. Verificação de Arquivos Obrigatórios
assertTest(file_exists($schemaFile), "Arquivo de Schema JSON deve existir ({$schemaFile})");
assertTest(file_exists($dataFile), "Arquivo de Dados JSON deve existir ({$dataFile})");
assertTest(file_exists($docFile), "Documento executivo Markdown deve existir ({$docFile})");

if (!file_exists($dataFile) || !file_exists($schemaFile)) {
    echo PHP_EOL . "⚠️ Interrompendo testes semânticos: arquivos de dados ou schema ausentes." . PHP_EOL;
    exit(1);
}

// 2. Integridade de Sintaxe JSON
$schemaContent = file_get_contents($schemaFile);
$schemaJson = json_decode($schemaContent, true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Schema JSON deve ter sintaxe válida", json_last_error_msg());

$dataContent = file_get_contents($dataFile);
$data = json_decode($dataContent, true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Base de dados JSON deve ter sintaxe válida", json_last_error_msg());

if (!$data || !$schemaJson) {
    exit(1);
}

// 3. Validação dos Campos de Instituição
assertTest(str_contains($data['instituicao']['nome'] ?? '', 'Escola Cristã Nova Esperança'), "Instituição deve ser Escola Cristã Nova Esperança");
assertTest(($data['instituicao']['localizacao']['bairro'] ?? '') === 'Kifangondo', "Localização deve ser no bairro de Kifangondo");
assertTest(($data['instituicao']['localizacao']['municipio'] ?? '') === 'Sequele', "Município deve ser Sequele");
assertTest(($data['instituicao']['localizacao']['provincia'] ?? '') === 'Ícolo e Bengo' || ($data['instituicao']['localizacao']['provincia'] ?? '') === 'Icolo e Bengo', "Província deve ser Ícolo e Bengo");

// 4. Validação da Capacidade Operacional Vigente (Regra de Negócio: 93 alunos e 5 salas)
assertTest(($data['cenario_operacional']['alunos_matriculados'] ?? 0) === 93, "Alunos matriculados deve ser exatamente 93");
assertTest(($data['cenario_operacional']['salas_em_uso'] ?? 0) === 5, "Salas em uso deve ser exatamente 5 (1 para cada classe)");
assertTest(($data['cenario_operacional']['regime_turnos']['turno_atual'] ?? '') === 'matutino_temporario', "Turno atual deve ser matutino temporário");
assertTest(($data['cenario_operacional']['regime_turnos']['ano_letivo_inicio_mes'] ?? '') === 'Setembro', "Ano letivo deve iniciar em Setembro");
assertTest(isset($data['cenario_operacional']['regime_turnos']['historico_turnos']), "Deve documentar histórico de 2 turnos");

// 5. Validação do Quadro Operacional (10 colaboradores)
$equipe = $data['equipe_operacional'] ?? [];
assertTest(($equipe['coordenador'] ?? 0) === 1, "Deve possuir 1 coordenador");
assertTest(($equipe['subdiretor_pedagogico'] ?? 0) === 1, "Deve possuir 1 subdiretor pedagógico");
assertTest(($equipe['educadoras'] ?? 0) === 5, "Deve possuir 5 educadoras/professoras (1 por sala)");
assertTest(($equipe['merendeira'] ?? 0) === 1, "Deve possuir 1 merendeira");
assertTest(($equipe['limpeza_e_apoio'] ?? 0) === 2, "Deve possuir 2 colaboradores de limpeza e apoio");
assertTest(($equipe['total_colaboradores'] ?? 0) === 10, "Total de colaboradores deve ser 10");

// 6. Validação da Rotina Diária
$rotina = $data['grade_rotina'] ?? [];
$temParada = false;
$temMerenda = false;
$temSaidaCreche = false;
$temSaidaPrimario = false;

foreach ($rotina as $item) {
    if (($item['inicio'] ?? '') === '07:30' && ($item['fim'] ?? '') === '08:00') {
        $temParada = true;
    }
    if (($item['inicio'] ?? '') === '09:30' && ($item['fim'] ?? '') === '10:00') {
        $temMerenda = true;
    }
    if (($item['fim'] ?? '') === '11:30') {
        $temSaidaCreche = true;
    }
    if (($item['fim'] ?? '') === '12:00') {
        $temSaidaPrimario = true;
    }
}

assertTest($temParada, "Rotina deve conter a Parada das 07:30 às 08:00 (Louvor e reflexão da Palavra)");
assertTest($temMerenda, "Rotina deve conter a Merenda das 09:30 às 10:00");
assertTest($temSaidaCreche, "Rotina deve contemplar a saída da Creche/Iniciação às 11:30");
assertTest($temSaidaPrimario, "Rotina deve contemplar a saída da 1ª à 4ª classe às 12:00");

// 7. Validação do Cardápio da Merenda
$cardapio = $data['cardapio_merenda']['itens'] ?? [];
$cardapioTexto = strtolower(implode(' ', $cardapio));
assertTest(str_contains($cardapioTexto, 'pão') || str_contains($cardapioTexto, 'pao'), "Cardápio deve conter pão com manteiga");
assertTest(str_contains($cardapioTexto, 'sopa'), "Cardápio deve conter sopa nutritiva");
assertTest(str_contains($cardapioTexto, 'arroz com feijão') || str_contains($cardapioTexto, 'arroz com feijao'), "Cardápio deve conter arroz com feijão");

// 8. Validação das Turmas Ativas (Soma deve bater com 93 alunos)
$turmas = $data['turmas_ativas'] ?? [];
assertTest(count($turmas) === 5, "Devem existir exatamente 5 turmas ativas (Iniciação à 4ª classe)");
$totalAlunosTurmas = array_sum(array_column($turmas, 'total_alunos'));
assertTest($totalAlunosTurmas === 93, "Soma de alunos nas turmas ({$totalAlunosTurmas}) deve ser igual a 93");

// 9. Validação das Metas de Expansão (4 Níveis do Sistema Educativo Angolano)
$metas = $data['metas_expansao']['ciclos'] ?? [];
$temCreche = isset($metas['creche']);
$temPrimario = isset($metas['ensino_primario']);
$temSecundarioI = isset($metas['primeiro_ciclo_secundario']);
$temSecundarioII = isset($metas['segundo_ciclo_secundario']);

assertTest($temCreche, "Meta de expansão deve incluir Creche");
assertTest($temPrimario, "Meta de expansão deve incluir Ensino Primário completo");
assertTest($temSecundarioI, "Meta de expansão deve incluir I Ciclo do Ensino Secundário (Fundamental II)");
assertTest($temSecundarioII, "Meta de expansão deve incluir II Ciclo do Ensino Secundário (Ensino Médio)");
assertTest(isset($data['metas_expansao']['ampliacao_salas_meta']), "Meta deve especificar a ampliação de salas de aula para viabilizar 2 turnos");

// 10. Validação de Cotas de Apadrinhamento e Contribuição
$cotas = $data['programa_apadrinhamento']['cotas'] ?? [];
assertTest(!empty($cotas), "Deve possuir cotas de apadrinhamento definidas");
$temCotaObra = false;
foreach ($cotas as $cota) {
    if (str_contains(strtolower($cota['id'] ?? ''), 'sala') || str_contains(strtolower($cota['id'] ?? ''), 'obra') || str_contains(strtolower($cota['id'] ?? ''), 'infra')) {
        $temCotaObra = true;
    }
}
assertTest($temCotaObra, "Deve possuir cota ou fundo para obras e ampliação de salas de aula");

$nacionais = $data['canais_contribuicao']['nacionais'] ?? [];
assertTest(!empty($nacionais), "Deve conter canais nacionais angolanos (IBAN / Multicaixa)");

echo PHP_EOL . "==========================================================" . PHP_EOL;
echo "RESULTADO DA EXECUÇÃO: {$assertions} asserções executadas." . PHP_EOL;

if (!empty($failures)) {
    echo "STATUS: ❌ FALHAS DETECTADAS (" . count($failures) . ")" . PHP_EOL;
    foreach ($failures as $f) {
        echo "  - {$f}" . PHP_EOL;
    }
    exit(1);
}

echo "STATUS: ✅ 100% DOS TESTES PASSARAM COM SUCESSO!" . PHP_EOL;
echo "==========================================================" . PHP_EOL;
exit(0);
