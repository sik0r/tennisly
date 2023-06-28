<?php

declare(strict_types=1);

namespace App\Entity\League;

use App\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class TeamLeague extends League
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\JoinTable(name: 'leagues_teams')]
    #[ORM\JoinColumn(name: 'league_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'team_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Team::class)]
    private Collection $teams;

    public function __construct()
    {
        parent::__construct();
        $this->teams = new ArrayCollection();
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
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
