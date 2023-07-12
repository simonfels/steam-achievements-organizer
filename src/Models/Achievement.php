<?php

namespace App\Models;
class Achievement
{
  public int $id;
  public int $game_id;
  public string $system_name;
  public string $display_name;
  public bool $hidden;
  public string $description;
  public string $icon;
  public string $icongray;
  public bool $achieved;
  public ?string $unlocked_at;

  public function formatted_unlocked_at():string {
    return DateTime::createFromFormat( 'U', $this->unlocked_at )->format( 'c' );
  }
}
