<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Helpers\DatabaseConnection;

abstract class AbstractRepository
{
    protected DatabaseConnection $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = new DatabaseConnection();
    }
}
