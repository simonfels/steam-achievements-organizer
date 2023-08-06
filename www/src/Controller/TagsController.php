<?php

namespace App\Controller;
use App\Helpers\DatabaseConnection;

class TagsController extends AbstractController {

  public function create(): void {
    $database_connection = new DatabaseConnection();
    $game_id = @$_POST['game_id'];
    $name = @$_POST['name'];
    $background_color = @$_POST['background_color'];

    $database_connection->pdo->prepare(<<<SQL
      INSERT INTO tags(game_id, name, background_color) VALUES (:game_id, :name, :background_color);
    SQL)->execute([
      'game_id' => $game_id,
      'name' => $name,
      'background_color' => $background_color
    ]);

    header('Location: /games/show.php?' . http_build_query(['gameid' => $game_id]));
  }
}
