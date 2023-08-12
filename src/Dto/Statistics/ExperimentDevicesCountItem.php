<?php

namespace App\Dto\Statistics;

class ExperimentDevicesCountItem
{
    private int $experimentId;
    private int $devicesCount;

    public function __construct(int $experimentId, int $devicesCount)
    {
        $this->experimentId = $experimentId;
        $this->devicesCount = $devicesCount;
    }

    public function getExperimentId(): int
    {
        return $this->experimentId;
    }

    public function getDevicesCount(): int
    {
        return $this->devicesCount;
    }
}
