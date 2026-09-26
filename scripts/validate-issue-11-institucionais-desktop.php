<?php
declare(strict_types=1);

/**
 * Validador Automatizado - Issue #11 (Paginas Institucionais Desktop: Sobre Nos, Galeria e Transaparencia)
 *
 * Verifica os criterios de aceitacao da Issue #11:
 * 1. /sobre em layout editorial bi-colunar (lg:grid-cols-12, lg:col-span-8 / lg:col-span-4) com
 *    narrativa da fundacao, registro fotografico oficial, Equipe de 10 colaboradores e sidebar
 *    institucional (diagnostico regional, salvaguarda da Lei no 25/12 e contato por WhatsApp).
 * 2. /galeria em grade de 3 colunas no desktop (lg:grid-cols-3) com as 3 fotografias autenticas,
 *    molduras aspect-[16/10], micro-interacao de hover e salvaguarda infantil ativa.
 * 3. /transparencia com Painel Executivo bi-colunar (Balanco Anual Operacional de 18.500.000 AOA
 *    ao lado da Decomposicao da Merenda de 350 AOA/dia) e tabela orcamentaria responsiva das
 *    8 novas salas (55.359.800 AOA) espelhando a base canonica fundo_obras_detalhado.
 * 4. Preservacao de dados, salvaguardas infantis e tratamento dos casos de borda declarados.
 * 5. Registro do validador no pipeline de CI (GitHub Actions) e regressao das Fases 1 a 7 e das
 *    Issues #9 e #10.
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

function formatarAoa(float $valor): string {
    return number_format($valor, 0, ',', '.');
}

echo "=== VALIDACAO ISSUE #11 (PAGINAS INSTITUCIONAIS DESKTOP: SOBRE, GALERIA E TRANSPARENCIA) ===\n\n";

$pagesDir     = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'pages';
$partialsDir  = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'partials';
$sobreFile    = $pagesDir . DIRECTORY_SEPARATOR . 'sobre.php';
$galeriaFile  = $pagesDir . DIRECTORY_SEPARATOR . 'galeria.php';
$transpFile   = $pagesDir . DIRECTORY_SEPARATOR . 'transparencia.php';
$custosFile   = $rootDir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'relatorio-custos-transparencia.json';

$sobreContent   = readTemplate($sobreFile);
$galeriaContent = readTemplate($galeriaFile);
$transpContent  = readTemplate($transpFile);
$custos         = file_exists($custosFile) ? (json_decode((string)file_get_contents($custosFile), true) ?? []) : [];

// -------------------------------------------------------------
// 1. Pagina Sobre Nos: Layout Editorial Bi-Colunar Desktop
// -------------------------------------------------------------
echo "1. Validando pagina /sobre em layout editorial bi-colunar...\n";

assertCondition(file_exists($sobreFile), "Arquivo templates/pages/sobre.php existe");
if ($sobreContent !== '') {
    assertCondition(
        str_contains($sobreContent, 'grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start'),
        "Sobre: bloco bi-colunar usa 'grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start'"
    );
    assertCondition(str_contains($sobreContent, 'lg:col-span-8'), "Sobre: coluna principal ocupa lg:col-span-8");
    assertCondition(str_contains($sobreContent, 'lg:col-span-4'), "Sobre: sidebar institucional ocupa lg:col-span-4");
    assertCondition(
        preg_match('/<aside[^>]*class="[^"]*lg:col-span-4[^"]*"/', $sobreContent) === 1,
        "Sobre: sidebar semantica usa <aside class=\"lg:col-span-4 ...\">"
    );
    assertCondition(
        str_contains($sobreContent, 'bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-6 md:p-8'),
        "Sobre: bloco de Historia & Missao usa o contrato de classes (p-6 md:p-8)"
    );

    // Narrativa historica e pedagogica preservada
    assertCondition(str_contains($sobreContent, 'Nossa História & Missão'), "Sobre: badge 'Nossa Historia & Missao' preservado");
    assertCondition(str_contains($sobreContent, 'O Florescer da Educação Comunitária em Kifangondo'), "Sobre: titulo editorial preservado");
    assertCondition(str_contains($sobreContent, 'Ícolo e Bengo'), "Sobre: contexto provincial de Icolo e Bengo preservado");
    assertCondition(str_contains($sobreContent, 'Sequele'), "Sobre: contexto municipal do Sequele preservado");
    assertCondition(str_contains($sobreContent, 'Igreja Missionária Nova Esperança (IMNE)'), "Sobre: fundacao pela IMNE declarada");
    assertCondition(str_contains($sobreContent, '2020') || stripos($sobreContent, 'fundad') !== false, "Sobre: fundacao datada referenciada");
    assertCondition(stripos($sobreContent, 'alfabetiza') !== false, "Sobre: alfabetizacao fonica preservada na narrativa");
    assertCondition(str_contains($sobreContent, 'src="/assets/images/parada-civica.jpeg"'), "Sobre: registro fotografico oficial referenciado");
    assertCondition(str_contains($sobreContent, 'loading="lazy"'), "Sobre: registro fotografico usa loading=\"lazy\"");

    // Equipe Operacional de 10 colaboradores
    assertCondition(str_contains($sobreContent, 'Nossa Equipe Operacional'), "Sobre: secao da Equipe Operacional preservada");
    assertCondition(str_contains($sobreContent, '10 colaboradores locais'), "Sobre: equipe declarada com 10 colaboradores locais");
    assertCondition(str_contains($sobreContent, 'sm:grid-cols-2 gap-3.5'), "Sobre: grade interna da equipe usa 'sm:grid-cols-2 gap-3.5'");
    foreach (['Coordenação Geral', 'Direção Pedagógica', '5 Educadoras Titulares', 'Merendeira e 2 Auxiliares'] as $cargo) {
        assertCondition(str_contains($sobreContent, $cargo), "Sobre: cargo da equipe '{$cargo}' declarado");
    }
    assertCondition(str_contains($sobreContent, 'href="/apadrinhe"'), "Sobre: CTA de apoio roteia para /apadrinhe");
    assertCondition(str_contains($sobreContent, 'Apoiar a Escola e os Educadores'), "Sobre: CTA de apoio rotulado 'Apoiar a Escola e os Educadores'");

    // Sidebar institucional
    assertCondition(str_contains($sobreContent, "View::partial('widget-diagnostico'"), "Sobre: sidebar mantem o partial 'widget-diagnostico'");
    assertCondition(str_contains($sobreContent, 'Lei nº 25/12'), "Sobre: sidebar cita a Lei no 25/12 de Angola");
    assertCondition(str_contains($sobreContent, 'https://wa.me/244930561688'), "Sobre: sidebar expoe o contato institucional por WhatsApp");
    assertCondition(str_contains($sobreContent, '?? '), "Sobre: variaveis dinamicas com coalescencia nula");
}

// -------------------------------------------------------------
// 2. Pagina Galeria: Grade de 3 Colunas no Desktop
// -------------------------------------------------------------
echo "\n2. Validando pagina /galeria em grade de 3 colunas...\n";

assertCondition(file_exists($galeriaFile), "Arquivo templates/pages/galeria.php existe");
if ($galeriaContent !== '') {
    assertCondition(
        str_contains($galeriaContent, 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6'),
        "Galeria: container de fotos usa 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6'"
    );
    assertCondition(
        substr_count($galeriaContent, 'bg-surface-container-lowest rounded-2xl border border-outline-variant/30 p-4 shadow-sm hover:shadow-md transition-shadow') === 3,
        "Galeria: exibe exatamente 3 cards de fotografia com o contrato de classes"
    );
    assertCondition(substr_count($galeriaContent, 'aspect-[16/10] overflow-hidden rounded-xl bg-surface-container') === 3, "Galeria: as 3 molduras usam 'aspect-[16/10] overflow-hidden rounded-xl bg-surface-container'");
    assertCondition(substr_count($galeriaContent, 'hover:scale-105 transition-transform duration-500') === 3, "Galeria: as 3 fotografias aplicam micro-interacao de escala no hover");
    assertCondition(substr_count($galeriaContent, 'loading="lazy"') === 3, "Galeria: as 3 fotografias usam loading=\"lazy\"");
    assertCondition(substr_count($galeriaContent, 'object-cover object-center') === 3, "Galeria: as 3 fotografias preservam a proporcao com object-cover");

    $fotos = [
        ['arquivo' => 'parada-civica.jpeg',   'titulo' => 'A Parada Matinal Cívica (07:30 - 08:00)'],
        ['arquivo' => 'predio-salas-atual.jpeg', 'titulo' => 'As 5 Salas de Aula em Ação'],
        ['arquivo' => 'merenda-escolar.jpeg',  'titulo' => 'A Merenda Escolar Diária (10:00 - 10:45)'],
    ];
    foreach ($fotos as $foto) {
        assertCondition(str_contains($galeriaContent, "/assets/images/{$foto['arquivo']}"), "Galeria: fotografia '{$foto['arquivo']}' referenciada");
        assertCondition(str_contains($galeriaContent, $foto['titulo']), "Galeria: legenda '{$foto['titulo']}' presente");
    }
    assertCondition(substr_count($galeriaContent, '<img ') === 3, "Galeria: renderiza exatamente 3 elementos <img>");

    // Salvaguarda infantil ativa
    assertCondition(str_contains($galeriaContent, 'Salvaguarda Infantil Ativa'), "Galeria: selo de salvaguarda infantil ativa preservado");
    assertCondition(str_contains($galeriaContent, 'Lei nº 25/12'), "Galeria: cita a Lei no 25/12 de Angola");
    assertCondition(str_contains($galeriaContent, '93 alunos') || str_contains($galeriaContent, '93 crianças'), "Galeria: contexto dos 93 alunos preservado");
    assertCondition(str_contains($galeriaContent, "View::partial('canais-apoio')"), "Galeria: mantem o partial 'canais-apoio'");
}

// -------------------------------------------------------------
// 3. Pagina Transaparencia: Painel Executivo e Tabela Orcamentaria
// -------------------------------------------------------------
echo "\n3. Validando pagina /transparencia com painel executivo e tabela orcamentaria...\n";

assertCondition(file_exists($transpFile), "Arquivo templates/pages/transparencia.php existe");
assertCondition(file_exists($custosFile), "Base canonica data/relatorio-custos-transparencia.json existe");
if ($transpContent !== '') {
    assertCondition(str_contains($transpContent, 'id="prestacao-contas"'), "Transparencia: ancora '#prestacao-contas' preservada (usada pelo rodape institucional)");
    assertCondition(str_contains($transpContent, 'Prestação de Contas Aberta'), "Transparencia: selo de auditoria aberto preservado");
    assertCondition(str_contains($transpContent, 'Transparência Financeira e Aplicação de Recursos'), "Transparencia: titulo institucional preservado");

    // Painel Executivo Bi-Colunar
    assertCondition(
        str_contains($transpContent, 'grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch'),
        "Transparencia: painel executivo usa 'grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch'"
    );
    assertCondition(str_contains($transpContent, 'lg:col-span-7'), "Transparencia: Balanco Anual Operacional ocupa lg:col-span-7");
    assertCondition(str_contains($transpContent, 'lg:col-span-5'), "Transparencia: Decomposicao da Merenda ocupa lg:col-span-5");
    assertCondition(str_contains($transpContent, 'grid grid-cols-2 sm:grid-cols-4 gap-3'), "Transparencia: 4 indicadores orcamentarios em 'grid grid-cols-2 sm:grid-cols-4'");
    foreach (['Receitas Totais', 'Despesas Executadas', 'Reserva Técnica', 'Saldo em Conta'] as $indicador) {
        assertCondition(str_contains($transpContent, $indicador), "Transparencia: indicador '{$indicador}' presente");
    }
    assertCondition(str_contains($transpContent, 'Custo Unitário da Merenda'), "Transparencia: bloco de decomposicao da merenda presente");
    assertCondition(str_contains($transpContent, 'refeicoes_servidas_mes'), "Transparencia: custo da merenda lida da base canonica (refeicoes_servidas_mes)");
    assertCondition(str_contains($transpContent, 'custo_mensal_total_aoa'), "Transparencia: consolidado mensal lido da base canonica (custo_mensal_total_aoa)");

    // Tabela orcamentaria das 8 novas salas
    assertCondition(
        str_contains($transpContent, 'overflow-x-auto rounded-2xl border border-outline-variant/40 bg-surface-container-lowest p-5 md:p-6 shadow-sm'),
        "Transparencia: tabelaorcamentaria encapsulada em container com overflow-x-auto"
    );
    assertCondition(str_contains($transpContent, 'min-w-[550px]'), "Transparencia: tabela usa min-w-[550px] (quebra horizontal em mobile)");
    assertCondition(str_contains($transpContent, '<table'), "Transparencia: tabela orcamentaria semantica renderizada");
    assertCondition(str_contains($transpContent, 'Orçamento Detalhado das 8 Novas Salas'), "Transparencia: titulo do detalhamento orcamentario presente");
    assertCondition(str_contains($transpContent, 'orcamento_total_aoa'), "Transparencia: total orcado lido da base canonica (orcamento_total_aoa)");
    foreach (['Etapa Construtiva', 'Descrição Técnica', 'Valor Orçado'] as $coluna) {
        assertCondition(str_contains($transpContent, $coluna), "Transparencia: coluna '{$coluna}' presente");
    }
    assertCondition(
        str_contains($transpContent, "\$custos['fundo_obras_detalhado']['composicao_custos'] ?? []"),
        "Transparencia: tabela orcamentaria le a base canonica com coalescencia nula"
    );
    assertCondition(str_contains($transpContent, "View::partial('termometro-obras'"), "Transparencia: mantem o partial 'termometro-obras'");
    assertCondition(str_contains($transpContent, "View::partial('canais-apoio')"), "Transparencia: mantem o partial 'canais-apoio'");
    assertCondition(str_contains($transpContent, '?? '), "Transparencia: variaveis dinamicas com coalescencia nula");
}

// -------------------------------------------------------------
// 4. Fidelidade a Base Canonica (dados auditados)
// -------------------------------------------------------------
echo "\n4. Validando fidelidade dos dados a base canonica relatorio-custos-transparencia.json...\n";

$execucao   = $custos['execucao_semestral'] ?? [];
$merenda    = $custos['detalhamento_merenda'] ?? [];
$obras      = $custos['fundo_obras_detalhado'] ?? [];
$composicao = $obras['composicao_custos'] ?? [];

assertCondition(count($composicao) === 5, "Base canonica: fundo_obras_detalhado possui 5 etapas construtivas");
assertCondition(isset($obras['orcamento_total_aoa']) && (float)$obras['orcamento_total_aoa'] === 55359800.0, "Base canonica: orcamento total das obras e de 55.359.800 AOA");
assertCondition(isset($obras['valor_arrecadado_aoa']) && (float)$obras['valor_arrecadado_aoa'] === 0.0, "Base canonica: valor arrecadado das obras e de 0 AOA");
assertCondition(isset($execucao['receita_total_aoa']) && (float)$execucao['receita_total_aoa'] === 18500000.0, "Base canonica: receita total do semestre e de 18.500.000 AOA");
assertCondition(isset($merenda['custo_refeicao_diaria_aluno_aoa']) && (float)$merenda['custo_refeicao_diaria_aluno_aoa'] === 350.0, "Base canonica: custo da refeicao diaria e de 350 AOA");

// Renderizacao real das tres rotas atraves do Router real
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'View.php';
\NovaEsperanca\Core\View::init($rootDir . DIRECTORY_SEPARATOR . 'templates');
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
$rotas = ['/sobre', '/galeria', '/transparencia', '/', '/apadrinhe', '/voluntariado'];
$htmls = [];
foreach ($rotas as $rota) {
    $htmls[$rota] = $router->dispatch(new \NovaEsperanca\Core\Request('GET', $rota))->getBody();
}
restore_error_handler();

assertCondition(count($routerWarnings) === 0, "Dispatch das 6 rotas canonicas nao emite warnings/notices de PHP");
if (count($routerWarnings) > 0) {
    echo "         Avisos: " . implode(' | ', $routerWarnings) . "\n";
}
foreach ($rotas as $rota) {
    assertCondition(!str_contains($htmls[$rota], 'não encontrada'), "Rota '{$rota}' nao aciona o graceful fallback do View::partial()");
    assertCondition(str_contains($htmls[$rota], 'max-w-7xl'), "Rota '{$rota}' mantem o shell desktop da Issue #9");
    assertCondition(!str_contains($htmls[$rota], 'Undefined'), "Rota '{$rota}' nao expoe aviso de variavel indefinida");
}

$sobreHtml   = $htmls['/sobre'];
$galeriaHtml = $htmls['/galeria'];
$transpHtml  = $htmls['/transparencia'];

// Fidelidade do HTML renderizado a base canonica
foreach ($execucao as $chave => $valor) {
    $formatado = formatarAoa((float)$valor);
    assertCondition(str_contains($transpHtml, $formatado), "Transparencia renderizada: '{$chave}' ({$formatado} AOA) bate com a base canonica");
}
foreach ($composicao as $etapa) {
    $linhaOk = str_contains($transpHtml, (string)$etapa['etapa'])
        && str_contains($transpHtml, (string)$etapa['descricao'])
        && str_contains($transpHtml, formatarAoa((float)$etapa['valor_estimado_aoa']));
    assertCondition($linhaOk, "Transparencia renderizada: etapa canonica '{$etapa['etapa']}' com descricao e valor orcado de " . formatarAoa((float)$etapa['valor_estimado_aoa']) . " AOA");
}
assertCondition(
    abs(array_sum(array_map(static fn(array $e): float => (float)$e['valor_estimado_aoa'], $composicao)) - 55359800.0) < 0.01,
    "Transparencia: soma das 5 etapas canonicas e exatamente 55.359.800 AOA"
);
assertCondition(
    substr_count($transpHtml, '<tr') === 7, "Transparencia: tabela orcamentaria renderiza 5 etapas + cabecalho + total"
);
assertCondition(substr_count($transpHtml, '<tr') === substr_count($transpHtml, '</tr>'), "Transparencia: todas as linhas da tabela sao fechadas");
assertCondition(substr_count($transpHtml, '<td') === substr_count($transpHtml, '</td>'), "Transparencia: todas as celulas da tabela sao fechadas");

// Merenda e total orcado renderizados a partir da base canonica
assertCondition(
    str_contains($transpHtml, formatarAoa((float)($merenda['refeicoes_servidas_mes'] ?? 0)) . ' refeições'),
    "Transparencia renderizada: " . formatarAoa((float)($merenda['refeicoes_servidas_mes'] ?? 0)) . " refeicoes por mes declaradas"
);
assertCondition(
    str_contains($transpHtml, formatarAoa((float)($merenda['custo_mensal_total_aoa'] ?? 0))),
    "Transparencia renderizada: consolidado mensal de " . formatarAoa((float)($merenda['custo_mensal_total_aoa'] ?? 0)) . " AOA declarado"
);
assertCondition(
    str_contains($transpHtml, formatarAoa((float)($obras['orcamento_total_aoa'] ?? 0))),
    "Transparencia renderizada: total orcado de " . formatarAoa((float)($obras['orcamento_total_aoa'] ?? 0)) . " AOA declarado"
);

// Itens da merenda espelhados da base canonica
foreach (($merenda['itens_principais'] ?? []) as $item) {
    assertCondition(str_contains($transpHtml, (string)$item['item']), "Transparencia renderizada: item de merenda '{$item['categoria']}' presente");
}
assertCondition(
    substr_count($transpHtml, '350,00 AOA') === 1,
    "Transparencia renderizada: custo diario de 350,00 AOA exibido em destaque"
);

// Estruturas multi-colunares renderizadas
assertCondition(preg_match_all('/<h1[\s>]/', $sobreHtml) === 1, "Sobre renderizada: exatamente 1 <h1>");
assertCondition(str_contains($sobreHtml, 'lg:grid-cols-12') && str_contains($sobreHtml, 'lg:col-span-8') && str_contains($sobreHtml, 'lg:col-span-4'), "Sobre renderizada: layout editorial de 12 colunas com 8/4");
assertCondition(str_contains($sobreHtml, 'Kifangondo'), "Sobre renderizada: contexto de Kifangondo preservado");
assertCondition(str_contains($sobreHtml, '13,8') || str_contains($sobreHtml, '13.8'), "Sobre renderizada: dado de 13,8% pre-escolar preservado (Fase 5)");

assertCondition(preg_match_all('/<h1[\s>]/', $galeriaHtml) === 1, "Galeria renderizada: exatamente 1 <h1>");
assertCondition(str_contains($galeriaHtml, 'lg:grid-cols-3'), "Galeria renderizada: grade de 3 colunas aplicada");
foreach (['parada-civica.jpeg', 'predio-salas-atual.jpeg', 'merenda-escolar.jpeg'] as $arquivo) {
    assertCondition(
        str_contains($galeriaHtml, '/assets/images/' . $arquivo),
        "Galeria renderizada: fotografia oficial '{$arquivo}' exibida"
    );
}
assertCondition(str_contains($galeriaHtml, 'aspect-[16/10]'), "Galeria renderizada: proporcao 16/10 preservada");
assertCondition(str_contains($galeriaHtml, 'Lei nº 25/12'), "Galeria renderizada: salvaguarda da Lei no 25/12 ativa");

assertCondition(preg_match_all('/<h1[\s>]/', $transpHtml) === 1, "Transparencia renderizada: exatamente 1 <h1>");
assertCondition(str_contains($transpHtml, 'lg:grid-cols-12') && str_contains($transpHtml, 'lg:col-span-7') && str_contains($transpHtml, 'lg:col-span-5'), "Transparencia renderizada: painel executivo de 12 colunas com 7/5");
assertCondition(str_contains($transpHtml, '18.500.000'), "Transparencia renderizada: receitas de 18.500.000 AOA preservadas (Fase 5)");
assertCondition(str_contains($transpHtml, '350'), "Transparencia renderizada: custo da merenda de 350 AOA preservado (Fase 5)");
assertCondition(str_contains($transpHtml, 'id="termometro-obras"'), "Transparencia renderizada: termometro de obras preservado");
assertCondition(str_contains($transpHtml, 'md:grid-cols-4'), "Transparencia renderizada: timeline de 4 marcos do termometro preservada (Issue #10)");
assertCondition(str_contains($transpHtml, 'min-w-[550px]'), "Transparencia renderizada: tabela com min-w-[550px] contra quebra de layout");

// -------------------------------------------------------------
// 5. Preservacao de Dados, Salvaguardas e Casos de Borda
// -------------------------------------------------------------
echo "\n5. Validando preservacao de dados, salvaguardas e casos de borda...\n";

foreach (['sobre.php' => $sobreContent, 'galeria.php' => $galeriaContent, 'transparencia.php' => $transpContent] as $pagina => $fonte) {
    assertCondition(!str_contains($fonte, 'w-screen'), "{$pagina}: nao fixa 'w-screen' (sem overflow horizontal em 360px-480px)");
    assertCondition(!str_contains($fonte, 'whitespace-nowrap'), "{$pagina}: nao usa 'whitespace-nowrap' em labels (quebra de linha flexivel)");
}
foreach (['/sobre' => $sobreHtml, '/galeria' => $galeriaHtml, '/transparencia' => $transpHtml] as $rota => $html) {
    assertCondition(
        !preg_match('/<img[^>]*alt="[^"]*\b(nome|completo)\b[^"]*"/i', $html),
        "{$rota}: nenhum alt text identifica menores nominalmente"
    );
    assertCondition(!str_contains($html, 'Lista de Alunos'), "{$rota}: nao expoe lista nominal de alunos");
    assertCondition(stripos($html, '25/12') !== false, "{$rota}: marco legal da Lei no 25/12 referenciado");
}

assertCondition(
    preg_match('/<div[^>]*class="[^"]*overflow-x-auto[^"]*"[^>]*>\s*<table/', $transpHtml) === 1,
    "Transparencia: <table> aninhada imediatamente dentro do container com overflow-x-auto"
);
assertCondition(
    preg_match('/<table[^>]*class="[^"]*min-w-\[550px\][^"]*"/', $transpHtml) === 1,
    "Transparencia: <table> declara a classe minima min-w-[550px]"
);
assertCondition(!str_contains($sobreHtml, 'id="bento-impacto"'), "Sobre: nao reutiliza a ancora #bento-impacto da Home");
assertCondition(!str_contains($sobreHtml, 'id="termometro-obras"'), "Sobre: nao reutiliza a ancora #termometro-obras da Home");
assertCondition(!str_contains($galeriaHtml, 'id="bento-impacto"'), "Galeria: nao reutiliza a ancora #bento-impacto da Home");

// Renderizacao isolada da pagina (sem os dados injetados pelo roteador)
$renderIsolado = (static function (string $pagina) use ($rootDir): string {
    $metricas = [];
    $transparencia = [];
    $diagnostico = [];
    $custos = [];
    $pageTitle = '';
    $currentRoute = '/transparencia';
    ob_start();
    require $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $pagina . '.php';
    return (string)ob_get_clean();
})('transparencia');
assertCondition(
    str_contains($renderIsolado, 'min-w-[550px]') && str_contains($renderIsolado, 'Orçamento Detalhado das 8 Novas Salas'),
    "Transparencia: renderizacao isolada (sem \$custos do roteador) mantem a estrutura da tabela orcamentaria"
);
assertCondition(
    preg_match('/<table[^>]*class="[^"]*min-w-\[550px\][^"]*"/', $renderIsolado) === 1,
    "Transparencia: renderizacao isolada mantem a classe minima da tabela"
);
assertCondition(
    substr_count($renderIsolado, '<tr') === substr_count($renderIsolado, '</tr>')
    && substr_count($renderIsolado, '<td') === substr_count($renderIsolado, '</td>'),
    "Transparencia: renderizacao isolada nao produz markup truncado"
);
assertCondition(
    !str_contains($renderIsolado, 'Warning') && !str_contains($renderIsolado, 'Fatal error'),
    "Transparencia: renderizacao isolada degrada com elegancia sem dados injetados"
);

// -------------------------------------------------------------
// 6. Registro do Validador no Pipeline de CI
// -------------------------------------------------------------
echo "\n6. Validando Registro do Validador no GitHub Actions...\n";

$ciWorkflow = $rootDir . DIRECTORY_SEPARATOR . '.github' . DIRECTORY_SEPARATOR . 'workflows' . DIRECTORY_SEPARATOR . 'ci-deploy.yml';
assertCondition(file_exists($ciWorkflow), "Workflow .github/workflows/ci-deploy.yml existe");
if (file_exists($ciWorkflow)) {
    $ciContent = (string)file_get_contents($ciWorkflow);
    assertCondition(str_contains($ciContent, 'validate-issue-11-institucionais-desktop.php'), "Workflow executa o validador da Issue #11 (validate-issue-11-institucionais-desktop.php)");
    assertCondition(str_contains($ciContent, 'validate-issue-10-home-desktop.php'), "Workflow mantem o validador da Issue #10 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-issue-9-desktop-shell.php'), "Workflow mantem o validador da Issue #9 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-fase-7-deploy-lancamento.php'), "Workflow mantem o validador da Fase 7 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-demanda-schema.php'), "Workflow mantem o validador da Fase 1 (regressao preservada)");
}

// -------------------------------------------------------------
// 7. Validacao de Regressao dos Validadores das Fases 1 a 7 e Issues #9 e #10
// -------------------------------------------------------------
echo "\n7. Executando Regressao dos Validadores das Fases 1 a 7 e das Issues #9 e #10...\n";

$legacyValidators = [
    'validate-demanda-schema.php',
    'validate-fase-2-planejamento.php',
    'validate-fase-3-design.php',
    'validate-fase-4-conteudo-dados.php',
    'validate-fase-5-desenvolvimento.php',
    'validate-fase-6-testes-qa.php',
    'validate-fase-7-deploy-lancamento.php',
    'validate-issue-9-desktop-shell.php',
    'validate-issue-10-home-desktop.php',
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
echo "RESULTADO DA VALIDACAO ISSUE #11: {$assertionsPassed} APROVADAS, {$assertionsFailed} FALHAS.\n";
echo "=======================================================\n";

if ($assertionsFailed > 0) {
    echo "\n[FALHA] Existem criterios pendentes na Issue #11.\n";
    exit(1);
}

echo "\n[SUCESSO] Paginas Institucionais Desktop (Sobre Nos, Galeria e Transaparencia) aprovadas com 100% de sucesso!\n";
exit(0);
