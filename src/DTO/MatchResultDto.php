<?php

declare(strict_types=1);

namespace App\DTO;

class MatchResultDto
{
    public function __construct(
        public string $homeCompetitorName,
        public int $homeCompetitorId,
        public string $awayCompetitorName,
        public int $awayCompetitorId,
        public array $points
    ) {
    }

    public static function create(array $matchResult): self
    {
        return new self(
            $matchResult['homeCompetitorName'],
            (int)$matchResult['homeCompetitorId'],
            $matchResult['awayCompetitorName'],
            (int)$matchResult['awayCompetitorId'],
            $matchResult['points']
        );
    }

    public function getHomePlayerWins(): int
    {
        $homePlayerWins = 0;
        foreach ($this->points as $point) {
            if ($point['homeGems'] > $point['awayGems']) {
                $homePlayerWins++;
            }
        }

        return $homePlayerWins;
    }

    public function getAwayPlayerWins(): int
    {
        $awayPlayerWins = 0;
        foreach ($this->points as $point) {
            if ($point['awayGems'] > $point['homeGems']) {
                $awayPlayerWins++;
            }
        }

        return $awayPlayerWins;
    }
}
