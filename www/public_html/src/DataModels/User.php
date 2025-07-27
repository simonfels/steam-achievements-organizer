<?php

namespace App\DataModels;

class User
{
    public string $id;
    public string $name;
    public string $avatar_url;
    public string $steam_url;
    public int $total_achievements;
    public int $achieved_achievements;
    public int $games_count;

    public function achievementPercentage(): float
    {
        if($this->total_achievements === 0) {
            return 0;
        }
        return round((float)$this->achieved_achievements / $this->total_achievements, 2) * 100;
    }
}
