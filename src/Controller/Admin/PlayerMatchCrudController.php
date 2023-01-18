<?php

namespace App\Controller\Admin;

use App\Entity\Match\PlayerMatch;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class PlayerMatchCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlayerMatch::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('homePlayer')
            ->setFormTypeOption('choice_label', 'fullName');
        yield AssociationField::new('awayPlayer')
            ->setFormTypeOption('choice_label', 'fullName');
        yield AssociationField::new('league')
            ->setFormTypeOption('choice_label', 'name');
        yield DateTimeField::new('createdAt')
            ->hideOnForm();
        yield DateTimeField::new('updatedAt')
            ->hideOnForm();
    }
}
