<?php

declare(strict_types=1);

namespace App\Entity\League;

use App\Entity\Id;
use App\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TeamLeague extends League
{
    use Id;

    #[ORM\JoinTable(name: 'leagues_teams')]
    #[ORM\JoinColumn(name: 'league_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'team_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Team::class)]
    private Collection $teams;

    public function __construct()
    {
        parent::__construct();
        $this->teams = new ArrayCollection();
    }

    /**
     * @return Collection<Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function setTeams(Collection $teams): void
    {
        $this->teams = $teams;
    }
}
