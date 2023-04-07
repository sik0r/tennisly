<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Match\PlayerMatch;
use App\Form\Admin\Types\Match\SetType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class PlayerMatchCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlayerMatch::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);

        $crud->setEntityLabelInSingular('admin.label.player_match');
        $crud->setEntityLabelInPlural('admin.label.player_matches');
        $crud->setPageTitle(Crud::PAGE_INDEX, 'admin.page.player_match.page_list');
        $crud->setPageTitle(Crud::PAGE_NEW, 'admin.page.player_match.page_new');
        $crud->setPageTitle(Crud::PAGE_EDIT, 'admin.page.player_match.page_edit');
        $crud->setPageTitle(Crud::PAGE_DETAIL, 'admin.page.player_match.page_detail');

        return $crud;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);

        $actions->update(
            Crud::PAGE_INDEX, Action::NEW,
            fn (Action $action) => $action->setIcon('fa fa-plus')->setLabel('admin.action.add')
        );

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('homePlayer', 'admin.label.home_player')
            ->setFormTypeOption('choice_label', 'fullName');
        yield AssociationField::new('awayPlayer', 'admin.label.away_player')
            ->setFormTypeOption('choice_label', 'fullName');
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
