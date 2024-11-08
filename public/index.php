<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\Router;

$router = new Router(__DIR__ . '/../views');

$router->get('/', 'welcome');            // Page d'accueil
$router->get('/blog', 'post/index');     // Page des posts
$router->get('/blog/category', 'category/show'); // Page d'une catégorie spécifique

$router->run();
