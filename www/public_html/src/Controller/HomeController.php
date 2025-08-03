<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('Home/index', []);
    }
}
