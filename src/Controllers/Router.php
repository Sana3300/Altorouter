<?php

namespace App\controllers;

use AltoRouter;

class Router
{
    private string $viewPath;
    private AltoRouter $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    // Définir une route GET pour une vue spécifique
    public function get(string $url, string $view): void
    {
        $this->router->map('GET', $url, function() use ($view) {
            $this->render($view);
        });
    }

    // Rendre la vue et l'injecter dans le template
    private function render(string $view): void
    {
        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();

        require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/template.php';
    }

    // Exécuter le routeur pour matcher les routes et les vues
    public function run(): void
    {
        $match = $this->router->match();

        if ($match && is_callable($match['target'])) {
            call_user_func($match['target']);
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            echo '404 Not Found';
        }
    }
}
