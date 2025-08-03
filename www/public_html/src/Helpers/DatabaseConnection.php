<?php

namespace App\Helpers;

use PDO;

class DatabaseConnection
{
    public PDO $pdo;

    public function __construct()
    {
        extract(json_decode(file_get_contents(__DIR__ . '/../../.env'), true));

        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function fetchAll(
        $class = null,
        string $table = null,
        string $custom_sql = null,
        int $pdoMode = null,
        int $column = null
    ): false|array {
        $sql = $custom_sql ?? 'SELECT * FROM ' . $table;
        $query = $this->pdo->prepare($sql);
        $query->execute();

        if (isset($pdoMode) && isset($column)) {
            return $query->fetchAll($pdoMode, $column);
        } else {
            if (!empty($class)) {
                return $query->fetchAll(PDO::FETCH_CLASS, $class);
            } else {
                return $query->fetchAll(PDO::FETCH_DEFAULT);
            }
        }
    }

    public function fetch(string $table, string $id_param, int $id, $class, string $custom_sql = null): mixed
    {
        $sql = $custom_sql ?? <<<SQL
            SELECT * FROM $table WHERE $id_param = $id
        SQL;
        $query = $this->pdo->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);

        return $query->fetch();
    }

    public function insert(string $table, array $attributes, array $entries, array|null $updatedAttributes = null): void
    {
        $sqlAttributes = implode(', ', $attributes);
        $sqlValues = "(" . implode(', ', array_map(function ($item) { return ':' . $item; }, $attributes)) . ")";

        $query = empty($updatedAttributes) ? "INSERT IGNORE INTO $table ($sqlAttributes) VALUES $sqlValues" : $this->upsertQuery($table, $sqlAttributes, $sqlValues, $updatedAttributes);

        $this->pdo->prepare($query)->execute($entries);
    }

    public function import(string $table, array $items, array|null $updatedAttributes = null): void
    {
        $sqlAttributes = implode(', ', array_keys($items[0]));
        $sqlValues = implode(", ", array_map(function ($item) {
            $values = array_map(function ($value) {
                return $value === null ? "NULL" : "\"" . addslashes($value) . "\"";
            }, array_values($item));
            return "(" . implode(", ", $values) . ")";
        }, $items));

        $query = empty($updatedAttributes) ? "INSERT IGNORE INTO $table ($sqlAttributes) VALUES $sqlValues" : $this->upsertQuery($table, $sqlAttributes, $sqlValues, $updatedAttributes);

        $this->pdo->exec($query);
    }

    private function upsertQuery(string $table, string $sqlAttributes, string $sqlValues, array $updatedAttributes): string
    {
        $updateValuesQuery = implode(', ', array_map(function ($attribute) { return "$attribute=VALUES($attribute)"; }, $updatedAttributes));
        return "INSERT INTO $table ($sqlAttributes) VALUES $sqlValues ON DUPLICATE KEY UPDATE $updateValuesQuery";
    }
}
