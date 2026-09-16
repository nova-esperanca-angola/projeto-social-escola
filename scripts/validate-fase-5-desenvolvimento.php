<?php
declare(strict_types=1);

/**
 * Suíte de Testes Automatizados - WDLC Fase 5: Aplicação PHP & Mockup Stitch (Issue #5)
 * Valida a arquitetura modular em PHP 8.2+, fidelidade visual ao mockup Stitch (Tela 7d8a046430cc4a9488c0004d4e9aeb38),
 * roteamento nativo das 6 rotas, renderização de templates, processamento do formulário de apadrinhamento e notificações.
 */

$rootDir = dirname(__DIR__);

// Arquivos Essenciais do Core e Roteamento
$fileIndex = $rootDir . '/public/index.php';
$fileJsApp = $rootDir . '/public/js/app.js';
$fileRouter = $rootDir . '/src/Core/Router.php';
$fileRequest = $rootDir . '/src/Core/Request.php';
$fileResponse = $rootDir . '/src/Core/Response.php';
$fileView = $rootDir . '/src/Core/View.php';

// Controladores
$fileHomeController = $rootDir . '/src/Controllers/HomeController.php';
$filePageController = $rootDir . '/src/Controllers/PageController.php';
$fileDonationController = $rootDir . '/src/Controllers/DonationController.php';

// Serviços de Notificação
$fileNotifInterface = $rootDir . '/src/Services/NotificationServiceInterface.php';
$fileEmailService = $rootDir . '/src/Services/EmailNotificationService.php';

// Templates do Layout e Parciais do Mockup Stitch
$fileLayoutMain = $rootDir . '/templates/layouts/main.php';
$filePartialTopBar = $rootDir . '/templates/partials/top-app-bar.php';
$filePartialBottomNav = $rootDir . '/templates/partials/bottom-nav.php';
$filePartialHero = $rootDir . '/templates/partials/hero.php';
$filePartialBento = $rootDir . '/templates/partials/bento-impacto.php';
$filePartialTermometro = $rootDir . '/templates/partials/termometro-obras.php';
$filePartialPlanos = $rootDir . '/templates/partials/planos-apadrinhamento.php';
$filePartialWidgetDiag = $rootDir . '/templates/partials/widget-diagnostico.php';
$filePartialCanais = $rootDir . '/templates/partials/canais-apoio.php';
$filePartialModal = $rootDir . '/templates/partials/modal-apadrinhamento.php';

// Páginas
$filePageHome = $rootDir . '/templates/pages/home.php';
$filePageSobre = $rootDir . '/templates/pages/sobre.php';
$filePageApadrinhe = $rootDir . '/templates/pages/apadrinhe.php';
$filePageTransparencia = $rootDir . '/templates/pages/transparencia.php';
$filePageGaleria = $rootDir . '/templates/pages/galeria.php';
$filePageVoluntariado = $rootDir . '/templates/pages/voluntariado.php';

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
echo "  TEST SUITE: Fase 5 - Aplicação PHP & Mockup Stitch" . PHP_EOL;
echo "==========================================================" . PHP_EOL . PHP_EOL;

// 1. Verificação de Arquivos Obrigatórios
assertTest(file_exists($fileIndex), "Front Controller public/index.php deve existir");
assertTest(file_exists($fileJsApp), "Script JavaScript public/js/app.js deve existir");
assertTest(file_exists($fileRouter), "Classe Router deve existir");
assertTest(file_exists($fileRequest), "Classe Request deve existir");
assertTest(file_exists($fileResponse), "Classe Response deve existir");
assertTest(file_exists($fileView), "Classe View deve existir");
assertTest(file_exists($fileHomeController), "Classe HomeController deve existir");
assertTest(file_exists($filePageController), "Classe PageController deve existir");
assertTest(file_exists($fileDonationController), "Classe DonationController deve existir");
assertTest(file_exists($fileNotifInterface), "Interface NotificationServiceInterface deve existir");
assertTest(file_exists($fileEmailService), "Classe EmailNotificationService deve existir");
assertTest(file_exists($fileLayoutMain), "Layout mestre templates/layouts/main.php deve existir");
assertTest(file_exists($filePartialTopBar), "Partial top-app-bar.php deve existir");
assertTest(file_exists($filePartialBottomNav), "Partial bottom-nav.php deve existir");
assertTest(file_exists($filePartialHero), "Partial hero.php deve existir");
assertTest(file_exists($filePartialBento), "Partial bento-impacto.php deve existir");
assertTest(file_exists($filePartialTermometro), "Partial termometro-obras.php deve existir");
assertTest(file_exists($filePartialPlanos), "Partial planos-apadrinhamento.php deve existir");
assertTest(file_exists($filePartialWidgetDiag), "Partial widget-diagnostico.php deve existir");
assertTest(file_exists($filePartialCanais), "Partial canais-apoio.php deve existir");
assertTest(file_exists($filePartialModal), "Partial modal-apadrinhamento.php deve existir");
assertTest(file_exists($filePageHome), "Página home.php deve existir");
assertTest(file_exists($filePageSobre), "Página sobre.php deve existir");
assertTest(file_exists($filePageApadrinhe), "Página apadrinhe.php deve existir");
assertTest(file_exists($filePageTransparencia), "Página transparencia.php deve existir");
assertTest(file_exists($filePageGaleria), "Página galeria.php deve existir");
assertTest(file_exists($filePageVoluntariado), "Página voluntariado.php deve existir");

$criticalFilesMissing = !file_exists($fileIndex) || !file_exists($fileRouter) ||
                        !file_exists($fileLayoutMain) || !file_exists($fileDonationController);

if ($criticalFilesMissing) {
    echo PHP_EOL . "⚠️ Interrompendo testes aprofundados: componentes essenciais da Fase 5 ainda não criados (Fase RED confirmada)." . PHP_EOL;
    echo "Total de asserções executadas: {$assertions}" . PHP_EOL;
    echo "Total de falhas registradas: " . count($failures) . PHP_EOL;
    exit(1);
}

// 2. Validação da Fidelidade Visual ao Mockup Stitch (Projeto 5162131248924929494 / Tela 7d8a046430cc4a9488c0004d4e9aeb38)
$layoutContent = file_get_contents($fileLayoutMain);
assertTest(str_contains($layoutContent, 'cdn.tailwindcss.com'), "Layout deve carregar Tailwind CSS");
assertTest(str_contains($layoutContent, 'Plus+Jakarta+Sans'), "Layout deve importar tipografia Plus Jakarta Sans do Stitch");
assertTest(str_contains($layoutContent, 'family=Inter'), "Layout deve importar tipografia Inter do Stitch");
assertTest(str_contains($layoutContent, 'Material+Symbols+Outlined'), "Layout deve importar ícones Material Symbols Outlined");
assertTest(str_contains($layoutContent, 'hope-amber-dark') || str_contains($layoutContent, 'nutrition-green'), "Layout deve conter configuração com tokens de cores do Stitch");

// Top App Bar do Mockup
$topBarContent = file_get_contents($filePartialTopBar);
assertTest(str_contains($topBarContent, 'Escola Nova Esperança'), "Top App Bar deve exibir o nome da escola");
assertTest(str_contains($topBarContent, 'Kifangondo, Luanda · Angola'), "Top App Bar deve exibir a localização oficial");
assertTest(str_contains($topBarContent, 'Impacto') && str_contains($topBarContent, 'Verificado'), "Top App Bar deve exibir selo de Impacto Verificado");

// Bottom Navigation do Mockup
$bottomNavContent = file_get_contents($filePartialBottomNav);
assertTest(str_contains($bottomNavContent, 'Início'), "Bottom Nav deve ter link Início");
assertTest(str_contains($bottomNavContent, 'Impacto'), "Bottom Nav deve ter link Impacto");
assertTest(str_contains($bottomNavContent, 'Apadrinhar'), "Bottom Nav deve ter link em destaque Apadrinhar");
assertTest(str_contains($bottomNavContent, 'Obras'), "Bottom Nav deve ter link Obras");

// Bento Grid 2x2 do Mockup
$bentoContent = file_get_contents($filePartialBento);
assertTest(str_contains($bentoContent, '93'), "Bento Grid deve exibir métrica de 93 alunos");
assertTest((str_contains($bentoContent, '08') || str_contains($bentoContent, '8')) && (str_contains($bentoContent, 'Salas') || str_contains($bentoContent, 'salas')), "Bento Grid deve exibir 08 salas de aula");
assertTest(str_contains($bentoContent, '10') && (str_contains($bentoContent, 'Colaboradores') || str_contains($bentoContent, 'colaboradores')), "Bento Grid deve exibir 10 colaboradores");
assertTest(str_contains($bentoContent, '100%') && (str_contains($bentoContent, 'Merenda') || str_contains($bentoContent, 'merenda')), "Bento Grid deve exibir 100% de merenda garantida");

// Termômetro Linear do Mockup
$termometroContent = file_get_contents($filePartialTermometro);
assertTest(str_contains($termometroContent, '15.000.000 Kz') || str_contains($termometroContent, '15.000.000'), "Termômetro deve exibir meta de 15.000.000 Kz");
assertTest(str_contains($termometroContent, '4.850.000 Kz') || str_contains($termometroContent, '4.850.000'), "Termômetro deve exibir arrecadação de 4.850.000 Kz");
assertTest(str_contains($termometroContent, 'Terraplanagem'), "Termômetro deve conter marco de Terraplanagem");
assertTest(str_contains($termometroContent, 'Alvenaria') || str_contains($termometroContent, 'Sapatas'), "Termômetro deve conter marco de Alvenaria/Sapatas");
assertTest(str_contains($termometroContent, 'Cobertura'), "Termômetro deve conter marco de Cobertura");

// Planos de Apoio
$planosContent = file_get_contents($filePartialPlanos);
assertTest(str_contains($planosContent, '12.500 Kz') || str_contains($planosContent, '12500'), "Planos devem conter Cota Nutricional de 12.500 Kz");
assertTest(str_contains($planosContent, '8.500 Kz') || str_contains($planosContent, '8500'), "Planos devem conter Cota Didática de 8.500 Kz");
assertTest(str_contains($planosContent, '25.000 Kz') || str_contains($planosContent, '25000'), "Planos devem conter Apoio Educador de 25.000 Kz");
assertTest(str_contains($planosContent, '40.000 Kz') || str_contains($planosContent, '40000'), "Planos devem conter Apadrinhamento Integral de 40.000 Kz em destaque");
assertTest(str_contains($planosContent, '50.000 Kz') || str_contains($planosContent, '50000'), "Planos devem conter Fundo de Obras de 50.000 Kz");

// Canais Oficiais de Doação
$canaisContent = file_get_contents($filePartialCanais);
assertTest(str_contains($canaisContent, 'Multicaixa Express') && str_contains($canaisContent, '9305-61688'), "Canais devem exibir Multicaixa Express 9305-61688");
assertTest(str_contains($canaisContent, 'Banco Atlântico') && str_contains($canaisContent, 'Banco BCI'), "Canais devem exibir Banco Atlântico e Banco BCI");
assertTest(!str_contains($canaisContent, 'Diáspora Global'), "Canais oficiais focam exclusivamente nos dados reais (sem Diáspora conceitual)");
assertTest(str_contains($canaisContent, 'WhatsApp') || str_contains($canaisContent, 'whatsapp'), "Canais devem exibir contato WhatsApp com a Coordenação");

// 3. Validação do Roteamento e Renderização das Páginas
require_once $fileRequest;
require_once $fileResponse;
require_once $fileView;
require_once $fileRouter;
require_once $rootDir . '/src/Repositories/DonationRepositoryInterface.php';
require_once $rootDir . '/src/Repositories/JsonDonationRepository.php';
require_once $fileNotifInterface;
require_once $fileEmailService;
require_once $fileHomeController;
require_once $filePageController;
require_once $fileDonationController;

// Instanciar dependências do App
$storageDir = $rootDir . '/storage/app';
$logsDir = $rootDir . '/storage/logs';
$donationsFile = $storageDir . '/test-donations-fase-5.json';
$donationRepo = new NovaEsperanca\Repositories\JsonDonationRepository($donationsFile);
$notifService = new NovaEsperanca\Services\EmailNotificationService($logsDir . '/test-notifications.log');

$router = new NovaEsperanca\Core\Router();
NovaEsperanca\Core\Router::registerRoutes($router, $donationRepo, $notifService);

// Teste de Rota GET /
$reqHome = new NovaEsperanca\Core\Request('GET', '/');
$resHome = $router->dispatch($reqHome);
assertTest($resHome->getStatusCode() === 200, "Rota GET / deve retornar status 200");
$bodyHome = $resHome->getBody();
assertTest(str_contains($bodyHome, 'Escola Nova Esperança'), "Home deve conter o nome institucional");
assertTest(str_contains($bodyHome, '93'), "Home deve conter o indicador de 93 alunos matriculados");
assertTest(str_contains($bodyHome, '15.000.000'), "Home deve conter o termômetro de 15.000.000 Kz");

// Teste de Rota GET /sobre
$reqSobre = new NovaEsperanca\Core\Request('GET', '/sobre');
$resSobre = $router->dispatch($reqSobre);
assertTest($resSobre->getStatusCode() === 200, "Rota GET /sobre deve retornar status 200");
$bodySobre = $resSobre->getBody();
assertTest(str_contains($bodySobre, 'Kifangondo'), "Página Sobre deve contextualizar Kifangondo");
assertTest(str_contains($bodySobre, '13.8') || str_contains($bodySobre, '13,8'), "Página Sobre deve conter dado de 13,8% pré-escolar");

// Teste de Rota GET /apadrinhe
$reqApadrinhe = new NovaEsperanca\Core\Request('GET', '/apadrinhe');
$resApadrinhe = $router->dispatch($reqApadrinhe);
assertTest($resApadrinhe->getStatusCode() === 200, "Rota GET /apadrinhe deve retornar status 200");
assertTest(str_contains($resApadrinhe->getBody(), 'Modalidades de Apadrinhamento') || str_contains($resApadrinhe->getBody(), 'Planos de Apadrinhamento'), "Página Apadrinhe deve conter os planos de apoio");

// Teste de Rota GET /transparencia
$reqTransp = new NovaEsperanca\Core\Request('GET', '/transparencia');
$resTransp = $router->dispatch($reqTransp);
assertTest($resTransp->getStatusCode() === 200, "Rota GET /transparencia deve retornar status 200");
$bodyTransp = $resTransp->getBody();
assertTest(str_contains($bodyTransp, '18.500.000') || str_contains($bodyTransp, '18500000'), "Página Transparência deve exibir receitas de 18.500.000 AOA");
assertTest(str_contains($bodyTransp, '350'), "Página Transparência deve exibir custo da merenda de 350 AOA/dia");

// Teste de Rota GET /galeria
$reqGaleria = new NovaEsperanca\Core\Request('GET', '/galeria');
$resGaleria = $router->dispatch($reqGaleria);
assertTest($resGaleria->getStatusCode() === 200, "Rota GET /galeria deve retornar status 200");

// Teste de Rota GET /voluntariado
$reqVolunt = new NovaEsperanca\Core\Request('GET', '/voluntariado');
$resVolunt = $router->dispatch($reqVolunt);
assertTest($resVolunt->getStatusCode() === 200, "Rota GET /voluntariado deve retornar status 200");

// Teste de Rota 404
$req404 = new NovaEsperanca\Core\Request('GET', '/rota-inexistente-xyz');
$res404 = $router->dispatch($req404);
assertTest($res404->getStatusCode() === 404, "Rota desconhecida deve retornar status 404");

// 4. Validação do Processamento do Formulário de Apadrinhamento
// Teste de Submissão Válida
$validDonation = [
    'cota_tipo' => 'nutricional',
    'frequencia' => 'mensal',
    'valor_aoa' => 12500.0,
    'nome_padrinho' => 'António Manuel',
    'contato' => '+244 923 111 222',
    'email' => 'antonio.manuel@exemplo.ao',
    'anonimo' => false,
    'mensagem' => 'Apoio com muito carinho aos alunos.'
];

$reqPost = new NovaEsperanca\Core\Request('POST', '/api/apadrinhar', $validDonation);
$resPost = $router->dispatch($reqPost);
assertTest($resPost->getStatusCode() === 201, "Submissão válida deve retornar status 201 Created");

$jsonPost = json_decode($resPost->getBody(), true);
assertTest(is_array($jsonPost) && ($jsonPost['success'] ?? false) === true, "Resposta da API deve retornar success = true");
$refCode = $jsonPost['codigo_referencia'] ?? '';
assertTest(str_starts_with($refCode, 'NE-2026-'), "Código de referência gerado deve seguir padrão NE-2026-XXXX ({$refCode})");

// Verificação de persistência no repositório
$persisted = $donationRepo->findByReference($refCode);
assertTest($persisted !== null, "Intenção de doação deve estar persistida no repositório");
assertTest(($persisted['nome_padrinho'] ?? '') === 'António Manuel', "Nome do padrinho persistido deve coincidir");

// Verificação do envio de notificação
$dispatches = $notifService->getRecentDispatches();
assertTest(!empty($dispatches), "Serviço de notificação deve registrar disparo para os coordenadores");
assertTest(($dispatches[0]['codigo_referencia'] ?? '') === $refCode, "Notificação deve conter o código de referência gerado");

// Teste de Submissão Inválida (Valor menor que 1.000 AOA)
$invalidDonation = [
    'cota_tipo' => 'nutricional',
    'frequencia' => 'mensal',
    'valor_aoa' => 500.0, // Abaixo do mínimo de 1.000 AOA
    'nome_padrinho' => 'A', // Curto demais
    'contato' => ''
];

$reqInvalid = new NovaEsperanca\Core\Request('POST', '/api/apadrinhar', $invalidDonation);
$resInvalid = $router->dispatch($reqInvalid);
assertTest($resInvalid->getStatusCode() === 422, "Submissão inválida deve retornar status 422 Unprocessable Entity");

// Limpeza de arquivos de teste
if (file_exists($donationsFile)) {
    @unlink($donationsFile);
}
if (file_exists($logsDir . '/test-notifications.log')) {
    @unlink($logsDir . '/test-notifications.log');
}

echo PHP_EOL . "----------------------------------------------------------" . PHP_EOL;
echo "Total de asserções executadas: {$assertions}" . PHP_EOL;
echo "Total de falhas: " . count($failures) . PHP_EOL;

if (count($failures) === 0) {
    echo "🎉 SUCESSO ABSOLUTO: 100% dos testes da Fase 5 foram aprovados!" . PHP_EOL;
    exit(0);
} else {
    echo "⚠️ ATENÇÃO: Há falhas que precisam ser corrigidas." . PHP_EOL;
    exit(1);
}
