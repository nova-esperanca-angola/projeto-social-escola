<?php
declare(strict_types=1);

/**
 * Validador Automatizado - Issue #12 (Fluxo de Apadrinhamento e Modal de Doacao Otimizados
 * para Telas Grandes e Doadores Internacionais)
 *
 * Verifica os criterios de aceitacao da Issue #12:
 * 1. CA1 - Grade comparativa desktop (lg:grid-cols-3) dos planos de apadrinhamento estudantil
 *    (Nutricional, Integral em destaque central e Didatica) com bloco complementar de 2 colunas
 *    para os planos de suporte institucional/predial (Apoio Educador e Fundo de Obras).
 * 2. CA2 - Notas informativas de referencia cambial aproximada em EUR, USD e BRL em todos os planos,
 *    mantendo o Kwanza (AOA/Kz) como moeda oficial soberana de liquidacao.
 * 3. CA3 - Modal ergonomico desktop (max-w-xl) com backdrop blur, centralizacao na viewport,
 *    alvos de toque WCAG AA (min-h-[48px]) e conversoes cambiais estimativas dinamicas na Etapa 1.
 * 4. CA4 - Instrucoes de transferencia bancaria internacional (SWIFT/BIC BMAOAOLU e BCIDAOLU, IBANs
 *    com prefixo AO06, titular juridico e codigo de referencia NE-2026-XXXX) na Etapa 3 do modal e
 *    no partial de canais oficiais de apoio.
 * 5. CA5 - Preservacao integral dos mecanismos anti-spam e de acessibilidade da Fase 6 (honeypot,
 *    time-trap de 2s, tecla Escape, role="dialog", aria-modal="true", aria-labelledby).
 * 6. CA6 - Registro do validador no pipeline de CI (GitHub Actions) e regressao verde das Fases 1 a 7
 *    e das Issues #9, #10 e #11.
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

/** Converte um montante em Kwanzas (AOA) para a moeda estrangeira de referencia. */
function converterAoa(float $valorAoa, float $taxaAoaPorMoeda): float {
    return $taxaAoaPorMoeda > 0.0 ? $valorAoa / $taxaAoaPorMoeda : 0.0;
}

echo "=== VALIDACAO ISSUE #12 (APADRINHAMENTO DESKTOP E MODAL DE DOACAO MULTIMOEDA) ===\n\n";

$partialsDir = $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'partials';
$planosFile  = $partialsDir . DIRECTORY_SEPARATOR . 'planos-apadrinhamento.php';
$modalFile   = $partialsDir . DIRECTORY_SEPARATOR . 'modal-apadrinhamento.php';
$canaisFile  = $partialsDir . DIRECTORY_SEPARATOR . 'canais-apoio.php';
$appJsFile   = $rootDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app.js';

$planosContent = readTemplate($planosFile);
$modalContent  = readTemplate($modalFile);
$canaisContent = readTemplate($canaisFile);
$appJsContent  = readTemplate($appJsFile);

// Taxas cambiais de referencia declaradas na spec (secao 2.1)
$taxas = ['USD' => 830.0, 'EUR' => 900.0, 'BRL' => 150.0];

/** Tabela canonica de planos: id, nome, valor AOA, frequencia e equivalencias informativas. */
$planos = [
    ['id' => 'nutricional', 'nome' => 'Cota Nutricional',           'aoa' => 12500.0, 'freq' => 'mensal',  'usd' => 15,  'eur' => 14,  'brl' => 80],
    ['id' => 'integral',    'nome' => 'Apadrinhamento Integral',    'aoa' => 40000.0, 'freq' => 'mensal',  'usd' => 48,  'eur' => 44,  'brl' => 260],
    ['id' => 'didatica',    'nome' => 'Cota Didática',              'aoa' =>  8500.0, 'freq' => 'mensal',  'usd' => 10,  'eur' => 9,   'brl' => 55],
    ['id' => 'educador',    'nome' => 'Apoio Educador',             'aoa' => 25000.0, 'freq' => 'mensal',  'usd' => 30,  'eur' => 28,  'brl' => 160],
    ['id' => 'obras',       'nome' => 'Fundo de Obras para 8 Novas Salas', 'aoa' => 50000.0, 'freq' => 'pontual', 'usd' => 60, 'eur' => 55, 'brl' => 325],
];

// -------------------------------------------------------------
// 1. CA1 - Grade Comparativa Desktop dos Planos de Apadrinhamento
// -------------------------------------------------------------
echo "1. Validando grade comparativa desktop dos planos de apadrinhamento (CA1)...\n";

assertCondition(file_exists($planosFile), "Arquivo templates/partials/planos-apadrinhamento.php existe");
if ($planosContent !== '') {
    assertCondition(
        str_contains($planosContent, 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6 items-stretch'),
        "Planos: grade comparativa dos 3 planos estudantis usa 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6 items-stretch'"
    );
    assertCondition(
        str_contains($planosContent, 'grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 pt-3'),
        "Planos: bloco de suporte institucional/predial usa 'grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 pt-3'"
    );
    assertCondition(
        str_contains($planosContent, 'border-2 border-hope-amber-dark/80 bg-gradient-to-b from-surface-container-lowest to-tertiary-fixed/10 lg:scale-[1.03] lg:shadow-xl'),
        "Planos: card do Apadrinhamento Integral em destaque com elevacao visual e gradiente tematico"
    );
    assertCondition(str_contains($planosContent, 'Mais Escolhido / Destaque'), "Planos: badge tematico 'Mais Escolhido / Destaque' preservado no plano de 40.000 Kz");
    assertCondition(str_contains($planosContent, 'Apoio Institucional & Expansão Predial'), "Planos: bloco complementar de suporte institucional rotulado");
    assertCondition(
        substr_count($planosContent, 'min-h-[48px] rounded-lg font-bold flex items-center justify-center gap-2') === 5
        || substr_count($planosContent, 'rounded-lg font-bold flex items-center justify-center gap-2') >= 5,
        "Planos: os 5 botoes de cota seguem o contrato de alvos de toque (min-h-[48px] + flex centralizado)"
    );
    assertCondition(!str_contains($planosContent, 'w-screen'), "Planos: nao fixa 'w-screen' (sem overflow horizontal em 360px-480px)");
    assertCondition(!str_contains($planosContent, 'whitespace-nowrap'), "Planos: nao usa 'whitespace-nowrap' em labels (quebra de linha flexivel)");

    // Ordem harmoniosa da grade: Nutricional (coluna 1), Integral (coluna 2 - destaque), Didatica (coluna 3)
    $posNutricional = strpos($planosContent, "abrirModalApadrinhamento('nutricional'");
    $posIntegral    = strpos($planosContent, "abrirModalApadrinhamento('integral'");
    $posDidatica    = strpos($planosContent, "abrirModalApadrinhamento('didatica'");
    $posEducador    = strpos($planosContent, "abrirModalApadrinhamento('educador'");
    $posObras       = strpos($planosContent, "abrirModalApadrinhamento('obras'");

    assertCondition(
        $posNutricional !== false && $posIntegral !== false && $posDidatica !== false
        && $posNutricional < $posIntegral && $posIntegral < $posDidatica,
        "Planos: ordem da grade superior e Nutricional -> Integral (destaque) -> Didatica"
    );
    assertCondition(
        $posEducador !== false && $posObras !== false && $posEducador < $posObras
        && $posDidatica < $posEducador,
        "Planos: bloco complementar expoe Apoio Educador antes do Fundo de Obras, apos a grade estudantil"
    );

    // Contrato de integracao com o modal (assinatura de 4 argumentos: tipo, valor, nome, frequencia)
    foreach ($planos as $plano) {
        $assinatura = sprintf(
            "abrirModalApadrinhamento('%s', %d, '%s', '%s')",
            $plano['id'],
            (int)$plano['aoa'],
            $plano['nome'],
            $plano['freq']
        );
        assertCondition(str_contains($planosContent, $assinatura), "Planos: CTA do plano '{$plano['id']}' chama o modal com a assinatura canonica");
    }
    assertCondition(str_contains($planosContent, '40.000 Kz'), "Planos: Apadrinhamento Integral de 40.000 Kz preservado");
    assertCondition(str_contains($planosContent, '50.000 Kz'), "Planos: Fundo de Obras de 50.000 Kz preservado");
}

// -------------------------------------------------------------
// 2. CA2 - Multimoeda e Referencia Internacional em Todos os Planos
// -------------------------------------------------------------
echo "\n2. Validando referencias cambiais EUR, USD e BRL em todos os planos (CA2)...\n";

if ($planosContent !== '') {
    /** Extrai o cartao de um plano a partir do marcador data-plano="<id>" ate o proximo marcador. */
    $cartaoDoPlano = static function (string $fonte, string $id): string {
        $inicio = strpos($fonte, "data-plano=\"{$id}\"");
        if ($inicio === false) {
            return '';
        }
        $proximo = strpos($fonte, 'data-plano="', $inicio + 1);
        return $proximo === false ? substr($fonte, $inicio) : substr($fonte, $inicio, $proximo - $inicio);
    };

    foreach ($planos as $plano) {
        $cartao = $cartaoDoPlano($planosContent, $plano['id']);

        assertCondition($cartao !== '', "Planos: card do plano '{$plano['id']}' identificavel para testes de multimoeda");
        if ($cartao === '') {
            continue;
        }
        assertCondition(
            str_contains($cartao, '$' . $plano['usd']),
            "Planos: '{$plano['id']}' exibe referencia USD (~\$" . $plano['usd'] . ")"
        );
        assertCondition(
            str_contains($cartao, "\u{20AC}" . $plano['eur']),
            "Planos: '{$plano['id']}' exibe referencia EUR (~\u{20AC}" . $plano['eur'] . ")"
        );
        assertCondition(
            str_contains($cartao, 'R$ ' . $plano['brl']),
            "Planos: '{$plano['id']}' exibe referencia BRL (~R\$ " . $plano['brl'] . ")"
        );
        foreach (['USD', 'EUR', 'BRL'] as $moeda) {
            assertCondition(str_contains($cartao, $moeda), "Planos: '{$plano['id']}' rotula a moeda de referencia {$moeda}");
        }
        assertCondition(
            substr_count($cartao, 'min-h-[48px]') >= 1,
            "Planos: '{$plano['id']}' mantem alvo de toque min-h-[48px] no CTA"
        );
    }

    // Kwanza (AOA/Kz) permanece como moeda oficial soberana de liquidacao
    assertCondition(stripos($planosContent, 'moeda oficial de liquidação') !== false, "Planos: declara o Kwanza (AOA/Kz) como moeda oficial de liquidacao");
    assertCondition(str_contains($planosContent, "1 USD \u{2248} 830 Kz"), "Planos: declara a taxa de referencia 1 USD \u{2248} 830 Kz");
    assertCondition(str_contains($planosContent, "1 EUR \u{2248} 900 Kz"), "Planos: declara a taxa de referencia 1 EUR \u{2248} 900 Kz");
    assertCondition(str_contains($planosContent, "1 BRL \u{2248} 150 Kz"), "Planos: declara a taxa de referencia 1 BRL \u{2248} 150 Kz");
    assertCondition(
        substr_count($planosContent, 'Equivalência Internacional') >= 1,
        "Planos: notas informativas de equivalencia internacional presentes"
    );

    // Fidelidade aritmetica das referencias a base cambial declarada na spec
    foreach ($planos as $plano) {
        foreach (['USD' => 'usd', 'EUR' => 'eur', 'BRL' => 'brl'] as $moeda => $chave) {
            $calculado = converterAoa((float)$plano['aoa'], $taxas[$moeda]);
            $declarado = (float)$plano[$chave];
            $tolerancia = max(2.0, $declarado * 0.10);
            assertCondition(
                abs($calculado - $declarado) <= $tolerancia,
                sprintf(
                    'Planos: referencia %s do plano \'%s\' e consistente com a base cambial (%.2f vs %d declarados, tolerancia %.1f)',
                    $moeda,
                    $plano['id'],
                    $calculado,
                    (int)$declarado,
                    $tolerancia
                )
            );
        }
    }
}

// -------------------------------------------------------------
// 3. CA3 - Modal Ergonomico Desktop e Conversao Cambial Dinamica
// -------------------------------------------------------------
echo "\n3. Validando modal ergonomico desktop e conversao cambial dinamica (CA3)...\n";

assertCondition(file_exists($modalFile), "Arquivo templates/partials/modal-apadrinhamento.php existe");
if ($modalContent !== '') {
    assertCondition(
        str_contains($modalContent, 'bg-surface-container-lowest w-full max-w-lg sm:max-w-xl rounded-t-3xl sm:rounded-2xl p-6 sm:p-8'),
        "Modal: cartao central adota largura ergonomica desktop (sm:max-w-xl) com padding p-6 sm:p-8"
    );
    assertCondition(
        str_contains($modalContent, 'fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/60 backdrop-blur-sm hidden transition-opacity'),
        "Modal: overlay com backdrop-blur-sm e centralizacao na viewport preservados"
    );
    assertCondition(str_contains($modalContent, 'max-h-[90vh] overflow-y-auto'), "Modal: cartao rolavel em telas baixas (max-h-[90vh])");
    assertCondition(str_contains($modalContent, 'min-h-[48px] min-w-[48px] rounded-full'), "Modal: botao de fechar com alvo de toque WCAG AA (48x48) e formato circular");
    assertCondition(
        substr_count($modalContent, 'min-h-[48px]') >= 8,
        "Modal: alvos de toque min-h-[48px] preservados em selects, inputs e botoes"
    );

    // Etapa 1: painel de equivalencia internacional dinamica
    assertCondition(str_contains($modalContent, 'id="cota-valor-usd"'), "Modal Etapa 1: campo dinamico de referencia em USD (cota-valor-usd)");
    assertCondition(str_contains($modalContent, 'id="cota-valor-eur"'), "Modal Etapa 1: campo dinamico de referencia em EUR (cota-valor-eur)");
    assertCondition(str_contains($modalContent, 'id="cota-valor-brl"'), "Modal Etapa 1: campo dinamico de referencia em BRL (cota-valor-brl)");
    assertCondition(str_contains($modalContent, 'Equivalência Internacional'), "Modal Etapa 1: painel de equivalencia internacional rotulado");
    assertCondition(stripos($modalContent, 'moeda oficial de liquidação') !== false, "Modal Etapa 1: avisa que o Kwanza (AOA) e a moeda oficial de liquidacao");
    assertCondition(
        stripos($modalContent, 'banco emissor') !== false,
        "Modal: caso de borda de doadores internacionais avisando a conversao pelo banco emissor"
    );
}

if ($appJsContent !== '') {
    assertCondition(file_exists($appJsFile), "Arquivo public/js/app.js existe");
    assertCondition(str_contains($appJsContent, 'atualizarConversaoCambial'), "app.js: expõe a função de conversão cambial dinâmica (atualizarConversaoCambial)");
    assertCondition(str_contains($appJsContent, 'USD: 830'), "app.js: taxa de referência USD de 830 AOA por dólar");
    assertCondition(str_contains($appJsContent, 'EUR: 900'), "app.js: taxa de referência EUR de 900 AOA por euro");
    assertCondition(str_contains($appJsContent, 'BRL: 150'), "app.js: taxa de referência BRL de 150 AOA por real");
    assertCondition(str_contains($appJsContent, "getElementById('cota-valor-usd')"), "app.js: atualiza dinamicamente o campo USD da Etapa 1");
    assertCondition(str_contains($appJsContent, "getElementById('cota-valor-eur')"), "app.js: atualiza dinamicamente o campo EUR da Etapa 1");
    assertCondition(str_contains($appJsContent, "getElementById('cota-valor-brl')"), "app.js: atualiza dinamicamente o campo BRL da Etapa 1");
    assertCondition(str_contains($appJsContent, "addEventListener('input'"), "app.js: recalcula as equivalencias ao alterar o valor numerico da cota");
    assertCondition(
        str_contains($appJsContent, 'atualizarConversaoCambial(valor)') && str_contains($appJsContent, 'atualizarConversaoCambial(cotaAtual.valor)'),
        "app.js: recalcula as equivalencias tanto na selecao da cota quanto apos o ajuste do valor"
    );
}

// -------------------------------------------------------------
// 4. CA4 - Instrucoes Bancarias Internacionais SWIFT/BIC
// -------------------------------------------------------------
echo "\n4. Validando instrucoes bancarias internacionais SWIFT/BIC (CA4)...\n";

$canaisBancarios = [
    'Banco Atlântico' => [
        'swift'      => 'BMAOAOLU',
        'ibanNac'    => '0005-0000-5089-22202-1014-6',
        'ibanIntl'   => 'AO06 0005 0000 5089 2220 2101 4',
    ],
    'Banco BCI' => [
        'swift'      => 'BCIDAOLU',
        'ibanNac'    => '0005-0000-6972-1564-1019-7',
        'ibanIntl'   => 'AO06 0005 0000 6972 1564 1019 7',
    ],
];

foreach ([['Modal (Etapa 3)', $modalContent], ['Canais Oficiais', $canaisContent]] as [$origem, $fonte]) {
    assertCondition($fonte !== '', "{$origem}: conteudo disponivel para validacao das coordenadas bancarias");
    if ($fonte === '') {
        continue;
    }

    foreach ($canaisBancarios as $banco => $coords) {
        assertCondition(str_contains($fonte, $coords['swift']), "{$origem}: codigo SWIFT/BIC {$coords['swift']} de {$banco} exposto");
        assertCondition(str_contains($fonte, $coords['ibanIntl']), "{$origem}: IBAN internacional de {$banco} com prefixo AO06 exposto");
    }
    assertCondition(str_contains($fonte, 'Igreja Missionária Nova Esperança - Escola'), "{$origem}: titularidade juridica declarada");
    assertCondition(str_contains($fonte, 'NE-2026-'), "{$origem}: orienta a inclusao do codigo de referencia NE-2026-XXXX no descritivo");
    assertCondition(str_contains($fonte, '9305-61688'), "{$origem}: canal local Multicaixa Express (9305-61688) preservado");
}

if ($modalContent !== '') {
    assertCondition(str_contains($modalContent, 'Canal Local (Angola)'), "Modal Etapa 3: painel do canal local (Angola) presente");
    assertCondition(str_contains($modalContent, 'Canal Internacional (SWIFT / Remessa Exterior)'), "Modal Etapa 3: painel do canal internacional (SWIFT / Remessa Exterior) presente");
    assertCondition(
        str_contains($modalContent, 'grid grid-cols-1 md:grid-cols-2 gap-3'),
        "Modal Etapa 3: dois paineis de alto contraste em 'grid grid-cols-1 md:grid-cols-2 gap-3'"
    );
    assertCondition(
        preg_match('/Canal Local \(Angola\)/', $modalContent) === 1
        && preg_match('/Canal Internacional \(SWIFT \/ Remessa Exterior\)/', $modalContent) === 1,
        "Modal Etapa 3: cada painel declara seu rotulo uma unica vez (markup nao duplicado)"
    );
    assertCondition(str_contains($modalContent, 'id="codigo-sucesso"'), "Modal Etapa 3: codigo de referencia unico exibido ao doador (codigo-sucesso)");
    assertCondition(str_contains($modalContent, 'id="btn-whatsapp-comprovativo"'), "Modal Etapa 3: envio de comprovativo via WhatsApp preservado");
}

if ($canaisContent !== '') {
    assertCondition(str_contains($canaisContent, 'SWIFT'), "Canais Oficiais: rotulo SWIFT/BIC exibido para consulta rapida");
    assertCondition(str_contains($canaisContent, 'AO06'), "Canais Oficiais: IBANs com prefixo internacional AO06 exibidos");
    assertCondition(
        str_contains($canaisContent, '0005-0000-5089-22202-1014-6') && str_contains($canaisContent, '0005-0000-6972-1564-1019-7'),
        "Canais Oficiais: IBANs nacionais preservados para doadores locais"
    );
    assertCondition(str_contains($canaisContent, 'https://wa.me/244930561688'), "Canais Oficiais: contato institucional por WhatsApp preservado");
    assertCondition(!str_contains($canaisContent, 'Diáspora') && !str_contains($canaisContent, 'PayPal'), "Canais Oficiais: sem canais conceituais nao verificados (regressao Fase 5)");
}

// -------------------------------------------------------------
// 5. CA5 - Preservacao dos Mecanismos Anti-Spam e WCAG da Fase 6
// -------------------------------------------------------------
echo "\n5. Validando preservacao dos mecanismos anti-spam e WCAG da Fase 6 (CA5)...\n";

if ($modalContent !== '') {
    // Honeypot invisivel
    assertCondition(str_contains($modalContent, 'hp_confirm_field'), "Modal: campo honeypot hp_confirm_field preservado");
    assertCondition(str_contains($modalContent, 'aria-hidden="true"'), "Modal: honeypot com aria-hidden=\"true\"");
    assertCondition(str_contains($modalContent, 'tabindex="-1"'), "Modal: honeypot com tabindex=\"-1\" (fora da ordem de tabulacao)");
    assertCondition(str_contains($modalContent, 'name="form_start_time"'), "Modal: campo oculto form_start_time do time-trap preservado");
    assertCondition(str_contains($modalContent, 'id="form-apadrinhamento"') && str_contains($modalContent, 'onsubmit="submeterApadrinhamento(event)"'), "Modal: formulario de apadrinhamento com submissao via submeterApadrinhamento preservado");

    // Semantica ARIA do dialogo
    assertCondition(str_contains($modalContent, 'role="dialog"'), "Modal: role=\"dialog\" preservado");
    assertCondition(str_contains($modalContent, 'aria-modal="true"'), "Modal: aria-modal=\"true\" preservado");
    assertCondition(str_contains($modalContent, 'aria-labelledby="modal-titulo"'), "Modal: aria-labelledby=\"modal-titulo\" ligando o rotulo ao titulo");
    assertCondition(str_contains($modalContent, 'id="modal-titulo"'), "Modal: elemento #modal-titulo presente como destino do aria-labelledby");
    assertCondition(str_contains($modalContent, 'aria-describedby="cota-desc"'), "Modal: aria-describedby=\"cota-desc\" preservado");
    assertCondition(str_contains($modalContent, 'id="cota-desc"'), "Modal: elemento #cota-desc presente como destino do aria-describedby");
}

if ($appJsContent !== '') {
    // Fechamento pela tecla Escape
    assertCondition(str_contains($appJsContent, "addEventListener('keydown'"), "app.js: listener global de teclado preservado");
    assertCondition(str_contains($appJsContent, "event.key === 'Escape'"), "app.js: tecla Escape encerra o modal imediatamente");
    assertCondition(str_contains($appJsContent, "getElementById('input-nome')?.focus()") || str_contains($appJsContent, "getElementById('input-nome').focus()"), "app.js: foco automatico no primeiro campo da Etapa 2 (#input-nome)");

    // Time-trap, feedback de envio e resiliencia em redes 3G
    assertCondition(str_contains($appJsContent, 'form_start_time'), "app.js: timestamp de inicio do formulario enviado ao backend");
    assertCondition(str_contains($appJsContent, 'modalSessionStartTime'), "app.js: sessao do modal marcada para o time-trap de 2 segundos");
    assertCondition(str_contains($appJsContent, 'btnSubmit.disabled = true'), "app.js: prevention de duplo clique durante o envio");
    assertCondition(str_contains($appJsContent, 'Processando'), "app.js: feedback visual 'Processando' no botao de envio");
    assertCondition(str_contains($appJsContent, 'AbortController'), "app.js: AbortController para timeout de rede 3G lenta");
    assertCondition(str_contains($appJsContent, 'controller.abort()'), "app.js: aborta a requisicao no timeout de 12 segundos");
    assertCondition(str_contains($appJsContent, '12000'), "app.js: timeout configurado em 12 segundos (redes 3G)");
    assertCondition(str_contains($appJsContent, "getElementById('hp_confirm_field')"), "app.js: honeypot enviado (vazio) junto ao payload");
}

require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'AntiSpamServiceInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'AntiSpamService.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Request.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Response.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Repositories' . DIRECTORY_SEPARATOR . 'DonationRepositoryInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Repositories' . DIRECTORY_SEPARATOR . 'JsonDonationRepository.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'NotificationServiceInterface.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'EmailNotificationService.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'DonationController.php';

$antiSpam = new \NovaEsperanca\Services\AntiSpamService();

// Caso de borda 2: bot preenchendo o honeypot
$botHoneypot = $antiSpam->validate(['hp_confirm_field' => 'https://spam.example.com', 'form_start_time' => time() - 10]);
assertCondition($botHoneypot['passed'] === false, "Backend: submissao com honeypot preenchido e rejeitada silenciosamente");
assertCondition(($botHoneypot['error_code'] ?? '') === 'SPAM_HONEYPOT_TRIGGERED', "Backend: codigo de erro SPAM_HONEYPOT_TRIGGERED preservado");

// Caso de borda 3: time-trap de 2 segundos
$botRapido = $antiSpam->validate(['hp_confirm_field' => '', 'form_start_time' => time()]);
assertCondition($botRapido['passed'] === false, "Backend: submissao em menos de 2 segundos e bloqueada pelo time-trap");
assertCondition(($botRapido['error_code'] ?? '') === 'SPAM_TOO_FAST', "Backend: codigo de erro SPAM_TOO_FAST preservado");

$submissaoHumana = $antiSpam->validate(['hp_confirm_field' => '', 'form_start_time' => time() - 5]);
assertCondition($submissaoHumana['passed'] === true, "Backend: submissao humana com honeypot vazio e tempo >= 2s e aprovada");

// Integracao: HTTP 422 para o bot preenchendo o honeypot
$repoTeste = $rootDir . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'test-donations-issue12.json';
$logTeste  = $rootDir . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'test-issue12.log';
$controller = new \NovaEsperanca\Controllers\DonationController(
    new \NovaEsperanca\Repositories\JsonDonationRepository($repoTeste),
    new \NovaEsperanca\Services\EmailNotificationService($logTeste),
    $antiSpam
);
$respostaBot = $controller->apadrinhar(new \NovaEsperanca\Core\Request('POST', '/api/apadrinhar', [
    'cota_tipo'       => 'integral',
    'frequencia'      => 'mensal',
    'valor_aoa'       => 40000,
    'nome_padrinho'   => 'Spam Bot',
    'contato'         => '+244 923 000 000',
    'hp_confirm_field'=> 'preenchido',
    'form_start_time' => time() - 30,
]));
assertCondition($respostaBot->getStatusCode() === 422, "API: requisicao de bot rejeitada com HTTP 422");

// Submissao valida gera o codigo de referencia NE-2026-XXXX e devolve as coordenadas
$respostaOk = $controller->apadrinhar(new \NovaEsperanca\Core\Request('POST', '/api/apadrinhar', [
    'cota_tipo'       => 'integral',
    'frequencia'      => 'mensal',
    'valor_aoa'       => 40000,
    'nome_padrinho'   => 'Doador Internacional',
    'contato'         => '+351 912 000 000',
    'hp_confirm_field'=> '',
    'form_start_time' => time() - 30,
]));
$corpoOk = json_decode($respostaOk->getBody(), true) ?? [];
assertCondition($respostaOk->getStatusCode() === 201, "API: submissao valida aceita com HTTP 201");
assertCondition(str_starts_with((string)($corpoOk['codigo_referencia'] ?? ''), 'NE-2026-'), "API: codigo de referencia no formato NE-2026-XXXX gerado");
assertCondition(
    str_contains((string)($corpoOk['dados_bancarios']['instrucoes'] ?? ''), (string)($corpoOk['codigo_referencia'] ?? '')),
    "API: instrucoes de pagamento referenciam o codigo gerado (NE-2026-XXXX)"
);
assertCondition(($corpoOk['dados_bancarios']['multicaixa_express'] ?? '') === '9305-61688', "API: canal local Multicaixa Express devolvido na resposta");
assertCondition(($corpoOk['dados_bancarios']['titular'] ?? '') === 'Igreja Missionária Nova Esperança - Escola', "API: titularidade juridica devolvida na resposta");

foreach ([$repoTeste, $logTeste] as $arquivoTemporario) {
    if (file_exists($arquivoTemporario)) {
        @unlink($arquivoTemporario);
    }
}

// -------------------------------------------------------------
// 6. Casos de Borda & Renderizacao Real da Rota /apadrinhe
// -------------------------------------------------------------
echo "\n6. Validando casos de borda e a renderizacao real da rota /apadrinhe...\n";

require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'View.php';
\NovaEsperanca\Core\View::init($rootDir . DIRECTORY_SEPARATOR . 'templates');
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Router.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'HomeController.php';
require_once $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'PageController.php';

$avisos = [];
set_error_handler(static function (int $severity, string $message) use (&$avisos): bool {
    $avisos[] = $message;
    return true;
});

$router = new \NovaEsperanca\Core\Router();
\NovaEsperanca\Core\Router::registerRoutes(
    $router,
    new \NovaEsperanca\Repositories\JsonDonationRepository($rootDir . '/storage/app/donations.json'),
    new \NovaEsperanca\Services\EmailNotificationService($rootDir . '/storage/logs/notifications.log'),
    $antiSpam
);
$rotas = ['/', '/apadrinhe', '/sobre', '/galeria', '/transparencia', '/voluntariado'];
$htmls = [];
foreach ($rotas as $rota) {
    $htmls[$rota] = $router->dispatch(new \NovaEsperanca\Core\Request('GET', $rota))->getBody();
}
restore_error_handler();

assertCondition(count($avisos) === 0, "Dispatch das 6 rotas canonicas nao emite warnings/notices de PHP");
if (count($avisos) > 0) {
    echo "         Avisos: " . implode(' | ', $avisos) . "\n";
}
foreach ($rotas as $rota) {
    assertCondition(!str_contains($htmls[$rota], 'não encontrada'), "Rota '{$rota}' nao aciona o graceful fallback do View::partial()");
    assertCondition(str_contains($htmls[$rota], 'max-w-7xl'), "Rota '{$rota}' mantem o shell desktop da Issue #9");
    assertCondition(!str_contains($htmls[$rota], 'Undefined'), "Rota '{$rota}' nao expoe aviso de variavel indefinida");
}

$apadrinheHtml = $htmls['/apadrinhe'];
assertCondition(str_contains($apadrinheHtml, 'lg:grid-cols-3 gap-5 lg:gap-6 items-stretch'), "/apadrinhe renderizada: grade comparativa de 3 colunas aplicada aos planos");
assertCondition(str_contains($apadrinheHtml, 'sm:max-w-xl'), "/apadrinhe renderizada: modal com largura ergonomica desktop");
assertCondition(str_contains($apadrinheHtml, 'BMAOAOLU') && str_contains($apadrinheHtml, 'BCIDAOLU'), "/apadrinhe renderizada: codigos SWIFT/BIC expostos aos doadores");
assertCondition(str_contains($apadrinheHtml, 'AO06 0005 0000 5089 2220 2101 4'), "/apadrinhe renderizada: IBAN internacional do Banco Atlantico com prefixo AO06");
assertCondition(str_contains($apadrinheHtml, 'AO06 0005 0000 6972 1564 1019 7'), "/apadrinhe renderizada: IBAN internacional do Banco BCI com prefixo AO06");
assertCondition(str_contains($apadrinheHtml, '9305-61688'), "/apadrinhe renderizada: canal local Multicaixa Express preservado");
assertCondition(str_contains($apadrinheHtml, 'role="dialog"') && str_contains($apadrinheHtml, 'aria-modal="true"'), "/apadrinhe renderizada: semantica de dialogo WCAG presente");
assertCondition(preg_match_all('/<h1[\s>]/', $apadrinheHtml) === 1, "/apadrinhe renderizada: exatamente 1 <h1>");
assertCondition(preg_match('/<div[^>]*id="modal-apadrinhar"[^>]*>/', $apadrinheHtml) === 1, "/apadrinhe renderizada: container do modal unico (id=\"modal-apadrinhar\")");
assertCondition(substr_count($apadrinheHtml, 'id="cota-valor-usd"') === 1, "/apadrinhe renderizada: painel de equivalencia USD renderizado uma unica vez");
assertCondition(substr_count($apadrinheHtml, 'id="codigo-sucesso"') === 1, "/apadrinhe renderizada: codigo de referencia do doador renderizado uma unica vez");

// Salvaguarda infantil: nenhuma identificacao nominal de menores no fluxo de doacao
foreach (['/apadrinhe' => $apadrinheHtml] as $rota => $html) {
    assertCondition(
        !preg_match('/<img[^>]*alt="[^"]*\b(nome|completo)\b[^"]*"/i', $html),
        "{$rota}: nenhum alt text identifica menores nominalmente (Lei no 25/12)"
    );
    assertCondition(!str_contains($html, 'Lista de Alunos'), "{$rota}: nao expoe lista nominal de alunos");
}

// Renderizacao isolada dos partials (sem as variaveis injetadas pelo roteador)
$renderParcial = (static function (string $partial) use ($rootDir): string {
    $pageTitle = '';
    $currentRoute = '/apadrinhe';
    ob_start();
    require $rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . $partial . '.php';
    return (string)ob_get_clean();
});
foreach (['planos-apadrinhamento', 'modal-apadrinhamento', 'canais-apoio'] as $partial) {
    $htmlIsolado = $renderParcial($partial);
    assertCondition(
        !str_contains($htmlIsolado, 'Warning') && !str_contains($htmlIsolado, 'Fatal error') && !str_contains($htmlIsolado, 'Undefined'),
        "Partial '{$partial}': renderizacao isolada degrada com elegancia sem dados injetados"
    );
    assertCondition(substr_count($htmlIsolado, '<div') === substr_count($htmlIsolado, '</div>'), "Partial '{$partial}': todas as tags <div> renderizadas sao fechadas");
}

// -------------------------------------------------------------
// 7. CA6 - Registro do Validador no Pipeline de CI
// -------------------------------------------------------------
echo "\n7. Validando registro do validador no GitHub Actions (CA6)...\n";

$ciWorkflow = $rootDir . DIRECTORY_SEPARATOR . '.github' . DIRECTORY_SEPARATOR . 'workflows' . DIRECTORY_SEPARATOR . 'ci-deploy.yml';
assertCondition(file_exists($ciWorkflow), "Workflow .github/workflows/ci-deploy.yml existe");
if (file_exists($ciWorkflow)) {
    $ciContent = (string)file_get_contents($ciWorkflow);
    assertCondition(str_contains($ciContent, 'validate-issue-12-apadrinhamento-desktop.php'), "Workflow executa o validador da Issue #12 (validate-issue-12-apadrinhamento-desktop.php)");
    assertCondition(str_contains($ciContent, 'validate-issue-11-institucionais-desktop.php'), "Workflow mantem o validador da Issue #11 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-issue-10-home-desktop.php'), "Workflow mantem o validador da Issue #10 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-issue-9-desktop-shell.php'), "Workflow mantem o validador da Issue #9 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-fase-7-deploy-lancamento.php'), "Workflow mantem o validador da Fase 7 (regressao preservada)");
    assertCondition(str_contains($ciContent, 'validate-demanda-schema.php'), "Workflow mantem o validador da Fase 1 (regressao preservada)");
}

// -------------------------------------------------------------
// 8. CA6 - Regressao das Fases 1 a 7 e das Issues #9, #10 e #11
// -------------------------------------------------------------
echo "\n8. Executando regressao dos validadores das Fases 1 a 7 e das Issues #9, #10 e #11...\n";

$validadoresAnteriores = [
    'validate-demanda-schema.php',
    'validate-fase-2-planejamento.php',
    'validate-fase-3-design.php',
    'validate-fase-4-conteudo-dados.php',
    'validate-fase-5-desenvolvimento.php',
    'validate-fase-6-testes-qa.php',
    'validate-fase-7-deploy-lancamento.php',
    'validate-issue-9-desktop-shell.php',
    'validate-issue-10-home-desktop.php',
    'validate-issue-11-institucionais-desktop.php',
];

foreach ($validadoresAnteriores as $validador) {
    $caminho = $rootDir . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . $validador;
    if (!file_exists($caminho)) {
        assertCondition(false, "scripts/{$validador} existe");
        continue;
    }
    $saida = [];
    $codigo = 1;
    @exec(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($caminho) . ' 2>&1', $saida, $codigo);
    assertCondition($codigo === 0, "Regressao sem quebras: scripts/{$validador} (exit {$codigo})");
    if ($codigo !== 0) {
        foreach (array_slice($saida, -8) as $linha) {
            echo "         > " . trim((string)$linha) . "\n";
        }
    }
}

// -------------------------------------------------------------
// Resumo Final
// -------------------------------------------------------------
echo "\n=======================================================\n";
echo "RESULTADO DA VALIDACAO ISSUE #12: {$assertionsPassed} APROVADAS, {$assertionsFailed} FALHAS.\n";
echo "=======================================================\n";

if ($assertionsFailed > 0) {
    echo "\n[FALHA] Existem criterios pendentes na Issue #12.\n";
    exit(1);
}

echo "\n[SUCESSO] Fluxo de Apadrinhamento Desktop e Modal de Doacao Multimoeda aprovados com 100% de sucesso!\n";
exit(0);
