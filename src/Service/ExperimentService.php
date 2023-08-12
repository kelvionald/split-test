<?php

namespace App\Service;

use App\Dto\Statistics\ExperimentStatistics;
use App\Entity\Device;
use App\Entity\DeviceExperimentValue;
use App\Entity\ExperimentValue;
use App\Repository\DeviceExperimentValueRepository;
use App\Repository\DeviceRepository;
use App\Repository\ExperimentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ExperimentService
{
    private DeviceRepository $deviceRepository;
    private ExperimentRepository $experimentRepository;
    private EntityManagerInterface $entityManager;
    private DeviceExperimentValueRepository $deviceExperimentValueRepository;

    public function __construct(
        DeviceRepository $deviceRepository,
        ExperimentRepository $experimentRepository,
        EntityManagerInterface $entityManager,
        DeviceExperimentValueRepository $deviceExperimentValueRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->experimentRepository = $experimentRepository;
        $this->entityManager = $entityManager;
        $this->deviceExperimentValueRepository = $deviceExperimentValueRepository;
    }

    /**
     * @return Collection<int, DeviceExperimentValue>
     * @throws Exception
     */
    public function getList(string $deviceToken): Collection
    {
        /* @var Device $device */
        $device = $this->deviceRepository->findOneByToken($deviceToken);

        if (!$device) {
            $device = new Device();
            $device->setToken($deviceToken);
            $this->entityManager->persist($device);

            $experiments = $this->experimentRepository->findAll();

            foreach ($experiments as $experiment) {
                $deviceExperimentValue = new DeviceExperimentValue();
                $device->addDeviceExperimentValue($deviceExperimentValue);

                if ($experiment->getExperimentValues()->isEmpty()) {
                    throw new Exception('ExperimentValues is empty.');
                }

                $deviceExperimentValue->setExperimentValue($this->roulette($experiment->getExperimentValues()));

                $this->entityManager->persist($deviceExperimentValue);
            }

            $this->entityManager->flush();
        }

        return $device->getDeviceExperimentValues();
    }

    /**
     * @param $experimentValues Collection<int, ExperimentValue>
     */
    private function roulette(Collection $experimentValues): ExperimentValue
    {
        $shareSum = array_sum(array_map(
            fn(ExperimentValue $experimentValue) => $experimentValue->getShare(),
            $experimentValues->toArray()
        ));
        $chance = rand(1, $shareSum);

        foreach ($experimentValues as $experimentValue) {
            if ($chance <= $experimentValue->getShare()) {
                return $experimentValue;
            } else {
                $chance -= $experimentValue->getShare();
            }
        }

        return $experimentValue;
    }

    public function getStatistics(): ExperimentStatistics
    {
        $experiments = $this->experimentRepository->findAll();

        $experimentDevicesCountItems = $this->deviceExperimentValueRepository->getExperimentsDevicesCount();

        $experimentsDevicesShares = $this->deviceExperimentValueRepository
            ->getExperimentsDevicesShares();

        return new ExperimentStatistics($experiments, $experimentDevicesCountItems, $experimentsDevicesShares);
    }
}
