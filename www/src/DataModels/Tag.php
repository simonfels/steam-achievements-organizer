<?php

namespace App\DataModels;
class Tag
{
  public int $id;
  public string $name;
  public string $game_id;
  public string $background_color;

  public static function withData(int $id, string $name, string $background_color): Tag
  {
    $instance = new self();
    $instance->id = $id;
    $instance->name = $name;
    $instance->background_color = $background_color;
    
    return $instance;
  }
}
