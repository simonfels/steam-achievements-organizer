<?php

namespace App\Models;

use App\DataModels\Achievement;
use App\DataModels\Game;

class GamesList extends AbstractModel
{
  public function all():array {
    return $this->database_connection->fetchAll(class: Game::class, table: "games");
  }

  public function find($app_id):array {
    $game = $this->database_connection->fetch("games", "app_id", $app_id, Game::class);
    $sql = "SELECT a.* FROM achievements a WHERE game_id = " . $app_id . " ORDER BY display_name";
    $game_achievements = $this->database_connection->fetchAll(class: Achievement::class, passed_sql: $sql);

    return [$game, $game_achievements];
  }
}
