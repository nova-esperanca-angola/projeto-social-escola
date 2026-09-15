<?php
declare(strict_types=1);

/**
 * Ponto de Entrada Raiz - Fallback para Servidores Web
 * Projeto Social Escola - Kifangondo, Luanda, Angola
 * 
 * Despacha a execução de forma transparente para o Front Controller em public/index.php.
 */

$publicIndex = __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.php';

if (file_exists($publicIndex)) {
    require_once $publicIndex;
} else {
    http_response_code(500);
    echo "Erro Crítico: O Front Controller public/index.php não foi localizado.";
    exit(1);
}
