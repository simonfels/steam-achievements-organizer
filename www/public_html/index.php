<?php
use App\Controller\GamesController;
use App\Controller\HomeController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/src/autoload.php';

$app = AppFactory::create();

// Create Twig
$twig = Twig::create(__DIR__ . '/src/Views', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/games', function (Request $request, Response $response) {
    return (new GamesController($request, $response))->index();
});

$app->get('/games/{gameid}', function (Request $request, Response $response, array $args) {

    return (new GamesController($request, $response))->show($args['gameid']);
});

$app->get('/games/{gameid}/edit', function (Request $request, Response $response, array $args) {

    return (new GamesController($request, $response))->edit($args['gameid']);
});

$app->get('/', function (Request $request, Response $response) {
    return (new HomeController($request, $response))->index();
});

$app->run();
