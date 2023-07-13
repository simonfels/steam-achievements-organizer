<?php

namespace App\Controller;
use App\Models\GamesList;

class GamesController extends AbstractController {
  private GamesList $games_list;

  public function __construct() {
    $this->games_list = new GamesList();
  }
  public function index():void {
    $this->render('Games/index', [
      'games' => $this->games_list->all()
    ]);
  }

  public function show():void {
    [$game, $achievements] = $this->games_list->find($_GET["appid"]);

    $this->render('Games/show', [
      'game' => $game,
      'achievements' => $achievements
    ]);
  }
}
