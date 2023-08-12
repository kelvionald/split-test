<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    #[ORM\JoinColumn(nullable: false)]
    private ?string $token = null;

    #[ORM\OneToMany(mappedBy: 'device', targetEntity: DeviceExperimentValue::class, orphanRemoval: true)]
    private Collection $deviceExperimentValues;

    public function __construct()
    {
        $this->deviceExperimentValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, DeviceExperimentValue>
     */
    public function getDeviceExperimentValues(): Collection
    {
        return $this->deviceExperimentValues;
    }

    public function addDeviceExperimentValue(DeviceExperimentValue $deviceExperimentValue): static
    {
        if (!$this->deviceExperimentValues->contains($deviceExperimentValue)) {
            $this->deviceExperimentValues->add($deviceExperimentValue);
            $deviceExperimentValue->setDevice($this);
        }

        return $this;
    }

    public function removeDeviceExperimentValue(DeviceExperimentValue $deviceExperimentValue): static
    {
        if ($this->deviceExperimentValues->removeElement($deviceExperimentValue)) {
            // set the owning side to null (unless already changed)
            if ($deviceExperimentValue->getDevice() === $this) {
                $deviceExperimentValue->setDevice(null);
            }
        }

        return $this;
    }
}
