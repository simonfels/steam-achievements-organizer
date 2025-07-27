<?php

include_once __DIR__ . '/../src/autoloader.php';

$tags_controller = new App\Controller\TaggedAchievementsController();
$tags_controller->new();
