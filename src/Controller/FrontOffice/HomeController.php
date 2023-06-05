<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Entity\Standings\Standings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $standings = $entityManager->getRepository(Standings::class)
            ->findBy([])[0];

        return $this->render('front_office/home/index.html.twig', [
            'standings' => $standings->getStandings(),
        ]);
    }
}
