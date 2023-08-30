<?php

namespace App\DataModels;
class Tag
{
  public int $id;
  public string $name;
  public string $game_id;

  public static function withData(int $id, string $name): Tag
  {
    $instance = new self();
    $instance->id = $id;
    $instance->name = $name;
    
    return $instance;
  }
}
