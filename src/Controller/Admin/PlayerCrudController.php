<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Player;
use App\Enum\GenderEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlayerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Player::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);

        $crud->setEntityLabelInSingular('admin.label.player');
        $crud->setEntityLabelInPlural('admin.label.players');
        $crud->setPageTitle(Crud::PAGE_INDEX, 'admin.page.player.page_list');
        $crud->setPageTitle(Crud::PAGE_NEW, 'admin.page.player.page_new');
        $crud->setPageTitle(Crud::PAGE_EDIT, 'admin.page.player.page_edit');
        $crud->setPageTitle(Crud::PAGE_DETAIL, 'admin.page.player.page_detail');

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
        yield TextField::new('firstName', 'admin.label.first_name');
        yield TextField::new('lastName', 'admin.label.last_name');
        yield EmailField::new('email', 'admin.label.email');
        yield ChoiceField::new('gender', 'admin.label.gender')
            ->setChoices(array_combine(
                    array_map(static fn(GenderEnum $gender) => "admin.label.genders.$gender->value", GenderEnum::cases()),
                    array_column(GenderEnum::cases(), 'value')
                )
            );
    }
}
