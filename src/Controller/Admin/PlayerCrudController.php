<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Player;
use App\Enum\GenderEnum;
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

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');
        yield TextField::new('firstName');
        yield TextField::new('lastName');
        yield ChoiceField::new('gender')
            ->setChoices(array_combine(
                    array_column(GenderEnum::cases(), 'name'),
                    array_column(GenderEnum::cases(), 'value')
                )
            );
    }
}
