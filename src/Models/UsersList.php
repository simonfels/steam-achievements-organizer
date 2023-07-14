<?php

namespace App\Models;
use App\DataModels\User;

class UsersList extends AbstractModel
{
  public function all(): array {
    $sql = "SELECT users.*, coalesce(sum(achieved), 0) achieved_achievements, count(*) total_achievements
            FROM users
            LEFT JOIN user_achievements ua ON users.id = ua.user_id
            GROUP BY users.id;";
    return $this->database_connection->fetchAll(class: User::class, passed_sql: $sql);
  }

  public function find($user_id): array {
    $user = $this->database_connection->fetch('users', 'id', $user_id, User::class);
    $sql = "SELECT floor((unlocked_at+7200)/86400)*86400 day, count(*) count FROM `user_achievements` WHERE unlocked_at IS NOT NULL AND user_id = '76561197999852541' GROUP BY day ORDER BY `day` DESC;";
    $days_query = $this->database_connection->fetchAll(passed_sql: $sql);
    $days = array_combine(
      array_map(function($item){ return $item['day']; }, $days_query),
      array_map(function($item){ return $item['count']; }, $days_query)
    );
    //$days = array_combine();
    return [$user, $days];
  }
}


/*
public function find($app_id):array {
  $game = $this->database_connection->fetch("games", "app_id", $app_id, \App\DataModels\Game::class);
  $sql = "SELECT a.*, ua.achieved, ua.unlocked_at FROM achievements a JOIN user_achievements ua ON ua.achievement_system_name = a.system_name WHERE game_id = " . $app_id . " ORDER BY achieved desc, unlocked_at desc";
  $game_achievements = $this->database_connection->fetchAll(class: \App\DataModels\Achievement::class, passed_sql: $sql);

  return [$game, $game_achievements];
}
*/