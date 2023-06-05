<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\League\PlayerLeague;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlayerLeague>
 */
class PlayerLeagueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerLeague::class);
    }

    /**
     * @return array<PlayerLeague>
     */
    public function getPlayersForLeague(int $leagueId): array
    {
        return $this->_em->createQueryBuilder()
            ->from(Player::class, 'player')
            ->join(
                PlayerLeague::class,
                'player_league',
                Join::WITH,
                'player_league.player = player.id AND player_league.league = :leagueId'
            )
            ->setParameter('leagueId', $leagueId)
            ->getQuery()
            ->getResult();
    }
}
