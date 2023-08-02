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
}
