<?php

include_once __DIR__ . '/../../src/autoloader.php';

$scraper_controller = new App\Controller\ScraperController();
$scraper_controller->achievements();
