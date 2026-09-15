<?php
declare(strict_types=1);

namespace NovaEsperanca\Core;

use NovaEsperanca\Controllers\HomeController;
use NovaEsperanca\Controllers\PageController;
use NovaEsperanca\Controllers\DonationController;
use NovaEsperanca\Repositories\DonationRepositoryInterface;
use NovaEsperanca\Services\NotificationServiceInterface;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, mixed $handler): void
    {
        $normMethod = strtoupper($method);
        $normPath = '/' . trim($path, '/');
        if ($normPath !== '/') {
            $normPath = rtrim($normPath, '/');
        }
        $this->routes[$normMethod][$normPath] = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        $handler = $this->routes[$method][$uri] ?? null;

        if (!$handler) {
            // Rota 404
            $html404 = View::render('404', [
                'pageTitle' => 'Página Não Encontrada - Escola Nova Esperança',
                'currentRoute' => $uri
            ]);
            return Response::html($html404, 404);
        }

        if (is_callable($handler)) {
            return $handler($request);
        }

        if (is_array($handler) && count($handler) === 2) {
            [$controller, $action] = $handler;
            return $controller->$action($request);
        }

        throw new \RuntimeException("Handler inválido para a rota {$method} {$uri}");
    }

    public static function registerRoutes(
        Router $router,
        DonationRepositoryInterface $donationRepo,
        NotificationServiceInterface $notifService
    ): void {
        $homeController = new HomeController();
        $pageController = new PageController();
        $donationController = new DonationController($donationRepo, $notifService);

        // Rotas Públicas Principais
        $router->add('GET', '/', [$homeController, 'index']);
        $router->add('GET', '/sobre', [$pageController, 'sobre']);
        $router->add('GET', '/apadrinhe', [$pageController, 'apadrinhe']);
        $router->add('GET', '/transparencia', [$pageController, 'transparencia']);
        $router->add('GET', '/galeria', [$pageController, 'galeria']);
        $router->add('GET', '/voluntariado', [$pageController, 'voluntariado']);

        // Processamento de Doações / Apadrinhamento
        $router->add('POST', '/api/apadrinhar', [$donationController, 'apadrinhar']);
        $router->add('POST', '/apadrinhar', [$donationController, 'apadrinhar']);
    }
}
