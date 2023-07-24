<?php

namespace App\Models;
use App\DataModels\User;
use App\DataModels\Achievement;

class UsersList extends AbstractModel
{
  public function all(): array {
    $sql = "SELECT users.*, coalesce(sum(achieved), 0) achieved_achievements, count(*) total_achievements
            FROM users
            LEFT JOIN user_achievements ua ON users.id = ua.user_id
            GROUP BY users.id;";
    return $this->database_connection->fetchAll(class: User::class, passed_sql: $sql);
  }

  public function find($user_id, $date = null): array {
    $user = $this->database_connection->fetch('users', 'id', $user_id, User::class);
    $sql = "SELECT floor((unlocked_at+7200)/86400)*86400 day, count(*) count FROM `user_achievements` WHERE unlocked_at IS NOT NULL AND user_id = $user_id GROUP BY day ORDER BY `day` DESC;";
    $days_query = $this->database_connection->fetchAll(passed_sql: $sql);
    $days = array_combine(
      array_map(function($item){ return $item['day']; }, $days_query),
      array_map(function($item){ return $item['count']; }, $days_query)
    );
    if(!empty($date)) {
      $sql2 = "SELECT achievements.*, games.name game_name, achieved, unlocked_at FROM `user_achievements` JOIN achievements ON user_achievements.achievement_id = achievements.id JOIN games ON games.id = achievements.game_id WHERE unlocked_at IS NOT NULL AND floor((unlocked_at+7200)/86400)*86400 = $date AND user_id = $user_id ORDER BY unlocked_at asc;";
      $achievements_query = $this->database_connection->fetchAll(class: Achievement::class,passed_sql: $sql2);
      $game_names = array_unique(array_map(function($item) { return $item->game_name; }, $achievements_query));
      $achievements = array_combine($game_names, array_map(function($game_name) use($achievements_query) { return array_filter($achievements_query, function($item) use($game_name) { return $item->game_name == $game_name; }); }, $game_names));
    }
    return [$user, $days, $achievements ?? null];
  }
}
