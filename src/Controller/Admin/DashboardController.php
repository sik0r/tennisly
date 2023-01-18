<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\League\PlayerLeague;
use App\Entity\League\TeamLeague;
use App\Entity\Match\PlayerMatch;
use App\Entity\Match\TeamMatch;
use App\Entity\Player;
use App\Entity\Season;
use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tennisly');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Admin', 'fa fa-user', Admin::class)
            ->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Season', '', Season::class);
        yield MenuItem::linkToCrud('Player league', '', PlayerLeague::class);
        yield MenuItem::linkToCrud('Team league', '', TeamLeague::class);
        yield MenuItem::linkToCrud('Player', '', Player::class);
        yield MenuItem::linkToCrud('Team', '', Team::class);
        yield MenuItem::linkToCrud('Team match', '', TeamMatch::class);
        yield MenuItem::linkToCrud('Player match', '', PlayerMatch::class);
    }
}
