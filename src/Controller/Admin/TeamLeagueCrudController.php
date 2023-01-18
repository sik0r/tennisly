<?php

namespace App\Controller\Admin;

use App\Entity\League\TeamLeague;
use App\Enum\GenderEnum;
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

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield AssociationField::new('season');
        yield ChoiceField::new('gender')
            ->setChoices(array_combine(
                    array_column(GenderEnum::cases(), 'name'),
                    array_column(GenderEnum::cases(), 'value')
                )
            );
        yield AssociationField::new('teams')
            ->setFormTypeOption('choice_label', 'name');
    }
}
