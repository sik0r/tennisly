<?php

declare(strict_types=1);

namespace App\Form\Admin\Types\Match;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class GemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gemNumber', IntegerType::class, [
                'label' => 'admin.types.match.gem.gem_number',
            ])
            ->add('homePoints', IntegerType::class, [
                'label' => 'admin.types.match.gem.home_points',
            ])
            ->add('awayPoints', IntegerType::class, [
                'label' => 'admin.types.match.gem.away_points',
            ]);
    }
}
