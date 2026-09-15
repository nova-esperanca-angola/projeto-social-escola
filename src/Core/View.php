<?php
declare(strict_types=1);

namespace NovaEsperanca\Core;

class View
{
    private static string $templatesDir;

    public static function init(string $dir): void
    {
        self::$templatesDir = rtrim($dir, '/\\');
    }

    public static function render(string $view, array $data = [], string $layout = 'main'): string
    {
        $templatesDir = self::$templatesDir ?? dirname(__DIR__, 2) . '/templates';
        $viewFile = $templatesDir . '/pages/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View não encontrada: {$viewFile}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout) {
            $layoutFile = $templatesDir . '/layouts/' . $layout . '.php';
            if (!file_exists($layoutFile)) {
                throw new \RuntimeException("Layout não encontrado: {$layoutFile}");
            }
            ob_start();
            require $layoutFile;
            return ob_get_clean();
        }

        return (string)$content;
    }

    public static function partial(string $partial, array $data = []): string
    {
        $templatesDir = self::$templatesDir ?? dirname(__DIR__, 2) . '/templates';
        $partialFile = $templatesDir . '/partials/' . $partial . '.php';

        if (!file_exists($partialFile)) {
            return "<!-- Partial {$partial} não encontrada -->";
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $partialFile;
        return (string)ob_get_clean();
    }
}
