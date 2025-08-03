<?php

declare(strict_types=1);

namespace App\Repositories;

class PlayerRepository extends AbstractRepository
{
    private const TABLE_NAME = 'users';
    private const TABLE_COLUMNS = ['id', 'name', 'steam_url', 'avatar_url'];

    public function upsert(array $playerData): void
    {
        $this->databaseConnection->insert(
            $this::TABLE_NAME,
            $this::TABLE_COLUMNS,
            $playerData,
            ['avatar_url', 'name']
        );
    }
}
