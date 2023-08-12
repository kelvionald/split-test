<?php

namespace App\Entity;

use App\Repository\ExperimentValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperimentValueRepository::class)]
class ExperimentValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'experimentValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Experiment $experiment = null;

    #[ORM\Column]
    private ?int $experimentId = null;

    #[ORM\Column(length: 255)]
    #[ORM\JoinColumn(nullable: false)]
    private ?string $value = null;

    #[ORM\Column]
    #[ORM\JoinColumn(nullable: false)]
    private ?int $share = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExperiment(): ?Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(?Experiment $experiment): static
    {
        $this->experiment = $experiment;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getShare(): ?int
    {
        return $this->share;
    }

    public function setShare(int $share): static
    {
        $this->share = $share;

        return $this;
    }
}
