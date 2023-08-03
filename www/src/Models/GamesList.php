<?php

namespace App\Models;

use App\DataModels\Achievement;
use App\DataModels\Game;

class GamesList extends AbstractModel
{
  public function all(): array {
    $sql = "select games.*, count(a.id) total_achievements from games join achievements a on games.id = a.game_id group by games.id";
    return $this->database_connection->fetchAll(class: Game::class, custom_sql: $sql);
  }

  public function find($id): array {
    $game = $this->database_connection->fetch("games", "id", $id, Game::class);
    $sql = "SELECT a.* FROM achievements a WHERE game_id = " . $id . " ORDER BY percent desc, display_name";
    $game_achievements = $this->database_connection->fetchAll(class: Achievement::class, custom_sql: $sql);

    return [$game, $game_achievements];
  }

  public function findAchievement($id): Achievement {
      return $this->database_connection->fetch('achievements', 'id', $id, Achievement::class);
  }

  public function updateAchievement($id, $description): Achievement {
      $this->database_connection->pdo->prepare(<<<SQL
        UPDATE achievements SET description = :description WHERE id = :id
      SQL)->execute([
        'id' => $id,
        'description' => $description
      ]);

      return $this->findAchievement($id);
  }

  public function findForUser($id, $user_id): array {
    $game = $this->database_connection->fetch("games", "id", $id, Game::class, <<<SQL
        SELECT g.*, ug.completed_at FROM games g JOIN user_games ug ON g.id = ug.game_id WHERE g.id = $id
    SQL);
    $sql = "SELECT a.*, ua.achieved, ua.unlocked_at FROM achievements a JOIN user_achievements ua ON ua.achievement_id = a.id WHERE user_id = $user_id AND game_id = $id ORDER BY achieved desc, unlocked_at desc";
    $game_achievements = $this->database_connection->fetchAll(class: Achievement::class, custom_sql: $sql);

    return [$game, $game_achievements];
  }
}
