<?php

namespace App\Models;

use App\DataModels\Achievement;
use App\DataModels\Game;
use App\DataModels\Tag;

class GamesList extends AbstractModel
{
  public function all(): array {
    $sql = "select games.*, count(a.id) total_achievements from games join achievements a on games.id = a.game_id group by games.id";
    return $this->database_connection->fetchAll(class: Game::class, custom_sql: $sql);
  }

  public function find($id): array {
    $game = $this->database_connection->fetch("games", "id", $id, Game::class);
    $sql = <<<SQL
        SELECT a.*, GROUP_CONCAT(t.id) tag_ids
        FROM achievements a
        LEFT JOIN tagged_achievements ta ON a.id = ta.achievement_id
        LEFT JOIN tags t ON ta.tag_id = t.id
        WHERE a.game_id = $id
        GROUP BY a.id, a.percent, a.display_name
        ORDER BY a.id
      SQL;
    $game_achievements = $this->database_connection->fetchAll(class: Achievement::class, custom_sql: $sql);
    $tags = $this->database_connection->fetchAll(class: Tag::class, custom_sql: <<<SQL
      SELECT * FROM tags WHERE game_id = $game->id
    SQL);

    $ids = array_column($tags, 'id');
    $preparedTags = array_combine($ids, $tags);

    return [$game, $game_achievements, $preparedTags];
  }

  public function findForTag($id, $tag_id): array {
    $game = $this->database_connection->fetch("games", "id", $id, Game::class);
    $sql = <<<SQL
        SELECT a.*, GROUP_CONCAT(t.id) tag_ids, if(sum(t.id = $tag_id), 1, 0) tagged
        FROM achievements a
        LEFT JOIN tagged_achievements ta ON a.id = ta.achievement_id
        LEFT JOIN tags t ON ta.tag_id = t.id
        WHERE a.game_id = $id
        GROUP BY a.id, a.percent, a.display_name
        ORDER BY a.id
      SQL;
    $game_achievements = $this->database_connection->fetchAll(class: Achievement::class, custom_sql: $sql);
    $tags = $this->database_connection->fetchAll(class: Tag::class, custom_sql: <<<SQL
      SELECT * FROM tags WHERE game_id = $game->id
    SQL);

    $ids = array_column($tags, 'id');
    $preparedTags = array_combine($ids, $tags);

    return [$game, $game_achievements, $preparedTags];
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
        SELECT g.*, ug.completed_at
        FROM games g
        JOIN user_games ug
          ON g.id = ug.game_id AND ug.user_id = $user_id
        WHERE g.id = $id
    SQL);
    $sql = "SELECT a.*, ua.achieved, ua.unlocked_at, GROUP_CONCAT(t.id) tag_ids FROM achievements a JOIN user_achievements ua ON ua.achievement_id = a.id LEFT JOIN tagged_achievements ta ON a.id = ta.achievement_id LEFT JOIN tags t ON ta.tag_id = t.id WHERE user_id = $user_id AND a.game_id = $id GROUP BY a.id, ua.achieved, ua.unlocked_at ORDER BY achieved desc, unlocked_at desc";
    $game_achievements = $this->database_connection->fetchAll(class: Achievement::class, custom_sql: $sql);
    $tags = $this->database_connection->fetchAll(class: Tag::class, custom_sql: <<<SQL
      SELECT * FROM tags WHERE game_id = $id
    SQL);

    if (sizeof($tags) > 0)
    {
      $tags[] = Tag::withData(-1, 'Untagged');
    }

    return [$game, $game_achievements, $tags];
  }
}
