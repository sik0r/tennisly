<?php

declare(strict_types=1);

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
        yield MenuItem::linkToDashboard('admin.label.sidebar.dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('admin.label.sidebar.admin', 'fa fa-user', Admin::class)
            ->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('admin.label.sidebar.player', 'fa-solid fa-user', Player::class);
        yield MenuItem::linkToCrud('admin.label.sidebar.team', 'fa-solid fa-users', Team::class);
        yield MenuItem::linkToCrud('admin.label.sidebar.season', 'fa-solid fa-trophy', Season::class);
        yield MenuItem::subMenu('admin.label.sidebar.league')->setSubItems(
            [
                MenuItem::linkToCrud('admin.label.sidebar.player_league', 'fa-solid fa-user', PlayerLeague::class),
                MenuItem::linkToCrud('admin.label.sidebar.team_league', 'fa-solid fa-users', TeamLeague::class),
            ]
        );
        yield MenuItem::subMenu('admin.label.sidebar.matches')->setSubItems(
            [
                MenuItem::linkToCrud('admin.label.sidebar.player_matches', 'fa-solid fa-user', PlayerMatch::class),
                MenuItem::linkToCrud('admin.label.sidebar.team_matches', 'fa-solid fa-users', TeamMatch::class),
            ]
        );
    }
}
