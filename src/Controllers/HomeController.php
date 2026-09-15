<?php
declare(strict_types=1);

namespace NovaEsperanca\Controllers;

use NovaEsperanca\Core\Request;
use NovaEsperanca\Core\Response;
use NovaEsperanca\Core\View;

class HomeController
{
    public function index(Request $request): Response
    {
        $rootDir = dirname(__DIR__, 2);
        
        $transpData = [];
        $transpFile = $rootDir . '/data/transparencia-prestacao-contas.json';
        if (file_exists($transpFile)) {
            $transpData = json_decode((string)file_get_contents($transpFile), true) ?? [];
        }

        $diagData = [];
        $diagFile = $rootDir . '/data/diagnostico-educacional-luanda.json';
        if (file_exists($diagFile)) {
            $diagData = json_decode((string)file_get_contents($diagFile), true) ?? [];
        }

        $html = View::render('home', [
            'pageTitle' => 'Escola Nova Esperança - Kifangondo, Luanda · Angola',
            'currentRoute' => '/',
            'transparencia' => $transpData,
            'diagnostico' => $diagData,
            'metricas' => [
                'alunos' => 93,
                'salas' => 5,
                'colaboradores' => 10,
                'merenda' => '100%'
            ]
        ]);

        return Response::html($html);
    }
}
