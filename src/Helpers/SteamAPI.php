<?php

namespace App\Helpers;

class SteamAPI {
  const BASE_URL = "https://api.steampowered.com";
  const ALL_ACHIEVEMENTS_URL = SteamAPI::BASE_URL . '/ISteamUserStats/GetSchemaForGame/v2/?';
  const USER_ACHIEVEMENTS_URL = SteamAPI::BASE_URL . '/ISteamUserStats/GetPlayerAchievements/v0001/?';
  public function __construct(private string $api_key) {}
  public function fetch_user_achievements(string $app_id, string $user_id):array
  {
    $response = $this->api_call(self::USER_ACHIEVEMENTS_URL . $this->build_params(["appid" => $app_id, "steamid" => $user_id]));

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
  public function fetch_achievements(string $app_id):array
  {
    $response = $this->api_call(self::ALL_ACHIEVEMENTS_URL . $this->build_params(["appid" => $app_id]));
    $achievements = array_map(function($item) use ($app_id) {
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

    return [
      "achievements" => $achievements
    ];
  }
  private function api_call(string $url):array
  {
    return json_decode(file_get_contents($url), true);
  }
  private function build_params(array $params):string
  {
    $default_params = [
      "key" => $this->api_key,
      "format" => "json"
    ];

    return http_build_query(array_merge($default_params, $params));
  }
}
