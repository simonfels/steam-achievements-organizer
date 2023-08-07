<?php

namespace App\Controller;
use App\DataModels\Achievement;
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
      [$game, $achievements, $tags] = $this->games_list->find($game_id);

      $this->render('Games/show', [
        'game' => $game,
        'achievements' => $achievements,
        'tags' => $tags
      ]);
    } else {
      $this->render('Games/404');
    }
  }

  public function edit(): void {
      $achievement_id = @$_GET['achievementid'];

      if(!empty($achievement_id)) {

          $this->render('Games/edit', [
            'achievement' => $this->games_list->findAchievement($achievement_id),
          ]);
      } else {
          $this->render('Games/404');
      }
  }

  public function update(): void {
      $achievement_id = @$_POST['achievement_id'];
      $description = @$_POST['description'];

      $achievement = $this->games_list->updateAchievement($achievement_id, $description);

      header('Location: /games/show.php?' . http_build_query(['gameid' => $achievement->game_id]));
  }

  public function user(): void {
    $game_id = @$_GET['gameid'];
    $user_id = @$_GET['userid'];

    if(!empty($game_id) && !empty($user_id)) {
      [$game, $achievements, $tags] = $this->games_list->findForUser($game_id, $user_id);

      $this->render('Games/user', [
        'game' => $game,
        'user_id' => $user_id,
        'achievements' => implode(", ", array_map(function($achievement) { return $achievement->getVars(); }, $achievements)),
        'tags' => $tags
      ]);
    } else {
      $this->render('Games/404');
    }
  }
}
