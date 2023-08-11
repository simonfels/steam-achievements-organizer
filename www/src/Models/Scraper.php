<?php

namespace App\Models;
use App\Helpers\SteamAPI;
use App\DataModels\User;
use PDO;

class Scraper extends AbstractModel {
  private SteamAPI $steam_api;
  public int $numberOfApiCalls;

  public function __construct() {
    parent::__construct();
    $this->steam_api = new SteamAPI();
    $this->numberOfApiCalls = 0;
  }

  public function allUsers(): array
  {
    $users = $this->database_connection->fetchAll(User::class, custom_sql: '
        select users.*, count(user_games.id) games_count, achievements.total_achievements from users
        left join user_games on users.id = user_games.user_id
        left join (
            select users.id, count(ua.id) total_achievements
            from users
            left join user_achievements ua on users.id = ua.user_id
            group by users.id
        ) achievements on achievements.id = users.id
        group by users.id
    ');
    return $users;
  }

  public function scrapeUserData(string $user_id): bool {
    $fetchedUser = $this->getSteamAPI()->fetchUser($user_id);
    if($fetchedUser)
    {
      $this->database_connection->insert('users', array_keys($fetchedUser), $fetchedUser, ['avatar_url', 'name']);
      return true;
    }
    return false;
  }

  public function scrapeUserGames(string $user_id): bool {
    $fetched = $this->getSteamAPI()->fetchUserGames($user_id);
    $fetchedGames = $fetched[0];
    $fetchedUserGames = $fetched[1];

    if(!empty($fetchedGames) && !empty($fetchedUserGames)) {
      $this->database_connection->import('games', $fetchedGames);
      $this->database_connection->import('user_games', $fetchedUserGames);

      return true;
    }
    return false;
  }

  public function scrapeGameAchievements(string $user_id, array $passedGameIds = null): bool {
    $user_games = $passedGameIds ?? $this->database_connection->fetchAll(custom_sql: "SELECT games.* FROM games JOIN user_games ON games.id = user_games.game_id WHERE user_games.user_id = $user_id", pdoMode: PDO::FETCH_COLUMN, column: 0);
    $game_ids = $user_games;

    foreach($game_ids as $game_id) {
      $fetchedAchievements = $this->getSteamAPI()->fetchAchievements($game_id);

      if(!empty($fetchedAchievements)) {
        $fetchedPercentages = $this->getSteamAPI()->fetchGameGlobalPercentages($game_id);
        $fetchedUserAchievements = $this->getSteamAPI()->fetchUserAchievements($game_id, $user_id);
        $mergedAchievements = array_map(function($item) use($fetchedPercentages) { return array_merge($item, ['percent' => $fetchedPercentages[$item['system_name']]]); }, $fetchedAchievements);

        $this->database_connection->import('achievements', $mergedAchievements, ['percent']);

        $insertedAchievementsQuery = $this->database_connection->fetchAll(custom_sql: "SELECT a.id, a.system_name FROM achievements a WHERE game_id = $game_id");
        $insertedAchievements = array_combine(array_column($insertedAchievementsQuery, 'system_name'), array_column($insertedAchievementsQuery, 'id'));

        $mergedUserAchievements = array_map(function($achievement) use($insertedAchievements) { return [
          'user_id' => $achievement['user_id'],
          'achievement_id' => $insertedAchievements[$achievement['achievement_system_name']],
          'achieved' => $achievement['achieved'],
          'unlocked_at' => $achievement['unlocked_at']
        ]; }, $fetchedUserAchievements);

        $this->database_connection->import('user_achievements', $mergedUserAchievements, ['achieved', 'unlocked_at']);

        if(count($mergedUserAchievements) === array_sum(array_column($mergedUserAchievements, 'achieved'))) {
            $last_unlocked_at = max(array_column($mergedUserAchievements, 'unlocked_at'));
            $sql = <<<SQL
                UPDATE user_games SET completed_at = :last_unlocked_at WHERE game_id = $game_id AND user_id = $user_id;
            SQL;

            $this->database_connection->pdo->prepare($sql)->execute(["last_unlocked_at" => $last_unlocked_at]);
        }
      }
    }
    return true;
  }

  private function getSteamAPI(): SteamAPI {
    $this->numberOfApiCalls++;
    return $this->steam_api;
  }
}