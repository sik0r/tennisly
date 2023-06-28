<?php

declare(strict_types=1);

namespace App\Application\DeletedMatch;

use Symfony\Component\Uid\Uuid;

class DeletedMatchCommand
{
    public function __construct(
        public readonly int $matchId,
        public readonly Uuid $leagueId,
        public readonly string $matchType,
    ) {
    }
}
