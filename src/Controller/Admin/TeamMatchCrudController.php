<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Application\CompletedMatch\CompletedMatchCommand;
use App\Application\DeletedMatch\DeletedMatchCommand;
use App\Entity\Match\TeamMatch;
use App\Form\Admin\Types\Match\SetType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Messenger\MessageBusInterface;

class TeamMatchCrudController extends AbstractCrudController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public static function getEntityFqcn(): string
    {
        return TeamMatch::class;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->wrapInTransaction(function (EntityManagerInterface $em) use ($entityInstance) {
            parent::updateEntity($em, $entityInstance);
            $this->messageBus->dispatch(
                new CompletedMatchCommand($entityInstance->getId(), $entityInstance->getLeague()->getId(), 'double')
            );
        });
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->wrapInTransaction(function (EntityManagerInterface $em) use ($entityInstance) {
            parent::persistEntity($em, $entityInstance);
            $this->messageBus->dispatch(
                new CompletedMatchCommand($entityInstance->getId(), $entityInstance->getLeague()->getId(), 'double')
            );
        });
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->wrapInTransaction(function (EntityManagerInterface $em) use ($entityInstance) {
            $this->messageBus->dispatch(
                new DeletedMatchCommand($entityInstance->getId(), $entityInstance->getLeague()->getId(), 'double')
            );
            parent::deleteEntity($em, $entityInstance);
        });
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);

        $crud->setEntityLabelInSingular('admin.label.team_match');
        $crud->setEntityLabelInPlural('admin.label.team_matches');
        $crud->setPageTitle(Crud::PAGE_INDEX, 'admin.page.team_match.page_list');
        $crud->setPageTitle(Crud::PAGE_NEW, 'admin.page.team_match.page_new');
        $crud->setPageTitle(Crud::PAGE_EDIT, 'admin.page.team_match.page_edit');
        $crud->setPageTitle(Crud::PAGE_DETAIL, 'admin.page.team_match.page_detail');

        return $crud;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);

        $actions->update(
            Crud::PAGE_INDEX, Action::NEW,
            fn(Action $action) => $action->setIcon('fa fa-plus')->setLabel('admin.action.add')
        );

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('homeTeam', 'admin.label.home_team')
            ->setFormTypeOption('choice_label', 'name');
        yield AssociationField::new('awayTeam', 'admin.label.away_team')
            ->setFormTypeOption('choice_label', 'name');
        yield AssociationField::new('league', 'admin.label.league')
            ->setFormTypeOption('choice_label', 'name');
        yield DateTimeField::new('createdAt', 'admin.label.created_at')
            ->hideOnForm();
        yield DateTimeField::new('updatedAt', 'admin.label.updated_at')
            ->hideOnForm();
        yield CollectionField::new('points', 'admin.label.points')
            ->setCustomOption(CollectionField::OPTION_ENTRY_TYPE, SetType::class)
            ->hideOnIndex();
    }
}
