<?php

namespace App\Helpers;

use PDO;

class DatabaseConnection {
  public PDO $pdo;
  public function __construct() {
    extract([
      'servername' => 'db',
      'username' => 'root',
      'dbname' => 'playground_development',
      'password' => 'rootpassword'
    ]);

    $this->pdo = new PDO("mysql:host=$servername;dbname={$dbname}", $username, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
  }

  public function fetchAll($class = null, string $table = null, string $passed_sql = null, int $pdoMode = null, int $column = null):false|array
  {
    $sql = $passed_sql ?? 'SELECT * FROM ' . $table;
    $query = $this->pdo->prepare($sql);
    $query->execute();

    if(isset($pdoMode) && isset($column)) {
      return $query->fetchAll($pdoMode, $column);
    } else {
      if(!empty($class)) {
        return $query->fetchAll(PDO::FETCH_CLASS, $class);
      } else {
        return $query->fetchAll(PDO::FETCH_DEFAULT);
      }
    }
  }

  public function fetch(string $table, string $id_param, int $id, $class):mixed
  {
    $query = $this->pdo->query('SELECT * FROM ' . $table . ' WHERE ' . $id_param . ' = ' . $id);
    $query->setFetchMode(PDO::FETCH_CLASS, $class);
    return $query->fetch();
  }

  public function insert(string $table, array $attributes, array $entries, array|null $updatedAttributes = null): void {
    if(empty($updatedAttributes)) {
      $sql = 'INSERT IGNORE INTO ' . $table . ' (' . implode(', ', $attributes) . ')' .
              ' VALUES (' . implode(', ', array_map(function($item) { return ':' . $item; }, $attributes)) . ')';
    } else {
      $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $attributes) . ')' .
              ' VALUES (' . implode(', ', array_map(function($item) { return ':' . $item; }, $attributes)) . ') AS val' .
              ' ON DUPLICATE KEY UPDATE ' . implode(', ', array_map(function($item) { return "$item=val.$item"; }, $updatedAttributes));
    }

    $this->pdo->prepare($sql)->execute($entries);
  }

  public function import(string $table, array $items, array|null $updatedAttributes = null): void {
    foreach($items as $entries) {
      $this->insert($table, array_keys($entries), $entries, $updatedAttributes);
    }
  }
}
