<?php

namespace App\DataModels;
class User
{
  public int $id;
  public string $name;
  public string $avatar_url;
  public string $steam_url;
  public int $total_achievements;
  public int $achieved_achievements;
  public int $games_count;

  public function achievementPercentage():float {
    return round((float)$this->achieved_achievements / $this->total_achievements, 2) * 100;
  }
  }
