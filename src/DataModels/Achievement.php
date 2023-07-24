<?php

namespace App\DataModels;
use DateTime;
use DateTimeZone;

class Achievement
{
  public int $id;
  public int $game_id;
  public string $game_name;
  public string $system_name;
  public string $display_name;
  public bool $hidden;
  public ?string $description;
  public string $icon;
  public string $icongray;
  public bool $achieved;
  public ?string $unlocked_at;
  public ?float $percent;

  public function formatted_unlocked_at(string $format = 'long'):?string {
    if(empty($this->unlocked_at)) return null;

    $datetime = DateTime::createFromFormat( 'U', $this->unlocked_at);
    $datetime->setTimezone(new DateTimeZone('Europe/Berlin'));

    if($format === 'short') {
      return $datetime->format( 'H:i \U\h\r' );
    } else {
      return $datetime->format( 'H:i \U\h\r d.m.Y' );
    }
  }

  public function getVars() {
    $array_of_vars = get_object_vars($this);
    $array_of_vars["unlocked_at"] = $this->formatted_unlocked_at();
    return json_encode($array_of_vars);
  }
}
