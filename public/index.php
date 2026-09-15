<?php
declare(strict_types=1);

/**
 * Front Controller do Portal Escola Nova Esperança (Kifangondo, Luanda)
 * Ponto de entrada HTTP único compatível com Hostinger e PHP 8.2+
 */

$rootDir = dirname(__DIR__);

// Carregamento de Classes do Core e Serviços
require_once $rootDir . '/src/Core/Request.php';
require_once $rootDir . '/src/Core/Response.php';
require_once $rootDir . '/src/Core/View.php';
require_once $rootDir . '/src/Core/Router.php';

require_once $rootDir . '/src/Repositories/DonationRepositoryInterface.php';
require_once $rootDir . '/src/Repositories/JsonDonationRepository.php';

require_once $rootDir . '/src/Services/NotificationServiceInterface.php';
require_once $rootDir . '/src/Services/EmailNotificationService.php';

require_once $rootDir . '/src/Services/AntiSpamServiceInterface.php';
require_once $rootDir . '/src/Services/AntiSpamService.php';

require_once $rootDir . '/src/Controllers/HomeController.php';
require_once $rootDir . '/src/Controllers/PageController.php';
require_once $rootDir . '/src/Controllers/DonationController.php';

// Inicializar Diretório de Templates
\NovaEsperanca\Core\View::init($rootDir . '/templates');

// Repositório e Notificações
$donationFile = $rootDir . '/storage/app/donations.json';
$logFile = $rootDir . '/storage/logs/notifications.log';

$donationRepo = new \NovaEsperanca\Repositories\JsonDonationRepository($donationFile);
$notificationService = new \NovaEsperanca\Services\EmailNotificationService($logFile);
$antiSpamService = new \NovaEsperanca\Services\AntiSpamService();

// Roteamento
$router = new \NovaEsperanca\Core\Router();
\NovaEsperanca\Core\Router::registerRoutes($router, $donationRepo, $notificationService, $antiSpamService);

// Processar Requisição
$request = \NovaEsperanca\Core\Request::createFromGlobals();
$response = $router->dispatch($request);
$response->send();
