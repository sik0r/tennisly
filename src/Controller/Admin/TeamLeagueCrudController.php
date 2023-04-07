<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\League\TeamLeague;
use App\Enum\GenderEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TeamLeagueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeamLeague::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);

        $crud->setEntityLabelInSingular('admin.label.team_league');
        $crud->setEntityLabelInPlural('admin.label.team_leagues');
        $crud->setPageTitle(Crud::PAGE_INDEX, 'admin.page.team_league.page_list');
        $crud->setPageTitle(Crud::PAGE_NEW, 'admin.page.team_league.page_new');
        $crud->setPageTitle(Crud::PAGE_EDIT, 'admin.page.team_league.page_edit');
        $crud->setPageTitle(Crud::PAGE_DETAIL, 'admin.page.team_league.page_detail');

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
        yield TextField::new('name', 'admin.label.name');
        yield AssociationField::new('season', 'admin.label.season')
            ->setFormTypeOption('choice_label', 'name');
        yield ChoiceField::new('gender', 'admin.label.gender')
            ->setChoices(array_combine(
                    array_map(static fn(GenderEnum $gender) => "admin.label.genders.$gender->value", GenderEnum::cases()),
                    array_column(GenderEnum::cases(), 'value')
                )
            );
        yield AssociationField::new('teams', 'admin.label.teams')
            ->setFormTypeOption('choice_label', 'name');
    }
}
