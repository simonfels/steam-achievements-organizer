<?php

declare(strict_types=1);

namespace App\Helpers;

class PlayerDTO
{
    public const TABLE_COLUMNS = ['id', 'name', 'steam_url', 'avatar_url'];

    public function __construct(
        private readonly string $steamId,
        private readonly string $name,
        private readonly string $steamUrl,
        private readonly string $avatarUrl
    ) {}

    public static function fromApiResponse(array $apiResponse)
    {
        $playerInformation = $apiResponse["response"]["players"][0];
        
        $steamId = $playerInformation["steamid"];
        $name = $playerInformation["personaname"];
        $steamUrl = $playerInformation["profileurl"];
        $avatarUrl = $playerInformation["avatarfull"];
        return new self($steamId, $name, $steamUrl, $avatarUrl);
    }

    public function getAttributes(): array
    {
        return [
            'id' => $this->steamId,
            'name' => $this->name,
            'steam_url' => $this->steamUrl,
            'avatar_url' => $this->avatarUrl
        ];
    }
}
