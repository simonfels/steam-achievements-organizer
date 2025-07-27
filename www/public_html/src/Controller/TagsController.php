<?php

namespace App\Controller;

use App\Helpers\DatabaseConnection;
use App\DataModels\Tag;

class TagsController extends AbstractController
{
    private DatabaseConnection $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = new DatabaseConnection();
    }

    public function create(): void
    {
        $game_id = @$_POST['game_id'];
        $name = @$_POST['name'];

        $this->databaseConnection->pdo->prepare(<<<SQL
      INSERT INTO tags(game_id, name) VALUES (:game_id, :name);
    SQL)->execute([
          'game_id' => $game_id,
          'name' => $name
        ]);

        header('Location: /games/show.php?' . http_build_query(['gameid' => $game_id]));
    }

    public function delete(): void
    {
        $tag_id = @$_GET['tagid'];

        if(!empty($tag_id)) {
            $tag = $this->databaseConnection->fetch('tags', 'id', $tag_id, Tag::class);
            $this->databaseConnection->pdo->exec(<<<SQL
                DELETE FROM tagged_achievements WHERE tag_id = $tag_id;
                DELETE FROM tags WHERE id = $tag_id;
            SQL);
            header('Location: /games/show.php?' . http_build_query(['gameid' => $tag->game_id]));
        } else {
            header('Location: /games/index.php');
        }
    }
}
