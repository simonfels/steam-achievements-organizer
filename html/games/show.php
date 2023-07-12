<?php

include_once __DIR__ . '/../../src/basics.php';

use App\Models\GamesList;

$games_list = new GamesList();
[$game, $achievements] = $games_list->fetch($_GET["appid"]);

render('Games/show', [
  'game' => $game,
  'achievements' => $achievements
]);
