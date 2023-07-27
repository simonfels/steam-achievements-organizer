<?php

namespace App\Models;
use App\Helpers\DatabaseConnection;

abstract class AbstractModel
{
  protected DatabaseConnection $database_connection;
  public function __construct() {
    $this->database_connection = new DatabaseConnection();
  }
}
