<?php

declare(strict_types=1);

namespace App\Entity\Standings;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
class LeagueTable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $player;

    #[ORM\Column(type: 'integer')]
    private int $points;

    #[ORM\Column(type: 'integer')]
    private int $wonGames;

    #[ORM\Column(type: 'integer')]
    private int $lostGames;

    #[ORM\Column(type: 'integer')]
    private int $wonSets;

    #[ORM\Column(type: 'integer')]
    private int $lostSets;

    #[ORM\Column(type: 'integer')]
    private int $season;

    #[ORM\Column(type: 'integer',)]
    private int $league;

    public function __construct(
        Uuid $id,
        string $player,
        int $points,
        int $wonGames,
        int $lostGames,
        int $wonSets,
        int $lostSets,
        int $season,
        int $league
    ) {
        $this->id = $id;
        $this->player = $player;
        $this->points = $points;
        $this->wonGames = $wonGames;
        $this->lostGames = $lostGames;
        $this->wonSets = $wonSets;
        $this->lostSets = $lostSets;
        $this->season = $season;
        $this->league = $league;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getWonGames(): int
    {
        return $this->wonGames;
    }

    public function getLostGames(): int
    {
        return $this->lostGames;
    }

    public function getWonSets(): int
    {
        return $this->wonSets;
    }

    public function getLostSets(): int
    {
        return $this->lostSets;
    }

    public function getSeason(): int
    {
        return $this->season;
    }

    public function getLeague(): int
    {
        return $this->league;
    }
}
