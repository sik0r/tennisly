<?php

declare(strict_types=1);

namespace App\Entity\Match;

use App\Entity\Id;
use App\Entity\League\TeamLeague;
use App\Entity\Team;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['league_id', 'home_team_id', 'away_team_id'])]
#[Gedmo\Loggable]
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
}
