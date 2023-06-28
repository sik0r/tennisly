<?php

declare(strict_types=1);

namespace App\Entity\Match;

use App\Entity\Id;
use App\Entity\League\PlayerLeague;
use App\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['league_id', 'home_player_id', 'away_player_id'])]
#[Gedmo\Loggable]
#[UniqueEntity(fields: ['league', 'homePlayer', 'awayPlayer'], message: 'Mecz z wybranmi zawodnikami już istnieje.')]
class PlayerMatch extends BaseMatch
{
    use Id;

    #[ORM\ManyToOne(targetEntity: Player::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Versioned]
    private Player $homePlayer;

    #[ORM\ManyToOne(targetEntity: Player::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Versioned]
    private Player $awayPlayer;

    #[ORM\ManyToOne(targetEntity: PlayerLeague::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Versioned]
    private PlayerLeague $league;

    public function getHomePlayer(): Player
    {
        return $this->homePlayer;
    }

    public function setHomePlayer(Player $homePlayer): void
    {
        $this->homePlayer = $homePlayer;
    }

    public function getAwayPlayer(): Player
    {
        return $this->awayPlayer;
    }

    public function setAwayPlayer(Player $awayPlayer): void
    {
        $this->awayPlayer = $awayPlayer;
    }

    public function getLeague(): PlayerLeague
    {
        return $this->league;
    }

    public function setLeague(PlayerLeague $league): void
    {
        $this->league = $league;
    }

    public function getLeagueId(): Uuid
    {
        return $this->league->getId();
    }

    public function getHomeCompetitorName(): string
    {
        return $this->homePlayer->getFullName();
    }

    public function getHomeCompetitorId(): string
    {
        return (string)$this->homePlayer->getId();
    }

    public function getAwayCompetitorName(): string
    {
        return $this->awayPlayer->getFullName();
    }

    public function getAwayCompetitorId(): string
    {
        return (string)$this->awayPlayer->getId();
    }
}
