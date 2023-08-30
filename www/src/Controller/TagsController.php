<?php

namespace App\Controller;
use App\Helpers\DatabaseConnection;

class TagsController extends AbstractController {

  public function create(): void {
    $database_connection = new DatabaseConnection();
    $game_id = @$_POST['game_id'];
    $name = @$_POST['name'];

    $database_connection->pdo->prepare(<<<SQL
      INSERT INTO tags(game_id, name) VALUES (:game_id, :name);
    SQL)->execute([
      'game_id' => $game_id,
      'name' => $name
    ]);

    header('Location: /games/show.php?' . http_build_query(['gameid' => $game_id]));
  }
}
