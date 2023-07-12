<?php

include_once __DIR__ . '/../src/basics.php';

use App\Helpers\DatabaseConnection;
use App\Helpers\SteamAPI;

ob_start();

$steam_api = new SteamAPI("34726D7C756F3C392EAD2DABB301462C");
$database_connection = new DatabaseConnection();

$api_key = '34726D7C756F3C392EAD2DABB301462C';

if(empty($_GET['appid'])) {
  echo "<p>- App-ID not set!</p>";
}
else {
  $appid = $_GET['appid'];
  $api_call = $steam_api->fetch_achievements($appid);

  echo "<p>- Achievements fetched for App-ID: " . $appid . "!</p>";

  foreach($api_call["achievements"] as $achievement) {
    $database_connection->insert('achievements', ['game_id', 'system_name', 'display_name', 'hidden', 'description', 'icon', 'icongray'], $achievement);
  }

  echo "<p>- " . count($api_call["achievements"]) . " Achievements written to DB!</p>";

  if(empty($_GET['userid'])) {
    echo "<p>- User-ID not set!</p>";
  }
  else {
    $userid = $_GET['userid'];

    $database_connection->insert('users', ['user_id'], ['user_id' => $userid]);

    echo "<p>- User '" . $userid . "' written to DB!</p>";

    $api_call = $steam_api->fetch_user_achievements($appid, $userid);

    echo "<p>- User-Achievements fetched for App-ID: " . $appid . " and User-ID: " . $userid . "!</p>";

    $database_connection->insert('games', ['app_id', 'name'], [
      'app_id' => $api_call["game_id"],
      'name' => $api_call["game_name"]
    ]);

    echo "<p>- Game '" . $api_call["game_name"] . "' written to DB!</p>";

    foreach($api_call["achievements"] as $achievement) {
      $database_connection->insert('user_achievements', ['user_id', 'achievement_system_name', 'achieved', 'unlocked_at'], $achievement);
    }


    echo "<p>- " . count($api_call["achievements"]) . " User-Achievements written to DB!</p>";
  }
}
$get_contents = ob_get_contents();

ob_end_clean();

render('fetch_data', ['protocol' => $get_contents]);