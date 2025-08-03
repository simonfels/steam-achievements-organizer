<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

abstract class AbstractController
{
    protected Twig $view;

    function __construct(protected Request $request, protected Response $response) {
        $this->view = Twig::fromRequest($request);
    }

    protected function render($path, $variables = []): Response
    {
        $variables['dev'] = $_SERVER["SERVER_NAME"] === "localhost";
        $variables['path'] = $path;

        return $this->view->render($this->response, $path . '.html.twig', $variables);
    }

    protected function renderJson(mixed $body): void
    {
        header('Content-Type: application/json');
        echo json_encode($body);
    }
}
