<?php

include_once "../src/autoloader.php";

use \App\Helpers\SteamAPI;

$steam_api = new SteamAPI();

$api_call = $steam_api->fetchUserGames($_GET['userid']);
$games = $api_call["response"]["games"];
?>

<?php echo $api_call["response"]["game_count"] ?>

<?php foreach($games as $game): ?>
  <p><?php var_dump($game); ?></p>
<?php endforeach; ?>