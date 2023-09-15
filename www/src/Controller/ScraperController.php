<?php

namespace App\Controller;

use App\Models\Scraper;

class ScraperController extends AbstractController
{
    private Scraper $scraper;

    public function __construct()
    {
        $this->scraper = new Scraper();
    }

    public function index(): void
    {
        $this->render('Scraper/index', [
          'users' => json_encode($this->scraper->allUsers())
        ]);
    }

    public function user(): void
    {
        $user_id = @$_GET['userid'];

        if (!empty($user_id)) {            
            header('Content-Type: application/json');
            echo json_encode($this->scraper->scrapeUserData($user_id));
        } else {
            $this->render('Scraper/404');
        }
    }

    public function games(): void
    {
        $user_id = @$_GET['userid'];

        if (!empty($user_id)) {
            header('Content-Type: application/json');
            echo json_encode($this->scraper->scrapeUserGames($user_id));
        } else {
            $this->render('Scraper/404');
        }
    }

    public function achievements(): void
    {
        $user_id = @$_GET['userid'];

        if (!empty($user_id)) {
            header('Content-Type: application/json');
            echo json_encode($this->scraper->scrapeGameAchievements($user_id));
        } else {
            $this->render('Scraper/404');
        }
    }
}
