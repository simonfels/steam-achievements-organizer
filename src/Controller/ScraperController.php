<?php

namespace App\Controller;
use App\Models\Scraper;

class ScraperController extends AbstractController {
  private Scraper $scraper;

  public function __construct() {
    $this->scraper = new Scraper();
  }

  public function index(): void {
    $this->render('Scraper/index', [
      'users' => $this->scraper->allUsers()
    ]);
  }

  public function user(): void {
    $user_id = @$_GET['userid'];

    if(!empty($user_id)) {
      $result = $this->scraper->scrapeUserData($_GET["userid"]);
      $this->render('Scraper/index', [
        'result' => $result,
        'user_id' => $user_id,
        'operation' => 'getUser',
        'api_calls' => $this->scraper->numberOfApiCalls,
        'users' => $this->scraper->allUsers()
      ]);
    } else {
      $this->render('Scraper/404');
    }
  }

  public function games(): void {
    $user_id = @$_GET['userid'];

    if(!empty($user_id)) {
      $result = $this->scraper->scrapeUserGames($_GET["userid"]);
      $this->render('Scraper/index', [
        'result' => $result,
        'user_id' => $user_id,
        'operation' => 'getGames',
        'api_calls' => $this->scraper->numberOfApiCalls,
        'users' => $this->scraper->allUsers()
      ]);
    } else {
      $this->render('Scraper/404');
    }
  }

  public function achievements(): void {
    $user_id = @$_GET['userid'];

    if(!empty($user_id)) {
      $result = $this->scraper->scrapeGameAchievements($_GET["userid"]);
      $this->render('Scraper/index', [
        'result' => $result,
        'user_id' => $user_id,
        'operation' => 'getAchievements',
        'api_calls' => $this->scraper->numberOfApiCalls,
        'users' => $this->scraper->allUsers()
      ]);
    } else {
      $this->render('Scraper/404');
    }
  }
}