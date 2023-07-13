<?php

namespace App\Models;
use App\DataModels\User;

class UsersList extends AbstractModel
{
  public function all():array {
    $sql = "SELECT users.*, coalesce(sum(achieved), 0) achieved_achievements, count(*) total_achievements
            FROM users
            LEFT JOIN user_achievements ua ON users.id = ua.user_id
            GROUP BY users.id;";
    return $this->database_connection->fetchAll(class: User::class, passed_sql: $sql);
  }
}
