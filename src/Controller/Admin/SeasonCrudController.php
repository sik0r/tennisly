<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Season;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeasonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Season::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);

        $crud->setEntityLabelInSingular('admin.label.season');
        $crud->setEntityLabelInPlural('admin.label.seasons');
        $crud->setPageTitle(Crud::PAGE_INDEX, 'admin.page.season.page_list');
        $crud->setPageTitle(Crud::PAGE_NEW, 'admin.page.season.page_new');
        $crud->setPageTitle(Crud::PAGE_EDIT, 'admin.page.season.page_edit');
        $crud->setPageTitle(Crud::PAGE_DETAIL, 'admin.page.season.page_detail');

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
        yield BooleanField::new('isActive', 'admin.label.is_active');
        yield DateTimeField::new('createdAt', 'admin.label.created_at')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'admin.label.updated_at')->onlyOnIndex();
    }
}
