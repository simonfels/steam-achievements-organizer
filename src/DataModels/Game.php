<?php

namespace App\DataModels;
class Game
{
  public int $id;
  public string $name;
  public int $unlocked_achievements;
  public int $total_achievements;
  public float $achievement_percent;
}
