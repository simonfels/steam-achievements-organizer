<?php

declare(strict_types=1);

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected function render($path, $variables = []): void
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $twig = new Environment($loader);

        $variables['dev'] = $_SERVER["SERVER_NAME"] === "localhost";
        $variables['path'] = $path;

        echo $twig->render($path . '.html.twig', $variables);
    }

    protected function renderJson(mixed $body): void
    {
        header('Content-Type: application/json');
        echo json_encode($body);
    }
}
