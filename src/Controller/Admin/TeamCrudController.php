<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);

        $crud->setEntityLabelInSingular('admin.label.team');
        $crud->setEntityLabelInPlural('admin.label.teams');
        $crud->setPageTitle(Crud::PAGE_INDEX, 'admin.page.team.page_list');
        $crud->setPageTitle(Crud::PAGE_NEW, 'admin.page.team.page_new');
        $crud->setPageTitle(Crud::PAGE_EDIT, 'admin.page.team.page_edit');
        $crud->setPageTitle(Crud::PAGE_DETAIL, 'admin.page.team.page_detail');

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
        yield AssociationField::new('firstPlayer', 'admin.label.first_player')
            ->setFormTypeOption('choice_label', 'fullName');
        yield AssociationField::new('secondPlayer', 'admin.label.second_player')
            ->setFormTypeOption('choice_label', 'fullName');
        yield DateTimeField::new('createdAt', 'admin.label.created_at')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'admin.label.updated_at')->onlyOnIndex();
    }
}
