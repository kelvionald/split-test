<?php

namespace App\Dto\Statistics;

use App\Entity\Experiment;

class ExperimentStatistics
{
    /**
     * @var Experiment[]
     */
    private array $experiments;
    /**
     * @var ExperimentDevicesCountItem[]
     */
    private array $experimentDevicesCountItems;
    /**
     * @var ExperimentDevicesShare[]
     */
    private array $experimentsDevicesShares;

    /**
     * @param Experiment[] $experiments
     * @param ExperimentDevicesCountItem[] $experimentDevicesCountItems
     * @param ExperimentDevicesShare[] $experimentsDevicesShares
     */
    public function __construct(array $experiments, array $experimentDevicesCountItems, array $experimentsDevicesShares)
    {
        $this->experiments = $experiments;
        $this->experimentDevicesCountItems = $experimentDevicesCountItems;
        $this->experimentsDevicesShares = $experimentsDevicesShares;
    }

    /**
     * @return ExperimentDevicesShare[]
     */
    public function getExperimentsDevicesShares(): array
    {
        return $this->experimentsDevicesShares;
    }

    /**
     * @return ExperimentDevicesCountItem[]
     */
    public function getExperimentDevicesCountItems(): array
    {
        return $this->experimentDevicesCountItems;
    }

    /**
     * @return Experiment[]
     */
    public function getExperiments(): array
    {
        return $this->experiments;
    }
}
