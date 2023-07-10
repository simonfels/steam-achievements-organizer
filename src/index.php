<?php

echo date("H:i:s d.m.Y", time());

die();

extract([
  'servername' => 'db',
  'username' => 'root',
  'dbname' => 'myDB',
  'password' => 'rootpassword'
]);

$pdo = new PDO("mysql:host=$servername;dbname={$dbname}", $username, $password);

/*
$statement = $pdo->prepare("SELECT * FROM achievements");

if($statement->execute()) {
  while($row = $statement->fetch()) {
    echo $row['display_name']."<br />";
  }
} else {
  echo "SQL Error <br />";
  echo $statement->queryString."<br />";
  echo $statement->errorInfo()[2];
}
*/

// 381210
$api_key = '34726D7C756F3C392EAD2DABB301462C';

if(!empty($_GET['appid'])) {
  $appid = $_GET['appid'];
  $api_call = file_get_contents("https://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key={$api_key}&appid={$appid}&format=json");
  $response = json_decode($api_call, true);

  $gamename = $response["game"]["gameName"];

  $game_data = ['appid' => $appid, 'name' => $gamename];
  $pdo->prepare('INSERT IGNORE INTO games (app_id, name) VALUES (:appid, :name)')->execute($game_data);

  $achievements = array_map(function($item) {
    return [
      'name' => $item['name'],
      'display_name' => $item['displayName'],
      'hidden' => $item['hidden'],
      'description' => @$item['description'],
      'icon' => $item['icon'],
      'icongray' => $item['icongray'],
    ];
  }, $response["game"]["availableGameStats"]["achievements"]);

  foreach($achievements as &$achievement) {
    $achievement['game_id'] = $appid;
    $pdo->prepare('INSERT IGNORE INTO achievements (game_id, name, display_name, hidden, description, icon, icongray) VALUES (:game_id, :name, :display_name, :hidden, :description, :icon, :icongray)')->execute($achievement);
  }

  if(!empty($_GET['userid'])) {
    $user_id = $_GET['userid'];
    $api_call = file_get_contents("https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=381210&key={$api_key}&steamid={$user_id}");
    $response = json_decode($api_call, true);
    var_dump($response["playerstats"]["achievements"]);
  } else {
    echo "User-ID not set";
  }

} else {
  echo "App-ID not set";
}
