<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $firstPlayer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $secondPlayer = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstPlayer(): ?Player
    {
        return $this->firstPlayer;
    }

    public function setFirstPlayer(?Player $firstPlayer): self
    {
        $this->firstPlayer = $firstPlayer;

        return $this;
    }

    public function getSecondPlayer(): ?Player
    {
        return $this->secondPlayer;
    }

    public function setSecondPlayer(?Player $secondPlayer): self
    {
        $this->secondPlayer = $secondPlayer;

        return $this;
    }
}
