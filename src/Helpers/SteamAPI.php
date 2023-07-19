<?php

namespace App\Helpers;

class SteamAPI {
  private const BASE_URL = "https://api.steampowered.com";
  private const ALL_ACHIEVEMENTS_URL = SteamAPI::BASE_URL . '/ISteamUserStats/GetSchemaForGame/v2/?';
  private const USER_ACHIEVEMENTS_URL = SteamAPI::BASE_URL . '/ISteamUserStats/GetPlayerAchievements/v0001/?';
  private const USER_URL = SteamAPI::BASE_URL . '/ISteamUser/GetPlayerSummaries/v2/?';
  private const USER_GAMES_URL = SteamAPI::BASE_URL . '/IPlayerService/GetOwnedGames/v0001/?';
  private const GLOBAL_PERCENTAGES_URL = SteamAPI::BASE_URL . '/ISteamUserStats/GetGlobalAchievementPercentagesForApp/v2/?';

  public function __construct(private string $api_key) {}
  public function fetchUserAchievements(string $app_id, string $user_id): array|false
  {
    $response = $this->apiCall(self::USER_ACHIEVEMENTS_URL . $this->buildParams(["appid" => $app_id, "steamid" => $user_id]));

    if(empty($response) || empty($response["playerstats"]) || empty($response["playerstats"]["achievements"])) {
      return false;
    }

    $achievements = array_map(function($item) use($user_id) { return [
      "achievement_system_name" => $item["apiname"],
      "achieved" => $item["achieved"],
      "unlocked_at" => ($item["unlocktime"] > 0 ? $item["unlocktime"] : null),
      "user_id" => $user_id
    ]; }, $response["playerstats"]["achievements"]);

    return [
      'game_name' => $response["playerstats"]["gameName"],
      'game_id' => $app_id,
      'achievements' => $achievements
    ];
  }
  public function fetchAchievements(string $app_id): array|false
  {
    $response = $this->apiCall(self::ALL_ACHIEVEMENTS_URL . $this->buildParams(["appid" => $app_id]));

    if(empty($response["game"]) || empty($response["game"]["availableGameStats"]) || empty($response["game"]["availableGameStats"]["achievements"])) {
      return false;
    }

    return array_map(function($item) use ($app_id) {
      return [
        'system_name' => $item['name'],
        'display_name' => $item['displayName'],
        'hidden' => $item['hidden'],
        'description' => @$item['description'],
        'icon' => $item['icon'],
        'icongray' => $item['icongray'],
        'game_id' => $app_id
      ];
    }, $response["game"]["availableGameStats"]["achievements"]);
  }
  public function fetchUser(string $user_id): array|false
  {
    $response = $this->apiCall(self::USER_URL . $this->buildParams(['steamids' => $user_id]));

    if(!empty($players = $response["response"]["players"])) {
      $player = $players[0];
      return [
        'id' => $player['steamid'],
        'name' => $player['personaname'],
        'steam_url' => $player['profileurl'],
        'avatar_url' => $player['avatarfull']
      ];
    } else {
      return false;
    }
  }
  public function fetchUserGames(string $user_id): array|false
  {
    $response = $this->apiCall(self::USER_GAMES_URL . $this->buildParams([
      'steamid' => $user_id,
      'include_played_free_games' => 1
    ]));

    return array_map(function($item) use ($user_id) { return ['game_id' => $item['appid'], 'user_id' => $user_id]; }, $response['response']['games']);
  }
  public function fetchGameGlobalPercentages(string $app_id): array|false {
    $response = $this->apiCall(self::GLOBAL_PERCENTAGES_URL . $this->buildParams([
      'gameid' => $app_id
    ]));

    $result = [];

    foreach($response['achievementpercentages']['achievements'] as $achievement) {
      $result[$achievement['name']] = $achievement['percent'];
    }

    return $result;
  }
  private function apiCall(string $url): array|null
  {
    return json_decode(@file_get_contents($url), true);
  }
  private function buildParams(array $params): string
  {
    $default_params = [
      "key" => $this->api_key,
      "format" => "json"
    ];

    return http_build_query(array_merge($default_params, $params));
  }
}
