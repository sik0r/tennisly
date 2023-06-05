<?php

declare(strict_types=1);

namespace App\Application\CompletedMatch;

use App\Entity\Match\PlayerMatch;
use App\Entity\Standings\Standings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Factory\UuidFactory;

#[AsMessageHandler]
class CompletedMatchHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UuidFactory $uuidFactory
    ) {
    }

    public function __invoke(CompletedMatchCommand $command): void
    {
        $currentMatch = $this->entityManager
            ->getRepository(PlayerMatch::class)
            ->find($command->matchId);
        $standings = $this->entityManager
            ->getRepository(Standings::class)
            ->findOneBy(['leagueId' => $command->leagueId]);

        if ($standings === null) {
            $standings = new Standings(
                $this->uuidFactory->create(),
                $command->leagueId
            );

            $this->entityManager->persist($standings);
            $this->entityManager->flush();
        }

        $this->entityManager->wrapInTransaction(function () use ($standings, $currentMatch) {
            if ($standings->hasMatch($currentMatch)) {
                $standings->removeMatch($currentMatch);
            }
            $standings->addMatch($currentMatch);
            $standings->calculateStandings();
        });
    }
}
