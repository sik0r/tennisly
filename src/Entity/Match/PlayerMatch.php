<?php

declare(strict_types=1);

namespace App\Entity\Match;

use App\Entity\Id;
use App\Entity\League\PlayerLeague;
use App\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['league_id', 'home_player_id', 'away_player_id'])]
#[Gedmo\Loggable]
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
}
