<?php

namespace App\Entity;

use App\Repository\DeviceExperimentValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceExperimentValueRepository::class)]
class DeviceExperimentValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'deviceExperiments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Device $device = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExperimentValue $experimentValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): static
    {
        $this->device = $device;

        return $this;
    }

    public function getExperimentValue(): ?ExperimentValue
    {
        return $this->experimentValue;
    }

    public function setExperimentValue(?ExperimentValue $experimentValue): static
    {
        $this->experimentValue = $experimentValue;

        return $this;
    }
}
