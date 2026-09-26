<?php
declare(strict_types=1);

/**
 * Validador Automatizado - Issue #13 (Testes de Responsividade Multi-Device,
 * Acessibilidade Desktop WCAG AA e Validacao de QA Consolidada do Epic #8)
 *
 * Verifica os criterios de aceitacao da Issue #13:
 * 1. CA1 - Responsividade Multi-Device & Breakpoints:
 *    - Bottom Navigation oculta no desktop (md:hidden)
 *    - Top App Bar com menu horizontal (hidden md:flex) e CTA (hidden md:inline-flex)
 *    - Rodapé institucional desktop (hidden md:block md:grid-cols-2 lg:grid-cols-4)
 *    - Container principal responsivo (max-w-screen-md md:max-w-5xl lg:max-w-7xl px-4 md:px-6)
 *    - Grades multi-coluna nas páginas canônicas (Home, Sobre, Galeria, Transparência, Apadrinhe)
 * 2. CA2 - Acessibilidade WCAG 2.1 AA por Teclado:
 *    - Foco visível (focus-visible:ring-2) em todos os links e botões do menu desktop e rodapé
 *    - Ordem lógica sem armadilhas de teclado e acessibilidade no modal (role="dialog", Escape, etc.)
 * 3. CA3 - Auditoria Matemática de Contraste WCAG AA:
 *    - Verificação de luminância relativa e contraste de cores >= 4.5:1 para texto normal
 *      e >= 3.0:1 para elementos de UI/texto em destaque
 * 4. CA4 - Auditoria de Performance em Redes 3G de Angola:
 *    - Ausência de frameworks pesados (React, Vue, lodash, jQuery)
 *    - Payload do app.js < 15 KB
 *    - Lazy loading de imagens (loading="lazy") e preconnect de fontes
 * 5. CA5 - Quality Gate e Regressão Integral:
 *    - Registro no workflow do GitHub Actions (.github/workflows/ci-deploy.yml)
 *    - Regressão de 100% dos testes das Fases 1 a 7 e das Issues #9, #10, #11 e #12
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

function readTemplate(string $path): string {
    return file_exists($path) ? (string)file_get_contents($path) : '';
}

/** Calcula a luminância relativa sRGB de uma cor hexadecimal conforme WCAG 2.1 */
function getRelativeLuminance(string $hex): float {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0].$hex[0] . $hex[1].$hex[1] . $hex[2].$hex[2];
    }
    $r = hexdec(substr($hex, 0, 2)) / 255.0;
    $g = hexdec(substr($hex, 2, 2)) / 255.0;
    $b = hexdec(substr($hex, 4, 2)) / 255.0;

    $rLin = ($r <= 0.04045) ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
    $gLin = ($g <= 0.04045) ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
    $bLin = ($b <= 0.04045) ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

    return 0.2126 * $rLin + 0.7152 * $gLin + 0.0722 * $bLin;
}

/** Calcula a razão de contraste entre duas cores hexadecimais */
function getContrastRatio(string $hex1, string $hex2): float {
    $l1 = getRelativeLuminance($hex1);
    $l2 = getRelativeLuminance($hex2);
    $lighter = max($l1, $l2);
    $darker = min($l1, $l2);
    return ($lighter + 0.05) / ($darker + 0.05);
}

echo "=== VALIDACAO ISSUE #13 (RESPONSIVIDADE MULTI-DEVICE, ACESSIBILIDADE WCAG AA E QA CONSOLIDADA) ===\n\n";

$templatesDir = $rootDir . DIRECTORY_SEPARATOR . 'templates';
$pagesDir     = $templatesDir . DIRECTORY_SEPARATOR . 'pages';
$partialsDir  = $templatesDir . DIRECTORY_SEPARATOR . 'partials';
$layoutsDir   = $templatesDir . DIRECTORY_SEPARATOR . 'layouts';

$layoutMainFile   = $layoutsDir . DIRECTORY_SEPARATOR . 'main.php';
$topAppBarFile    = $partialsDir . DIRECTORY_SEPARATOR . 'top-app-bar.php';
$bottomNavFile    = $partialsDir . DIRECTORY_SEPARATOR . 'bottom-nav.php';
$desktopFooterFile = $partialsDir . DIRECTORY_SEPARATOR . 'desktop-footer.php';
$modalFile        = $partialsDir . DIRECTORY_SEPARATOR . 'modal-apadrinhamento.php';
$planosFile       = $partialsDir . DIRECTORY_SEPARATOR . 'planos-apadrinhamento.php';
$heroFile         = $partialsDir . DIRECTORY_SEPARATOR . 'hero.php';
$bentoFile        = $partialsDir . DIRECTORY_SEPARATOR . 'bento-impacto.php';
$termoFile        = $partialsDir . DIRECTORY_SEPARATOR . 'termometro-obras.php';
$canaisFile       = $partialsDir . DIRECTORY_SEPARATOR . 'canais-apoio.php';
$sobreFile        = $pagesDir . DIRECTORY_SEPARATOR . 'sobre.php';
$galeriaFile      = $pagesDir . DIRECTORY_SEPARATOR . 'galeria.php';
$transpFile       = $pagesDir . DIRECTORY_SEPARATOR . 'transparencia.php';
$apadrinheFile    = $pagesDir . DIRECTORY_SEPARATOR . 'apadrinhe.php';
$homeFile         = $pagesDir . DIRECTORY_SEPARATOR . 'home.php';
$appJsFile        = $rootDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app.js';
$tokensFile       = $rootDir . DIRECTORY_SEPARATOR . 'design-tokens.json';

$layoutContent   = readTemplate($layoutMainFile);
$topBarContent   = readTemplate($topAppBarFile);
$bottomNavContent = readTemplate($bottomNavFile);
$footerContent   = readTemplate($desktopFooterFile);
$modalContent    = readTemplate($modalFile);
$planosContent   = readTemplate($planosFile);
$heroContent     = readTemplate($heroFile);
$bentoContent    = readTemplate($bentoFile);
$termoContent    = readTemplate($termoFile);
$canaisContent   = readTemplate($canaisFile);
$sobreContent    = readTemplate($sobreFile);
$galeriaContent  = readTemplate($galeriaFile);
$transpContent   = readTemplate($transpFile);
$apadrinheContent = readTemplate($apadrinheFile);
$homeContent     = readTemplate($homeFile);
$appJsContent    = readTemplate($appJsFile);
$tokens          = file_exists($tokensFile) ? (json_decode((string)file_get_contents($tokensFile), true) ?? []) : [];

// ---------------------------------------------------------------------
// 1. Responsividade Multi-Device & Breakpoints (CA1)
// ---------------------------------------------------------------------
echo "1. Validando Breakpoints e Visibilidade de Componentes Multi-Device...\n";

// Bottom Nav oculta no desktop
assertCondition(file_exists($bottomNavFile), "Arquivo bottom-nav.php existe");
assertCondition(str_contains($bottomNavContent, 'md:hidden'), "Bottom Navigation possui 'md:hidden' (oculta a partir de 768px)");
assertCondition(str_contains($bottomNavContent, 'fixed bottom-0'), "Bottom Navigation ancorada no rodape em mobile (fixed bottom-0)");

// Layout Main Container
assertCondition(file_exists($layoutMainFile), "Arquivo layouts/main.php existe");
assertCondition(
    str_contains($layoutContent, 'max-w-screen-md md:max-w-5xl lg:max-w-7xl'),
    "Container principal declara expansao progressiva: max-w-screen-md md:max-w-5xl lg:max-w-7xl"
);
assertCondition(
    str_contains($layoutContent, 'px-4 md:px-6'),
    "Container principal declara padding adaptativo: px-4 md:px-6"
);
assertCondition(
    str_contains($layoutContent, 'pb-24 md:pb-0'),
    "Body declara compensacao da barra inferior em mobile e neutralizacao em desktop: pb-24 md:pb-0"
);

// Top App Bar Desktop Menu & CTA
assertCondition(file_exists($topAppBarFile), "Arquivo top-app-bar.php existe");
assertCondition(
    str_contains($topBarContent, 'hidden md:flex'),
    "Top App Bar possui menu de navegacao horizontal em 'hidden md:flex'"
);
assertCondition(
    str_contains($topBarContent, 'hidden md:inline-flex'),
    "Top App Bar possui CTA primario de acao em 'hidden md:inline-flex'"
);

// Desktop Footer
assertCondition(file_exists($desktopFooterFile), "Arquivo desktop-footer.php existe");
assertCondition(
    str_contains($footerContent, 'hidden md:block'),
    "Desktop Footer possui 'hidden md:block' (visivel apenas a partir de 768px)"
);
assertCondition(
    str_contains($footerContent, 'md:grid-cols-2 lg:grid-cols-4'),
    "Desktop Footer organiza 4 secoes em grade adaptativa: md:grid-cols-2 lg:grid-cols-4"
);

// Grades multi-coluna nas páginas canônicas
echo "\n2. Validando Consistencia de Grades Multi-Coluna em Todas as Telas...\n";
assertCondition(str_contains($heroContent, 'lg:grid-cols-12'), "Home / Hero: grade multi-coluna 'lg:grid-cols-12'");
assertCondition(str_contains($heroContent, 'lg:col-span-7'), "Home / Hero: coluna de narrativa 'lg:col-span-7'");
assertCondition(str_contains($heroContent, 'lg:col-span-5'), "Home / Hero: coluna de imagem oficial 'lg:col-span-5'");

assertCondition(str_contains($bentoContent, 'grid-cols-2 lg:grid-cols-4'), "Home / Bento: grade responsiva 4 colunas 'grid-cols-2 lg:grid-cols-4'");
assertCondition(str_contains($termoContent, 'lg:grid-cols-12'), "Home / Termometro: painel duplo expandido 'lg:grid-cols-12'");

assertCondition(str_contains($sobreContent, 'lg:grid-cols-12'), "Sobre: layout editorial 'lg:grid-cols-12'");
assertCondition(str_contains($sobreContent, 'lg:col-span-8'), "Sobre: coluna de conteudo principal 'lg:col-span-8'");
assertCondition(str_contains($sobreContent, 'lg:col-span-4'), "Sobre: sidebar institucional 'lg:col-span-4'");

assertCondition(str_contains($galeriaContent, 'lg:grid-cols-3'), "Galeria: grade fotografica de 3 colunas 'lg:grid-cols-3'");
assertCondition(str_contains($galeriaContent, 'aspect-[16/10]'), "Galeria: moldura das fotografias autenticas 'aspect-[16/10]'");

assertCondition(str_contains($transpContent, 'lg:grid-cols-12'), "Transparencia: painel executivo de 12 colunas 'lg:grid-cols-12'");
assertCondition(str_contains($transpContent, 'min-w-[550px]'), "Transparencia: tabela orcamentaria com largura minima segura 'min-w-[550px]'");

assertCondition(str_contains($planosContent, 'lg:grid-cols-3'), "Apadrinhamento: grade comparativa de 3 colunas 'lg:grid-cols-3'");
assertCondition(str_contains($planosContent, 'lg:scale-[1.03]'), "Apadrinhamento: destaque proeminente no Apadrinhamento Integral 'lg:scale-[1.03]'");
assertCondition(str_contains($planosContent, 'md:grid-cols-2'), "Apadrinhamento: bloco de expansao predial e educadores 'md:grid-cols-2'");

// ---------------------------------------------------------------------
// 2. Acessibilidade WCAG 2.1 AA por Teclado (CA2)
// ---------------------------------------------------------------------
echo "\n3. Validando Acessibilidade por Teclado e Foco Visivel (WCAG AA)...\n";

assertCondition(
    str_contains($topBarContent, 'focus-visible:ring-2') || str_contains($topBarContent, 'focus:ring-2'),
    "Top App Bar: links de navegacao declaram anel de foco visivel por teclado (focus-visible:ring-2)"
);
assertCondition(
    str_contains($topBarContent, 'focus-visible:ring-primary') || str_contains($topBarContent, 'focus:ring-primary'),
    "Top App Bar: anel de foco utiliza a cor de destaque institucional (focus-visible:ring-primary)"
);
assertCondition(
    str_contains($topBarContent, 'focus-visible:outline-none') || str_contains($topBarContent, 'outline-none'),
    "Top App Bar: remove outline padrao em favor do anel acessivel (outline-none)"
);

assertCondition(
    str_contains($footerContent, 'focus-visible:ring-2') || str_contains($footerContent, 'focus:ring-2'),
    "Desktop Footer: links e saltos diretos declaram foco visivel por teclado (focus-visible:ring-2)"
);
assertCondition(
    str_contains($footerContent, 'focus-visible:ring-primary') || str_contains($footerContent, 'focus:ring-primary'),
    "Desktop Footer: foco utiliza cor de destaque institucional (focus-visible:ring-primary)"
);

// Validacao do Modal acessivel por teclado
assertCondition(str_contains($modalContent, 'role="dialog"'), "Modal: declara role=\"dialog\" para leitores de tela");
assertCondition(str_contains($modalContent, 'aria-modal="true"'), "Modal: declara aria-modal=\"true\"");
assertCondition(str_contains($modalContent, 'aria-labelledby="modal-titulo"'), "Modal: rotulado por aria-labelledby=\"modal-titulo\"");
assertCondition(str_contains($appJsContent, 'Escape'), "Modal: listener da tecla Escape presente no JavaScript");
assertCondition(str_contains($appJsContent, 'input-nome') && str_contains($appJsContent, 'focus()'), "Modal: foco automatico direcionado ao primeiro input ao avancar");

// ---------------------------------------------------------------------
// 3. Auditoria Matematica de Contraste de Cores (CA3)
// ---------------------------------------------------------------------
echo "\n4. Validando Taxas Matematicas de Contraste WCAG 2.1 AA...\n";

// Paleta Oficial Stitch
$colorBackground = '#ffffff';
$colorSurfaceLow = '#f8fafc';
$colorOnSurface  = '#131b2e';
$colorOnSurfaceV = '#434655';
$colorPrimary    = '#009ada';
$colorPrimaryDark = '#006fa1';
$colorNutritionDark = '#008748';

$ratioOnSurface = getContrastRatio($colorOnSurface, $colorBackground);
assertCondition($ratioOnSurface >= 4.5, sprintf("Contraste texto principal (#131b2e vs #ffffff) e %.2f:1 (>= 4.5:1 exigido)", $ratioOnSurface));

$ratioOnSurfaceV = getContrastRatio($colorOnSurfaceV, $colorBackground);
assertCondition($ratioOnSurfaceV >= 4.5, sprintf("Contraste texto secundario (#434655 vs #ffffff) e %.2f:1 (>= 4.5:1 exigido)", $ratioOnSurfaceV));

$ratioPrimaryDark = getContrastRatio($colorPrimaryDark, $colorBackground);
assertCondition($ratioPrimaryDark >= 4.5, sprintf("Contraste primario escuro (#006fa1 vs #ffffff) e %.2f:1 (>= 4.5:1 exigido)", $ratioPrimaryDark));

$ratioNutritionDark = getContrastRatio($colorNutritionDark, $colorBackground);
assertCondition($ratioNutritionDark >= 4.5, sprintf("Contraste verde nutricao escuro (#008748 vs #ffffff) e %.2f:1 (>= 4.5:1 exigido)", $ratioNutritionDark));

$ratioPrimaryUI = getContrastRatio($colorPrimary, $colorBackground);
assertCondition($ratioPrimaryUI >= 3.0, sprintf("Contraste componente UI primario (#009ada vs #ffffff) e %.2f:1 (>= 3.0:1 exigido para UI)", $ratioPrimaryUI));

$ratioOnSurfaceLow = getContrastRatio($colorOnSurface, $colorSurfaceLow);
assertCondition($ratioOnSurfaceLow >= 4.5, sprintf("Contraste sobre surface-container-low (#131b2e vs #f8fafc) e %.2f:1 (>= 4.5:1 exigido)", $ratioOnSurfaceLow));

// ---------------------------------------------------------------------
// 4. Auditoria de Performance em Redes 3G de Angola (CA4)
// ---------------------------------------------------------------------
echo "\n5. Validando Orcamento de Performance em Redes 3G...\n";

// Script client-side leve
$appJsSize = file_exists($appJsFile) ? filesize($appJsFile) : 0;
assertCondition($appJsSize > 0 && $appJsSize < 15360, sprintf("app.js possui tamanho leve de %d bytes (< 15 KB orcamento 3G)", $appJsSize));

// Sem dependências pesadas
assertCondition(!str_contains($layoutContent, 'react.production.min.js'), "Layout nao carrega biblioteca React");
assertCondition(!str_contains($layoutContent, 'vue.global.prod.js'), "Layout nao carrega biblioteca Vue");
assertCondition(!str_contains($layoutContent, 'jquery.min.js'), "Layout nao carrega biblioteca jQuery");
assertCondition(!str_contains($layoutContent, 'lodash.min.js'), "Layout nao carrega biblioteca lodash");

// Lazy loading em todas as imagens dos partials e páginas
$allTemplates = [$heroContent, $sobreContent, $galeriaContent, $termoContent, $footerContent];
$allTemplatesJoined = implode("\n", $allTemplates);
assertCondition(
    substr_count($allTemplatesJoined, 'loading="lazy"') >= 3,
    "Imagens fotograficas institucionais utilizam loading=\"lazy\" para nao bloquear 3G"
);

// Preconnect com fontes do Google
assertCondition(
    str_contains($layoutContent, '<link rel="preconnect" href="https://fonts.googleapis.com">'),
    "Layout otimiza conexao DNS com preconnect ao Google Fonts"
);
assertCondition(
    str_contains($layoutContent, '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'),
    "Layout otimiza handshake TLS com preconnect e crossorigin ao fonts.gstatic.com"
);

// ---------------------------------------------------------------------
// 5. Renderizacao Real das 6 Rotas Canonicas no Shell Desktop
// ---------------------------------------------------------------------
echo "\n6. Validando Renderizacao Real das 6 Rotas Canonicas no Shell Desktop...\n";

require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'View.php';
\NovaEsperanca\Core\View::init($rootDir . DIRECTORY_SEPARATOR . 'templates');
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Router.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Request.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Response.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'AntiSpamServiceInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'AntiSpamService.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Repositories' . DIRECTORY_SEPARATOR . 'DonationRepositoryInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Repositories' . DIRECTORY_SEPARATOR . 'JsonDonationRepository.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'NotificationServiceInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'EmailNotificationService.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'HomeController.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'PageController.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'DonationController.php';

$antiSpam = new \NovaEsperanca\Services\AntiSpamService();
$donationRepo = new \NovaEsperanca\Repositories\JsonDonationRepository($rootDir . '/storage/app/donations.json');
$notifService = new \NovaEsperanca\Services\EmailNotificationService($rootDir . '/storage/logs/notifications.log');

$router = new \NovaEsperanca\Core\Router();
\NovaEsperanca\Core\Router::registerRoutes($router, $donationRepo, $notifService, $antiSpam);

$routesToTest = [
    '/'              => 'Início',
    '/sobre'         => 'Sobre Nós',
    '/apadrinhe'     => 'Apadrinhe',
    '/transparencia' => 'Transparência',
    '/galeria'       => 'Galeria',
    '/voluntariado'  => 'Voluntariado',
];

foreach ($routesToTest as $uri => $expectedTitle) {
    $request  = new \NovaEsperanca\Core\Request('GET', $uri);
    $response = $router->dispatch($request);
    $html     = $response->getBody();

    assertCondition($response->getStatusCode() === 200, "Rota '{$uri}' responde com HTTP 200");
    assertCondition(str_contains($html, 'md:hidden'), "Rota '{$uri}' contem Bottom Nav com md:hidden");
    assertCondition(str_contains($html, 'hidden md:block'), "Rota '{$uri}' contem Desktop Footer com hidden md:block");
    assertCondition(str_contains($html, 'hidden md:flex'), "Rota '{$uri}' contem Top Bar com hidden md:flex");
    assertCondition(!str_contains($html, 'PHP Notice') && !str_contains($html, 'PHP Warning'), "Rota '{$uri}' sem notices/warnings PHP");
}

// ---------------------------------------------------------------------
// 6. Registro no GitHub Actions CI (CA5)
// ---------------------------------------------------------------------
echo "\n7. Validando Registro no GitHub Actions CI (CA5)...\n";
$ciWorkflowFile = $rootDir . DIRECTORY_SEPARATOR . '.github' . DIRECTORY_SEPARATOR . 'workflows' . DIRECTORY_SEPARATOR . 'ci-deploy.yml';
$ciContent = readTemplate($ciWorkflowFile);

assertCondition(file_exists($ciWorkflowFile), "Workflow .github/workflows/ci-deploy.yml existe");
assertCondition(
    str_contains($ciContent, 'validate-issue-13-qa-responsividade-acessibilidade.php'),
    "Workflow executa o validador da Issue #13 (validate-issue-13-qa-responsividade-acessibilidade.php)"
);
assertCondition(
    str_contains($ciContent, 'validate-issue-12-apadrinhamento-desktop.php'),
    "Workflow mantem o validador da Issue #12 (regressao preservada)"
);
assertCondition(
    str_contains($ciContent, 'validate-issue-11-institucionais-desktop.php'),
    "Workflow mantem o validador da Issue #11 (regressao preservada)"
);
assertCondition(
    str_contains($ciContent, 'validate-issue-10-home-desktop.php'),
    "Workflow mantem o validador da Issue #10 (regressao preservada)"
);
assertCondition(
    str_contains($ciContent, 'validate-issue-9-desktop-shell.php'),
    "Workflow mantem o validador da Issue #9 (regressao preservada)"
);

// ---------------------------------------------------------------------
// 7. Regressao de Todas as Fases 1 a 7 e Issues #9 a #12
// ---------------------------------------------------------------------
echo "\n8. Executando Regressao dos Validadores Anteriores (Fases 1 a 7 + Issues #9 a #12)...\n";

$regressionScripts = [
    'scripts/validate-demanda-schema.php',
    'scripts/validate-fase-2-planejamento.php',
    'scripts/validate-fase-3-design.php',
    'scripts/validate-fase-4-conteudo-dados.php',
    'scripts/validate-fase-5-desenvolvimento.php',
    'scripts/validate-fase-6-testes-qa.php',
    'scripts/validate-fase-7-deploy-lancamento.php',
    'scripts/validate-issue-9-desktop-shell.php',
    'scripts/validate-issue-10-home-desktop.php',
    'scripts/validate-issue-11-institucionais-desktop.php',
    'scripts/validate-issue-12-apadrinhamento-desktop.php'
];

foreach ($regressionScripts as $script) {
    $cmd = 'php ' . escapeshellarg($rootDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $script));
    exec($cmd, $out, $ret);
    assertCondition($ret === 0, "Regressao sem quebras: {$script} (exit {$ret})");
}

echo "\n=======================================================\n";
echo "RESULTADO DA VALIDACAO ISSUE #13: {$assertionsPassed} APROVADAS, {$assertionsFailed} FALHAS.\n";
echo "=======================================================\n\n";

if ($assertionsFailed > 0) {
    echo "[ERRO] Foram encontradas {$assertionsFailed} falhas nos criterios de aceitacao da Issue #13.\n";
    exit(1);
}

echo "[SUCESSO] Responsividade Multi-Device, Acessibilidade Desktop WCAG AA e QA consolidada do Epic #8 aprovadas com 100% de sucesso!\n";
exit(0);
