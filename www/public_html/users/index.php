<?php

include_once __DIR__ . '/../../src/autoloader.php';

$users_controller = new App\Controller\UsersController();
$users_controller->index();
