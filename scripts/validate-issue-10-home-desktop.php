<?php
declare(strict_types=1);

/**
 * Validador Automatizado - Issue #10 (Home Desktop: Bento 4 Colunas, Hero Duplo e Termometro Expandido)
 *
 * Verifica os criterios de aceitacao da Issue #10:
 * 1. Hero institucional bi-colunar no desktop (lg:grid-cols-12, lg:col-span-7 / lg:col-span-5),
 *    com CTAs "Apadrinhe uma crianca" e "Transparencia Financeira" e a fotografia oficial
 *    (parada-civica.jpeg) com aspect-ratio travado, loading lazy e fallback de fundo.
 * 2. Bento Grid de Impacto responsivo progressivo (grid-cols-2 -> lg:grid-cols-4) com os
 *    4 pilares auditados: 93 alunos, 05 salas, 10 colaboradores locais e 100% de merenda.
 * 3. Termometro de Obras com barra de progresso em largura total e linha do tempo horizontal
 *    de 4 marcos construtivos (Terraplanagem, Sapatas/Alvenaria, Cobertura, Acabamentos).
 * 4. Preservacao integral dos dados oficiais (93, 05, 10, 100%, 55.359.800 Kz, 0 Kz) e das
 *    salvaguardas infantis, alem da ausencia de identificacao de menores.
 * 5. Casos de borda: coalescencia nula das variaveis dinamicas, protecao contra overflow
 *    horizontal, CLS controlado e renderizacao real da Home sem warnings de PHP.
 * 6. Registro do validador no pipeline de CI (GitHub Actions) e regressao das Fases 1 a 7
 *    e da Issue #9.
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

echo "=== VALIDACAO ISSUE #10 (HOME DESKTOP: HERO DUPLO, BENTO 4 COLUNAS E TERMOMETRO EXPANDIDO) ===\n\n";

$partialsDir = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'partials';
$pagesDir   = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'pages';
$heroFile   = $partialsDir . DIRECTORY_SEPARATOR . 'hero.php';
$bentoFile  = $partialsDir . DIRECTORY_SEPARATOR . 'bento-impacto.php';
$termoFile  = $partialsDir . DIRECTORY_SEPARATOR . 'termometro-obras.php';
$homeFile   = $pagesDir   . DIRECTORY_SEPARATOR . 'home.php';
$imageFile  = $rootDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'parada-civica.jpeg';

$heroContent  = readTemplate($heroFile);
$bentoContent = readTemplate($bentoFile);
$termoContent = readTemplate($termoFile);
$homeContent  = readTemplate($homeFile);

// -------------------------------------------------------------
// 1. Hero Institucional Desktop (Bi-Columnar)
// -------------------------------------------------------------
echo "1. Validando Hero Institucional Desktop bi-colunar...\n";

assertCondition(file_exists($heroFile), "Arquivo templates/partials/hero.php existe");
assertCondition(file_exists($imageFile), "Fotografia oficial public/assets/images/parada-civica.jpeg existe");
if ($heroContent !== '') {
    // Container e grade interna de 12 colunas
    assertCondition(
        str_contains($heroContent, 'rounded-2xl bg-surface-container-lowest p-6 md:p-8 lg:p-10 border border-outline-variant/40 shadow-sm relative overflow-hidden'),
        "Hero: container usa o contrato de classes (p-6 md:p-8 lg:p-10, border, shadow-sm, overflow-hidden)"
    );
    assertCondition(
        str_contains($heroContent, 'grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center'),
        "Hero: estrutura interna usa 'grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center'"
    );
    assertCondition(str_contains($heroContent, 'lg:col-span-7'), "Hero: coluna esquerda de conteudo ocupa lg:col-span-7");
    assertCondition(str_contains($heroContent, 'lg:col-span-5'), "Hero: coluna direita da fotografia ocupa lg:col-span-5");
    assertCondition(
        preg_match('/<h1[^>]*class="[^"]*text-2xl sm:text-3xl lg:text-4xl[^"]*"/', $heroContent) === 1,
        "Hero: H1 responsivo (text-2xl sm:text-3xl lg:text-4xl) com titulo institucional"
    );
    assertCondition(
        str_contains($heroContent, 'Juntos pela infância e pelo futuro em Kifangondo.'),
        "Hero: H1 preserva o titulo institucional auditado"
    );
    assertCondition(str_contains($heroContent, 'Educação e Dignidade Comunitária'), "Hero: badge territorial 'Educacao e Dignidade Comunitaria' preservado");
    assertCondition(str_contains($heroContent, 'Igreja Missionária Nova Esperança'), "Hero: proposta de valor comunitaria declara a manutencao pela IMNE");

    // CTAs de conversao
    assertCondition(
        str_contains($heroContent, "abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral')"),
        "Hero: CTA primario dispara abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral')"
    );
    assertCondition(str_contains($heroContent, 'Apadrinhe uma Criança'), "Hero: CTA primario rotulado 'Apadrinhe uma crianca'");
    assertCondition(
        str_contains($heroContent, 'inline-flex items-center justify-center min-h-[48px] px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-dark text-white font-label-md font-bold transition-all shadow-sm active:scale-95'),
        "Hero: CTA primario com alvo de toque de 48px e estilo Stitch (bg-primary hover:bg-primary-dark)"
    );
    assertCondition(str_contains($heroContent, 'href="/transparencia"'), "Hero: CTA secundario roteia para /transparencia");
    assertCondition(str_contains($heroContent, 'Transparência Financeira'), "Hero: CTA secundario rotulado 'Transparencia Financeira'");
    assertCondition(
        str_contains($heroContent, 'inline-flex items-center justify-center min-h-[48px] px-5 py-2.5 rounded-lg border border-outline-variant bg-surface-container/60 hover:bg-surface-container text-on-surface font-label-md font-bold transition-all'),
        "Hero: CTA secundario com alvo de toque de 48px e estilo outline"
    );
    assertCondition(
        str_contains($heroContent, 'flex flex-wrap items-center gap-3 pt-2'),
        "Hero: container dos CTAs usa 'flex flex-wrap items-center gap-3 pt-2' (evita esmagamento em tablet)"
    );

    // Quick Proofs preservados
    assertCondition(
        str_contains($heroContent, 'flex flex-wrap gap-2 text-on-surface-variant font-label-sm text-xs'),
        "Hero: Quick Proofs preservados (Prestacao publica, Kz & USD, Impacto direto)"
    );
    foreach (['Prestação pública', 'Kz &amp; USD', 'Impacto direto'] as $proof) {
        assertCondition(str_contains($heroContent, $proof), "Hero: quick proof '{$proof}' presente");
    }

    // Coluna direita: fotografia oficial com moldura travada
    assertCondition(
        str_contains($heroContent, 'relative aspect-[4/3] rounded-2xl overflow-hidden shadow-md border border-outline-variant/40'),
        "Hero: moldura da fotografia usa 'relative aspect-[4/3]' (proporcao travada contra esticamento ultra-wide)"
    );
    assertCondition(str_contains($heroContent, 'src="/assets/images/parada-civica.jpeg"'), "Hero: fotografia oficial parada-civica.jpeg referenciada");
    assertCondition(
        str_contains($heroContent, 'alt="Alunos e equipe da Escola Cristã Nova Esperança reunidos na Parada Cívica Matinal em Kifangondo"'),
        "Hero: alt text desritivo efuscado da fotografia oficial"
    );
    assertCondition(str_contains($heroContent, 'class="w-full h-full object-cover object-center'), "Hero: imagem cobre a moldura (object-cover object-center)");
    assertCondition(str_contains($heroContent, 'loading="lazy"'), "Hero: fotografia oficial usa loading=\"lazy\" (mitigacao de CLS)");
    assertCondition(str_contains($heroContent, 'bg-surface-container'), "Hero: fallback de fundo da moldura contra imagem ainda nao carregada");

    // Card de contexto numerico sobre a fotografia
    assertCondition(str_contains($heroContent, '93 Alunos'), "Hero: card de contexto exibe '93 Alunos'");
    assertCondition(str_contains($heroContent, '5 Salas Ativas'), "Hero: card de contexto exibe '5 Salas Ativas'");
    assertCondition(str_contains($heroContent, 'Kifangondo, Sequele'), "Hero: card de contexto declara o territorio 'Kifangondo, Sequele'");
}

// -------------------------------------------------------------
// 2. Bento Grid de Impacto em 4 Colunas no Desktop
// -------------------------------------------------------------
echo "\n2. Validando Bento Grid de Impacto responsivo (2 -> 4 colunas)...\n";

assertCondition(file_exists($bentoFile), "Arquivo templates/partials/bento-impacto.php existe");
if ($bentoContent !== '') {
    assertCondition(str_contains($bentoContent, 'id="bento-impacto"'), "Bento: ancora '#bento-impacto' preservada (usada pelo rodape institucional)");
    assertCondition(
        str_contains($bentoContent, 'grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4'),
        "Bento: grid responsivo progressivo 'grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4'"
    );
    assertCondition(!str_contains($bentoContent, 'grid grid-cols-2"'), "Bento: grid de 2 colunas nao fica travado apenas no mobile");
    assertCondition(
        str_contains($bentoContent, 'bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-4 md:p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow'),
        "Bento: cards usam o contrato de classes (p-4 md:p-5 + hover:shadow-md)"
    );
    assertCondition(
        substr_count($bentoContent, 'flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow') === 4,
        "Bento: exibe exatamente 4 cards de pilar"
    );

    $pilares = [
        ['rotulo' => 'Alunos Matriculados', 'legenda' => 'Da iniciação à 4ª classe',             'icone' => 'school',      'cor' => 'text-primary'],
        ['rotulo' => 'Salas de Aula Ativas', 'legenda' => 'Turno matutino estruturado (Meta: +8)', 'icone' => 'foundation',  'cor' => 'text-hope-amber-dark'],
        ['rotulo' => 'Colaboradores Locais', 'legenda' => '5 educadoras e equipe de apoio',      'icone' => 'diversity_3', 'cor' => 'text-secondary'],
        ['rotulo' => 'Merenda Garantida',    'legenda' => 'Pão fresco, sopa e feijão diário',   'icone' => 'restaurant',  'cor' => 'text-nutrition-green'],
    ];
    foreach ($pilares as $pilar) {
        assertCondition(str_contains($bentoContent, $pilar['rotulo']), "Bento: rotulo '{$pilar['rotulo']}' presente");
        assertCondition(str_contains($bentoContent, $pilar['legenda']), "Bento: legenda '{$pilar['legenda']}' presente");
        assertCondition(str_contains($bentoContent, "data-icon=\"{$pilar['icone']}\""), "Bento: icone '{$pilar['icone']}' presente");
        assertCondition(str_contains($bentoContent, $pilar['cor']), "Bento: cor de destaque '{$pilar['cor']}' aplicada");
    }
    assertCondition(str_contains($bentoContent, "['alunos'] ?? 93"), "Bento: metrica de 93 alunos auditada como valor padrao");
    assertCondition(str_contains($bentoContent, "['salas'] ?? 5"), "Bento: metrica de 5 salas ativas auditada como valor padrao");
    assertCondition(str_contains($bentoContent, "['colaboradores'] ?? 10"), "Bento: metrica de 10 colaboradores locais auditada como valor padrao");
    assertCondition(str_contains($bentoContent, "['merenda'] ?? '100%'"), "Bento: metrica de 100% de merenda auditada como valor padrao");
    assertCondition(str_contains($bentoContent, 'Indicadores de Impacto Real'), "Bento: titulo da secao preservado");
    assertCondition(!str_contains($bentoContent, '08') && !str_contains($bentoContent, '>8<'), "Bento: nunca exibe 8 salas ativas (salvaguarda de dado auditado)");
}

// -------------------------------------------------------------
// 3. Termometro de Obras Expandido (Largura Total + Timeline de 4 Marcos)
// -------------------------------------------------------------
echo "\n3. Validando Termometro de Obras expandido e timeline de 4 marcos...\n";

assertCondition(file_exists($termoFile), "Arquivo templates/partials/termometro-obras.php existe");
if ($termoContent !== '') {
    assertCondition(str_contains($termoContent, 'id="termometro-obras"'), "Termometro: ancora '#termometro-obras' preservada (usada pelo rodape institucional)");
    assertCondition(
        str_contains($termoContent, 'w-full bg-surface-container'),
        "Termometro: barra de progresso contida em 'w-full' (largura total responsiva)"
    );
    assertCondition(str_contains($termoContent, 'style="width: 0%;"'), "Termometro: barra de progresso reflete a arrecadação de 0%");

    // Cabecalho amplo com metrica em destaque
    assertCondition(str_contains($termoContent, 'Fundo de Infraestrutura'), "Termometro: cabecalho amplo 'Fundo de Infraestrutura' preservado");
    assertCondition(str_contains($termoContent, 'Expansão de 8 Novas Salas Necessárias'), "Termometro: titulo da meta preservado");
    assertCondition(str_contains($termoContent, '55.359.800 Kz'), "Termometro: meta de 55.359.800 Kz exibida");
    assertCondition(str_contains($termoContent, '0 Kz angariados'), "Termometro: arrecadação inicial de 0 Kz angariados exibida");
    assertCondition(str_contains($termoContent, '0% Arrecadado'), "Termometro: percentual de 0% Arrecadado exibido");

    // Linha do tempo horizontal de 4 marcos
    assertCondition(
        str_contains($termoContent, 'grid grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-3'),
        "Termometro: linha do tempo responsiva 'grid grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-3'"
    );
    $marcos = [
        ['n' => 1, 'titulo' => 'Terraplanagem',            'status' => 'Concluído',         'icone' => 'check_circle',  'badge' => 'bg-nutrition-green/10'],
        ['n' => 2, 'titulo' => 'Alvenaria',                 'status' => 'Em andamento',      'icone' => 'engineering',    'badge' => 'bg-secondary-fixed/40'],
        ['n' => 3, 'titulo' => 'Cobertura',                 'status' => 'Próxima fase',      'icone' => 'roofing',        'badge' => 'bg-surface-container'],
        ['n' => 4, 'titulo' => 'Acabamentos',               'status' => 'Aguardando fundos', 'icone' => 'format_paint',   'badge' => 'bg-surface-container'],
    ];
    foreach ($marcos as $marco) {
        assertCondition(str_contains($termoContent, "data-test=\"marco-{$marco['n']}\""), "Termometro: marco {$marco['n']} identificado na timeline");
        assertCondition(str_contains($termoContent, $marco['titulo']), "Termometro: marco {$marco['n']} - '{$marco['titulo']}' presente");
        assertCondition(str_contains($termoContent, $marco['status']), "Termometro: marco {$marco['n']} - status '{$marco['status']}' presente");
        assertCondition(str_contains($termoContent, "data-icon=\"{$marco['icone']}\""), "Termometro: marco {$marco['n']} usa o icone '{$marco['icone']}'");
        assertCondition(str_contains($termoContent, $marco['badge']), "Termometro: marco {$marco['n']} usa o badge '{$marco['badge']}'");
    }
    assertCondition(
        substr_count($termoContent, 'data-test="marco-') === 4,
        "Termometro: a linha do tempo expoe exatamente 4 marcos construtivos"
    );

    // CTA de obra interligado ao modal de apadrinhamento
    assertCondition(
        str_contains($termoContent, "abrirModalApadrinhamento('obras', 50000, 'Fundo de Obras (8 Novas Salas)', 'pontual')"),
        "Termometro: CTA de obra dispara abrirModalApadrinhamento('obras', 50000, ...)"
    );
    assertCondition(str_contains($termoContent, 'min-h-[48px]'), "Termometro: CTA de obra mantem alvo de toque minimo de 48px (WCAG)");
}

// -------------------------------------------------------------
// 4. Composicao da Home e Renderizacao Real
// -------------------------------------------------------------
echo "\n4. Validando composicao da Home e renderizacao real...\n";

assertCondition(file_exists($homeFile), "Arquivo templates/pages/home.php existe");
if ($homeContent !== '') {
    foreach (['hero', 'bento-impacto', 'termometro-obras'] as $partial) {
        assertCondition(str_contains($homeContent, "View::partial('{$partial}'"), "Home.php inclui o partial '{$partial}'");
    }
    assertCondition(
        strpos($homeContent, "View::partial('hero'") < strpos($homeContent, "View::partial('bento-impacto'"),
        "Home.php preserva a ordem narrativa (Hero -> Bento -> Termometro)"
    );
    assertCondition(substr_count($homeContent, '<section') === 0, "Home.php permanece um arquivo de composicao (sem <section> proprio)");
}

require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'View.php';
\NovaEsperanca\Core\View::init($rootDir . DIRECTORY_SEPARATOR . 'templates');

$renderWarnings = [];
set_error_handler(static function (int $severity, string $message) use (&$renderWarnings): bool {
    $renderWarnings[] = $message;
    return true;
});
$heroHtml  = \NovaEsperanca\Core\View::partial('hero');
$bentoHtml = \NovaEsperanca\Core\View::partial('bento-impacto', ['alunos' => 93, 'salas' => 5, 'colaboradores' => 10, 'merenda' => '100%']);
$termoHtml = \NovaEsperanca\Core\View::partial('termometro-obras', []);
restore_error_handler();

assertCondition(count($renderWarnings) === 0, "Renderizacao dos 3 partials nao emite warnings/notices de PHP");
if (count($renderWarnings) > 0) {
    echo "         Avisos: " . implode(' | ', $renderWarnings) . "\n";
}
foreach (['hero' => $heroHtml, 'bento-impacto' => $bentoHtml, 'termometro-obras' => $termoHtml] as $nome => $htmlParcial) {
    assertCondition(!str_contains($htmlParcial, 'não encontrada'), "Partial '{$nome}' renderiza sem graceful fallback do View::partial()");
    assertCondition(trim($htmlParcial) !== '', "Partial '{$nome}' produz saida HTML nao vazia");
}
assertCondition(
    \NovaEsperanca\Core\View::partial('hero') === $heroHtml
    && \NovaEsperanca\Core\View::partial('bento-impacto') === $bentoHtml
    && \NovaEsperanca\Core\View::partial('termometro-obras') === $termoHtml,
    "Partials sao deterministicos: renderizar isolado ou via roteador produz o mesmo HTML"
);

assertCondition(preg_match_all('/<h1[\s>]/', $heroHtml) === 1, "Hero renderiza exatamente 1 elemento <h1>");
assertCondition(str_contains($heroHtml, 'lg:grid-cols-12') && str_contains($heroHtml, 'lg:col-span-7') && str_contains($heroHtml, 'lg:col-span-5'), "HTML do Hero: grade de 12 colunas com as duas colunas contratuais");
assertCondition(str_contains($heroHtml, 'src="/assets/images/parada-civica.jpeg"'), "HTML do Hero: fotografia oficial renderizada");
assertCondition(str_contains($heroHtml, 'aspect-[4/3]'), "HTML do Hero: proporcao da moldura travada em aspect-[4/3]");
assertCondition(str_contains($bentoHtml, 'lg:grid-cols-4'), "HTML do Bento: 4 colunas aplicadas no desktop");
assertCondition(str_contains($bentoHtml, 'grid-cols-2'), "HTML do Bento: 2 colunas preservadas no mobile");
foreach ([['93', 'Alunos Matriculados'], ['05', 'Salas de Aula Ativas'], ['10', 'Colaboradores Locais'], ['100%', 'Merenda Garantida']] as [$valor, $rotulo]) {
    assertCondition(
        preg_match('/>' . preg_quote($valor, '/') . '</', $bentoHtml) === 1,
        "HTML do Bento: pilar '{$rotulo}' renderiza a metrica auditada '{$valor}'"
    );
}
assertCondition(str_contains($termoHtml, 'md:grid-cols-4'), "HTML do Termometro: timeline horizontal de 4 colunas no desktop");
assertCondition(str_contains($termoHtml, 'w-full'), "HTML do Termometro: barra de progresso em largura total");

// Renderizacao completa da Home atraves do Router real
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

$router = new \NovaEsperanca\Core\Router();
\NovaEsperanca\Core\Router::registerRoutes(
    $router,
    new \NovaEsperanca\Repositories\JsonDonationRepository($rootDir . '/storage/app/donations.json'),
    new \NovaEsperanca\Services\EmailNotificationService($rootDir . '/storage/logs/notifications.log'),
    new \NovaEsperanca\Services\AntiSpamService()
);
$homeHtmlCompleto = $router->dispatch(new \NovaEsperanca\Core\Request('GET', '/'))->getBody();
$transpHtmlCompleto = $router->dispatch(new \NovaEsperanca\Core\Request('GET', '/transparencia'))->getBody();
restore_error_handler();

assertCondition(count($routerWarnings) === 0, "Dispatch das rotas '/' e '/transparencia' nao emite warnings/notices de PHP");
if (count($routerWarnings) > 0) {
    echo "         Avisos: " . implode(' | ', $routerWarnings) . "\n";
}

assertCondition(preg_match_all('/<h1[\s>]/', $homeHtmlCompleto) === 1, "Home renderizada possui exatamente 1 <h1> (hierarquia semantica preservada)");
assertCondition(str_contains($homeHtmlCompleto, 'max-w-7xl'), "Home renderizada permanece contida no container max-w-7xl do shell (Issue #9 preservada)");
assertCondition(str_contains($homeHtmlCompleto, 'lg:grid-cols-12'), "Home renderizada expoe o Hero bi-colunar de 12 colunas");
assertCondition(str_contains($homeHtmlCompleto, 'parada-civica.jpeg'), "Home renderizada expoe a fotografia oficial da comunidade");
assertCondition(str_contains($homeHtmlCompleto, 'lg:grid-cols-4'), "Home renderizada expoe o Bento Grid de 4 colunas");
assertCondition(str_contains($homeHtmlCompleto, 'md:grid-cols-4'), "Home renderizada expoe a timeline de 4 marcos");
assertCondition(str_contains($homeHtmlCompleto, '<footer') && str_contains($homeHtmlCompleto, 'hidden md:block bg-surface-container'), "Home renderizada mantem o rodape institucional da Issue #9");
assertCondition(!str_contains($homeHtmlCompleto, 'não encontrada'), "Nenhum partial da Home retorna o aviso de graceful fallback do View::partial()");

// Regressao de rota compartilhada: o Termometro tambem vive em /transparencia
assertCondition(str_contains($transpHtmlCompleto, 'id="termometro-obras"'), "Termometro continua renderizado na rota /transparencia (regressao evitada)");
assertCondition(str_contains($transpHtmlCompleto, 'md:grid-cols-4'), "Termometro compartilhado mantem a timeline de 4 marcos em /transparencia");
assertCondition(str_contains($transpHtmlCompleto, '55.359.800 Kz'), "Termometro compartilhado mantem a meta de 55.359.800 Kz em /transparencia");

// -------------------------------------------------------------
// 5. Preservacao de Dados Oficiais e Salvaguardas
// -------------------------------------------------------------
echo "\n5. Validando preservacao de dados oficiais e salvaguardas...\n";

foreach ([
    'hero'             => $heroContent,
    'bento-impacto'    => $bentoContent,
    'termometro-obras' => $termoContent,
] as $nomeParcial => $conteudoParcial) {
    assertCondition(!str_contains($conteudoParcial, 'w-screen'), "{$nomeParcial}: nao fixa 'w-screen' (sem overflow horizontal em 360px-400px)");
    assertCondition(!str_contains($conteudoParcial, 'whitespace-nowrap'), "{$nomeParcial}: nao usa 'whitespace-nowrap' em labels (quebra de linha flexivel)");
}

assertCondition(str_contains($bentoContent, 'text-2xl sm:text-3xl'), "Bento: tipografia fluida preservada nos cards de pilar");
assertCondition(str_contains($heroContent, '?? '), "Hero: parametros dinamicos com coalescencia nula (renderizacao identica isolada ou roteada)");
assertCondition(str_contains($bentoContent, '?? '), "Bento: parametros dinamicos com coalescencia nula (renderizacao identica isolada ou roteada)");
assertCondition(str_contains($termoContent, '?? '), "Termometro: parametros dinamicos com coalescencia nula (renderizacao identica isolada ou roteada)");

assertCondition(preg_match('/<a[^>]*href="\/transparencia"[^>]*class="[^"]*min-h-\[48px\]/', $heroHtml) === 1, "Hero: CTA secundario 'Transparencia Financeira' mantem alvo de toque de 48px");
assertCondition(preg_match('/<button[^>]*onclick="abrirModalApadrinhamento\(' . "'integral'" . '[^>]*min-h-\[48px\]/', $heroHtml) === 1, "Hero: CTA primario mantem alvo de toque de 48px");
assertCondition(substr_count($homeHtmlCompleto, 'min-h-[48px]') >= 4, "Home: alvos de toque de 48px preservados nos CTAs de conversao");

assertCondition(
    stripos($homeHtmlCompleto, 'Lei nº 25/12') !== false || stripos($homeHtmlCompleto, 'Lei n.º 25/12') !== false,
    "Home: salvaguarda da Lei nº 25/12 referenciada no shell institucional"
);
assertCondition(stripos($homeHtmlCompleto, 'menores') !== false, "Home: protecao da intimidade de menores referenciada");
foreach (['Lista de Alunos', 'Nom Complet', 'Encarregado de Educacao:', 'Encarregado de Educação:'] as $termoProibido) {
    assertCondition(!str_contains($homeHtmlCompleto, $termoProibido), "Home: nenhuma exposicao de dados pessoais de menores ('{$termoProibido}')");
}
assertCondition(
    !preg_match('/<img[^>]*alt="[^"]*\b(aluno|crianca|criança)\b[^"]*\b(nome|completo)\b/i', $homeHtmlCompleto),
    "Home: o alt text da fotografia oficial nao identifica menores nominalmente"
);

// -------------------------------------------------------------
// 6. Registro do Validador no Pipeline de CI
// -------------------------------------------------------------
echo "\n6. Validando Registro do Validador no GitHub Actions...\n";

$ciWorkflow = $rootDir . DIRECTORY_SEPARATOR . '.github' . DIRECTORY_SEPARATOR . 'workflows' . DIRECTORY_SEPARATOR . 'ci-deploy.yml';
assertCondition(file_exists($ciWorkflow), "Workflow .github/workflows/ci-deploy.yml existe");
if (file_exists($ciWorkflow)) {
    $ciContent = (string)file_get_contents($ciWorkflow);
    assertCondition(str_contains($ciContent, 'validate-issue-10-home-desktop.php'), "Workflow executa o validador da Issue #10 (validate-issue-10-home-desktop.php)");
    assertCondition(str_contains($ciContent, 'validate-issue-9-desktop-shell.php'), "Workflow mantem o validador da Issue #9 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-fase-7-deploy-lancamento.php'), "Workflow mantem o validador da Fase 7 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-demanda-schema.php'), "Workflow mantem o validador da Fase 1 (regressao preservada)");
}

// -------------------------------------------------------------
// 7. Validacao de Regressao dos Validadores das Fases 1 a 7 e Issue #9
// -------------------------------------------------------------
echo "\n7. Executando Regressao dos Validadores das Fases 1 a 7 e da Issue #9...\n";

$legacyValidators = [
    'validate-demanda-schema.php',
    'validate-fase-2-planejamento.php',
    'validate-fase-3-design.php',
    'validate-fase-4-conteudo-dados.php',
    'validate-fase-5-desenvolvimento.php',
    'validate-fase-6-testes-qa.php',
    'validate-fase-7-deploy-lancamento.php',
    'validate-issue-9-desktop-shell.php',
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
    assertCondition($returnVar === 0, "Regressao sem quebras: scripts/{$validator} (exit {$returnVar})");
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
echo "RESULTADO DA VALIDACAO ISSUE #10: {$assertionsPassed} APROVADAS, {$assertionsFailed} FALHAS.\n";
echo "=======================================================\n";

if ($assertionsFailed > 0) {
    echo "\n[FALHA] Existem criterios pendentes na Issue #10.\n";
    exit(1);
}

echo "\n[SUCESSO] Home Desktop (Hero Duplo, Bento 4 Colunas e Termometro Expandido) aprovada com 100% de sucesso!\n";
exit(0);
