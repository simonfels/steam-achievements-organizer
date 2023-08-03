<?php

namespace App\DataModels;

use DateTime;
use DateTimeZone;

class Game
{
    public int $id;
    public string $name;
    public int $unlocked_achievements;
    public int $total_achievements;
    public float $achievement_percent;
    public ?string $completed_at;

    public function formatted_completed_at(): ?string
    {
        if (empty($this->completed_at)) {
            return null;
        }

        $datetime = DateTime::createFromFormat('U', $this->completed_at);
        $datetime->setTimezone(new DateTimeZone('Europe/Berlin'));

        return $datetime->format('d.m.Y');
    }

    public function getVars()
    {
        $array_of_vars = get_object_vars($this);
        $array_of_vars["completed_at"] = $this->formatted_completed_at();
        $array_of_vars["achievement_percent"] = $this->floordec($this->achievement_percent);
        return json_encode($array_of_vars);
    }

    private function floordec($zahl): float|int
    {
        return floor($zahl*pow(10, 2))/pow(10, 2);
    }
}
