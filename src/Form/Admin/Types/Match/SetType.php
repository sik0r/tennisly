<?php

declare(strict_types=1);

namespace App\Form\Admin\Types\Match;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class SetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('setNumber', IntegerType::class, [
                'label' => 'admin.types.match.set.set_number',
            ])
            ->add('gems', CollectionType::class, [
                'entry_type' => GemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'admin.types.match.set.gems',
            ]);
    }
}
