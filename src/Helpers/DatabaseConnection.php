<?php

namespace App\Helpers;

class DatabaseConnection {
  private \PDO $pdo;
  public function __construct() {
    extract([
      'servername' => 'db',
      'username' => 'root',
      'dbname' => 'playground_development',
      'password' => 'rootpassword'
    ]);

    $this->pdo = new \PDO("mysql:host=$servername;dbname={$dbname}", $username, $password, [
      \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]);
  }

  public function fetchAll(string $table, $class, $passed_sql = null):false|array
  {
    $sql = $passed_sql ?? 'SELECT * FROM ' . $table;
    $query = $this->pdo->prepare($sql);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, $class);
  }

  public function fetch(string $table, string $id_param, int $id, $class):mixed
  {
    $query = $this->pdo->query('SELECT * FROM ' . $table . ' WHERE ' . $id_param . ' = ' . $id);
    $query->setFetchMode(\PDO::FETCH_CLASS, $class);
    return $query->fetch();
  }

  public function insert(string $table, array $attributes, array $entries) {
    $sql = 'INSERT IGNORE INTO ' . $table . ' (' . implode(', ', $attributes) . ') VALUES (' . implode(', ', array_map(function($item) { return ':' . $item; }, $attributes)) . ')';
    $this->pdo->prepare($sql)->execute($entries);
  }
}
