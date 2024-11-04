<?php
require_once __DIR__ . '/../vendor/autoload.php';
//define('DEBUG_TIME', microtime(true));
use  App\Controllers\Router;

$router = new Router(__DIR__ . '/../views');

$router->get('/', 'welcome');
$router->get('/blog', 'post/index');
$router->get('/blog/category', 'category/show');

$router->run();
