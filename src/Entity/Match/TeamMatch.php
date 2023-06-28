<?php

declare(strict_types=1);

namespace App\Entity\Match;

use App\Entity\Id;
use App\Entity\League\TeamLeague;
use App\Entity\Team;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['league_id', 'home_team_id', 'away_team_id'])]
#[Gedmo\Loggable]
#[UniqueEntity(fields: ['league', 'homeTeam', 'awayTeam'], message: 'Mecz z wybranmi drużynami już istnieje.')]
class TeamMatch extends BaseMatch
{
    use Id;

    #[ORM\ManyToOne(targetEntity: Team::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Versioned]
    private Team $homeTeam;

    #[ORM\ManyToOne(targetEntity: Team::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Versioned]
    private Team $awayTeam;

    #[ORM\ManyToOne(targetEntity: TeamLeague::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Versioned]
    private TeamLeague $league;

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(Team $homeTeam): void
    {
        $this->homeTeam = $homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function setAwayTeam(Team $awayTeam): void
    {
        $this->awayTeam = $awayTeam;
    }

    public function getLeague(): TeamLeague
    {
        return $this->league;
    }

    public function setLeague(TeamLeague $league): void
    {
        $this->league = $league;
    }

    public function getLeagueId(): Uuid
    {
        return $this->league->getId();
    }

    public function getHomeCompetitorName(): string
    {
        return $this->homeTeam->getName();
    }

    public function getHomeCompetitorId(): string
    {
        return (string)$this->homeTeam->getId();
    }

    public function getAwayCompetitorName(): string
    {
        return $this->awayTeam->getName();
    }

    public function getAwayCompetitorId(): string
    {
        return (string)$this->awayTeam->getId();
    }
}
