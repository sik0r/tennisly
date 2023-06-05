<?php

declare(strict_types=1);

namespace App\Application\CompletedMatch;

class CompletedMatchCommand
{
    public function __construct(public readonly int $matchId, public readonly int $leagueId)
    {
    }
}
