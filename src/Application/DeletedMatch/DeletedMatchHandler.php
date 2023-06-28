<?php

declare(strict_types=1);

namespace App\Application\DeletedMatch;

use App\Entity\Match\PlayerMatch;
use App\Entity\Match\TeamMatch;
use App\Entity\Standings\MatchInterface;
use App\Entity\Standings\Standings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeletedMatchHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(DeletedMatchCommand $command): void
    {
        $currentMatch = $this->getMatch($command);
        $standings = $this->entityManager
            ->getRepository(Standings::class)
            ->findOneBy(['leagueId' => $command->leagueId]);

        if ($standings === null) {
            return;
        }

        if ($standings->hasMatch($currentMatch)) {
            $standings->removeMatch($currentMatch);
        }

        $standings->calculateStandings();
    }

    private function getMatch(DeletedMatchCommand $command): MatchInterface
    {
        $repository = match ($command->matchType) {
            'single' => $this->entityManager->getRepository(PlayerMatch::class),
            'double' => $this->entityManager->getRepository(TeamMatch::class),
            default => throw new \InvalidArgumentException('Invalid match type'),
        };

        return $repository->find($command->matchId);
    }
}
