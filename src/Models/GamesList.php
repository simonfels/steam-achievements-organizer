<?php

namespace App\Models;
use App\Helpers\DatabaseConnection;

class GamesList
{
  private DatabaseConnection $database_connection;
  public function __construct() {
    $this->database_connection = new DatabaseConnection();
  }
  public function fetchAll():array {
    return $this->database_connection->fetchAll("games", Game::class);
  }

  public function fetch($app_id):array {
    $game = $this->database_connection->fetch("games", "app_id", $app_id, Game::class);
    $sql = "SELECT a.*, ua.achieved, ua.unlocked_at FROM achievements a JOIN user_achievements ua ON ua.achievement_system_name = a.system_name WHERE game_id = " . $app_id;
    $game_achievements = $this->database_connection->fetchAll("achievements", Achievement::class, $sql);

    return [$game, $game_achievements];
  }
}
