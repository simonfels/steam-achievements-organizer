<?php

namespace App\Models;

class GamesList extends AbstractModel
{
  public function all():array {
    return $this->database_connection->fetchAll(class: \App\DataModels\Game::class, table: "games");
  }

  public function find($app_id):array {
    $game = $this->database_connection->fetch("games", "app_id", $app_id, \App\DataModels\Game::class);
    $sql = "SELECT a.*, ua.achieved, ua.unlocked_at FROM achievements a JOIN user_achievements ua ON ua.achievement_system_name = a.system_name WHERE game_id = " . $app_id . " ORDER BY achieved desc, unlocked_at desc";
    $game_achievements = $this->database_connection->fetchAll(class: \App\DataModels\Achievement::class, passed_sql: $sql);

    return [$game, $game_achievements];
  }
}
