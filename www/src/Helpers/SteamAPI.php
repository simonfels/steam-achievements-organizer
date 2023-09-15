<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class SteamAPI
{
    private const BASE_URL = "https://api.steampowered.com";
    private const ALL_ACHIEVEMENTS_URL = 'ISteamUserStats/GetSchemaForGame/v2/?';
    private const USER_ACHIEVEMENTS_URL = 'ISteamUserStats/GetPlayerAchievements/v1/?';
    private const USER_URL = 'ISteamUser/GetPlayerSummaries/v2/?';
    private const USER_GAMES_URL = 'IPlayerService/GetOwnedGames/v1/?';
    private const GLOBAL_PERCENTAGES_URL = 'ISteamUserStats/GetGlobalAchievementPercentagesForApp/v2/?';

    private string $steamApiKey;

    public function __construct()
    {
        extract(json_decode(file_get_contents(__DIR__ . '/../../.env'), true));

        $this->steamApiKey = $steamapikey;
    }

    public function fetchUserAchievements(string $app_id, string $user_id): array|false
    {
        $response = $this->apiCall(self::USER_ACHIEVEMENTS_URL, $this->buildParams(["appid" => $app_id, "steamid" => $user_id]));

        if(empty($response) || empty($response["playerstats"]) || empty($response["playerstats"]["achievements"])) {
            return false;
        }

        return array_map(function ($item) use ($user_id) {
            return [
              "achievement_system_name" => $item["apiname"],
              "achieved" => $item["achieved"],
              "unlocked_at" => ($item["unlocktime"] > 0 ? $item["unlocktime"] : null),
              "user_id" => $user_id
            ];
        }, $response["playerstats"]["achievements"]);
    }

    public function fetchAchievements(string $app_id): array|false
    {
        $response = $this->apiCall(self::ALL_ACHIEVEMENTS_URL, $this->buildParams(["appid" => $app_id]));

        if(empty($response["game"]) || empty($response["game"]["availableGameStats"]) || empty($response["game"]["availableGameStats"]["achievements"])) {
            return false;
        }

        return array_map(function ($item) use ($app_id) {
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

    public function fetchPlayer(string $user_id): PlayerDTO|false
    {
        $response = $this->apiCall(self::USER_URL, $this->buildParams(['steamids' => $user_id]));

        if(!empty($response["response"]["players"])) {
            return PlayerDTO::fromApiResponse($response);
        } else {
            return false;
        }
    }

    public function fetchUserGames(string $user_id): array|false
    {
        $response = $this->apiCall(self::USER_GAMES_URL, $this->buildParams([
            'steamid' => $user_id,
            'include_played_free_games' => 1,
            'include_appinfo' => 1
        ]));
        $games = array_map(function ($item) { return ['id' => $item['appid'], 'name' => $item['name']]; }, $response['response']['games']);
        $user_games = array_map(function ($item) use ($user_id) { return ['game_id' => $item['appid'], 'user_id' => $user_id]; }, $response['response']['games']);

        return [$games, $user_games];
    }

    public function fetchGameGlobalPercentages(string $app_id): array|false
    {
        $response = $this->apiCall(self::GLOBAL_PERCENTAGES_URL, $this->buildParams([
            'gameid' => $app_id
        ]));

        $result = [];

        foreach($response['achievementpercentages']['achievements'] as $achievement) {
            $result[$achievement['name']] = $achievement['percent'];
        }

        return $result;
    }

    private function apiCall(string $url, array $params): array|null
    {
        $client = new Client([
            'base_uri' => $this::BASE_URL,
            'timeout'  => 2.0,
        ]);

        $request = $client->request('GET', $url, ['query' => $params]);

        return json_decode($request->getBody(), true);
    }

    private function buildParams(array $params): array
    {
        $default_params = [
          "key" => $this->steamApiKey,
          "format" => "json"
        ];

        return array_merge($default_params, $params);
    }
}
