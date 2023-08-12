<?php

namespace App\Entity;

use App\Repository\ExperimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperimentRepository::class)]
class Experiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[ORM\JoinColumn(nullable: false)]
    private ?string $identifier = null;

    #[ORM\OneToMany(
        mappedBy: 'experiment',
        targetEntity: ExperimentValue::class,
        cascade: ['persist'],
        fetch: 'EAGER',
        orphanRemoval: true
    )]
    private Collection $experimentValues;

    public function __construct()
    {
        $this->experimentValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return Collection<int, ExperimentValue>
     */
    public function getExperimentValues(): Collection
    {
        return $this->experimentValues;
    }

    public function addExperimentValue(ExperimentValue $experimentValue): static
    {
        if (!$this->experimentValues->contains($experimentValue)) {
            $this->experimentValues->add($experimentValue);
            $experimentValue->setExperiment($this);
        }

        return $this;
    }

    public function removeExperimentValue(ExperimentValue $experimentValue): static
    {
        if ($this->experimentValues->removeElement($experimentValue)) {
            // set the owning side to null (unless already changed)
            if ($experimentValue->getExperiment() === $this) {
                $experimentValue->setExperiment(null);
            }
        }

        return $this;
    }
}
