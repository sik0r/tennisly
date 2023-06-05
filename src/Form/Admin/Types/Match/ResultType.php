<?php

declare(strict_types=1);

namespace App\Form\Admin\Types\Match;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('setNumber', IntegerType::class, [
            'label' => 'number seta',
        ])->add('homeGems', IntegerType::class, [
            'label' => 'Gemy gospodarzy',
        ])->add('awayGems', IntegerType::class, [
            'label' => 'Gemy gości',
        ]);
    }
}
