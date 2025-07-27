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
            $this->renderJson($this->scraper->scrapeUserData($user_id));
        } else {
            $this->renderJson(['error' => 'Scraper/404']);
        }
    }

    public function games(): void
    {
        $user_id = @$_GET['userid'];

        if (!empty($user_id)) {
            $this->renderJson($this->scraper->scrapeUserGames($user_id));
        } else {
            $this->renderJson(['error' => 'Scraper/404']);
        }
    }

    /**
     * refetch the data for a single game
     * uses: games/user.php
    */
    public function game(): void
    {
        $user_id = @$_GET['userid'];
        $game_id = @$_GET['gameid'];

        if (!empty($user_id) && !empty($game_id)) {
            $this->scraper->scrapeGameAchievements($user_id, [$game_id]);
            header("Location: /games/user.php?" . http_build_query(['userid' => $user_id, 'gameid' => $game_id]));
         } else {
            header("Location: /users");
         }
    }

    public function achievements(): void
    {
        $user_id = @$_GET['userid'];

        if (!empty($user_id)) {
            $this->renderJson($this->scraper->scrapeGameAchievements($user_id));
        } else {
            $this->renderJson(['error' => 'Scraper/404']);
        }
    }
}
