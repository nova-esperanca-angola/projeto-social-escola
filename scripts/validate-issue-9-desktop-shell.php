<?php
declare(strict_types=1);

/**
 * Validador Automatizado - Issue #9 (Desktop Shell Responsivo, Header Completo e Rodapé Institucional)
 *
 * Verifica os critérios de aceitação da Issue #9:
 * 1. Expansão responsiva progressiva do container em templates/layouts/main.php até max-w-7xl.
 * 2. Top App Bar com container max-w-7xl, menu horizontal (hidden md:flex) com as 6 rotas canônicas,
 *    indicador dinâmico de rota ativa e CTA "Apadrinhar Agora" ligado ao modal de apadrinhamento.
 * 3. Partial templates/partials/desktop-footer.php com os 4 eixos: Identidade/Kifangondo,
 *    Contas Bancárias (MCX/Atlântico/BCI), Salvaguarda Infantil (Lei nº 25/12) e Navegação/WhatsApp.
 * 4. Bottom Navigation oculta em >= 768px (md:hidden) e body sem padding fantasma no desktop.
 * 5. Renderização real do layout sem warnings de PHP e com fallback seguro de $currentRoute.
 * 6. Registro do validador no pipeline de CI (GitHub Actions).
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

echo "=== VALIDACAO ISSUE #9 (DESKTOP SHELL, HEADER COMPLETO E RODAPE INSTITUCIONAL) ===\n\n";

$layoutFile   = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'layouts'  . DIRECTORY_SEPARATOR . 'main.php';
$topBarFile   = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'top-app-bar.php';
$bottomNavFile= $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'bottom-nav.php';
$footerFile   = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'desktop-footer.php';

$layoutContent    = readTemplate($layoutFile);
$topBarContent    = readTemplate($topBarFile);
$bottomNavContent = readTemplate($bottomNavFile);
$footerContent    = readTemplate($footerFile);

// -------------------------------------------------------------
// 1. Shell Responsivo Progressivo no Layout Principal
// -------------------------------------------------------------
echo "1. Validando Shell Responsivo Progressivo em templates/layouts/main.php...\n";

assertCondition(file_exists($layoutFile), "Arquivo templates/layouts/main.php existe");
if ($layoutFile !== '' && $layoutContent !== '') {
    assertCondition(
        str_contains($layoutContent, 'max-w-screen-md md:max-w-5xl lg:max-w-7xl'),
        "Container principal expande progressivamente (max-w-screen-md md:max-w-5xl lg:max-w-7xl)"
    );
    assertCondition(preg_match('/<main[^>]*class="[^"]*mx-auto[^"]*"/', $layoutContent) === 1, "Container principal (<main>) permanece centralizado com mx-auto");
    assertCondition(preg_match('/<body[^>]*class="[^"]*pb-24 md:pb-0[^"]*"/', $layoutContent) === 1, "Body aplica 'pb-24 md:pb-0' (sem padding fantasma no desktop)");
    assertCondition(str_contains($layoutContent, "View::partial('desktop-footer'"), "Layout inclui o partial 'desktop-footer'");
    assertCondition(str_contains($layoutContent, "View::partial('top-app-bar'"), "Layout inclui o partial 'top-app-bar'");
    assertCondition(str_contains($layoutContent, "View::partial('bottom-nav'"), "Layout inclui o partial 'bottom-nav'");
    assertCondition(str_contains($layoutContent, "View::partial('modal-apadrinhamento'"), "Layout inclui o partial 'modal-apadrinhamento'");
}

// -------------------------------------------------------------
// 2. Top App Bar Desktop: Container, Menu de 6 Rotas, Rota Ativa e CTA
// -------------------------------------------------------------
echo "\n2. Validando Top App Bar Desktop com Menu Completo e CTA...\n";

assertCondition(file_exists($topBarFile), "Arquivo templates/partials/top-app-bar.php existe");
if ($topBarFile !== '' && $topBarContent !== '') {
    assertCondition(
        str_contains($topBarContent, 'max-w-screen-md md:max-w-5xl lg:max-w-7xl'),
        "Container da Top App Bar expande progressivamente até max-w-7xl"
    );
    assertCondition(str_contains($topBarContent, 'hidden md:flex'), "Navegação horizontal desktop utilizing 'hidden md:flex'");
    assertCondition(str_contains($topBarContent, 'Impacto Verificado'), "Badge 'Impacto Verificado' preservado na Top App Bar");
    assertCondition(str_contains($topBarContent, 'Kifangondo, Sequele'), "Contexto territorial 'Kifangondo, Sequele' preservado");
    assertCondition(str_contains($topBarContent, 'logo.jpeg'), "Logotipo oficial preservado na Top App Bar");
    assertCondition(str_contains($topBarContent, "\$currentRoute = \$currentRoute ?? '/'"), "Fallback seguro de rota: \$currentRoute = \$currentRoute ?? '/'");

    // Estrutura do array de navegação com as 6 rotas canônicas
    assertCondition(str_contains($topBarContent, "\$navLinks = ["), "Array \$navLinks de navegação desktop declarado");
    $canonicalRoutes = [
        '/'            => 'Início',
        '/sobre'       => 'Sobre Nós',
        '/apadrinhe'   => 'Apadrinhe',
        '/transparencia' => 'Transparência',
        '/galeria'     => 'Galeria',
        '/voluntariado'=> 'Voluntariado',
    ];
    foreach ($canonicalRoutes as $route => $label) {
        $hasRoute = str_contains($topBarContent, "'href' => '{$route}'") || str_contains($topBarContent, "\"href\" => \"{$route}\"");
        assertCondition($hasRoute, "Menu desktop contém a rota canônica '{$route}'");
        assertCondition(str_contains($topBarContent, "'label' => '{$label}'"), "Menu desktop contém o rótulo '{$label}'");
    }
    assertCondition(substr_count($topBarContent, "'href' => '/") >= 6, "Menu desktop declara no mínimo 6 links de navegação");

    // Indicador de rota ativa + CTA primário
    assertCondition(str_contains($topBarContent, "\$currentRoute === \$link['href']"), "Indicador de rota ativa dinâmico (\$currentRoute === \$link['href'])");
    assertCondition(str_contains($topBarContent, 'text-primary font-bold border-b-2 border-primary bg-primary/5'), "Estilo Stitch aplicado ao link ativo (border-b-2 border-primary bg-primary/5)");
    assertCondition(str_contains($topBarContent, 'hover:text-primary transition-colors font-medium'), "Estilo Stitch aplicado ao link inativo (hover:text-primary)");
    assertCondition(str_contains($topBarContent, 'Apadrinhar Agora'), "CTA 'Apadrinhar Agora' presente na Top App Bar");
    assertCondition(
        str_contains($topBarContent, "abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral')"),
        "CTA dispara abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral')"
    );
    assertCondition(str_contains($topBarContent, 'bg-primary hover:bg-primary-dark text-white font-bold'), "CTA com estilo Stitch (bg-primary hover:bg-primary-dark)");
    assertCondition(str_contains($topBarContent, 'gap-1 lg:gap-3'), "Menu desktop usa gap responsivo (gap-1 lg:gap-3) para caber em 768px-1024px");
    assertCondition(str_contains($topBarContent, 'text-xs lg:text-sm'), "Menu desktop usa tipografia responsiva (text-xs lg:text-sm)");
}

// -------------------------------------------------------------
// 3. Rodapé Institucional (desktop-footer.php)
// -------------------------------------------------------------
echo "\n3. Validando Rodape Institucional (desktop-footer.php)...\n";

assertCondition(file_exists($footerFile), "Arquivo templates/partials/desktop-footer.php existe");
if ($footerContent !== '') {
    require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'View.php';
    \NovaEsperanca\Core\View::init($rootDir . DIRECTORY_SEPARATOR . 'templates');
    $footerHtml = \NovaEsperanca\Core\View::partial('desktop-footer', ['currentRoute' => '/sobre']);
    assertCondition(!str_contains($footerHtml, 'não encontrada'), "desktop-footer.php renderiza sem graceful fallback do View::partial()");

    // Eixo 1 - Identidade & Missão
    assertCondition(str_contains($footerContent, 'logo.jpeg'), "Coluna 1: logotipo oficial renderizado");
    assertCondition(str_contains($footerContent, 'Kifangondo'), "Coluna 1: menção territorial Kifangondo");
    assertCondition(str_contains($footerContent, 'Igreja Missionária Nova Esperança') || str_contains($footerContent, 'IMNE'), "Coluna 1: manutenção pela IMNE declarada");
    assertCondition(str_contains($footerContent, '93'), "Coluna 1: contexto dos 93 alunos registrado");

    // Eixo 2 - Mapa de Navegação Institucional
    foreach (array_keys($canonicalRoutes) as $route) {
        assertCondition(str_contains($footerHtml, "href=\"{$route}\""), "Coluna 2: link institucional para '{$route}'");
    }
    assertCondition(str_contains($footerHtml, 'href="/#termometro-obras"'), "Coluna 2: âncora para o Termômetro de Obras");
    assertCondition(str_contains($footerHtml, 'href="/#bento-impacto"'), "Coluna 2: âncora para o Bento Grid de impacto");
    assertCondition(str_contains($footerHtml, 'href="/transparencia#prestacao-contas"'), "Coluna 2: âncora para a Prestação de Contas");

    // Eixo 3 - Canais Bancários & Doadores Internacionais
    assertCondition(str_contains($footerContent, '9305-61688'), "Coluna 3: Multicaixa Express 9305-61688 presente");
    assertCondition(str_contains($footerContent, 'Banco Atlântico'), "Coluna 3: Banco Atlântico presente");
    assertCondition(str_contains($footerContent, '0005-0000-5089-22202-1014-6'), "Coluna 3: IBAN do Banco Atlântico fidedigno");
    assertCondition(str_contains($footerContent, 'Banco BCI'), "Coluna 3: Banco BCI presente");
    assertCondition(str_contains($footerContent, '0005-0000-6972-1564-1019-7'), "Coluna 3: IBAN do Banco BCI fidedigno");
    assertCondition(str_contains($footerContent, 'USD') && str_contains($footerContent, 'Kz'), "Coluna 3: instruções para doadores internacionais (Kz / USD)");
    assertCondition(str_contains($footerContent, 'Igreja Missionária Nova Esperança - Escola'), "Coluna 3: titular da conta bancária declarado");

    // Eixo 4 - Salvaguarda Infantil & Marco Legal
    assertCondition(str_contains($footerContent, 'Lei nº 25/12') || str_contains($footerContent, 'Lei n.º 25/12') || str_contains($footerContent, 'Lei 25/12'), "Coluna 4: cita a Lei nº 25/12 de Angola");
    assertCondition(str_contains($footerContent, 'República de Angola'), "Coluna 4: referencie a República de Angola");
    assertCondition(stripos($footerContent, 'nomes completos') !== false, "Coluna 4: proibição explícita de nomes completos de menores");
    assertCondition(stripos($footerContent, '93 alunos') !== false || stripos($footerContent, '93 crianças') !== false, "Coluna 4: protege a intimidade dos 93 alunos");

    // Barra inferior do rodapé
    assertCondition(str_contains($footerContent, '+244 930 561 688'), "Barra inferior: WhatsApp da Coordenação (+244 930 561 688)");
    assertCondition(str_contains($footerContent, 'https://wa.me/244930561688'), "Barra inferior: link direto de WhatsApp (wa.me/244930561688)");
    assertCondition(str_contains($footerContent, 'Todos os direitos reservados') || str_contains($footerContent, 'Direitos Reservados'), "Barra inferior: copyrights reservados à IMNE");

    // Estrutura de classes contratuais
    assertCondition(
        str_contains($footerContent, 'class="hidden md:block bg-surface-container border-t border-outline-variant/40 mt-16 text-on-surface"'),
        "Container raiz do rodapé usa as classes contratuais do Stitch (hidden md:block bg-surface-container ...)"
    );
    assertCondition(
        str_contains($footerContent, 'class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8"'),
        "Container interno do rodapé usa grid responsivo de 4 colunas (max-w-7xl ... lg:grid-cols-4)"
    );
    assertCondition(str_contains($footerContent, '$currentRoute = $currentRoute'), "Rodapé possui fallback seguro para \$currentRoute");
}

// -------------------------------------------------------------
// 4. Ocultação da Bottom Navigation e Espaçamento do Body
// -------------------------------------------------------------
echo "\n4. Validando Ocultacao da Bottom Navigation em Desktop...\n";

assertCondition(file_exists($bottomNavFile), "Arquivo templates/partials/bottom-nav.php existe");
if ($bottomNavFile !== '' && $bottomNavContent !== '') {
    assertCondition(preg_match('/<nav[^>]*class="[^"]*md:hidden[^"]*"/', $bottomNavContent) === 1, "Bottom Nav permanece oculta em viewports >= 768px (md:hidden)");
    assertCondition(str_contains($bottomNavContent, "fixed bottom-0"), "Bottom Nav continua fixa no mobile (fixed bottom-0)");
}

// -------------------------------------------------------------
// 5. Renderização Real do Layout (Smoke Test de Shell)
// -------------------------------------------------------------
echo "\n5. Renderizando o Shell Real para Validacao de Integridade...\n";

require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'View.php';
\NovaEsperanca\Core\View::init($rootDir . DIRECTORY_SEPARATOR . 'templates');

$renderShell = function (string $currentRoute) use ($layoutFile, $rootDir): string {
    $content = '<section data-test="conteudo"></section>';
    $pageTitle = 'Teste de Shell Desktop';
    $currentRoute = $currentRoute;
    ob_start();
    require $layoutFile;
    return (string)ob_get_clean();
};

$phpWarnings = [];
set_error_handler(static function (int $severity, string $message) use (&$phpWarnings): bool {
    $phpWarnings[] = $message;
    return true;
});

$htmlHome = $renderShell('/');
$htmlPage = $renderShell('/transparencia');
$htmlUnknown = $renderShell('/rota-inexistente-404');
restore_error_handler();

assertCondition(count($phpWarnings) === 0, "Renderização do layout não emite warnings/notices de PHP (rotas: '/', '/transparencia' e 404)");
if (count($phpWarnings) > 0) {
    echo "         Avisos: " . implode(' | ', $phpWarnings) . "\n";
}

assertCondition(str_contains($htmlHome, '<footer') && str_contains($htmlHome, 'hidden md:block bg-surface-container'), "HTML renderizado contém o rodapé institucional");
assertCondition(str_contains($htmlHome, 'max-w-7xl'), "HTML renderizado utiliza o container max-w-7xl");
assertCondition(str_contains($htmlHome, 'pb-24 md:pb-0'), "HTML renderizado aplica pb-24 md:pb-0 no body");
assertCondition(substr_count($htmlHome, 'href="/galeria"') >= 1, "HTML renderizado expõe a rota /galeria na navegação");
assertCondition(substr_count($htmlHome, 'href="/voluntariado"') >= 1, "HTML renderizado expõe a rota /voluntariado na navegação");
assertCondition(str_contains($htmlHome, "abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral')"), "HTML renderizado expõe o CTA de apadrinhamento integral");
assertCondition(!str_contains($htmlHome, 'não encontrada'), "Nenhum partial retorna o aviso de graceful fallback do View::partial()");

// Rota ativa: exatamente um link de menu desktop ativo por rota canônica
$countActiveTopBarLinks = function (string $html): int {
    return preg_match_all('/<a[^>]*class="[^"]*border-b-2 border-primary[^"]*"[^>]*>/', $html) ?: 0;
};
assertCondition($countActiveTopBarLinks($htmlHome) === 1, "Rota '/' destaca exatamente 1 item do menu desktop");
assertCondition($countActiveTopBarLinks($htmlPage) === 1, "Rota '/transparencia' destaca exatamente 1 item do menu desktop");
assertCondition($countActiveTopBarLinks($htmlUnknown) === 0, "Rota não-canônica (404) não destaca nenhum item e não gera warning");

// Smoke test das 6 rotas canônicas + 404 através do Router real
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Request.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Response.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Router.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Repositories' . DIRECTORY_SEPARATOR . 'DonationRepositoryInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Repositories' . DIRECTORY_SEPARATOR . 'JsonDonationRepository.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'NotificationServiceInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'EmailNotificationService.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'AntiSpamServiceInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'AntiSpamService.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'HomeController.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'PageController.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'DonationController.php';

$routerWarnings = [];
set_error_handler(static function (int $severity, string $message) use (&$routerWarnings): bool {
    $routerWarnings[] = $message;
    return true;
});

$donationRepo = new \NovaEsperanca\Repositories\JsonDonationRepository($rootDir . '/storage/app/donations.json');
$notifService = new \NovaEsperanca\Services\EmailNotificationService($rootDir . '/storage/logs/notifications.log');
$antiSpam = new \NovaEsperanca\Services\AntiSpamService();

$routeShellOk = true;
foreach (array_keys($canonicalRoutes) as $route) {
    $router = new \NovaEsperanca\Core\Router();
    \NovaEsperanca\Core\Router::registerRoutes($router, $donationRepo, $notifService, $antiSpam);
    $body = $router->dispatch(new \NovaEsperanca\Core\Request('GET', $route))->getBody();
    $hasShell = str_contains($body, '<footer')
        && str_contains($body, 'max-w-7xl')
        && str_contains($body, 'pb-24 md:pb-0')
        && str_contains($body, 'hidden md:flex')
        && !str_contains($body, 'não encontrada');
    if (!$hasShell) {
        $routeShellOk = false;
        echo "         Rota com shell incompleto: {$route}\n";
    }
}
restore_error_handler();

assertCondition($routeShellOk, "As 6 rotas canônicas renderizam o shell desktop completo via Router");
assertCondition(count($routerWarnings) === 0, "Dispatch das rotas não emite warnings/notices de PHP");
if (count($routerWarnings) > 0) {
    echo "         Avisos: " . implode(' | ', $routerWarnings) . "\n";
}

// -------------------------------------------------------------
// 6. Registro do Validador no Pipeline de CI
// -------------------------------------------------------------
echo "\n6. Validando Registro do Validador no GitHub Actions...\n";

$ciWorkflow = $rootDir . DIRECTORY_SEPARATOR . '.github' . DIRECTORY_SEPARATOR . 'workflows' . DIRECTORY_SEPARATOR . 'ci-deploy.yml';
assertCondition(file_exists($ciWorkflow), "Workflow .github/workflows/ci-deploy.yml existe");
if (file_exists($ciWorkflow)) {
    $ciContent = (string)file_get_contents($ciWorkflow);
    assertCondition(str_contains($ciContent, 'validate-issue-9-desktop-shell.php'), "Workflow executa o validador da Issue #9 (validate-issue-9-desktop-shell.php)");
    assertCondition(str_contains($ciContent, 'validate-fase-7-deploy-lancamento.php'), "Workflow mantém o validador da Fase 7 (regressão preservada)");
    assertCondition(str_contains($ciContent, 'validate-demanda-schema.php'), "Workflow mantém o validador da Fase 1 (regressão preservada)");
}

// -------------------------------------------------------------
// 7. Validação de Regressão dos Validadores das Fases 1 a 7
// -------------------------------------------------------------
echo "\n7. Executando Regressao dos Validadores das Fases 1 a 7...\n";

$legacyValidators = [
    'validate-demanda-schema.php',
    'validate-fase-2-planejamento.php',
    'validate-fase-3-design.php',
    'validate-fase-4-conteudo-dados.php',
    'validate-fase-5-desenvolvimento.php',
    'validate-fase-6-testes-qa.php',
    'validate-fase-7-deploy-lancamento.php',
];

foreach ($legacyValidators as $validator) {
    $validatorPath = $rootDir . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . $validator;
    if (!file_exists($validatorPath)) {
        assertCondition(false, "scripts/{$validator} existe");
        continue;
    }
    $output = [];
    $returnVar = 1;
    @exec(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($validatorPath) . ' 2>&1', $output, $returnVar);
    assertCondition($returnVar === 0, "Regressão sem quebras: scripts/{$validator} (exit {$returnVar})");
    if ($returnVar !== 0) {
        foreach (array_slice($output, -8) as $line) {
            echo "         > " . trim((string)$line) . "\n";
        }
    }
}

// -------------------------------------------------------------
// Resumo Final
// -------------------------------------------------------------
echo "\n=======================================================\n";
echo "RESULTADO DA VALIDACAO ISSUE #9: {$assertionsPassed} APROVADAS, {$assertionsFailed} FALHAS.\n";
echo "=======================================================\n";

if ($assertionsFailed > 0) {
    echo "\n[FALHA] Existen criterios pendentes na Issue #9.\n";
    exit(1);
}

echo "\n[SUCESSO] Shell Desktop, Header Completo e Rodape Institucional aprovados com 100% de sucesso!\n";
exit(0);
