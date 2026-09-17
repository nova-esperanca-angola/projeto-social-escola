<?php
declare(strict_types=1);

namespace NovaEsperanca\Controllers;

use NovaEsperanca\Core\Request;
use NovaEsperanca\Core\Response;
use NovaEsperanca\Core\View;

class PageController
{
    public function sobre(Request $request): Response
    {
        $rootDir = dirname(__DIR__, 2);
        $diagFile = $rootDir . '/data/diagnostico-educacional-luanda.json';
        $diag = file_exists($diagFile) ? json_decode((string)file_get_contents($diagFile), true) : [];

        $html = View::render('sobre', [
            'pageTitle' => 'Nossa História & Diagnóstico - Escola Cristã Nova Esperança',
            'currentRoute' => '/sobre',
            'diagnostico' => $diag
        ]);
        return Response::html($html);
    }

    public function apadrinhe(Request $request): Response
    {
        $html = View::render('apadrinhe', [
            'pageTitle' => 'Planos de Apadrinhamento - Escola Cristã Nova Esperança',
            'currentRoute' => '/apadrinhe'
        ]);
        return Response::html($html);
    }

    public function transparencia(Request $request): Response
    {
        $rootDir = dirname(__DIR__, 2);
        $custosFile = $rootDir . '/data/relatorio-custos-transparencia.json';
        $transpFile = $rootDir . '/data/transparencia-prestacao-contas.json';

        $custos = file_exists($custosFile) ? json_decode((string)file_get_contents($custosFile), true) : [];
        $transp = file_exists($transpFile) ? json_decode((string)file_get_contents($transpFile), true) : [];

        $html = View::render('transparencia', [
            'pageTitle' => 'Transparência e Prestação de Contas - Escola Cristã Nova Esperança',
            'currentRoute' => '/transparencia',
            'custos' => $custos,
            'transparencia' => $transp
        ]);
        return Response::html($html);
    }

    public function galeria(Request $request): Response
    {
        $html = View::render('galeria', [
            'pageTitle' => 'Galeria & Rotina Escolar - Escola Cristã Nova Esperança',
            'currentRoute' => '/galeria'
        ]);
        return Response::html($html);
    }

    public function voluntariado(Request $request): Response
    {
        $html = View::render('voluntariado', [
            'pageTitle' => 'Voluntariado & Parcerias - Escola Cristã Nova Esperança',
            'currentRoute' => '/voluntariado'
        ]);
        return Response::html($html);
    }
}
