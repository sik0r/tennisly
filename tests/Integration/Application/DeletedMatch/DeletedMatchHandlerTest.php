<?php

declare(strict_types=1);

namespace App\Tests\Integration\Application\DeletedMatch;

use App\Application\DeletedMatch\DeletedMatchCommand;
use App\Application\DeletedMatch\DeletedMatchHandler;
use App\Entity\League\PlayerLeague;
use App\Entity\Match\PlayerMatch;
use App\Entity\Player;
use App\Entity\Season;
use App\Entity\Standings\Standings;
use App\Enum\GenderEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class DeletedMatchHandlerTest extends KernelTestCase
{
    private DeletedMatchHandler $handler;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->handler = self::getContainer()->get(DeletedMatchHandler::class);
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCorrectDeleteMatch(): void
    {
        $homePlayer = new Player();
        $homePlayer->setFirstName('test');
        $homePlayer->setLastName('test');
        $homePlayer->setEmail(uniqid());
        $homePlayer->setGender(GenderEnum::Male->value);
        $this->em->persist($homePlayer);
        $awayPlayer = new Player();
        $awayPlayer->setFirstName('test');
        $awayPlayer->setLastName('test');
        $awayPlayer->setEmail(uniqid());
        $awayPlayer->setGender(GenderEnum::Male->value);
        $this->em->persist($awayPlayer);
        $season = new Season();
        $season->setName('test');
        $this->em->persist($season);
        $match = new PlayerMatch();
        $league = new PlayerLeague();
        $league->setName('test');
        $league->setSeason($season);
        $league->setGender(GenderEnum::Male->value);
        $match->setLeague($league);
        $match->setHomePlayer($homePlayer);
        $match->setAwayPlayer($awayPlayer);
        $this->em->persist($league);
        $this->em->persist($match);
        $standings = new Standings(Uuid::v7(), $league->getId());
        $standings->addMatch($match);
        $this->em->persist($standings);
        $this->em->flush();

        ($this->handler)(new DeletedMatchCommand($match->getId(), $league->getId(), 'single'));

        $this->assertFalse($standings->hasMatch($match));
    }
}
