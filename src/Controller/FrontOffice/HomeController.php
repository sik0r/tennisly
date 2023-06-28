<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\DTO\MatchResultDto;
use App\Entity\League\League;
use App\Entity\League\PlayerLeague;
use App\Entity\Season;
use App\Entity\Standings\Standings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $standings = $entityManager
            ->getRepository(Standings::class)
            ->findAll();
        $leagueIds = array_map(fn(Standings $standing) => $standing->getLeagueId(), $standings);
        /** @var League[] $leagues */
        $leagues = $entityManager
            ->getRepository(PlayerLeague::class)
            ->findBy(['id' => $leagueIds]);
        $leaguesName = [];
        foreach ($leagues as $league) {
            $leaguesName[(string)$league->getId()] = $league->getName();
        }

        return $this->render('front_office/home/index.html.twig', [
            'standings' => $standings,
            'leagues' => $leaguesName
        ]);
    }

    #[Route('/api/leagues/{leagueId}/standings', name: 'league_standings', methods: ['GET'])]
    public function getStandings(string $leagueId, EntityManagerInterface $em)
    {
        $standings = $em
            ->getRepository(Standings::class)
            ->findOneBy(['leagueId' => $leagueId]);

        if ($standings === null) {
            return new JsonResponse(['message' => 'Standings not found'], Response::HTTP_NOT_FOUND);
        }

        $htmlResponse = $this->render('front_office/home/standings.html.twig', [
            'standings' => $standings->standings(),
            'matches' => array_map(fn(array $match) => MatchResultDto::create($match), $standings->matches()),
        ]);

        return new JsonResponse(['html' => $htmlResponse->getContent()]);
    }
}
