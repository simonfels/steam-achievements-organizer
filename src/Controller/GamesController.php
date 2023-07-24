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
    $game_id = @$_GET['gameid'];

    if(!empty($game_id)) {
      [$game, $achievements] = $this->games_list->find($game_id);

      $this->render('Games/show', [
        'game' => $game,
        'achievements' => $achievements
      ]);
    } else {
      $this->render('Games/404');
    }
  }
}
