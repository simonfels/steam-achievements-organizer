<?php

namespace App\Controller;
use App\Helpers\DatabaseConnection;
use App\DataModels\Tag;
use App\DataModels\Achievement;

class TaggedAchievementsController extends AbstractController {

  private readonly DatabaseConnection $databaseConnection;

  public function __construct()
  {
    $this->databaseConnection = new DatabaseConnection();
  }

  public function new(): void {
    $tag_id = @$_GET['tagid'];

    $tag = $this->databaseConnection->fetch('tags', 'id', $tag_id, Tag::class);

    $achievements = $this->databaseConnection->fetchAll(Achievement::class, custom_sql: <<<SQL
      SELECT achievements.*, ifnull(ta.tag_id, 0) tagged
      FROM achievements
      LEFT JOIN tagged_achievements ta
        ON ta.achievement_id = achievements.id
        AND ta.tag_id = $tag_id
      WHERE game_id = {$tag->game_id}
      ORDER BY achievements.id
    SQL);

    $this->render('TaggedAchievements/new', [
      'achievements' => $achievements,
      'tag' => $tag
    ]);
  }

  public function create(): void {
    $tag_id = @$_POST['tag_id'];
    $checked_ids = @$_POST['checked_ids'];
    $tag = $this->databaseConnection->fetch('tags', 'id', $tag_id, Tag::class);

    //Weiterleiten falls Tag nicht existiert
    if(empty($tag)) {
      header('Location: /games');
    }

    // Nicht selektierte Achievements löschen
    $checked_ids_sql = "DELETE FROM tagged_achievements" . (!empty($checked_ids) ? ' WHERE id NOT IN (' . implode(", ", $checked_ids) . ')' : "");
    $this->databaseConnection->pdo->exec($checked_ids_sql);

    // Selektierte Achievements inserten
    if(!empty($checked_ids))
    {
      $sql_values = implode(", ", array_map(function($id) use($tag_id) { return "($tag_id, $id)"; }, $checked_ids));
      $this->databaseConnection->pdo->exec(<<<SQL
        INSERT IGNORE INTO tagged_achievements(tag_id, achievement_id) VALUES $sql_values;
      SQL);
    }

    header('Location: /games/show.php?' . http_build_query(['gameid' => $tag->game_id]));
  }
}
