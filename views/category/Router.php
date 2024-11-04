<?php

namespace App\Controllers;

use AltoRouter;
use App\PostManager;

/**
 * Router
 */
class Router {
    private $viewPath;
    /**
     * @var AltoRouter
     */
    private $router;

    public function __construct(string $viewPath) {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    /**
     * get
     * génère le chemin de la page à accéder
     * @param  string $url
     * @param  string $view
     * @return void
     */
    public function get(string $url, string $view): void {
        $this->router->map('GET', $url, function() use ($view) {
            // Inclure la vue avec les données récupérées
            require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php'; // Chargement de la vue
        });
    }

    /**
     * run
     * génération de la page du chemin trouvé
     * @return void
     */
    public function run(): void {
        $match = $this->router->match();
        if ($match && is_callable($match['target'])) {
            ob_start(); // Commence la capture de la sortie
            call_user_func_array($match['target'], $match['params']);
            $content = ob_get_clean(); // Récupère le contenu et nettoie le tampon
            require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/template.php'; // Inclure le template
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            echo '404 Not Found';
        }
    }
    
}
