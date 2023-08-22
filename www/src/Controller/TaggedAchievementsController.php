<?php

namespace App\Controller;
use App\Helpers\DatabaseConnection;
use App\DataModels\Tag;
use App\DataModels\Achievement;

class TaggedAchievementsController extends AbstractController {

  public function new(): void {
    $database_connection = new DatabaseConnection();
    $tag_id = @$_GET['tagid'];

    $tag = $database_connection->fetch('tags', 'id', $tag_id, Tag::class);

    $achievements = $database_connection->fetchAll(Achievement::class, custom_sql: <<<SQL
      SELECT * FROM achievements WHERE game_id = {$tag->game_id} ORDER BY achievements.id
    SQL);

    $this->render('TaggedAchievements/new', [
      'achievements' => $achievements,
      'tag' => $tag
    ]);
  }

  public function create(): void {
    $database_connection = new DatabaseConnection();
    $tag_id = @$_POST['tag_id'];
    $tag = $database_connection->fetch('tags', 'id', $tag_id, Tag::class);
    $checked_ids = @$_POST['checked_ids'];
    $sql_values = implode(", ", array_map(function($id) use($tag_id) { return "($tag_id, $id)"; }, $checked_ids));

    $database_connection->pdo->exec(<<<SQL
      INSERT IGNORE INTO tagged_achievements(tag_id, achievement_id) VALUES $sql_values;
    SQL);

    header('Location: /games/show.php?' . http_build_query(['gameid' => $tag->game_id]));
  }
}
