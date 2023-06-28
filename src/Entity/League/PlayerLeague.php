<?php

declare(strict_types=1);

namespace App\Entity\League;

use App\Entity\Player;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class PlayerLeague extends League
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\JoinTable(name: 'leagues_players')]
    #[ORM\JoinColumn(name: 'league_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'player_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Player::class)]
    private Collection $players;

    public function __construct()
    {
        parent::__construct();
        $this->players = new ArrayCollection();
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function setPlayers(Collection $players): void
    {
        $this->players = $players;
    }
}
