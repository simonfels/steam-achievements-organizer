<?php

namespace App\Helpers;

use PDO;

class DatabaseConnection {
  public PDO $pdo;
  public function __construct() {
    extract(json_decode(file_get_contents(__DIR__ . '/../../.env'), true));

    $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
  }

  public function fetchAll($class = null, string $table = null, string $custom_sql = null, int $pdoMode = null, int $column = null):false|array
  {
    $sql = $custom_sql ?? 'SELECT * FROM ' . $table;
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
      $base_sql = "INTO $table (" . implode(', ', $attributes) . ')' .
                  ' VALUES (' . implode(', ', array_map(function($item) { return ':' . $item; }, $attributes)) . ')';

      if(empty($updatedAttributes)) {
          $sql = "INSERT IGNORE $base_sql";
      } else {
          $sql = "INSERT $base_sql ON DUPLICATE KEY UPDATE " . implode(', ', array_map(function($item) { return "$item=VALUES($item)"; }, $updatedAttributes));
      }

      $this->pdo->prepare($sql)->execute($entries);
  }

    public function import(string $table, array $items, array|null $updatedAttributes = null): void {
        $schema = array_keys($items[0]);
        $base_sql = "INTO $table (" . implode(', ', $schema) . ")" .
                    " VALUES " . implode(', ', array_map(function($item) {
                        $values = array_map(function($val) { return $val === null ? "NULL" : "\"" . addslashes($val) . "\""; }, array_values($item));
                        return "(" . implode(", ", $values) . ")";
                    }, $items));

        if(empty($updatedAttributes)) {
            $sql = "INSERT IGNORE $base_sql";
        } else {
            $sql = "INSERT $base_sql  ON DUPLICATE KEY UPDATE " . implode(', ', array_map(function($item) { return "$item=VALUES($item)"; }, $updatedAttributes));
        }

        $this->pdo->exec($sql);
    }
}
