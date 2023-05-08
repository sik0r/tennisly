<?php

declare(strict_types=1);

namespace App\Entity\Match;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\MappedSuperclass]
abstract class BaseMatch
{
    use TimestampableEntity;

    #[ORM\Column(type: 'json', options: ['default' => '[]'])]
    #[Gedmo\Versioned]
    private array $points;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->points = [];
    }

    public function getPoints(): array
    {
        return $this->points;
    }

    public function setPoints(array $points): void
    {
        $this->points = $points;
    }
}
