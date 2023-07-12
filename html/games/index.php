<?php

include_once __DIR__ . '/../../src/basics.php';

use App\Models\GamesList;

// fetch games from db

$games_list = new GamesList();

render('Games/index', [
  'games' => $games_list->fetchAll()
]);
