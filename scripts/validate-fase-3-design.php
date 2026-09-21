<?php
declare(strict_types=1);

/**
 * Suíte de Testes Automatizados - WDLC Fase 3: UI/UX Mobile-First & Stitch Design (Issue #3)
 * Valida os Design Tokens, Folha de Estilos Tailwind-ready, Catálogo de Componentes e Integração Stitch.
 */

$rootDir = dirname(__DIR__);
$fileTokens = $rootDir . '/design-tokens.json';
$fileDesignMd = $rootDir . '/docs/stitch-design-system.md';
$fileCss = $rootDir . '/public/css/design-system.css';
$filePreview = $rootDir . '/public/componentes-preview.html';

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
echo "  TEST SUITE: Fase 3 - UI/UX Mobile-First & Stitch Design" . PHP_EOL;
echo "==========================================================" . PHP_EOL . PHP_EOL;

// 1. Verificação de Arquivos Obrigatórios
assertTest(file_exists($fileTokens), "Arquivo de Design Tokens deve existir ({$fileTokens})");
assertTest(file_exists($fileDesignMd), "Documento do Stitch Design System deve existir ({$fileDesignMd})");
assertTest(file_exists($fileCss), "Folha de estilo design-system.css deve existir ({$fileCss})");
assertTest(file_exists($filePreview), "Catálogo de componentes preview HTML deve existir ({$filePreview})");

if (!file_exists($fileTokens) || !file_exists($fileCss) || !file_exists($filePreview)) {
    echo PHP_EOL . "⚠️ Interrompendo testes aprofundados: arquivos de UI ainda não criados." . PHP_EOL;
    exit(1);
}

// 2. Validação dos Design Tokens
$tokens = json_decode(file_get_contents($fileTokens), true);
assertTest(json_last_error() === JSON_ERROR_NONE, "Tokens JSON deve possuir sintaxe válida");

$colors = $tokens['colors'] ?? [];
assertTest(isset($colors['primary']), "Tokens devem conter cor primária (azul institucional)");
assertTest(isset($colors['hope-amber']), "Tokens devem conter cor hope-amber (âmbar solar)");
assertTest(isset($colors['kifangondo-terra']), "Tokens devem conter cor kifangondo-terra (terracota de Kifangondo)");
assertTest(isset($colors['nutrition-green']), "Tokens devem conter cor nutrition-green (verde nutrição)");

$typography = $tokens['typography'] ?? [];
assertTest(isset($typography['fontFamily']), "Tokens devem especificar família tipográfica");

// 3. Validação do CSS Modular (public/css/design-system.css)
$cssContent = file_get_contents($fileCss);
assertTest(str_contains($cssContent, ':root'), "CSS deve conter declaração de variáveis nativas :root");
assertTest(str_contains($cssContent, '--color-primary'), "CSS deve conter variável --color-primary");
assertTest(str_contains($cssContent, '--color-hope-amber'), "CSS deve conter variável --color-hope-amber");
assertTest(str_contains($cssContent, '--color-kifangondo-terra'), "CSS deve conter variável --color-kifangondo-terra");
assertTest(str_contains($cssContent, '--color-nutrition-green'), "CSS deve conter variável --color-nutrition-green");

// Validação das Classes de Componentes Obrigatórios da Issue #3
assertTest(str_contains($cssContent, '.card-apadrinhamento'), "CSS deve conter classe do componente Card de Apadrinhamento");
assertTest(str_contains($cssContent, '.progress-termometro'), "CSS deve conter classe do componente Termômetro de Obras");
assertTest(str_contains($cssContent, '.progress-bar'), "CSS deve conter classe da barra de preenchimento do progresso");
assertTest(str_contains($cssContent, '.impact-grid'), "CSS deve conter classe do Grid de Impacto Social");
assertTest(str_contains($cssContent, '.impact-card'), "CSS deve conter classe dos cartões de indicadores de impacto");

// Validação de Acessibilidade Mobile (Touch Target mínimo 48px)
assertTest(
    str_contains($cssContent, 'min-height: 48px') || str_contains($cssContent, 'min-height: 3rem') || str_contains($cssContent, 'h-12'),
    "CSS deve estabelecer alvo de toque mínimo de 48px para botões interativos móveis"
);

// 4. Validação do Catálogo de Visualização (public/componentes-preview.html)
$previewHtml = file_get_contents($filePreview);
assertTest(str_contains($previewHtml, '<meta name="viewport"'), "Preview HTML deve conter meta viewport mobile-first");
assertTest(str_contains($previewHtml, 'Escola Nova Esperança'), "Preview HTML deve identificar a Escola Nova Esperança");

// Verificação das 5 Cotas de Apadrinhamento nos Cards
assertTest(str_contains($previewHtml, 'Nutricional') || str_contains($previewHtml, 'Merenda'), "Preview deve conter Card de Apadrinhamento Nutricional");
assertTest(str_contains($previewHtml, 'Didático') || str_contains($previewHtml, 'Uniforme'), "Preview deve conter Card de Apadrinhamento Didático");
assertTest(str_contains($previewHtml, 'Educador') || str_contains($previewHtml, 'Equipe'), "Preview deve conter Card de Apoio ao Educador/Equipe");
assertTest(str_contains($previewHtml, 'Integral'), "Preview deve conter Card de Apadrinhamento Integral");
assertTest(str_contains($previewHtml, 'Salas') || str_contains($previewHtml, 'Predial'), "Preview deve conter Card do Fundo de Salas");

// Verificação dos Valores em Kwanza (AOA)
assertTest(str_contains($previewHtml, '12.500') || str_contains($previewHtml, '12500'), "Preview deve exibir cota de 12.500 AOA");
assertTest(str_contains($previewHtml, '8.500') || str_contains($previewHtml, '8500'), "Preview deve exibir cota de 8.500 AOA");
assertTest(str_contains($previewHtml, '25.000') || str_contains($previewHtml, '25000'), "Preview deve exibir cota de 25.000 AOA");
assertTest(str_contains($previewHtml, '40.000') || str_contains($previewHtml, '40000'), "Preview deve exibir cota de 40.000 AOA");
assertTest(str_contains($previewHtml, '50.000') || str_contains($previewHtml, '50000'), "Preview deve exibir cota de 50.000 AOA");

// Verificação do Termômetro do Fundo de Novas Salas
assertTest(str_contains($previewHtml, '55.359.800') || str_contains($previewHtml, '55359800'), "Preview deve exibir meta de 55.359.800 AOA no termômetro");
assertTest(str_contains($previewHtml, '8 novas salas') || str_contains($previewHtml, '8 salas'), "Preview deve informar a meta de 8 novas salas de aula necessárias");

// Verificação dos Indicadores de Impacto Social
assertTest(str_contains($previewHtml, '93'), "Preview deve exibir o indicador de 93 alunos matriculados");
assertTest(str_contains($previewHtml, '5 salas') || str_contains($previewHtml, '5 Salas'), "Preview deve exibir o indicador de 5 salas ativas");
assertTest(str_contains($previewHtml, '10 colaboradores') || str_contains($previewHtml, '10 Colaboradores') || str_contains($previewHtml, '10 profissionais'), "Preview deve exibir indicador de 10 colaboradores");

// 5. Validação da Especificação do Stitch Design System
$designMdContent = file_get_contents($fileDesignMd);
assertTest(str_contains($designMdContent, 'Escola Nova Esperança'), "Stitch Design MD deve ter o nome do projeto");
assertTest(str_contains($designMdContent, 'colors:'), "Stitch Design MD deve conter seção de cores");
assertTest(str_contains($designMdContent, 'typography:'), "Stitch Design MD deve conter seção de tipografia");

echo PHP_EOL . "==========================================================" . PHP_EOL;
echo "RESULTADO DA EXECUÇÃO: {$assertions} asserções executadas." . PHP_EOL;

if (!empty($failures)) {
    echo "STATUS: ❌ FALHAS DETECTADAS (" . count($failures) . ")" . PHP_EOL;
    foreach ($failures as $f) {
        echo "  - {$f}" . PHP_EOL;
    }
    exit(1);
}

echo "STATUS: ✅ 100% DOS TESTES DA FASE 3 PASSARAM COM SUCESSO!" . PHP_EOL;
echo "==========================================================" . PHP_EOL;
exit(0);
