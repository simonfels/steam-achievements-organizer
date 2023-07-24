<?php

namespace App\Controller;
use App\Models\Scraper;

class ScraperController extends AbstractController {
  private Scraper $scraper;

  public function __construct() {
    $this->scraper = new Scraper();
  }
  public function index(): void {
    $user_id = @$_GET['userid'];
    $log = [];
    if(!empty($user_id)) {
      $log = $this->scraper->scrapeUser($_GET["userid"]);
    }
    $this->render('Scraper/index', [
      'protocol' => $log,
      'user_id' => $user_id
    ]);
  }
}