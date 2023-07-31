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

  public function show(): void {
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

  public function user(): void {
    $game_id = @$_GET['gameid'];
    $user_id = @$_GET['userid'];

    if(!empty($game_id) && !empty($user_id)) {
      [$game, $achievements] = $this->games_list->findForUser($game_id, $user_id);

      $this->render('Games/user', [
        'game' => $game,
        'user_id' => $user_id,
        'achievements' => implode(", ", array_map(function($achievement) { return $achievement->getVars(); }, $achievements))
      ]);
    } else {
      $this->render('Games/404');
    }
  }
}
