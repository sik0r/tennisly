<?php

declare(strict_types=1);

namespace App\Entity\Standings;

use Symfony\Component\Uid\Uuid;

interface MatchInterface
{
    public function getId(): ?int;

    public function getLeagueId(): Uuid;

    public function getHomeCompetitorName(): string;
    public function getHomeCompetitorId(): string;

    public function getAwayCompetitorName(): string;
    public function getAwayCompetitorId(): string;

    public function getPoints(): array;
}
