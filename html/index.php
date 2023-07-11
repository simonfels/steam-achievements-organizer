<?php

require __DIR__ . '/helpers/db_connection.php';
require __DIR__ . '/helpers/steam_api.php';

$steam_api = new SteamApi("34726D7C756F3C392EAD2DABB301462C");


/*
$statement = $pdo->prepare("SELECT * FROM achievements");

if($statement->execute()) {
  echo $statement->fetchAll();
} else {
  echo "SQL Error <br />";
  echo $statement->queryString."<br />";
  echo $statement->errorInfo()[2];
}
*/

$api_key = '34726D7C756F3C392EAD2DABB301462C';

if(!empty($_GET['appid'])) {
  $appid = $_GET['appid'];

  $api_call = $steam_api->fetch_achievements($appid);

  $game_data = [
    'appid' => $api_call["game_id"],
    'name' => $api_call["game_name"]
  ];

  $pdo->prepare('INSERT IGNORE INTO games (app_id, name) VALUES (:appid, :name)')->execute($game_data);

  $sql = 'INSERT IGNORE INTO achievements (game_id, system_name, display_name, hidden, description, icon, icongray)
            VALUES (:game_id, :system_name, :display_name, :hidden, :description, :icon, :icongray)';
  foreach($api_call["achievements"] as $achievement) {
    $pdo->prepare($sql)->execute($achievement);
  }

  if(!empty($_GET['userid'])) {
    $userid = $_GET['userid'];

    $pdo->prepare('INSERT IGNORE INTO users (user_id) VALUES (:user_id)')->execute(['user_id' => $userid]);

    $api_call = $steam_api->fetch_user_achievements($appid, $userid);

    $sql = 'INSERT IGNORE INTO user_achievements (user_id, achievement_system_name, achieved, unlocked_at)
            VALUES (:user_id, :achievement_system_name, :achieved, :unlocked_at)';
    foreach($api_call as $achievement) {
      $pdo->prepare($sql)->execute($achievement);
    }
  } else {
    echo "User-ID not set";
  }

} else {
  echo "App-ID not set";
}
