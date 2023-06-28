<?php

declare(strict_types=1);

namespace App\Entity\Standings;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
class Standings
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'uuid', unique: true)]
    private readonly Uuid $id;

    #[ORM\Column(type: 'uuid', unique: true)]
    private readonly Uuid $leagueId;

    #[ORM\Column(type: 'json')]
    private array $matches;

    #[ORM\Column(type: 'json')]
    private array $standings;

    public function __construct(Uuid $id, Uuid $leagueId)
    {
        $this->id = $id;
        $this->leagueId = $leagueId;
        $this->matches = [];
        $this->standings = [];
    }

    public function standings(): array
    {
        return array_values($this->standings);
    }

    public function matches(): array
    {
        return array_values($this->matches);
    }

    public function getLeagueId(): Uuid
    {
        return $this->leagueId;
    }

    public function hasMatch(MatchInterface $match): bool
    {
        return array_key_exists($match->getId(), $this->matches);
    }

    public function addMatch(MatchInterface $match): void
    {
        if (!$this->leagueId->equals($match->getLeagueId())) {
            throw new \InvalidArgumentException('Match league id does not match aggregate league id');
        }

        if (array_key_exists($match->getId(), $this->matches)) {
            throw new \InvalidArgumentException('Match already exists in aggregate');
        }

        $this->matches[$match->getId()] = [
            'homeCompetitorName' => $match->getHomeCompetitorName(),
            'homeCompetitorId' => $match->getHomeCompetitorId(),
            'awayCompetitorName' => $match->getAwayCompetitorName(),
            'awayCompetitorId' => $match->getAwayCompetitorId(),
            'points' => $match->getPoints(),
        ];
    }

    public function removeMatch(MatchInterface $match): void
    {
        if (!$this->leagueId->equals($match->getLeagueId())) {
            throw new \InvalidArgumentException('Match league id does not match aggregate league id');
        }

        if (!array_key_exists($match->getId(), $this->matches)) {
            throw new \InvalidArgumentException('Match does not exist in aggregate');
        }

        unset($this->matches[$match->getId()]);
    }

    public function calculateStandings(): void
    {
        $standings = [];
        foreach ($this->matches as $match) {
            $standings = $this->initCompetitorIfNotExists($match, $standings);
            $homeGems = 0;
            $awayGems = 0;
            $homeSets = 0;
            $awaySets = 0;

            foreach ($match['points'] as $setPoints) {
                $homeGems += $setPoints['homeGems'];
                $awayGems += $setPoints['awayGems'];

                if ($setPoints['homeGems'] > $setPoints['awayGems']) {
                    $homeSets++;
                } else {
                    $awaySets++;
                }
            }

            $standings = $this->applyCalculatedMatchResult(
                standings: $standings,
                match: $match,
                homeGems: $homeGems,
                awayGems: $awayGems,
                homeSets: $homeSets,
                awaySets: $awaySets
            );
        }

        $standings = $this->sortStandings($standings);
        $this->standings = $standings;
    }

    private function initCompetitorIfNotExists(array $match, array $standings): array
    {
        if (!array_key_exists($match['homeCompetitorId'], $standings)) {
            $standings[$match['homeCompetitorId']] = [
                'points' => 0,
                'wonGames' => 0,
                'lostGames' => 0,
                'wonSets' => 0,
                'lostSets' => 0,
                'wonGems' => 0,
                'lostGems' => 0,
            ];
        }

        if (!array_key_exists($match['awayCompetitorId'], $standings)) {
            $standings[$match['awayCompetitorId']] = [
                'points' => 0,
                'wonGames' => 0,
                'lostGames' => 0,
                'wonSets' => 0,
                'lostSets' => 0,
                'wonGems' => 0,
                'lostGems' => 0,
            ];
        }

        return $standings;
    }

    private function applyCalculatedMatchResult(
        array $standings,
        array $match,
        int $homeGems,
        int $awayGems,
        int $homeSets,
        int $awaySets
    ): array {
        $standings[$match['homeCompetitorId']]['wonGems'] += $homeGems;
        $standings[$match['homeCompetitorId']]['lostGems'] += $awayGems;
        $standings[$match['homeCompetitorId']]['wonSets'] += $homeSets;
        $standings[$match['homeCompetitorId']]['lostSets'] += $awaySets;
        $standings[$match['awayCompetitorId']]['wonGems'] += $awayGems;
        $standings[$match['awayCompetitorId']]['lostGems'] += $homeGems;
        $standings[$match['awayCompetitorId']]['wonSets'] += $awaySets;
        $standings[$match['awayCompetitorId']]['lostSets'] += $homeSets;

        if ($homeSets > $awaySets) {
            $standings[$match['homeCompetitorId']]['points'] += 3;
            $standings[$match['homeCompetitorId']]['wonGames'] += 1;
            $standings[$match['awayCompetitorId']]['lostGames'] += 1;
        } else {
            $standings[$match['awayCompetitorId']]['points'] += 3;
            $standings[$match['awayCompetitorId']]['wonGames'] += 1;
            $standings[$match['homeCompetitorId']]['lostGames'] += 1;
        }

        $standings[$match['homeCompetitorId']]['name'] = $match['homeCompetitorName'];
        $standings[$match['homeCompetitorId']]['homeCompetitorId'] = $match['homeCompetitorId'];
        $standings[$match['awayCompetitorId']]['name'] = $match['awayCompetitorName'];
        $standings[$match['awayCompetitorId']]['awayCompetitorId'] = $match['awayCompetitorId'];

        return $standings;
    }

    private function sortStandings(array $standings): array
    {
        usort($standings, function (array $a, array $b) {
            return $b['points'] <=> $a['points'];
        });

        return $standings;
    }
}
