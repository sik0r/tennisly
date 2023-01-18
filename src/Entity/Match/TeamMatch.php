<?php

declare(strict_types=1);

namespace App\Entity\Match;

use App\Entity\League\TeamLeague;
use App\Entity\Team;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['league_id', 'home_team_id', 'away_team_id'])]
class TeamMatch extends BaseMatch
{
    #[ORM\ManyToOne(targetEntity: Team::class, cascade: ['remove'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private Team $homeTeam;

    #[ORM\ManyToOne(targetEntity: Team::class, cascade: ['remove'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private Team $awayTeam;

    #[ORM\ManyToOne(targetEntity: TeamLeague::class, cascade: ['remove'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
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
}
