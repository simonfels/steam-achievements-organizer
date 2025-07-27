<?php

include_once __DIR__ . '/src/autoloader.php';

$home_controller = new App\Controller\HomeController();
$home_controller->index();
