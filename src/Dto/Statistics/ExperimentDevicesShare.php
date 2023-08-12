<?php

namespace App\Dto\Statistics;

class ExperimentDevicesShare
{
    private int $experimentId;

    /**
     * @var ExperimentDevicesShareValue[]
     */
    private array $shareValues;

    public function __construct(int $experimentId)
    {
        $this->experimentId = $experimentId;
        $this->shareValues = [];
    }

    public function getExperimentId(): int
    {
        return $this->experimentId;
    }

    public function addValue(ExperimentDevicesShareValue $experimentDevicesShareValue): void
    {
        $this->shareValues[] = $experimentDevicesShareValue;
    }

    /**
     * @return ExperimentDevicesShareValue[]
     */
    public function getShareValues(): array
    {
        return $this->shareValues;
    }
}
