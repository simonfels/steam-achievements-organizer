<?php

include_once "../src/autoloader.php";

use \App\Models\Scraper;

$scraper = new Scraper();

if(!empty($_GET['gameids'])) {
  $scraper->scrapeGameAchievements($_GET['gameids']);
  echo implode(', ', $_GET['gameids']);
}
