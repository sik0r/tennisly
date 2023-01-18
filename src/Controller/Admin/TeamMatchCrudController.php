<?php

namespace App\Controller\Admin;

use App\Entity\Match\TeamMatch;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class TeamMatchCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeamMatch::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('homeTeam')
            ->setFormTypeOption('choice_label', 'name');
        yield AssociationField::new('awayTeam')
            ->setFormTypeOption('choice_label', 'name');
        yield AssociationField::new('league')
            ->setFormTypeOption('choice_label', 'name');
        yield DateTimeField::new('createdAt')
            ->hideOnForm();
        yield DateTimeField::new('updatedAt')
            ->hideOnForm();
    }
}
