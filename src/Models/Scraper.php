<?php

namespace App\Models;
use App\Helpers\SteamAPI;

class Scraper extends AbstractModel {
  const STEAM_API_KEY = "34726D7C756F3C392EAD2DABB301462C";
  private SteamAPI $steam_api;
  private array $log;
  public function __construct() {
    parent::__construct();
    $this->steam_api = new SteamAPI(self::STEAM_API_KEY);
    $this->log = array();
  }
  public function scrapeUser(string $user_id): array {
    $scrapedUser = $this->scrapeUserData($user_id);

    if($scrapedUser)
    {
      $scrapedGames = $this->scrapeUserGames($scrapedUser);
      $this->scrapeGameAchievements($scrapedGames);
      $userAchievements = $this->scrapeGamesData($scrapedGames, $user_id);
      $this->scrapeGameUserAchievements($userAchievements);
    }
    return ["success"];
  }

  private function scrapeUserData(string $user_id): string|false {
    $fetchedUser = $this->steam_api->fetchUser($user_id);
    if($fetchedUser)
    {
      $this->database_connection->insert('users', array_keys($fetchedUser), $fetchedUser);
      return $user_id;
    }
    return false;
  }
  private function scrapeUserGames(string $user_id): array {
    $fetchedGames = $this->steam_api->fetchUserGames($user_id);
    foreach($fetchedGames as $fetchedGame)
    {
      $this->database_connection->insert('user_games', array_keys($fetchedGame), $fetchedGame);
    }
    return array_column($fetchedGames, 'game_id');
  }
  private function scrapeGamesData(array $game_ids, string $user_id): array|false {
    $userAchievements = [];
    foreach($game_ids as $game_id) {
      $fetchedGame = $this->steam_api->fetchUserAchievements($game_id, $user_id);

      if(!empty($fetchedGame)) {
        $this->database_connection->insert('games', ['app_id', 'name'], [
          'app_id' => $fetchedGame["game_id"],
          'name' => $fetchedGame["game_name"]
        ]);
        $userAchievements[] = $fetchedGame["achievements"];
      }
    }
    return $userAchievements;
  }
  private function scrapeGameAchievements(array $game_ids): void {
    foreach($game_ids as $game_id)
    {
      $fetchedAchievements = $this->steam_api->fetchAchievements($game_id);

      if($fetchedAchievements) {
        foreach($fetchedAchievements as $fetchedAchievement) {
          $this->database_connection->insert('achievements', array_keys($fetchedAchievement), $fetchedAchievement);
        }
      }
    }
  }
  private function scrapeGamePercentages(): void {}
  private function scrapeGameUserAchievements(array $userAchievements): void {
    foreach($userAchievements as $gameAchievements) {
      foreach($gameAchievements as $gameAchievement) {
        $this->database_connection->insert('user_achievements', array_keys($gameAchievement), $gameAchievement);
      }
    }
  }
}