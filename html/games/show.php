<?php

include_once __DIR__ . '/../../src/autoloader.php';

$games_controller = new App\Controller\GamesController();
$games_controller->show();
